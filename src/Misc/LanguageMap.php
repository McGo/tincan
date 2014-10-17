<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Misc;

class LanguageMap extends \ArrayObject {
  
  function __construct($array) {
    parent::__construct($array, self::ARRAY_AS_PROPS);
  }
  
  function toArray() {
    return $this->getArrayCopy();
  }
}
