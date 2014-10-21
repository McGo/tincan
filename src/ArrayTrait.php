<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

trait ArrayTrait {
  
  protected $arrayStructure = array();
  
  /**
   * @todo change to getArrayStructure
   * @return array
   */
  public function toArray() {
    return $this->arrayStructure;
  }
  
  /**
   * 
   * @param type $values
   */
  public function addArray($values) {
    $this->arrayStructure += $values;
  }
  
  /**
   * @todo move to proper place
   * @param string $property
   */
  public function get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
}
