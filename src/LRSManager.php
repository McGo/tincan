<?php

namespace GO1\Aduro\TinCan;
use TinCan\RemoteLRS;

class LRSManager extends RemoteLRS {
  
  public function __construct($endpoint, $version, $username, $password) {
    parent::__construct($endpoint, $version, $username, $password);
  }
  
  
}

