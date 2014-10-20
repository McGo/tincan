<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Object\InverseIdentity;
use GO1\LMS\TinCan\Object\Verb;
use GO1\LMS\TinCan\Object\ObjectInterface;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;


interface TinCanFactoryInterface {

  /**
   * 
   * @param ActorInterface $actor
   * @param Verb $verb
   * @param \GO1\LMS\TinCan\ObjectInterface $object
   */
  function createStatement(ActorInterface $actor, Verb $verb, ObjectInterface $object);
  
  /**
   * 
   * @param string $type
   * @param mixed $value
   * @return InverseIdentity
   */
  function createInverseIdentity($type, $value);
  
  /**
   * 
   * @param string $type Agent|Group
   * @param InverseIdentity $id
   * @param string $name
   * @param array $members
   * @return Agent|IdentifiedGroup|AnonymousGroup
   */
  function createActor($type, InverseIdentity $id = NULL, $name = NULL, $members = NULL);
  
  /**
   * 
   * @param InverseIdentity $id
   * @return Verb
   */
  function createVerb(InverseIdentity $id);
  
  /**
   * Create object in a statement
   * Activity|Agent|GroupBase|SubStatement|StatementRef
   * @param string $type default value is 'Activity' if not set
   * @param mixed $id optional
   * @param string $name optional
   * @param array $members optional
   * @param Statement
   * @return ObjectInterface
   */
  function createObject($type = 'Activity', $id = NULL, $name = NULL,
      $members = NULL, Statement $statement = NULL);
  
  /**
   * 
   * @param mixed $values
   */
  function createLanguageMap($values);
}
