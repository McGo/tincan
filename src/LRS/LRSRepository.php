<?php

namespace GO1\LMS\TinCan\LRS;

use GO1\LMS\TinCan\TinCanAPI;
use GO1\LMS\TinCan\Parser\JsonParserInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\RequestException;

class LRSRepository implements LRSRepositoryInterface {

  const GET_ENDPOINT = 'statements';

  protected $httpClient;
  protected $lrs;
  protected $parser;

  public function __construct(ClientInterface $httpClient, LRS $lrs, JsonParserInterface $parser) {
    $this->httpClient = $httpClient;
    $this->lrs = $lrs;
    $this->parser = $parser;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatements($params = array()) {
    if ($this->validateParams($params)) {
      $resultObject = $this->sendRequest($this->lrs->getEndpoint() . self::GET_ENDPOINT, $params);
      return $resultObject->statements;
    }
  }

  /**
   *  @{inheritdoc}
   */
  protected function validateParams($params) {
    foreach ($params as $param) {
      if (!in_array(key($param), TinCanAPI::$statementRequestParams)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
   * 
   * @param string $url
   * @return RequestInterface
   */
  protected function makeRequest($url) {
    return $this->httpClient->createRequest('GET', $url, array('headers' => array(
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
    foreach ($params as $param) {
      $query->set(key($param), current($param));
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
  }

  /**
   * 
   * @param string $url
   * @param array $params
   * @return array
   */
  public function sendRequest($url, $params = array()) {
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

  /**
   * Verify the connection to LRS
   * @return type
   */
  public function verifyConnection() {
    // Build request
    $request = $this->makeRequest('statements');
    $params = array('limit' => 1);

    // Set parameters
    $this->setRequestParams($request, $params);

    try {
      $reponse = $this->httpClient->send($request);
    } catch (RequestException $ex) {
      return FALSE;
    }
    return $reponse->getStatusCode() == '200';
  }

}
