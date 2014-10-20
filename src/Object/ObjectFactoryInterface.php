<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

use GO1\LMS\TinCan\Object\InverseIdentity;

interface ObjectFactoryInterface {

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
   * @return ObjectInterface
   */
  function createObject($type = 'Activity', $id = NULL);
}
