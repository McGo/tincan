<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Statement\Statement;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;
use GO1\LMS\TinCan\Object\Activity\Activity;
use GO1\LMS\TinCan\Object\Activity\ActivityDefinition;
use GO1\LMS\TinCan\Object\Activity\InteractionComponent;
use GO1\LMS\TinCan\Object\StatementRef;
use GO1\LMS\TinCan\Object\SubStatement;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\Object\Actor\Agent;
use GO1\LMS\TinCan\Object\Actor\GroupBase;
use GO1\LMS\TinCan\Object\Actor\AnonymousGroup;
use GO1\LMS\TinCan\Object\Actor\IdentifiedGroup;
use GO1\LMS\TinCan\Object\ObjectInterface;
use GO1\LMS\TinCan\Object\Verb;
use GO1\LMS\TinCan\Misc\LanguageMap;
use GO1\LMS\TinCan\Object\Result\Result;
use GO1\LMS\TinCan\Object\Result\Score;
use GO1\LMS\TinCan\Object\Context\Context;
use GO1\LMS\TinCan\Object\Context\ContextActivity;
use GO1\LMS\TinCan\Misc\Extension;
use GO1\LMS\TinCan\Object\Attachment;

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
    if ((is_null($type) || $type == Agent::OBJECT_TYPE) && $id instanceof InverseIdentity) {
      return new Agent($id, $name);
    }
  }

  /**
   * @{inheritdoc}
   */
  public function createVerb($id ) {
    return new Verb($id);
  }
  
  /**
   * @{inheritdoc}
   */
  public function createObject($type = NULL, $id = NULL, $name = NULL,
      $members = NULL, Statement $statement = NULL) {

    if (($type == NULL || $type == Activity::OBJECT_TYPE) && !is_null($id)) {
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
  
  /**
   * @{inheritdoc}
   */
  public function createResult() {
    return new Result;
  }
  
  /**
   * @{inheritdoc}
   */
  public function createScore() {
    return new Score;
  }
  
  /**
   * @{inheritdoc}
   */
  public function createContext() {
    return new Context;
  }
  
  /**
   * @{inheritdoc}
   */
  public function createContextActivity($key, $value) {
    return new ContextActivity($key, $value);
  }
  
  /**
   * @{inheritdoc}
   */
  public function createExtension($key, $value) {
    return new Extension($key, $value);
  }
  
  /**
   * @{inheritdoc}
   */
  public function createAttachment($usageType, $display, $contentType, $length, $sha2) {
    return new Attachment($usageType, $display, $contentType, $length, $sha2);
  }
  
  /**
   * 
   */
  public function createActivityDefinition() {
    return new ActivityDefinition();
  }
  
  /**
   * 
   */
  public function createInteractionComponent($id) {
    return new InteractionComponent($id);
  }
}
