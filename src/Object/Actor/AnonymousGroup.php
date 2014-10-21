<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Actor;

use GO1\LMS\TinCan\Object\ObjectTrait;

class AnonymousGroup extends GroupBase {
  use ObjectTrait;
  /**
   * @param array $members required
   * @param string $name optional
   */
  public function __construct($members, $name = NULL) {
    
    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setMember($members);
    $this->addArray(array('member' => $this->makeMemberArray($members)));
    
    if (!is_null($name)) {
      $this->setName($name);
    }
    
  }
  
  /**
   * 
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
    $this->addArray(array('name' => $name));
  }
  
}
