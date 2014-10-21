<?php

namespace GO1\LMS\TinCan\Package;

interface PackageInterface {

  /**
   * @return array activities
   */
  function getActivities();
  
  /**
   * @return array structure of tincan.xml
   */
  function getMetadata();
  
  /**
   * 
   * @param array $metadata
   */
  function setMetadata($metadata = array());
  
}
