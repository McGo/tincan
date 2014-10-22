<?php

namespace GO1\LMS\TinCan\LRS;

use GO1\LMS\TinCan\TinCanAPI;

// @todo reconsider class naming and namespace
class StatementGetParam {
  
  protected $key;
  
  protected $value;
  
  public function __construct($name, $value) {
    if (in_array($name, TinCanAPI::$statementRequestParams)) {
      $this->name = $name;
      $this->value = $value;
    }
    else {
      throw new Exception($key . ' is not supported.');
    }
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function getValue() {
    return $this->value;
  }
}