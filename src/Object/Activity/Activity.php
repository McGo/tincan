<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Activity;

use GO1\LMS\TinCan\Object\ObjectTrait;
use GO1\LMS\TinCan\Object\ObjectInterface;

class Activity implements ObjectInterface {
  use ObjectTrait;
  
  const OBJECT_TYPE = 'Activity';
  
  /**
   *
   * @var string IRI identifier
   */
  protected $id;

  /**
   *
   * @var ActivityDefinition 
   */
  protected $definition;
  
  /**
   * 
   * @param string $id IRI unique identifier
   * @param ActivityDefinition $definition optional
   */
  public function __construct($id, ActivityDefinition $definition = NULL) {
    $this->setId($id);
    
    if (!is_null($definition)) {
      $this->setDefinition($definition);
    }
  }
  
  /**
   * 
   * @param string $id IRI identifier
   */
  public function setId($id) {
    $this->id = $id;
    $this->addArray(array('id' => $id));
  }
  
  public function getId() {
    return $this->id;
  }
  
  /**
   * 
   */
  public function setDefinition($definition) {
    //@todo validation
    $this->definition = $definition;
    $this->addArray(array('definition' => $definition->toArray()));
  }
  
  
  
}
