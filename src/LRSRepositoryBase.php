<?php

namespace GO1\Aduro\TinCan;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;

class LRSRepositoryBase implements LRSRepositoryInterface {

  protected $httpClient;
  protected $lrs;
  protected $parser;

  public function __construct(ClientInterface $httpClient, LRS $lrs, StatementParserInterface $parser) {
    $this->httpClient = $httpClient;
    $this->lrs = $lrs;
    $this->parser = $parser;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatement($actor, $verb, $object) {
    $params = array(
      'agent' => $actor,
      'verb' => $verb,
      'activity' => $object,
    );
    $statements = $this->sendRequest('statements', $params);
    return !empty($statements) ? reset($statements) : FALSE;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementById($statementID) {
    $statements = $this->sendRequest('statements', array('statementId' => $statementID));
    return !empty($statements) ? reset($statements) : FALSE;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasActor($actor, $conditions = array()) {
    return $this->sendRequest('statements', array('agent' => $actor));
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasObject($object, $conditions = array()) {
    return $this->sendRequest('statements', array('activity' => $object));
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasVerb($verbID, $conditions = array()) {
    return $this->sendRequest('statements', array('verb' => $verbID));
  }

  /**
   * 
   * @param string $url
   * @return RequestInterface
   */
  protected function makeRequest($url) {
    return $this->httpClient->createRequest('GET', $url, array(
        'headers' => array(
          'X-Experience-API-Version' => $this->lrs->getVersion(),
          'Content-Type' => 'application/json',
        ),
        'auth' => array(
          $this->lrs->getUsername(),
          $this->lrs->getPassword(),
        )
    ));
  }
  
  /**
   * 
   * @param RequestInterface $request
   * @param array $params
   */
  protected function setRequestParams(RequestInterface $request, $params = array()) {
    $query = $request->getQuery();
    foreach ($params as $name => $value) {
      $query->set($name, $value);
    }
  }
  
  /**
   * 
   * @param RequestInterface $request
   * @return string
   */
  protected function getRequestContent(RequestInterface $request) {
    $reponse = $this->httpClient->send($request);
    if ($reponse->getStatusCode() == '200') {
      $json = $reponse->getBody()->getContents();
      return $json;
    }
    return '[]';
  }
  
  /**
   * 
   * @param string $url
   * @param array $params
   * @return array
   */
  protected function sendRequest($url, array $params = array()) {
    // Build request
    $request = $this->makeRequest($url);

    // Set parameters
    $this->setRequestParams($request, $params);

    // Execute request
    $json = $this->getRequestContent($request);
    
    return $this->parse($json);
  }
  
  /**
   * 
   * @param string $json
   * @return array
   */
  public function parse($json) {
    return $this->parser->parse($json);
  }

}
