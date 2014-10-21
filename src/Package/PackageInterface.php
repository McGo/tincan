<?php

namespace GO1\LMS\TinCan\Package;

interface PackageInterface {

  /**
   * @return array
   */
  function getActivities();
  
  /**
   * @return array
   */
  function getLaunchActivity();
  
}
