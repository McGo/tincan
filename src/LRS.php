<?php

namespace GO1\Aduro\TinCan;

//use GO1\Aduro\TinCan\LRSInterface;
use TinCan\RemoteLRS;

/**
 * @todo remove extending of RemoteLRS
 */
class LRS extends RemoteLRS implements LRSInterface {
  protected $username;
  protected $password;

  public function __construct($endpoint, $username, $password) {
    $this->username = $username;
    $this->password = $password;
    $this->setEndpoint($endpoint);
    $this->setAuth($username, $password);
    $this->setVersion(\TinCan\Version::latest());
  }
  
  public function setAuth() {
    $this->auth = 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword());
  }
  
  public function getUsername() {
    return $this->username;
  }
  
  public function getPassword() {
    return $this->password;
  }

}