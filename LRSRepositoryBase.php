<?php

namespace GO1\Aduro\TinCan;

class LRSRepositoryBase implements LRSRepositoryInterface {
  
  /**
   * @{inheritdoc}
   */
  public function getStatement($actor, $verbID, $object) {
    
  }

  /**
   * @{inheritdoc}
   */
  public function getStatementById($statementID) {
    
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
