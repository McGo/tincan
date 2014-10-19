<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Activity;

use GO1\LMS\TinCan\ArrayTrait;
use GO1\LMS\TinCan\Misc\LanguageMap;

class InteractionComponent {
  use ArrayTrait;
  
  /**
   *
   * @var string
   */
  protected $id;
  
  /**
   *
   * @var LanguageMap
   */
  protected $description;
  
  /**
   * 
   * @param string $id
   */
  public function __construct($id) {
    $this->setId($id);
  }
  
  /**
   *
   * @param string $id
   */
  public function setId($id) {
    $this->id = $id;
    $this->addArray(array('id' => $id));
  }
  
  /**
   * 
   * @param LanguageMap $description
   */
  public function setDescription(LanguageMap $description) {
    $this->description = $description;
    $this->addArray(array('description' => $description->toArray()));
  }
  
}
