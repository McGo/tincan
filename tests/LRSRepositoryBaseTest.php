<?php

namespace GO1\Aduro\TinCan\Test;

use GO1\Aduro\TinCan\LRSRepositoryBase;
use GO1\Aduro\TinCan\LRS;
use GuzzleHttp\Client;
use TinCan\Agent;

define('COMMON_EMAIL',       'tincanphp@tincanapi.com');
define('COMMON_GROUP_EMAIL', 'tincanphp+group@tincanapi.com');
define('COMMON_MBOX',        'mailto:tincanphp@tincanapi.com');
define('COMMON_GROUP_MBOX',  'mailto:tincanphp+group@tincanapi.com');
define('COMMON_VERB_ID',     'http://adlnet.gov/expapi/verbs/experienced');
define('COMMON_ACTIVITY_ID', 'http://tincanapi.com/TinCanPHP/Test/Activity');

class LRSRepositoryBaseTest extends \PHPUnit_Framework_TestCase {

  static private $endpoint = 'http://duynguyen.lrs.aduro.go1.com.vn/data/xAPI/';
  static private $username = 'ed0bd8f9ece36054232a66c4386261397b18bdb6';
  static private $password = 'b5aa8c3732b2a7eb982bb4ff02dacac92a60cd9c';
  static private $version  = '1.0.1';
  protected $remoteLRS;
  protected $lrs;
  protected $lrsRepo;
  protected $client;

  protected function setUp() {
    $this->remoteLRS = new \TinCan\RemoteLRS(self::$endpoint, self::$version, self::$username, self::$password);
    $this->lrs = new LRS(self::$endpoint, self::$username, self::$password);
    $this->client = new Client(['base_url' => $this->lrs->getEndpoint()]);
    $this->parse = new \GO1\Aduro\TinCan\StatementParserBase();
    $this->lrsRepo = new LRSRepositoryBase($this->client, $this->lrs, $this->parse);
  }
  
  function createStatement($mbox = COMMON_MBOX, $verb = COMMON_VERB_ID, $object = COMMON_ACTIVITY_ID) {
    $saveResponse = $this->remoteLRS->saveStatement(
      [
        'actor' => ['mbox' => $mbox],
        'verb' => ['id' => $verb, 'display' => ['US' => 'US']],
        'object' => new \TinCan\Activity(['id' => $object])
      ]
    );
    return $saveResponse->success ? $saveResponse : FALSE;
  }

  public function testGetStatement() {
    $mbox = uniqid()  . '@go1.com.au';
    $verbId = 'http://adlnet.gov/expapi/verbs/' . uniqid();
    $object = 'http://tincanapi.com/go1/' . uniqid() . '.html';
    $this->createStatement($mbox, $verbId, $object);
    
    $statement  = $this->lrsRepo->getStatement($mbox, $verbId, $object);
    $this->assertInstanceOf('TinCan\Statement', $statement);
    $this->assertEquals('mailto:' . $mbox, $statement->getActor()->getMbox());
    $this->assertEquals($verbId, $statement->getVerb()->getId());
    $this->assertEquals($object, $statement->getObject()->getId());
  }

  public function testgGetStatementById() {
    $saveResponse = $this->createStatement();
    $statement = $this->lrsRepo->getStatementById($saveResponse->content->getId());
    $this->assertInstanceOf('TinCan\Statement', $statement);
  }

  public function testGetStatementsHasActor() {
    $mbox = uniqid()  . '@go1.com.au';
    for($i = 0; $i < 3; ++$i) {
      $this->createStatement($mbox);
    }
    
    // getStatementsHasActor
    $obj = new Agent([ 'mbox' => $mbox]);
    $params = array(
      'objectType' => $obj->getObjectType(),
      'mbox' => $obj->getMbox(),
    );
    $statements = $this->lrsRepo->getStatementsHasActor(json_encode($params));
    $this->assertEquals(3, count($statements));
    foreach ($statements as $statement) {
      $this->assertInstanceOf('TinCan\Statement', $statement);
    }
  }

  public function testGetStatementsHasVerb() {
    $verbId = 'http://adlnet.gov/expapi/verbs/' . uniqid();
    for($i = 0; $i < 4; ++$i) {
      $this->createStatement(COMMON_EMAIL, $verbId);
    }
    
    // getStatementsHasVerb
    $statements = $this->lrsRepo->getStatementsHasVerb($verbId);
    $this->assertEquals(4, count($statements));
    foreach ($statements as $statement) {
      $this->assertInstanceOf('TinCan\Statement', $statement);
    }
  }

  public function testGetStatementsHasObject() {
    $object = 'http://tincanapi.com/go1/' . uniqid() . '.html';
    for($i = 0; $i < 2; ++$i) {
      $this->createStatement(COMMON_EMAIL, COMMON_VERB_ID, $object);
    }
    $statements = $this->lrsRepo->getStatementsHasObject($object);
    $this->assertEquals(2, count($statements));
    foreach ($statements as $statement) {
      $this->assertInstanceOf('TinCan\Statement', $statement);
    }
  }

}
