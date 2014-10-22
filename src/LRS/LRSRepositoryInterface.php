<?php

namespace GO1\LMS\TinCan\LRS;

interface LRSRepositoryInterface {
  
  /**
   * Get statements with parameters as criteria (if any)
   */
  function getStatements($params = array());
  
}
