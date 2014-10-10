<?php

namespace GO1\Aduro\TinCan;

use GO1\Aduro\TinCan\LRSInterface;
use TinCan\RemoteLRS;

class LRS extends RemoteLRS implements LRSInterface {

  protected $endpoint;
  protected $username;
  protected $password;

  function __construct($endpoint, $username, $password) {
    $this->endpoint = $endpoint;
    $this->username = $username;
    $this->password = $password;
    $this->setAuth();
  }

  public function getUsername() {
    return $this->username;
  }
  
  public function getPassword() {
    return $this->password;
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  public function setUserName($username) {
    $this->username = $username;
  }
  
  public function setAuth() {
    $this->auth = 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword());
  }

}
