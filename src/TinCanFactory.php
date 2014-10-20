<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Statement;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;
use GO1\LMS\TinCan\Object\Activity;
use GO1\LMS\TinCan\Object\StatementRef;
use GO1\LMS\TinCan\Object\SubStatement;
use GO1\LMS\TinCan\Object\Actor\Agent;
use GO1\LMS\TinCan\Object\Actor\GroupBase;
use GO1\LMS\TinCan\Object\Actor\AnonymousGroup;
use GO1\LMS\TinCan\Object\Actor\IdentifiedGroup;
use GO1\LMS\TinCan\Object\Verb;
use GO1\LMS\TinCan\Misc\LanguageMap;

class TinCanFactory implements TinCanFactoryInterface {

  /**
   * @{inheritdoc}
   */
  public function createInverseIdentity($type, $value) {
    return new InverseIdentity($type, $value);
  }

  /**
   * @{inheritdoc}
   */
  public function createActor($type, InverseIdentity $id = NULL, $name = NULL, $members = NULL) {
    if ($type == GroupBase::OBJECT_TYPE) {
      if (is_null($id) && !empty($members)) {
        return new AnonymousGroup($members, $name);
      }
      if ($id instanceof InverseIdentity) {
        return new IdentifiedGroup($id, $name, $members);
      }
    }
    if ($type == Agent::OBJECT_TYPE && $id instanceof InverseIdentity) {
      return new Agent($id, $name);
    }
  }

  /**
   * @{inheritdoc}
   */
  public function createVerb(InverseIdentity $id ) {
    return new Verb($id);
  }
  
  /**
   * @{inheritdoc}
   */
  public function createObject($type = 'Activity', $id = NULL, $name = NULL,
      $members = NULL, Statement $statement = NULL) {
    
    if ($type == Activity::OBJECT_TYPE && !is_null($id)) {
      return new Activity($id);
    }
    
    if ($type == Agent::OBJECT_TYPE || $type == GroupBase::OBJECT_TYPE) {
      return $this->createActor($type, $id, $name, $members);
    }
    
    if ($type == StatementRef::OBJECT_TYPE && !is_null($id)) {
      return new StatementRef($id);
    }
    
    if ($type == SubStatement::OBJECT_TYPE && !is_null($statement)) {
      return new SubStatement($statement);
    }
    
    return NULL;
  }
  
  /**
   * @{inheritdoc}
   */
  public function createLanguageMap($values) {
    // @todo check for non scalar values
    return new LanguageMap($values);
  }
  
  /**
   * @{inheritdoc}
   */
  public function createStatement(ActorInterface $actor, Verb $verb, ObjectInterface $object) {
    return new Statement($actor, $verb, $object);
  }
  
}
