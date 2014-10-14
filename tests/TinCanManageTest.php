<?php

namespace GO1\Aduro\TinCan\Test;
use GO1\Aduro\TinCan\TinCanPackage;
use GO1\Aduro\TinCan\TinCanManager;
use GO1\Aduro\TinCan\LRS;
use TinCan\Agent;

class TinCanManagerTest extends \PHPUnit_Framework_TestCase {

  protected $manager;
  protected $archiveFile;
  protected $dirPath;

  protected function setUp() {
    $this->archiveFile    = __DIR__ . '/fixtures/GolfExample_TCAPI.zip';
    
    $this->dirPath = '/tmp/' . uniqid();
    
    $this->lrs = new LRS('example.com', 'user', 'password');
    
    $this->manager = new TinCanManager($this->lrs);
  }

  /**
   * @covers TinCanManager::createPackageDirectory
   */
  public function testCreatePackageDirectory() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $this->assertTrue($package instanceof TinCanPackage);
  }
  
  /**
   * @covers TinCanManager::validateTinCanSchema
   */
  public function testValidateTinCanSchema() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $result = $this->manager->validateTinCanSchema($package->getSchemaFile());
    $this->assertTrue($result);
  }
  
  /**
   * @covers TinCanManager::buildLaunchUrl
   */
  public function testBuildLaunchUrl() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $agent = new Agent(array('name' => 'duynguyen', 'mbox' => 'mailto:duy.nguyen@gmail.com'));
    $result = $this->manager->buildLaunchUrl('abc.com' , $package, $agent);
    $this->assertTrue(is_string($result));
  }
  
  /**
   * @covers TinCanManager::buildLaunchQueryString
   */
  public function testBuildLaunchQueryString() {
    
  }
  
  
}
