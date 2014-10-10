<?php

namespace GO1\Aduro\TinCan;

use GuzzleHttp\ClientInterface;
use TinCan\Agent;
use TinCan\Verb;
use TinCan\Activity;
use TinCan\Statement;

class LRSRepositoryBase implements LRSRepositoryInterface {

  protected $httpClient;
  protected $lrs;

  public function __construct(ClientInterface $httpClient, LRS $lrs) {
    $this->httpClient = $httpClient;
    $this->lrs = $lrs;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatement(Agent $actor, Verb $verb, Activity $object) {
    $params = array(
      'agent' => $actor->getMbox(),
      'verb' => $verb->getId(),
      'activity' => $object->getId(),
    );
    return $this->doGetStatements('statements', $params);
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementById($statementID) {
    $response = $this->doGetStatements('statements', array('statementId' => $statementID));
    $statements = $response->statements;
    return !empty($statements) ? Statement::fromJSON(json_encode(reset($statements))) : FALSE;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasActor($actor, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('agent' => $actor));
    return $response->statements;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasObject($object, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('activity' => $object));
    return $response->statements;
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasVerb($verbID, $conditions = array()) {
    $response = $this->doGetStatements('statements', array('verb' => $verbID));
    return $response->statements;
  }

  private function doGetStatements($url, array $urlParameters = array()) {
    $this->httpClient;
    if (count($urlParameters) > 0) {
      $url .= '?' . http_build_query($urlParameters);
    }
    print_r(array($url));
    try {
      $reponse = $this->httpClient->get($url, [
        'headers' => [
          'X-Experience-API-Version' => $this->lrs->getVersion(),
          'Content-Type' => 'application/json',
        ],
        'auth' => [
          $this->lrs->getUsername(),
          $this->lrs->getPassword(),
        ]
      ]);
      
      if ($reponse->getStatusCode() == '200') {
        $content = $reponse->getBody()->getContents();
        return \GuzzleHttp\json_decode($content);
      }
    }
    catch (Exception $ex) {
      throw new Exception($ex->getMessage());
    }
  }

}
