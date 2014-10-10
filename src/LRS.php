<?php

namespace GO1\Aduro\TinCan;

use GO1\Aduro\TinCan\LRSInterface;

class LRS implements LRSInterface {

  protected $endpoint;
  protected $username;
  protected $password;

  function __construct($endpoint, $username, $password) {
    $this->endpoint = $endpoint;
    $this->username = $username;
    $this->password = $password;
  }

  public function getEndpoint() {
    return $this->endpoint;
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

  public function setEndpoint($endpoint) {
    $this->endpoint = $endpoint;
  }

  public function setUserName($username) {
    $this->username = $username;
  }
  
  public function getAuth() {
    return 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword());
  }

}
