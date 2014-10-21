<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

use GO1\LMS\TinCan\Misc\LanguageMap;
use GO1\LMS\TinCan\ArrayTrait;

class Verb implements ObjectInterface {
  use ArrayTrait;
  /**
   *
   * @var string IRI
   */
  protected $id;
  
  /**
   *
   * @var LanguageMap 
   */
  protected $display;
  
  /**
   * 
   * @param string $id
   */
  public function __construct($id) {
    $this->setId($id);
  }
  
  /**
   * 
   * @param LanguageMap $display
   */
  public function setDisplay(LanguageMap $display) {
    $this->display = $display;
    $this->addArray(array('display' => $display->toArray()));
  }
  
  /**
   * 
   */
  public function setId($id) {
    $this->id = $id;
    // InverseIdentity is supposed to self declared its key
    $this->addArray(array('id' => $id));
  }

}
