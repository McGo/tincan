<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Actor;

use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentityObjectTrait;

class Agent implements ActorInterface {
  use InverseIdentityObjectTrait;
  
  const OBJECT_TYPE = 'Agent';
  
  //Agent full name
  protected $name;
  
  /**
   * 
   * @param InverseFunctionalIdentifier $id required
   * @param string $name optional
   */
  public function __construct(InverseIdentity $id, $name = NULL) {
    
//    $this->setObjectType(self::OBJECT_TYPE);
    
    $this->setId($id);
    
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

  public function getName() {
    return $this->name;
  }
}
