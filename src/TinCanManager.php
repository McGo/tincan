<?php

namespace GO1\LMS\TinCan;

use GO1\LMS\TinCan\Object\Actor\ActorInterface;
use GO1\LMS\TinCan\LRS\LRSInterface;
use GO1\LMS\TinCan\Package\PackageInterface;
use GO1\LMS\TinCan\Package\Package;

class TinCanManager implements TinCanManagerInterface {

  protected $lrs;

  function __construct(LRSInterface $lrs) {
    $this->lrs = $lrs;
  }

  /**
   * Extract tincan zip file to specify directory.
   * @return Package|NULL
   */
  public function createPackageDirectory($archiveFile, $dirPath) {
    $zip = new \ZipArchive;
    if ($zip->open($archiveFile) === TRUE) {
      $zip->extractTo($dirPath);
      $zip->close();

      $schemaFile = $dirPath . '/tincan.xml';
      return $this->loadPackage($schemaFile);
    }
    return NULL;
  }

  /**
   * Get url to launch package from agent
   * @param Agent $agent
   * @return string
   */
  public function buildLaunchUrl($basePath, PackageInterface $package, ActorInterface $agent, $registration = NULL) {
    $queryString = array();

    // @todo need cleaner code for query string builder
    $queryString['endpoint'] = $this->lrs->getEndpoint();
    $queryString['auth'] = $this->lrs->getAuth();
    // @todo figure out why launcher url need value as an array
    $queryString['actor'] = json_encode($this->createActor($agent->toArray()));
    $queryString['activity_id'] = $package->getLaunchActivityId();
    if (!is_null($registration)) {
      $queryString['registration'] = $registration;
    }

    return $basePath . '/' . $package->getLaunchValue() . '?' .
        $this->buildLaunchQueryString($queryString);
  }

  /**
   * 
   * @param string $schemaFile path to tincan.xml
   * @return Package
   */
  public function loadPackage($schemaFile) {
    return new Package($schemaFile);
  }

  /**
   * 
   * @param string $zipFile path to package zip file
   * @return boolean
   */
  public function validateSchema($zipFile) {
    if (file_exists($zipFile)) {
      $schema = file_get_contents("zip://$zipFile#tincan.xml");
      $xml = new \DOMDocument();
      $xml->loadXML($schema);
      if ($xml->schemaValidate(__DIR__ . '/tincan.xsd')) {
        return TRUE;
      }
    } 
    return FALSE;
  }

  /**
   * @see drupal_http_build_query
   * @param array $query
   * @param type $parent
   * @return type
   */
  protected function buildLaunchQueryString(array $query, $parent = '') {
    $params = array();

    foreach ($query as $key => $value) {
      $key = ($parent ? $parent . '[' . rawurlencode($key) . ']' : rawurlencode($key));

      // Recurse into children.
      if (is_array($value)) {
        $params[] = $this->buildLaunchQueryString($value, $key);
      }
      // If a query parameter value is NULL, only append its key.
      elseif (!isset($value)) {
        $params[] = $key;
      } else {
        // For better readability of paths in query strings, we decode slashes.
        $params[] = $key . '=' . str_replace('%2F', '/', rawurlencode($value));
      }
    }

    return implode('&', $params);
  }
  
  /**
   * @todo remove this method
   */
  protected function createActor($values) {
    $actor = array();
    foreach ($values as $key => $value) {
      $actor[$key] = array($value);
    }
    return $actor;
  }
}
