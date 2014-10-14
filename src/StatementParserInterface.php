<?php

namespace GO1\LMS\TinCan;

interface StatementParserInterface {
  
  /**
   * 
   * @param string $json
   */
  function parse($json);
  
}

