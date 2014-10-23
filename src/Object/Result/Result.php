<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Result;

use GO1\LMS\TinCan\ArrayTrait;
use GO1\LMS\TinCan\Object\ObjectInterface;

class Result implements ObjectInterface {
  use ArrayTrait;
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
  
  /**
   * 
   * @param Score $score
   */
  public function setScore(Score $score) {
    $this->score = $score;
    $this->addArray(array('score' => $score->toArray()));
  }
  
  /**
   * 
   * @param bool $bool
   */
  public function setSuccess($bool) {
    $this->success = $bool;
    // @todo check json_encode with TRUE/FALSE
    $this->addArray(array('success' => $bool ? 'true' : 'false'));
  }
  
  /**
   * 
   * @param bool $bool
   */
  public function setCompletion($bool) {
    $this->completion = $bool;
    // @todo check json_encode with TRUE/FALSE
    $this->addArray(array('completion' => $bool ? 'true' : 'false'));
  }
  
  /**
   * 
   * @param string $response
   */
  public function setResponse($response) {
    $this->response = $response;
    $this->addArray(array('response' => $response));
  }

  /**
   * 
   * @param string $duration
   */
  public function setDuration($duration) {
    $this->duration = $duration;
    //\DateInterval::createFromDateString($duration);
    $this->addArray(array('duration' => $duration));
  }
    
}
