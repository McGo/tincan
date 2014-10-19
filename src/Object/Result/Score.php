<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Result;

use GO1\LMS\TinCan\Object\ObjectInterface;

class Score implements ObjectInterface {
  
  protected $scaled;
  
  protected $raw;
  
  protected $min;
  
  protected $max;
  
}
