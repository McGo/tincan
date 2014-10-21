<?php

namespace GO1\LMS\TinCan\Package;

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
   * Get the actity has properties launch
   */
  public function getLaunchActivity() {
    return reset($this->xmlDoc->xpath('(/x:tincan/x:activities/x:activity[x:launch])[1]')); 
  }
  
  /**
   * 
   * @return string path to tincan.xml
   */
  public function getSchemaFile() {
    return $this->schemaFile;
  }

}
