<?php

namespace GO1\LMS\TinCan;

/**
 *
 * @author khoa <khoa@go1.com.au>
 */
trait ArrayTrait {
  
  protected $arrayStructure = array();
  
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
