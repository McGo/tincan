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
   * Get user name to access to LRS
   */
  function getUsername();
  
  /**
   * Get password to authen to LRS
   */
  function getPassword();
  
  /**
   * Get version tincan API
   */
  function getVersion();
  
  
  /**
   * Set version will be use for LRS
   * @param type $version
   */
  function setVersion($version);

  /**
   * Get authentication string(basic authentication)
   */
  function getAuth();
    
}
