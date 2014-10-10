<?php

namespace GO1\Aduro\TinCan;

class TinCanPackage implements TinCanPackageInterface {

  protected $manifest;
  protected $filePath;

  public function __construct($xmlFilePath) {
    $this->filePath = $xmlFilePath;
  }


  public function getFilePath() {
    return $this->filePath;
  }

  /**
   * Parse tincan.xml to array.
   * @return type
   */
  protected function parseManifest() {
    $content = simplexml_load_file($this->getFilePath());
    $this->manifest = json_decode(json_encode($content), TRUE);
    return $this->manifest;
  }
  
  protected function getActivities() {
    $this->parseManifest();
    return isset($this->manifest->activities) ? $this->manifest->activities : array();
  }
  
  protected function getProvider() {
    $this->parseManifest();
    return isset($this->manifest->provider) ? $this->manifest->provider : array();
  }
  
  

}
