<?php

namespace GO1\Aduro\TinCan\Test;

use GO1\Aduro\TinCan\LRSRepositoryBase;
use GO1\Aduro\TinCan\LRS;
use GuzzleHttp\Client;
use TinCan\Agent;

class LRSRepositoryBaseTest extends \PHPUnit_Framework_TestCase {

  static private $endpoint = 'http://duynguyen.lrs.aduro.go1.com.vn/data/xAPI/';
  static private $username = 'ed0bd8f9ece36054232a66c4386261397b18bdb6';
  static private $password = 'b5aa8c3732b2a7eb982bb4ff02dacac92a60cd9c';
  protected $lrs;
  protected $lrsRepo;
  protected $client;

  protected function setUp() {
    $this->lrs = new LRS(self::$endpoint, self::$username, self::$password);
    $this->client = new Client(['base_url' => $this->lrs->getEndpoint()]);
    $this->parse = new \GO1\Aduro\TinCan\StatementParserBase();
    $this->lrsRepo = new LRSRepositoryBase($this->client, $this->lrs, $this->parse);
  }

  public function testGetStatement() {
    return;
    $obj = new Agent(
        [ 'mbox' => 'duy.nguyen@go1.com.au']
    );
    $params = array(
      'objectType' => $obj->getObjectType(),
      'mbox' => $obj->getMbox(),
    );
    $verbId = 'http://adlnet.gov/expapi/verbs/experienced';
    $activity = 'http://tincanapi.com/GolfExample_TCAPI/Playing/Playing.html';
    $statement = $this->lrsRepo->getStatement(json_encode($params), $verbId, $activity);
  }
  
  public function testgGetStatementById() {
    $statement = $this->lrsRepo->getStatementById('28ed1312-95ee-4241-b3fa-86e4bee68d07');
    $this->assertEquals($statement->getId(), '28ed1312-95ee-4241-b3fa-86e4bee68d07');
  }

  public function testGetStatementsHasActor() {
    $obj = new Agent(
        [ 'mbox' => 'duy.nguyen@go1.com.au']
    );
    $params = array(
      'objectType' => $obj->getObjectType(),
      'mbox' => $obj->getMbox(),
    );
    $statements = $this->lrsRepo->getStatementsHasActor(json_encode($params));
  }
  
  public function testGetStatementsHasVerb() {
    $verbId = 'http://adlnet.gov/expapi/verbs/experienced';
    $statements = $this->lrsRepo->getStatementsHasVerb($verbId);
  }
  
  public function testGetStatementsHasObject() {
    $activity = 'http://tincanapi.com/GolfExample_TCAPI/Playing/Playing.html';
    $statements = $this->lrsRepo->getStatementsHasObject($activity);
  }

}
