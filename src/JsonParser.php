<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\TinCanAPI;
use GO1\LMS\TinCan\Object\ObjectFactoryInterface;

class JsonParser implements JsonParserInterface {

  /**
   *
   * @var ObjectFactoryInterface 
   */
  protected $factory;

  /**
   * 
   * @param ObjectFactoryInterface $factory
   */
  public function __construct(ObjectFactoryInterface $factory) {
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
        $actor = $this->parseActor($statementJsonObject->actor);
        $verb = $this->parseVerb($statementJsonObject->verb);
        $object = $this->parseObject($statementJsonObject->object);
      }
      return $statements;
    }
    return NULL;
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
       return $this->factory->createVerb($id);
     }
     return NULL;
  }
  
  /**
   * @{inheritdoc}
   */
  public function parseObject($jsonObject) {
    
  }
}
