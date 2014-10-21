<?php

namespace GO1\LMS\TinCan\LRS;

class LRS implements LRSInterface {
  
  protected $username;
  protected $password;
  protected $endpoint;
  protected $version;
  protected $auth;

  public function __construct($endpoint, $username, $password) {
    $this->username = $username;
    $this->password = $password;
    $this->setEndpoint($endpoint);
    $this->setVersion(\TinCan\Version::latest());
    $this->setAuth();
  }
  
  public function setVersion($version) {
    $this->version = $version;
  }
  
  public function getVersion() {
    return $this->version;
  }


  public function getEndpoint() {
    return $this->endpoint;
  }
  
  public function setEndpoint($endpoint) {
    $this->endpoint = $endpoint;
  }
  
  public function getAuth() {
    return $this->auth;
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