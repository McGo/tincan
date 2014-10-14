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
    $params = array_merge(array('agent' => $actor), $conditions);
    return $this->sendRequest('statements', $params);
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasObject($object, $conditions = array()) {
    $params = array_merge(array('activity' => $object), $conditions);
    return $this->sendRequest('statements', $params);
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasVerb($verbID, $conditions = array()) {
    $params = array_merge(array('verb' => $verbID), $conditions);
    return $this->sendRequest('statements', $params);
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
  protected function executeRequest(RequestInterface $request) {
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
    $json = $this->executeRequest($request);
    
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
