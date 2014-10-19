<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Misc;

class Extension {
  
  protected $key;
  
  protected $value;
  
  public function __construct($key, $value) {
    $this->key = $key;
    $this->value = $value;
  }
  
  public function toArray() {
    return array($this->key => $this->value);
  }
}
