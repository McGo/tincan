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
   */
  public function __construct($usageType, LanguageMap $display, $contentType, $length, $sha2) {
    
  }
  
}
