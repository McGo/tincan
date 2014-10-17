<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Activity;

use GO1\LMS\TinCan\Misc\LanguageMap;
use GO1\LMS\TinCan\Object\ObjectTrait;


class ActivityDefinition {
  use ObjectTrait;
  
  protected $name;
  
  protected $description;
  
  protected $type;
  
  protected $moreInfo;
  
  protected $interactionProperties;
  
  protected $extensions;
  
  /**
   * 
   * @param type $name
   */
  public function setName(LanguageMap $name) {
    $this->name = $name;
    $this->addArray(array('name' => $name));
  }
  
  /**
   * @param string $description
   */
  public function setDescription(LanguageMap $description) {
    $this->description = $description;
    $this->addArray(array('description' => $description->toArray()));
  }
  
  /**
   * 
   * @param string $type IRI
   */
  public function setType($type) {
    $this->type = $type;
    $this->addArray(array('type' => $type));
  }
  
  /**
   * 
   * @param string $moreInfo IRL
   */
  public function setMoreInfo($moreInfo) {
    $this->moreInfo = $moreInfo;
    $this->addArray(array('moreInfo' => $moreInfo));
  }
  
  /**
   * 
   * @param InteractionActivity $interactionProperties
   */
  public function setInteractionProperties(InteractionActivity $interactionProperties) {
    $this->interactionProperties = $interactionProperties;
  }
}
