<?php

namespace GO1\Aduro\TinCan;

use GuzzleHttp\ClientInterface;
use TinCan\Statement;

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
    $response = $this->doGetStatements('statements', $params);
    $statements = $response->statements;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementById($statementID) {
    $response = $this->doGetStatements('statements', array('statementId' => $statementID));
    $statements = $this->parse($response);
    return !empty($statements) ? reset($statements) : FALSE;
    ;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasActor($actor, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('agent' => $actor));
    return $this->parse($response);
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasObject($object, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('activity' => $object));
    return $this->parse($response);
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasVerb($verbID, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('verb' => $verbID));
    return $this->parse($response);
  }

  private function doGetStatements($url, array $parameters = array()) {
    try {
      // Build request
      $request = $this->httpClient->createRequest('GET', $url, [
        'headers' => [
          'X-Experience-API-Version' => $this->lrs->getVersion(),
          'Content-Type' => 'application/json',
        ],
        'auth' => [
          $this->lrs->getUsername(),
          $this->lrs->getPassword(),
        ]
      ]);
      
      // Buidl parameters
      $query = $request->getQuery();
      foreach ($parameters as $name => $value) {
        $query->set($name, $value);
      }
      
      // Send request
      $reponse = $this->httpClient->send($request);
      if ($reponse->getStatusCode() == '200') {
        $content = $reponse->getBody()->getContents();
        return $content;
      }
    }
    catch (Exception $ex) {
      throw new Exception($ex->getMessage());
    }
  }
  
  public function parse($json) {
    return $this->parser->parse($json);
  }

}
