<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Context;

use GO1\LMS\TinCan\Object\StatementReference;

class Context {
  
  /**
   *
   * @var string UUID
   */
  protected $registration;
  
  /**
   *
   * @var ActorInterface 
   */
  protected $instructor;
  
  /**
   *
   * @var GroupBase
   */
  protected $team;
  
  /**
   *
   * @var array 
   */
  protected $contextActivities;
  
  /**
   *
   * @var string
   */
  protected $revision;
  
  /**
   *
   * @var string
   */
  protected $platform;
  
  /**
   *
   * @var string
   * @see http://tools.ietf.org/html/rfc5646
   */
  protected $language;
  
  /**
   *
   * @var StatementReference 
   */
  protected $statement;
  
  /**
   *
   * @var array
   */
  protected $extensions;
  
  
}