<?php

namespace GO1\LMS\TinCan\LRS;

use GO1\LMS\TinCan\TinCanAPI;

class StatementRequestParam {
  
  protected $key;
  
  protected $value;
  
  public function __construct($key, $value) {
    if (in_array($key, TinCanAPI::$statementRequestParams)) {
      $this->key = $key;
      $this->value = $value;
    }
    else {
      throw new Exception($key . ' is not supported.');
    }
  }
  
  public function toArray() {
    return array(
      $this->key => $this->value
    );
  }
}