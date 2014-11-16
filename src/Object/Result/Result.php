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
    $this->addArray(array('duration' => $duration));
  }

  /**
   * @return DateInterval|null
   */
  public function getDuration() {
    // special case that need to initialize in getter
    if (!is_null($this->duration)) {
      $duration = new \DateInterval($this->removeDurationSec($this->duration));
      return $duration;
    }
    return $this->duration;
  }

  /**
   * @todo refactor
   * @param $duration
   * @return int
   */
  protected function removeDurationSec($duration) {
    return preg_replace('/\d+(\.\d+)?S$/', '', $duration);
  }

  /**
   * @todo refactor
   * @return int
   */
  public function getDurationSec() {
    $match = array();
    preg_match('/\d+(\.\d+)?S$/', $this->duration, $match);
    if (!empty($match)) {
      return floatval(reset($match));
    }
    return 0;
  }

  public function getSuccess($true = 'true', $false = 'false', $null = '') {
    if (!isset($this->success)) {
      return $null;
    }
    return $this->success ? $true : $false;
  }

  public function getCompletion($true = 'true', $false = 'false', $null = '') {
    if (!isset($this->completion)) {
      return $null;
    }
    return $this->completion ? $true : $false;
  }

  public function getScore() {
    return $this->score;
  }

  public function getResponse() {
    return $this->response;
  }

}
