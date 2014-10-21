<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Actor;

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
  public function __construct(InverseIdentity $id, $name = NULL, $members = NULL) {
    
    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setId($id);
    
    if (!is_null($name)) {
      $this->setName($name);
    }
    
    if (!is_null($members)) {
      $this->setMember($members);
      $this->addArray(array('member' => $this->makeMemberArray($members)));
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
