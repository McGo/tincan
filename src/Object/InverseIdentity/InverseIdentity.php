<?php

namespace GO1\LMS\TinCan\Object\InverseIdentity;

/**
 * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#inversefunctional
 */
class InverseIdentity {
  
  /**
   *
   * @var string mailto IRI mailto:example@example.com 
   */
  protected $mbox;
  
  /**
   *
   * @var string SHA1 hash of mailto IRI f427d80dc332a166bf5f160ec15f009ce7e68c4c
   */
  protected $mbox_sha1sum;
  
  /**
   *
   * @var string uri http://example.openid.example.com/
   */
  protected $openid;
  
  /**
   *
   * @var array includes homePage and name 
   */
  protected $account;
  
  /**
   * @var string 
   */
  private $property;
  
  
  function __construct($property, $value) {
    if (!property_exists($this, $property)) {
      throw new Exception($property . ' is not defined.');
    }
    // @todo validation
    $this->$property = $value;
    $this->property = $property;
  }
  
  /**
   * 
   */
  function toArray() {
    return array($this->property => $this->{$this->property});
  }
}
