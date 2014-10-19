<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Statement;

use GO1\LMS\TinCan\Object\ObjectInterface;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\Object\Verb;

class Statement {
  use ArrayTrait;
  /**
   *
   * @var string UUID
   */
  protected $id;
  
  /**
   * 
   * @var ActorInterface
   */
  protected $actor;
  
  /**
   * 
   * @var Verb
   */
  protected $verb;
  
  /**
   *
   * @var ObjectInterface
   */
  protected $object;
  
  /**
   *
   * @var ObjectInterface
   */
  protected $result;
  
  /**
   *
   * @var ObjectInterface
   */
  protected $context;
  
  /**
   * @var DateTime
   */
  protected $timestamp;
  
  /**
   * @var DateTime
   */
  protected $stored;
  
  /**
   *
   * @var ObjectInterface
   */
  protected $authority;
  
  /**
   *
   * @var string semantic version
   */
  protected $version;
  
  /**
   * @var array
   */
  protected $attachments;
  
  /**
   * 
   */
  public function __construct(ActorInterface $actor, Verb $verb, ObjectInterface $object) {
    $this->setActor($actor);
    $this->setVerb($verb);
    $this->setObject($object);
  }
  
  /**
   * 
   * @param ActorInterface $actor
   */
  public function setActor(ActorInterface $actor) {
    $this->actor = $actor;
    $this->addArray(array('actor' => $actor->toArray()));
  }
  
  /**
   * 
   * @param Verb $verb
   */
  public function setVerb(Verb $verb) {
    $this->verb = $verb;
    $this->addArray(array('verb' => $verb->toArray()));
  }
  
  /**
   * @param ObjectInterface $object
   */
  public function setObject(ObjectInterface $object) {
    $this->object = $object;
    $this->addArray(array('object' => $object->toArray()));
  }
  
  /**
   * 
   * @param string $id UUID
   */
  public function setId($id) {
    $this->id = $id;
    $this->addArray(array('id' => $id));
  }
  
  /**
   * 
   */
}
