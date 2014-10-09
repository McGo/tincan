<?php

namespace GO1\Aduro\TinCan\Test;
use GO1\Aduro\TinCan\TinCanPackage;
use GO1\Aduro\TinCan\LRSManager;
use TinCan\Agent;

class TinCanPackageTest extends \PHPUnit_Framework_TestCase {
  
  static private $endpoint = 'http://cloud.scorm.com/tc/3HYPTQLAI9/sandbox';
  static private $version  = '1.0.1';
  static private $username = '';
  static private $password = '';


  protected $package;
  protected $filePath;
  protected $extractPath;

  protected function setUp() {
    $this->filePath    = __DIR__ . '/fixtures/GolfExample_TCAPI.zip';
    $this->extractPath = '/tmp/' . uniqid();
    $this->lrs = new LRSManager(self::$endpoint, self::$version, self::$username, self::$password);
    $this->package = new TinCanPackage($this->lrs, $this->filePath, $this->extractPath);
  }

  public function testExtract() {
    $this->assertTrue($this->package->extract());
  }
  
  public function testVerify() {
    $this->package->extract();
    $result = $this->package->verify();
    $this->assertTrue($result);
  }
  
  public function testLaunch() {
    $this->package->extract();
    $agent = new Agent(array('name' => 'duynguyen', 'mbox' => 'mailto:duy.nguyen@gmail.com'));
    $result = $this->package->launch($agent);
    $this->assertTrue(is_string($result));
  }
}
