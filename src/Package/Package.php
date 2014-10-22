<?php

namespace GO1\LMS\TinCan\Package;

use GO1\LMS\TinCan\TinCanAPI;

class Package implements PackageInterface {

  private $xmlDoc;
  protected $schemaFile;

  public function __construct($schemaFile) {
    $this->schemaFile = $schemaFile;
    $this->xmlDoc = simplexml_load_file($schemaFile);
    $this->xmlDoc->registerXPathNamespace('x', 'http://projecttincan.com/tincan.xsd');
  }
  
  /**
   * @{inheritdoc}
   */
  public function getActivities() {
    return $this->xmlDoc->xpath('/x:tincan/x:activities/x:activity');
  }
  
  /**
   * Get the actity has child launch element
   */
  public function getLaunchActivity() {
    $result = $this->xmlDoc->xpath('(/x:tincan/x:activities/x:activity[x:launch])[1]');
    return reset($result); 
  }
  
  /**
   * @{inheritdoc}
   */
  public function getLaunchActivityId() {
    return (string) $this->getLaunchActivity()['id'];
  }
  
  /**
   * @{inheritdoc}
   */
  public function getLaunchValue() {
    return (string) $this->getLaunchActivity()->launch;
  }
  
  /**
   * @{inheritdoc}
   */
  public function getTopGranularActivityId() {
    $result = $this->xmlDoc->xpath('(/x:tincan/x:activities/x:activity[@type=\'' . 
        TinCanAPI::$topGranularActivityType . '\'])[1]');
    $object = reset($result);
    return (string) $object['id']; 
  }
  
  /**
   * 
   * @return string path to tincan.xml
   */
  public function getSchemaFile() {
    return $this->schemaFile;
  }

}
