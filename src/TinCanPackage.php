<?php

namespace GO1\Aduro\TinCan;

class TinCanPackage implements TinCanPackageInterface {

  protected $manifest;
  protected $schemaFile;

  public function __construct($schemaFile) {
    $this->schemaFile = $schemaFile;
  }


  public function getSchemaFile() {
    return $this->schemaFile;
  }
  
  public function getManifest() {
    return $this->manifest;
  }

  /**
   * Parse tincan.xml to array.
   * @return type
   */
  public function parseManifest() {
    $content = simplexml_load_file($this->getSchemaFile());
    $this->manifest = json_decode(json_encode($content), TRUE);
    return $this->manifest;
  }
  
  public function getActivities() {
    $this->parseManifest();
    return isset($this->manifest['activities']) ? $this->manifest['activities'] : array();
  }
  
  public function getProvider() {
    $this->parseManifest();
    return isset($this->manifest['provider']) ? $this->manifest['provider'] : array();
  }
  
  

}
