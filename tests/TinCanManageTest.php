<?php

namespace GO1\LMS\TinCan\Test;
use GO1\LMS\TinCan\Package\Package;
use GO1\LMS\TinCan\TinCanManager;
use GO1\LMS\TinCan\LRS\LRS;
use GO1\LMS\TinCan\Object\Actor\Agent;
use GO1\LMS\TinCan\Object\InverseIdentity\InverseIdentity;

class TinCanManagerTest extends \PHPUnit_Framework_TestCase {

  protected $manager;
  protected $archiveFile;
  protected $dirPath;

  protected function setUp() {
    $this->archiveFile    = __DIR__ . '/fixtures/GolfExample_TCAPI.zip';
    
    $this->dirPath = '/tmp/' . uniqid();
    
    $this->manager = new TinCanManager(new LRS('http://lrs.example.com/data/xAPI/', 'user', 'password'));
  }

  /**
   * @covers TinCanManager::createPackageDirectory
   */
  public function testCreatePackageDirectory() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $this->assertTrue($package instanceof Package);
    $this->assertEquals($package->getSchemaFile(), $this->dirPath . '/tincan.xml');
    $this->assertEquals(1, count($package->getActivities()));
  }
  
  /**
   * @covers TinCanManager::validateTinCanSchema
   */
  public function testValidateTinCanSchema() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $this->assertTrue($this->manager->validateTinCanSchema($package->getSchemaFile()));
    $this->assertFalse($this->manager->validateTinCanSchema('nowhere'));
  }
  
  /**
   * @covers TinCanManager::buildLaunchUrl
   */
  public function testBuildLaunchUrl() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $id = new InverseIdentity('mbox', 'mailto:no-reply@example.com');
    $agent = new Agent($id);
    $agent->setName('fname lname');
    $url = $this->manager->buildLaunchUrl('http://example.com/tincan-path' , $package, $agent);
    $expected = 'http://example.com/tincan-path/index.html?endpoint=http://lrs.example.com/data/xAPI/&auth=Basic dXNlcjpwYXNzd29yZA==&actor={"mbox":["mailto:no-reply@example.com"],"name":["fname lname"]}&activity_id=http://tincanapi.com/GolfExample_TCAPI';
    
    $this->assertEquals($expected, urldecode($url));
  }
  
}
