<?php

namespace GO1\LMS\TinCan;

class TinCanPackage implements TinCanPackageInterface {

  protected $manifest;
  protected $schemaFile;

  public function __construct($schemaFile) {
    $this->schemaFile = $schemaFile;
    $this->setManifest($this->parseManifest($schemaFile));
  }

  /**
   * Parse tincan.xml to array.
   * @return type
   */
  public function parseManifest($schemaFile) {
    $content = simplexml_load_file($schemaFile);
    // SimpleXMLElement to JSON string
    $json = json_encode($content);
    
    return json_decode($json, TRUE);
  }
  
  /**
   * @{inheritdoc}
   */
  public function getActivities() {
    return isset($this->manifest['activities']) ? $this->manifest['activities'] : array();
  }
  
  /**
   * Get the actity has properties launch
   */
  public function getCourse() {
    // Get activities
    $activities = $this->getActivities();
    
    // The activities has only activity
    if(isset($activities['activity']['@attributes'])) {
      if (isset($activities['activity']['launch'])) {
        return $activities['activity']['@attributes']['id'];
      }
    }
    else { // The activities has more activity
      foreach ($activities['activity'] as $activity) {
        // Looking for main activity of package.
        if (isset($activity['launch'])) {
          return $activity['@attributes']['id'];
        }
      }
    }
    return FALSE;
  }

  /**
   * @{inheritdoc}
   */
  public function getManifest() {
    return $this->manifest;
  }

  /**
   * @{inheritdoc}
   */
  public function setManifest($manifest = array()) {
    $this->manifest = $manifest;
  }
  
  /**
   * 
   * @return string path to tincan.xml
   */
  public function getSchemaFile() {
    return $this->schemaFile;
  }

}
