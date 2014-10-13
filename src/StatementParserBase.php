<?php

namespace GO1\Aduro\TinCan;

class StatementParserBase implements StatementParserInterface {
  
  public function parse($json) {
    // Get statements from json;
    $result = \TinCan\StatementsResult::fromJSON($json);
    return $result->getStatements();
  }

}

