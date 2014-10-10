<?php

namespace GO1\Aduro\TinCan;

use GO1\Aduro\TinCan\LRSInterface;

class LRS implements LRSInterface {

  protected $endpoint;
  protected $version;
  protected $auth;

  function __construct($endpoint, $version, $auth) {
    $this->endpoint = $endpoint;
    $this->version = $version;
    $this->auth = $auth;
  }

  public function getEndpoint() {
    return $this->endpoint;
  }

  public function getAuth() {
    return $this->auth;
  }

  public function getVersion() {
    return $this->version;
  }

  public function setAuth($auth) {
    $this->auth = $auth;
  }

  public function setEndpoint($endpoint) {
    $this->endpoint = $endpoint;
  }

  public function setVersion($version) {
    $this->version = $version;
  }

}
