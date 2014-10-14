<?php

namespace GO1\LMS\TinCan;

use TinCan\StatementsResult;

class StatementParserBase implements StatementParserInterface {
  
  public function parse($json) {
    // Get statements from json;
    $result = StatementsResult::fromJSON($json);
    return $result->getStatements();
  }

}

