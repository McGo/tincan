<?php

namespace GO1\LMS\TinCan;

interface TinCanPackageInterface {

  /**
   * @return array activities
   */
  function getActivities();
  
  /**
   * @return array parsed array structure of tincan.xml
   */
  function getManifest();
  
  /**
   * 
   * @param array $manifest
   */
  function setManifest($manifest = array());
  
}
