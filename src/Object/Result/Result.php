<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Result;

use GO1\LMS\TinCan\Object\ObjectInterface;

class Result implements ObjectInterface {

  /**
   * @var Score
   */
  protected $score;
  
  /**
   *
   * @var bool 
   */
  protected $success;
  
  /**
   *
   * @var bool 
   */
  protected $completion;
  
  /**
   * @var string
   */
  protected $response;
  
  /**
   * @var DateInterval
   */
  protected $duration;
  
  /**
   * @var array
   */
  protected $extensions;
}
