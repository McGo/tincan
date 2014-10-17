<?php

namespace GO1\LMS\TinCan\Object\Group;

use GO1\LMS\TinCan\Object\ObjectInterface;

class GroupBase implements ObjectInterface {
  
  const OBJECT_TYPE = 'Group';

  /**
   * 
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
    $this->addArray(array('name' => $name));
  }
  
  /**
   * 
   * @param array $members
   */
  public function setMember($members) {
    //@todo validate $members parameter
    $this->member = $members;
    $this->addArray(array('member' => $this->makeMemberArray($members)));
  }
  
  /**
   * 
   * @param array $members
   * @return array
   */
  protected function makeMemberArray($members) {
    $group = array();
    foreach ($members as $member) {
      $group[] = $member->toArray();
    }
    return $group;
  }
  
  /**
   * @param array $members
   * @return bool
   */
  public function validateMember($members) {
    foreach ($members as $member) {
      if (!$member instanceof Agent) {
        return FALSE;
      }
    }
    return TRUE;
  }
}
