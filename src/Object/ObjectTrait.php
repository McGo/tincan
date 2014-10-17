<?php

namespace GO1\LMS\TinCan\Object;

trait ObjectTrait {
  
  protected $objectType;
  
  protected $arrayStructure = array();
  
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
  
  /**
   * @todo change to getArrayStructure
   * @return array
   */
  protected function toArray() {
    return $this->arrayStructure;
  }
  
  /**
   * 
   * @param type $values
   */
  public function addArray($values) {
    $this->arrayStructure += $values;
  }
}
