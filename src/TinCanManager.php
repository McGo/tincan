<?php

namespace GO1\Aduro\TinCan;

use TinCan\Agent;

class TinCanManager implements TinCanManagerInterface {

  protected $lrs;

  function __construct(LRSInterface $lrs) {
    $this->lrs = $lrs;
  }

  /**
   * Extract tincan zip file to specify directory.
   * @return TinCanPackage|NULL
   */
  public function createPackageDirectory($archiveFile, $dirPath) {
    $zip = new \ZipArchive;
    if ($zip->open($archiveFile) === TRUE) {
      $zip->extractTo($dirPath);
      $zip->close();

      $schemaFile = $dirPath . '/tincan.xml';
      return $this->loadTinCanPackage($schemaFile);
    }
    return NULL;
  }

  /**
   * Get url to launch package from agent
   * @param Agent $agent
   * @return string
   */
  public function buildLaunchUrl($basePath, TinCanPackageInterface $package, Agent $agent) {
    foreach ($package->getActivities() as $activity) {
      // Looking for main activity of package.
      if (isset($activity['launch'])) {
        $params['endpoint'] = $this->lrs->getEndpoint();
        $params['auth'] = $this->lrs->getAuth();
        $params['actor'] = array(
          "name" => $agent->getName(),
          "mbox" => $agent->getMbox(),
        );
        $params['activity_id'] = $activity['@attributes']['id'];
        $query_string = $this->buildLaunchQueryString($params);
        return $basePath . '/' . $activity['launch'] . '?' . $query_string;
      }
    }
    return '';
  }

  /**
   * 
   * @param string $schemaFile path to tincan.xml
   * @return TinCanPackage
   */
  public function loadTinCanPackage($schemaFile) {
    return new TinCanPackage($schemaFile);
  }

  /**
   * 
   * @param string $schemaFile path to tincan.xml
   * @return boolean
   */
  public function validateTinCanSchema($schemaFile) {
    $xml = new \DOMDocument();
    $xml->load($schemaFile);

    if (!$xml->schemaValidate(__DIR__ . '/static/tincan.xsd')) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * @see drupal_http_build_query
   * @param array $query
   * @param type $parent
   * @return type
   */
  public function buildLaunchQueryString(array $query, $parent = '') {
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

}
