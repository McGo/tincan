<?php

namespace GO1\LMS\TinCan;
use TinCan\Agent;

interface TinCanManagerInterface {
  
  /**
   * unzip package
   * @archiveFile path to tincan zip file
   * @dirPath path to extract zip file
   * return TinCanPackage
   */
  function createPackageDirectory($archiveFile, $dirPath);

  /**
   * @schemaFile path to tincan.xml
   * validate tincan.xsd
   */
  function validateTinCanSchema($schemaFile);

  /**
   * @schemaFile: path to tincan.xml
   * return TinCanPackage
   */
  function loadTinCanPackage($schemaFile);

  /**
   * @baseUrl: the url of directory contain tincan package 
   * @package: GO1\LMS\TinCan\TinCanPackageInterface
   * @agent: TinCan\Agent
   */
  function buildLaunchUrl($basePath, TinCanPackageInterface $package, Agent $agent);
  
}