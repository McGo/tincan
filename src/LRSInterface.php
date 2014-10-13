<?php

namespace GO1\Aduro\TinCan;

interface LRSInterface {
  
  /**
   * @return string url to LRS endpoint, trailing slash is necessary
   */
  function getEndpoint();

  /**
   * Set url of LRS
   * @param type $endpoint
   * 
   */
  function setEndpoint($endpoint);
  
  /**
   * @return string HTTP basic access authentication
   */
  function getAuth();

  /**
   * Set HTTP basic access authentication
   * @param string $username
   * @param string $password
   */
  function setAuth($username, $password);
  
}
