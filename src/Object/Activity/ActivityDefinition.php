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
  protected $interactionType;
  protected $correctResponsePatterns;
  protected $choices;
  protected $scale;
  protected $source;
  protected $target;
  protected $steps;
  protected $extensions;

  /**
   * 
   * @param LanguageMap $name
   */
  public function setName(LanguageMap $name) {
    $this->name = $name;
    $this->addArray(array('name' => $name->toArray()));
  }

  /**
   * @param LanguageMap $description
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

  /**
   * 
   * @param string $interactionType
   */
  public function setInteractionType($interactionType) {
    if (in_array($interactionType, TinCanAPI::$interactionTypes)) {
      $this->interactionType = $interactionType;
      $this->addArray(array('interactionType' => $interactionType));
    }
  }

  /**
   * 
   * @param string $property
   * @param array $components
   * @param string $interactionType
   */
  public function setComponents($property, $components, $interactionType) {
    if ($this->validateSupportedMap($interactionType, $property) &&
        $this->validateComponents($components)) {

      $this->setInteractionType($interactionType);
      $this->$property = $components;

      $componentsArray = array();
      foreach ($components as $component) {
        $componentsArray[] = $component->toArray();
      }
      $this->addArray(array($property => $componentsArray));
    }
  }

  /**
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#details-10
   */
  protected function validateSupportedMap($interactionType, $componentList) {
    // Exclude true-false, fill-in, long-fill-in, numeric, other
    if (in_array($interactionType, TinCanAPI::$interactionTypes) &&
        in_array($componentList, TinCanAPI::$interactionComponentMap[$interactionType])) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * 
   */
  protected function validateComponents($components) {
    foreach ($components as $component) {
      if (!$component instanceof InteractionComponent) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
   * 
   * @param array $patterns Each pattern is a string
   */
  public function setCorrectResponsePatterns($patterns) {
    $this->correctResponsePatterns = $patterns;
    $this->addArray(array('correctResponsePatterns' => $patterns));
  }

}
