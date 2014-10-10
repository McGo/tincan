<?php

namespace GO1\Aduro\TinCan;

use GuzzleHttp\ClientInterface;


class LRSRepositoryBase implements LRSRepositoryInterface {
  
  protected $client;
  
  protected $lrs;

  public function __construct(ClientInterface $client, LRS $lrs) {
    $this->client = $client;
    $this->lrs = $lrs;
  }
  
  /**
   * @{inheritdoc}
   */
  public function getStatement($actor, $verbID, $object) {
   
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementById($statementID) {
    $response = $this->client->get($this->lrs->getEndpoint(), array('statementId' => $statementID));
    return $response->getBody();
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasActor($actor, $conditions = array()) {
    
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasObject($object, $conditions = array()) {
    
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementsHasVerb($verbID, $conditions = array()) {
    
  }

}
