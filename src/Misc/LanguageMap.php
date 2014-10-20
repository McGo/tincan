<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Misc;

class LanguageMap extends \ArrayObject {
  
  /**
   * 
   * @param mixed $values
   */
  function __construct($values) {
    parent::__construct($values, self::STD_PROP_LIST);
  }
  
  function toArray() {
    return $this->getArrayCopy();
  }
}
