<?php

namespace GO1\LMS\TinCan\Object\Activity;

class Activity implements ObjectInterface {
  use ObjectTrait;
  
  const OBJECT_TYPE = 'Activity';
  
  protected $id;

  protected $definition;
  
  /**
   * 
   * @param string $id IRI unique identifier
   * @param ActivityDefinition $definition optional
   */
  public function __construct($id, ActivityDefinition $definition = null) {
    $this->setId($id);
    
    if (!is_null($definition)) {
      $this->definition = $definition;
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
  
}
