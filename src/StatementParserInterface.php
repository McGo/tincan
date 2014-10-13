<?php

namespace GO1\Aduro\TinCan;

interface StatementParserInterface {
  
  /**
   * 
   * @param string $json
   */
  function parse($json);
  
}

