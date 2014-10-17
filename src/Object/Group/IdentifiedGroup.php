<?php

namespace GO1\LMS\TinCan\Object\Group;

use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentityObjectTrait;

class IdentifiedGroup extends GroupBase {
  use InverseIdentityObjectTrait;
  
  protected $name;
  
  /**
   * Singular as declared in Tin Can API
   */
  protected $member;
  
  /**
   * 
   * @param InverseFunctionalIdentifier $id required
   * @param string $name optional
   * @param array $members optional
   */
  public function __construct(InverseIdentity $id, $name = null, $members = null) {
    
    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setId($id);
    
    if (!is_null($name)) {
      $this->setName($name);
    }
    
    if (!is_null($members)) {
      $this->setMember($members);
    }
    
  }

}
