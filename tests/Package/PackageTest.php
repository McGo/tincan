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
   * @covers \GO1\LMS\TinCan\Package\Package::getLaunchActivity
   */
  public function testGetLaunchActivity() {
    $launch = $this->package->getLaunchActivity();
    $this->assertEquals((string) $launch->launch, 'index.html');
  }
  
}
