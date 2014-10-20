<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

use GO1\LMS\TinCan\Statement\Statement;

class SubStatement implements ObjectInterface {
  use ObjectTrait;
  
  const OBJECT_TYPE = 'SubStatement';
  
  protected $statement;
  
  public function __construct(Statement $statement) {
    $this->setStatement($statement);
  }
  
  /**
   * 
   * @param Statement $statement
   */
  protected function setStatement(Statement $statement) {
    $this->statement = $statement;
    // Not under any specific property
    $this->addArray($statement->toArray());
  }
}
