<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Actor;

class AnonymousGroup extends GroupBase {
  
  /**
   * @param array $members required
   * @param string $name optional
   */
  public function __construct($members, $name = NULL) {
    
    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setMember($members);
    
    if (!is_null($name)) {
      $this->setName($name);
    }
    
  }
  
}
