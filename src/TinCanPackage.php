<?php

namespace GO1\Aduro\TinCan;

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
