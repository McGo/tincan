<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

class StatementRef implements ObjectInterface {
  use ObjectTrait;
  
  const OBJECT_TYPE = 'StatementRef';
  
  /**
   *
   * @var string statement UUID 
   */
  protected $id;
  
  public function __construct($id) { 
    $this->setObjectType(self::OBJECT_TYPE); 
    $this->setId($id);
  }
  
  /**
   * 
   * @param string $id statement UUID
   */
  public function setId($id) {
    $this->id = $id;
    $this->addArray(array('id' => $id));
  }
}
