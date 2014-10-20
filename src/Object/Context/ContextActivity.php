<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Context;

use GO1\LMS\TinCan\TinCanAPI;
use GO1\LMS\TinCan\ArrayTrait;
use GO1\LMS\TinCan\Object\Activity;

class ContextActivity {
  use ArrayTrait;
  
  /**
   *
   * @var string parent|grouping|category|other
   */
  protected $key;
  
  /**
   *
   * @var array
   */
  protected $value;
  
  /**
   * 
   */
  public function __construct($key, $value) {
    if ($this->validateKey($key) &&
        $this->validateValue($value)) {
      $this->key = $key;
      $this->value = $value;
      $this->addArray(array($key => $value));
    }
  }
  
  /**
   * 
   * @param string $key
   * @throws Exception
   */
  protected function validateKey($key) {
    if (in_array($key, TinCanAPI::$contextActivityKeys)) {
      throw new Exception($key . ' is not supported.');
    }
  }
  
  /**
   * 
   * @param array $value
   */
  protected function validateValue($value) {
    if (is_array($value)) {
      foreach ($value as $each) {
        if (!$each instanceof Activity) {
          throw new Exception($each . ' must be Activity instance.');
        }
      }
      return TRUE;
    }
    else {
      throw new Exception($value . ' must be an array.');
    }
  }
}
