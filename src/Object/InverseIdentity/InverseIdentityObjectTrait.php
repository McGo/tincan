<?php

namespace GO1\LMS\TinCan\Object\InverseIdentity;

use GO1\LMS\TinCan\Object\ObjectTrait;

trait InverseIdentityObjectTrait {
  
  use ObjectTrait;
  
  protected $id;
  
  /**
   * 
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * 
   */
  public function setId(InverseIdentity $id) {
    $this->id = $id;
    $this->addArray($this->id->toArray());
  }
  
}
