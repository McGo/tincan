<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Actor;

use GO1\LMS\TinCan\ArrayTrait;

abstract class GroupBase implements ActorInterface {
  
  const OBJECT_TYPE = 'Group';
  
  /**
   * 
   * @param array $members
   */
  public function setMember($members) {
    //@todo validate $members parameter
    $this->member = $members;
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
