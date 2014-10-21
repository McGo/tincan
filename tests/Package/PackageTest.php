<?php

use GO1\LMS\TinCan\Package\Package;

class PackageTest extends \PHPUnit_Framework_TestCase {
  
  protected $package;
  
  protected function setUp() {
    $this->package = new Package(__DIR__ . '/../fixtures/tincan.xml');
  }
  
  /**
   * @covers \GO1\LMS\TinCan\Package\Package::getActivities
   */
  public function testGetActivities() {
    $this->assertEquals(1, count($this->package->getActivities()));
  }
  
  /**
   * @covers \GO1\LMS\TinCan\Package\Package::getLaunchValue
   */
  public function testGetLaunchValue() {
    $value = $this->package->getLaunchValue();
    $this->assertEquals($value, 'index.html');
  }
  
  /**
   * @covers \GO1\LMS\TinCan\Package\Package::getLaunchActivityId
   */
  public function testGetLaunchActivityId() {
    $id = $this->package->getLaunchActivityId();
    $this->assertEquals($id, 'http://tincanapi.com/GolfExample_TCAPI');
  }
}
