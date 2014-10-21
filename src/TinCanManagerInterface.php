<?php

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Package\PackageInterface;
use GO1\LMS\TinCan\Object\Actor\ActorInterface;

interface TinCanManagerInterface {
  
  /**
   * unzip package
   * @archiveFile path to tincan zip file
   * @dirPath path to extract zip file
   * return Package
   */
  function createPackageDirectory($archiveFile, $dirPath);

  /**
   * @schemaFile path to tincan.xml
   * validate tincan.xsd
   */
  function validateTinCanSchema($schemaFile);

  /**
   * @schemaFile: path to tincan.xml
   * return Package
   */
  function loadPackage($schemaFile);

  /**
   * 
   * @param string $basePath
   * @param \GO1\LMS\TinCan\Package\PackageInterface $package
   * @param \GO1\LMS\TinCan\Object\Actor\ActorInterface
   * @return string
   */
  function buildLaunchUrl($basePath, PackageInterface $package, ActorInterface $agent, $registration = NULL);
  
}