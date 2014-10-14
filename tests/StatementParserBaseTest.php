<?php

use GO1\Aduro\TinCan\StatementParserBase;

class StatementParserBaseTest extends \PHPUnit_Framework_TestCase {
  
  protected $parser;
  
  protected $json;
  
  protected function setUp() {
    $this->parser = new StatementParserBase();
    $this->json = file_get_contents(__DIR__ . '/fixtures/statement.json');
  }
  
  /**
   * @covers GO1\Aduro\TinCan\StatementParserBase::parse
   */
  public function testParse() {
    $array = $this->parser->parse($this->json);
    $this->assertInstanceOf('TinCan\Statement', reset($array));
  }
  
}
