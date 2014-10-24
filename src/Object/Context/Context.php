<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\Context;

use GO1\LMS\TinCan\Misc\Extension;
use GO1\LMS\TinCan\Object\StatementRef;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\Object\Actor\GroupBase;
use GO1\LMS\TinCan\ArrayTrait;

class Context {
  use ArrayTrait;
  /**
   *
   * @var string UUID
   */
  protected $registration;

  /**
   *
   * @var ActorInterface 
   */
  protected $instructor;

  /**
   *
   * @var GroupBase
   */
  protected $team;

  /**
   *
   * @var array 
   */
  protected $contextActivities;

  /**
   *
   * @var string
   */
  protected $revision;

  /**
   *
   * @var string
   */
  protected $platform;

  /**
   *
   * @var string
   * @see http://tools.ietf.org/html/rfc5646
   */
  protected $language;

  /**
   *
   * @var StatementRef 
   */
  protected $statement;

  /**
   *
   * @var array
   */
  protected $extensions;

  /**
   * 
   * @param string $registration UUID
   */
  public function setRegistration($registration) {
    $this->registration = $registration;
    $this->addArray(array('registration' => $registration));
  }

  /**
   * 
   * @param ActorInterface $actor
   */
  public function setInstructor(ActorInterface $actor) {
    $this->instructor = $actor;
    $this->addArray(array('instructor' => $actor->toArray()));
  }

  /**
   * 
   * @param GroupBase $group
   */
  public function setTeam(GroupBase $team) {
    $this->team = $team;
    $this->addArray(array('team' => $team->toArray()));
  }

  /**
   * 
   * @param type $activities
   */
  public function setContextActivities($activities) {
    $this->contextActivities = $activities;

    $activitiesArray = array();
    foreach ($activities as $group => $members) {
      foreach ($members as $activity) {
        $activitiesArray[$group][] = $activity->toArray();
      }
    }
    $this->addArray(array('contextActivities' => $activitiesArray));
  }
  
  public function getContextActivities() {
    return $this->contextActivities;
  }

  /**
   * 
   * @param string $revision
   */
  public function setRevision($revision) {
    $this->revision = $revision;
    $this->addArray(array('revision' => $revision));
  }

  /**
   * 
   * @param string $platform
   */
  public function setPlatform($platform) {
    $this->platform = $platform;
    $this->addArray(array('platform' => $platform));
  }

  /**
   * 
   * @param string $language
   */
  public function setLanguage($language) {
    // @todo validation
    $this->language = $language;
    $this->addArray(array('language' => $language));
  }

  /**
   * 
   * @param StatementRef $statement
   */
  public function setStatement(StatementRef $statement) {
    $this->statement = $statement;
    $this->addArray(array('statement' => $statement->toArray()));
  }

  /**
   * 
   * @param array $extensions
   */
  public function setExtensions($extensions) {
    if ($this->validateExtensions($extensions)) {
      $this->extensions = $extensions;

      $extensionsArray = array();
      foreach ($extensions as $extension) {
        $extensionsArray[] = $extension->toArray();
      }
      $this->addArray(array('contextActivities' => $extensionsArray));
    }
  }

  /**
   * 
   * @param array $extensions
   * @return boolean
   * @throws Exception
   */
  protected function validateExtensions($extensions) {
    foreach ($extensions as $extension) {
      if (!$extension instanceof Extension) {
        throw new Exception($extension . ' must be Extension instance.');
      }
    }
    return TRUE;
  }

  /**
   * 
   */
  public function getRegistration() {
    return $this->registration;
  }
}
