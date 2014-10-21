<?php

use GO1\LMS\TinCan\JsonParser;
use GO1\LMS\TinCan\TinCanFactory;

class JsonParserTest extends \PHPUnit_Framework_TestCase {

  protected $parser;
  protected $json;

  protected function setUp() {
    $this->parser = new JsonParser(new TinCanFactory);
    $this->json = file_get_contents(__DIR__ . '/fixtures/statement.json');
  }

  /**
   * @covers GO1\LMS\TinCan\JsonParser::parse
   */
  public function testParse() {
    //$a = $this->parser->parse($this->json);
  }

  /**
   * @covers GO1\LMS\TinCan\JsonParser::parseActor
   */
  public function testParseActor() {
    $jsonObject = json_decode(file_get_contents(__DIR__ . '/fixtures/actor/agent-account.json'));
    $agent = $this->parser->parseActor($jsonObject);
    $this->assertInstanceOf('GO1\LMS\TinCan\Object\Actor\Agent', $agent);

    $jsonObject2 = json_decode(file_get_contents(__DIR__ . '/fixtures/actor/agent.json'));
    $agent2 = $this->parser->parseActor($jsonObject2);
    $this->assertInstanceOf('GO1\LMS\TinCan\Object\Actor\Agent', $agent2);

    $jsonObject3 = json_decode(file_get_contents(__DIR__ . '/fixtures/actor/identified-group.json'));
    $group = $this->parser->parseActor($jsonObject3);
    $this->assertInstanceOf('GO1\LMS\TinCan\Object\Actor\IdentifiedGroup', $group);

    $jsonObject4 = json_decode(file_get_contents(__DIR__ . '/fixtures/actor/anonymous-group.json'));
    $group2 = $this->parser->parseActor($jsonObject4);
    $this->assertInstanceOf('GO1\LMS\TinCan\Object\Actor\AnonymousGroup', $group2);
  }

  /**
   * @covers GO1\LMS\TinCan\JsonParser::parseVerb
   */
  public function testParseVerb() {
    $jsonObject = json_decode(file_get_contents(__DIR__ . '/fixtures/verb/verb.json'));
    $verb = $this->parser->parseVerb($jsonObject);
    $this->assertInstanceOf('GO1\LMS\TinCan\Object\Verb', $verb);
    
    $this->assertInstanceOf('GO1\LMS\TinCan\Misc\LanguageMap', $verb->get('display'));
  }

}
