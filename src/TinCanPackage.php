<?php

namespace GO1\Aduro\TinCan;

class TinCanPackage implements TinCanPackageInterface {

  protected $manifest;

  public function __construct($schemaFile) {
    $this->setManifest($this->parseManifest($schemaFile));
  }

  /**
   * Parse tincan.xml to array.
   * @return type
   */
  public function parseManifest($schemaFile) {
    $content = simplexml_load_file($schemaFile);
    //@todo is this correct way to parse xml file ?
    return json_decode(json_encode($content), TRUE);
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

}
