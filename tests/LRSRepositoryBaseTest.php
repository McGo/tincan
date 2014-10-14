<?php

namespace GO1\Aduro\TinCan\Test;

use GO1\Aduro\TinCan\LRSRepositoryBase;
use GO1\Aduro\TinCan\LRS;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Stream\Stream;
use TinCan\Agent;
use TinCan\RemoteLRS;
use TinCan\Activity;
use GO1\Aduro\TinCan\StatementParserBase;

class LRSRepositoryBaseTest extends \PHPUnit_Framework_TestCase {

  protected $repository;

  protected function setUp() {
    //mock $client
    $client = $this->getMockBuilder('GuzzleHttp\Client')
      ->disableOriginalConstructor()
      ->getMock();
    //stub send()
    $response = new Response(200);
    $stream = Stream::factory(file_get_contents(__DIR__ . '/fixtures/statement.json'));
    $stream->read(1);
    $response->setBody($stream);
    $client->method('send')->willReturn($response);
    
    //stub createRequest()
    $request = new \GuzzleHttp\Message\Request('GET', 'example.com');
    $client->method('createRequest')->willReturn($request);
    
    $lrs = new LRS('lrs.example.com', 'user', 'password');
    
    $parser = new StatementParserBase();
    
    $this->repository = new LRSRepositoryBase($client, $lrs, $parser);
  }
  
//  public function testGetStatement() {
//    $mbox = uniqid()  . '@go1.com.au';
//    $verbId = 'http://adlnet.gov/expapi/verbs/' . uniqid();
//    $object = 'http://tincanapi.com/go1/' . uniqid() . '.html';
//    $this->createStatement($mbox, $verbId, $object);
//    
//    $statement  = $this->lrsRepo->getStatement($mbox, $verbId, $object);
//    $this->assertInstanceOf('TinCan\Statement', $statement);
//    $this->assertEquals('mailto:' . $mbox, $statement->getActor()->getMbox());
//    $this->assertEquals($verbId, $statement->getVerb()->getId());
//    $this->assertEquals($object, $statement->getObject()->getId());
//  }
//
//  public function testgGetStatementById() {
//    $saveResponse = $this->createStatement();
//    $statement = $this->lrsRepo->getStatementById($saveResponse->content->getId());
//    $this->assertInstanceOf('TinCan\Statement', $statement);
//  }
//
//  public function testGetStatementsHasActor() {
//    $mbox = uniqid()  . '@go1.com.au';
//    for($i = 0; $i < 3; ++$i) {
//      $this->createStatement($mbox);
//    }
//    
//    // getStatementsHasActor
//    $obj = new Agent([ 'mbox' => $mbox]);
//    $params = array(
//      'objectType' => $obj->getObjectType(),
//      'mbox' => $obj->getMbox(),
//    );
//    $statements = $this->lrsRepo->getStatementsHasActor(json_encode($params));
//    $this->assertEquals(3, count($statements));
//    foreach ($statements as $statement) {
//      $this->assertEquals('mailto:' . $mbox, $statement->getActor()->getMbox());
//      $this->assertInstanceOf('TinCan\Statement', $statement);
//    }
//  }
//
//  public function testGetStatementsHasVerb() {
//    $verbId = 'http://adlnet.gov/expapi/verbs/' . uniqid();
//    for($i = 0; $i < 4; ++$i) {
//      $this->createStatement(COMMON_EMAIL, $verbId);
//    }
//    
//    // getStatementsHasVerb
//    $statements = $this->lrsRepo->getStatementsHasVerb($verbId);
//    $this->assertEquals(4, count($statements));
//    foreach ($statements as $statement) {
//      $this->assertEquals($verbId, $statement->getVerb()->getId());
//      $this->assertInstanceOf('TinCan\Statement', $statement);
//    }
//  }
//
//  public function testGetStatementsHasObject() {
//    $object = 'http://tincanapi.com/go1/' . uniqid() . '.html';
//    for($i = 0; $i < 2; ++$i) {
//      $this->createStatement(COMMON_EMAIL, COMMON_VERB_ID, $object);
//    }
//    $statements = $this->lrsRepo->getStatementsHasObject($object);
//    $this->assertEquals(2, count($statements));
//    foreach ($statements as $statement) {
//      $this->assertEquals($object, $statement->getObject()->getId());
//      $this->assertInstanceOf('TinCan\Statement', $statement);
//    }
//  }

}
