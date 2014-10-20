<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Statement;

use GO1\LMS\TinCan\Object\ObjectInterface;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\Object\Result\Result;
use GO1\LMS\TinCan\Object\Verb;
use GO1\LMS\TinCan\Object\Attachment;
use GO1\LMS\TinCan\ArrayTrait;

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
   * @var ActorInterface
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
   * @param Result $result
   */
  public function setResult(Result $result) {
    $this->result = $result;
    $this->addArray(array('result' => $result->toArray()));
  }
  
  /**
   * 
   * @param Context $context
   */
  public function setContext($context) {
    $this->context = $context;
    $this->addArray(array('context' => $context->toArray()));
  }
  
  /**
   * 
   * @param string $timestamp
   * @see https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations
   */
  public function setTimestamp($timestamp) {
    $this->timestamp = new \DateTime($timestamp);
    $this->addArray(array('timestamp' => $timestamp));
  }
  
  /**
   * @param string $stored
   * @see https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations
   */
  public function setStored($stored) {
    $this->stored = new \DateTime($stored);
    $this->addArray(array('stored' => $stored));
  }
  
  /**
   * 
   * @param ActorInterface $authority
   */
  public function setAuthority(ActorInterface $authority) {
    $this->authority = $authority;
    $this->addArray(array('authority' => $authority->toArray()));
  }
  
  /**
   * 
   * @param string $version
   */
  public function setVersion($version) {
    $this->version = $version;
    $this->addArray(array('version' => $version));
  }
  
  /**
   * @param array $attachments
   */
  public function setAttachments($attachments) {
    if ($this->validateAttachments($attachments)) {
      $this->attachments = $attachments;
      
      $attachmentsArray = array();
      foreach ($attachments as $attachment) {
        $attachmentsArray[] = $attachment->toArray();
      }
      
      $this->addArray(array('attachments' => $attachmentsArray));
    }
  }
  
  /**
   * 
   * @param array $attachments
   * @return boolean
   */
  protected function validateAttachments($attachments) {
    foreach ($attachments as $attachment) {
      if (!$attachment instanceof Attachment) {
        return FALSE;
      }
    }
    return TRUE;
  }
}
