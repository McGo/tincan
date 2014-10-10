<?php

namespace GO1\Aduro\TinCan\Test;
use GO1\Aduro\TinCan\TinCanPackage;
use GO1\Aduro\TinCan\TinCanManager;
use GO1\Aduro\TinCan\LRS;
use TinCan\Agent;

class TinCanManageTest extends \PHPUnit_Framework_TestCase {
  
  static private $endpoint = 'http://cloud.scorm.com/tc/3HYPTQLAI9/sandbox';
  static private $username = '';
  static private $password = '';


  protected $manage;
  protected $archiveFile;
  protected $dirPath;

  protected function setUp() {
    $this->archiveFile    = __DIR__ . '/fixtures/GolfExample_TCAPI.zip';
    $this->dirPath = '/tmp/' . uniqid();
    $this->lrs = new LRS(self::$endpoint, self::$username, self::$password);
    $this->manage = new TinCanManager($this->lrs);
  }

  public function testcCreatePackageDirectory() {
    $package = $this->manage->createPackageDirectory($this->archiveFile, $this->dirPath);
    $this->assertTrue($package instanceof TinCanPackage);
  }
  
  public function testValidateTinCanSchema() {
    $package = $this->manage->createPackageDirectory($this->archiveFile, $this->dirPath);
    $result = $this->manage->validateTinCanSchema($package->getSchemaFile());
    $this->assertTrue($result);
  }
  
  public function testBuildLaunchUrl() {
    $package = $this->manage->createPackageDirectory($this->archiveFile, $this->dirPath);
    $agent = new Agent(array('name' => 'duynguyen', 'mbox' => 'mailto:duy.nguyen@gmail.com'));
    $result = $this->manage->buildLaunchUrl('abc.com' , $package, $agent);
    $this->assertTrue(is_string($result));
  }
}
