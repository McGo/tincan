<?php

namespace GO1\Aduro\TinCan;

use TinCan\StatementsResult;

class StatementParserBase implements StatementParserInterface {
  
  public function parse($json) {
    // Get statements from json;
    $result = StatementsResult::fromJSON($json);
    return $result->getStatements();
  }

}

