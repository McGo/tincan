<?php

namespace GO1\LMS\TinCan\Object;

class AnonymousGroup extends GroupBase {
  
  /**
   * @param array $members required
   * @param string $name optional
   */
  public function __construct($members, $name = null) {
    
    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setMember($members);
    
    if (!is_null($name)) {
      $this->setName($name);
    }
    
  }
  
}
