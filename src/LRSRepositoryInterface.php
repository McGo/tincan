<?php

namespace GO1\LMS\TinCan;

interface LRSRepositoryInterface {
  
  /**
   * 
   * @param string $statementID uuid
   * @return string json format
   */
  function getStatementById($statementID);
  
  /**
   * 
   * @param array $actor type can be agent / group, id is inverse functional identifier
   * @param string $verbID IRI
   * @param type $object type can be activity / agent or group / substatement / statementref,
   * id can be activity IRI / inverse functional identifier / NO ID supplied / UUID
   * @return string json format
   */
  function getStatement($actor, $verbID, $object);
  
  /**
   * 
   * @param array $actor type can be agent / group, id is inverse functional identifier
   * @param array $conditions since: timestamp, until: timestamp, limit: integer
   * @return string json format
   */
  function getStatementsHasActor($actor, $conditions = array());
  
  /**
   * 
   * @param string $verbID IRI
   * @param array $conditions since: timestamp, until: timestamp, limit: integer
   * @return string json format
   */
  function getStatementsHasVerb($verbID, $conditions = array());

  /**
   * 
   * @param type $object type can be activity / agent or group / substatement / statementref,
   * id can be activity IRI / inverse functional identifier / NO ID supplied / UUID
   * @param array $conditions since: timestamp, until: timestamp, limit: integer
   * @return string json format
   */
  function getStatementsHasObject($object, $conditions = array());
  
}
