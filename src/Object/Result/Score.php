<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Result;

use GO1\LMS\TinCan\ArrayTrait;
use GO1\LMS\TinCan\Object\ObjectInterface;

class Score implements ObjectInterface {
  use ArrayTrait;
  
  protected $scaled;
  
  protected $raw;
  
  protected $min;
  
  protected $max;
  
  /**
   * 
   * @param decimal $scaled
   */
  public function setScaled($scaled) {
    if ($this->validateScaled($scaled)) {
      $this->scaled = $scaled;
      $this->addArray(array('scaled' => $scaled));
    }
  }
  
  /**
   * 
   * @param float $scaled
   * @return boolean
   */
  protected function validateScaled($scaled) {
    if ($scaled < -1 && $scaled > 1) {
      return FALSE;
    }
    return TRUE;
  }
  
  /**
   * 
   * @param float $raw
   */
  public function setRaw($raw) {
    if (isset($this->max) && $raw > $this->max) {
      throw new Exception('raw property can\'t be greater than max.');
    }
    
    if (isset($this->min) && $raw < $this->min) {
      throw new Exception('raw property can\'t be less than min.');
    }
    
    $this->raw = $raw;
    $this->addArray(array('raw' => $raw));
  }
  
  /**
   * 
   * @param float $min
   */
  public function setMin($min) {
    if (isset($this->max) && $min > $this->max) {
      throw new Exception('min property can\'t be greater than max.');
    }
    $this->min = $min;
    $this->addArray(array('min' => $min));
  }
  
  /**
   * 
   * @param float $max
   */
  public function setMax($max) {
     if (isset($this->min) && $max < $this->min) {
      throw new Exception('max property can\'t be less than min.');
    }
    $this->max = $max;
    $this->addArray(array('max' => $max));
  }

  public function getRaw() {
    return $this->raw;
  }

  public function getScaled() {
    return $this->scaled;
  }

  public function getMax() {
    return $this->max;
  }

  public function getMin() {
    return $this->min;
  }
}
