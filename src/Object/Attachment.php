<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object;

use GO1\LMS\TinCan\Misc\LanguageMap;

class Attachment {

  /**
   *
   * @var string IRI 
   */
  protected $usageType;

  /**
   *
   * @var LanguageMap 
   */
  protected $display;

  /**
   *
   * @var LanguageMap 
   */
  protected $description;

  /**
   * @var string
   * @see https://www.ietf.org/rfc/rfc2046.txt?number=2046
   */
  protected $contentType;

  /**
   *
   * @var int
   */
  protected $length;

  /**
   *
   * @var string SHA-2 (SHA-256, SHA-384, SHA-512)
   */
  protected $sha2;

  /**
   *
   * @var string IRL
   */
  protected $fileUrl;

  /**
   * 
   * @param string $usageType IRI
   * @param LanguageMap $display
   * @param string $contentType
   * @param int $length
   * @param string $sha2 SHA-2 (SHA-256, SHA-384, SHA-512)
   */ 
  public function __construct($usageType, LanguageMap $display, $contentType, $length, $sha2) {
    $this->setUsageType($usageType);
    $this->setDisplay($display);
    $this->setContentType($contentType);
    $this->setLength($length);
    $this->setSha2($sha2);
  }
  
  /**
   * 
   * @param string $usageType IRI
   */
  public function setUsageType($usageType) {
    $this->usageType = $usageType;
    $this->addArray(array('usageType' => $usageType));
  }
  
  /**
   * 
   * @param LanguageMap $display
   */
  public function setDisplay($display) {
    $this->display = $display;
    $this->addArray(array('display' => $display->toArray()));
  }
  
  /**
   * 
   * @param string $contentType
   */
  public function setContentType($contentType) {
    $this->contentType = $contentType;
    $this->addArray(array('contentType' => $contentType));
  }

  /**
   * 
   * @param int $length
   */
  public function setLength($length) {
    $this->length = $length;
    $this->addArray(array('length' => $length));
  }
  
  /**
   * 
   * @param string $sha2 SHA-2 (SHA-256, SHA-384, SHA-512)
   */
  public function setSha2($sha2) {
    $this->sha2 = $sha2;
    $this->addArray(array('sha2' => $sha2));
  }
  
  /**
   * 
   * @param LanguageMap $description
   */
  public function setDescription(LanguageMap $description) {
    $this->description = $description;
    $this->addArray(array('description' => $description->toArray()));
  }
  
  /**
   * 
   * @param string $fileUrl
   */
  public function setFileUrl($fileUrl) {
    $this->fileUrl = $fileUrl;
    $this->addArray(array('fileUrl' => $fileUrl));
  }
  
}
