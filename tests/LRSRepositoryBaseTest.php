<?php

namespace GO1\LMS\TinCan\Test;

use GO1\LMS\TinCan\LRSRepositoryBase;
use GO1\LMS\TinCan\LRS;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Stream\Stream;
use GO1\LMS\TinCan\StatementParserBase;

class LRSRepositoryBaseTest extends \PHPUnit_Framework_TestCase {

  protected $repository;

  protected function setUp() {
    //mock $client
    $client = $this->getMockBuilder('GuzzleHttp\Client')
      ->disableOriginalConstructor()
      ->getMock();
    //stub send()
    $stream = Stream::factory(file_get_contents(__DIR__ . '/fixtures/statement.json')); 
    $stream->read(0);
    $response = new Response(200, array(), $stream);
    
    $client->method('send')->willReturn($response);
    
    //stub createRequest()
    $request = new Request('GET', 'example.com');
    $client->method('createRequest')->willReturn($request);
    
    $lrs = new LRS('lrs.example.com', 'user', 'password');
    
    $parser = new StatementParserBase();
    
    $this->repository = new LRSRepositoryBase($client, $lrs, $parser);
  }

  /**
   * @covers LRSRepositoryBaseTest::sendRequest
   */
  function testSendRequest() {
    $result = $this->repository->sendRequest('example.com');
    $this->assertInstanceOf('\TinCan\Statement', reset($result));
  }

}
