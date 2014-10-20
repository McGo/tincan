<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\TinCanAPI;
use GO1\LMS\TinCan\TinCanFactoryInterface;

class JsonParser implements JsonParserInterface {

  /**
   *
   * @var TinCanFactoryInterface 
   */
  protected $factory;

  /**
   * 
   * @param TinCanFactoryInterface $factory
   */
  public function __construct(TinCanFactoryInterface $factory) {
    $this->factory = $factory;
  }

  /**
   * {@inheritdoc}
   */
  public function parse($json) {
    $jsonObject = json_decode($json);  
    $statements = $this->parseStatements($jsonObject);
  }

  /**
   * @{inheritdoc}
   */
  public function parseStatements($jsonObject) {
    if (isset($jsonObject->statements)) {
      $statements = array();
      foreach ($jsonObject->statements as $statementJsonObject) {
        $statements[] = $this->parseStatement($statementJsonObject);
      }
      return $statements;
    }
    return NULL;
  }

  /**
   * @{inheritdoc}
   */
  public function parseStatement($statementJsonObject) {
    $actor = $this->parseActor($statementJsonObject->actor);
    $verb = $this->parseVerb($statementJsonObject->verb);
    $object = $this->parseObject($statementJsonObject->object);
    
    $statement = $this->factory->createStatement($actor, $verb, $object);
    
    //futher processing
    
    return $statement;
  }
  
  /**
   * @{inheritdoc}
   */
  public function parseActor($actorJsonObject) {
    $id = $this->parseInverseIdentity($actorJsonObject);

    $members = $this->parseMembers($actorJsonObject);

    return $this->factory->createActor($actorJsonObject->objectType, $id, $actorJsonObject->name, $members);
  }

  /**
   * @{inheritdoc}
   */
  public function parseInverseIdentity($jsonObject) {
    foreach (TinCanAPI::$inverseIdentityTypes as $type) {
      if (isset($jsonObject->$type)) {
        return $this->factory->createInverseIdentity($type, $jsonObject->$type);
      }
    }
    return NULL;
  }

  /**
   * 
   * @param stdClass $jsonObject
   */
  public function parseMembers($jsonObject) {
    if (isset($jsonObject->members)) {
      $members = array();
      foreach ($jsonObject->members as $agentJsonObject) {
        $members[] = $this->parseActor($agentJsonObject);
      }
    }
    return NULL;
  }

  /**
   * @{inheritdoc}
   */
  public function parseVerb($jsonObject) {
     $id = $this->parseInverseIdentity($jsonObject);
     if (!is_null($id)) {
       $verb = $this->factory->createVerb($id);
       if (isset($jsonObject->display)) {
         $verb->setDisplay($this->parseLanguageMap($jsonObject));
       }
     }
     return NULL;
  }
  
  /**
   * @{inheritdoc}
   */
  public function parseObject($jsonObject) {
    $type = $jsonObject->objectType;
    
    // try parsing inverse identity
    $id = isset($jsonObject->id) ? $jsonObject->id : $this->parseInverseIdentity($jsonObject);
    
    $name = isset($jsonObject->name) ? $jsonObject->name : NULL;
    
    $members = $this->parseMembers($jsonObject);
    
    $statement = $this->parseStatement($jsonObject);
    
    $this->factory->createObject($type, $id, $name, $members, $statement);
  }
  
  /**
   * @{inheritdoc}
   */
  public function parseLanguageMap($jsonObject) {
    return $this->factory->createLanguageMap($jsonObject);
  }
}
