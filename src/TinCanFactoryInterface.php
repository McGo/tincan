<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Statement\Statement;
use GO1\LMS\TinCan\Object\Result\Result;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;
use GO1\LMS\TinCan\Object\Verb;
use GO1\LMS\TinCan\Object\ObjectInterface;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\Misc\LanguageMap;
use GO1\LMS\TinCan\Object\Result\Score;
use GO1\LMS\TinCan\Object\Context\Context;
use GO1\LMS\TinCan\Object\Context\ContextActivity;
use GO1\LMS\TinCan\Misc\Extension;
use GO1\LMS\TinCan\Object\Attachment;

interface TinCanFactoryInterface {

  /**
   * 
   * @param ActorInterface $actor
   * @param Verb $verb
   * @param ObjectInterface $object
   * @return Statement
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
   * @return AnonymousGroup
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
   * @return LanguageMap
   */
  function createLanguageMap($values);
  
  /**
   * @return Result
   */
  function createResult();
  
  /**
   * @return Score
   */
  function createScore();
  
  /**
   * @return Context
   */
  function createContext();
  
  /**
   * 
   * @param string $key 
   * @param array $value
   * @return ContextActivity
   */
  function createContextActivity($key, $value);
  
  /**
   * 
   * @param string $key
   * @param mixed $value
   * @return Extension
   */
  function createExtension($key, $value);
  
  /**
   * 
   * @param string $usageType IRI
   * @param LanguageMap $display
   * @param string $contentType
   * @param int $length
   * @param string $sha2 SHA-2 (SHA-256, SHA-384, SHA-512)
   * @return Attachment
   */
  function createAttachment($usageType, $display, $contentType, $length, $sha2);
}
