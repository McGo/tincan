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
  function getActivitiesByType($type);
  
  /**
   * @return string
   */
  function getLaunchActivityId();
  
  /**
   * @return string
   */
  function getLaunchValue();
  
  /**
   * @see http://adlnet.gov/expapi/activities/course
   * Top level of granularity activity in the package
   * @return 
   */
  function getTopGranularActivityId();
}
