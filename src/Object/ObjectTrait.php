<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

use GO1\LMS\TinCan\ArrayTrait;

trait ObjectTrait {
  use ArrayTrait;
  
  protected $objectType;
  
  /**
   * @return string 
   */
  public function getObjectType() {
    return $this->objectType;
  }
  
  /**
   * 
   * @param string $objectType
   */
  public function setObjectType($objectType) {
    $this->objectType = $objectType;
    $this->addArray('objectType', $objectType);
  }
  
}
