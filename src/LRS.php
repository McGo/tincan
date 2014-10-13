<?php

namespace GO1\Aduro\TinCan;

use GO1\Aduro\TinCan\LRSInterface;
use TinCan\RemoteLRS;

/**
 * @todo remove extending of RemoteLRS
 */
class LRS extends RemoteLRS implements LRSInterface {

  function __construct($endpoint, $username, $password) {
    $this->setEndpoint($endpoint);
    $this->setAuth($username, $password);
  }
  
  public function setAuth($username, $password) {
    $this->auth = 'Basic ' . base64_encode($username . ':' . $password);
  }

}