<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Object\InverseIdentity;

use GO1\LMS\TinCan\TinCanAPI;

/**
 * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#inversefunctional
 */
class InverseIdentity {
  
  /**
   *
   * @var array
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#details-3
   *      mbox: string mailto IRI mailto:example@example.com 
   *      mbox_sha1sum: string SHA1 hash of mailto IRI f427d80dc332a166bf5f160ec15f009ce7e68c4c
   *      openid: string uri http://example.openid.example.com/
   *      account: array includes homePage and name
   */

  
  /**
   *
   * @var string mbox|mbox_sha1sum|openid|account 
   */
  protected $type;
  
  /**
   *
   * @var mixed 
   */
  protected $value;
  
  /**
   * 
   * @param string $type
   * @param mixed $value
   */
  public function __construct($type, $value) {
    if ($this->validateType($type) &&
        $this->validateValue($type, $value)) {
      $this->type = $type;
      $this->value = $value;
    }
  }
  
  /**
   * 
   * @param string $type
   * @throws Exception
   */
  protected function validateType($type) {
    if (!in_array($type, TinCanAPI::$inverseIdentityTypes)) {
      throw new \Exception($type . ' is not supported.');
    }
    return TRUE;
  }
  
  /**
   * 
   * @param string $type
   * @param mixed $value
   * @return boolean
   * @throws Exception
   */
  protected function validateValue($type, $value) {
    if ($type == 'account') {
      if (!is_array($value)) {
        throw new \Exception($type . ' must be an array.');
      }
    } 
    else {
      if (is_array($value)) {
        throw new \Exception($type . ' must be a string.');
      }
    }
    return TRUE;
  }
  
  /**
   * 
   */
  function toArray() {
    return array($this->type => $this->value);
  }
}
