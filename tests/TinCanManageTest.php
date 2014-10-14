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
    
    $this->manager = new TinCanManager(new LRS('example.com', 'user', 'password'));
  }

  /**
   * @covers TinCanManager::createPackageDirectory
   */
  public function testCreatePackageDirectory() {
    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
    $this->assertTrue($package instanceof TinCanPackage);
    $this->assertEquals($package->getSchemaFile(), $this->dirPath . '/tincan.xml');
    $this->assertEquals(count($package->getActivities()), 1);
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
   * @covers TinCanManager::buildLaunchQueryString
   */
  public function testBuildLaunchQueryString() {
    $params = array(
      'endpoint' => 'example.com',
      'auth' => 'auth',
      'actor' => array(
        'name' => 'fname lname',
        'mbox' => 'no-reply@example.com'
      )
    );
    $queryString = $this->manager->buildLaunchQueryString($params);
    $this->assertEquals($queryString, 'endpoint=example.com&auth=auth&actor[name]=fname%20lname&actor[mbox]=no-reply%40example.com');
  }
  
  /**
   * @covers TinCanManager::buildLaunchUrl
   */
  public function testBuildLaunchUrl() {
//    $package = $this->manager->createPackageDirectory($this->archiveFile, $this->dirPath);
//    $agent = new Agent(array('name' => 'fname lname', 'mbox' => 'mailto:no-reply@example.com'));
//    $url = $this->manager->buildLaunchUrl('example.com' , $package, $agent);
//    $this->assertEquals($url, 'aaa');
  }
  

  
  
}
