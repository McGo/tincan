<?php

namespace GO1\Aduro\TinCan;

use TinCan\RemoteLRS;
use GO1\Aduro\TinCan\TinCanManagerInterface;
use GO1\Aduro\TinCan\LRSInterface;
use GO1\Aduro\TinCan\TinCanPackageInterface;
use GO1\Aduro\TinCan\TinCanPackage;

class TinCanManager extends RemoteLRS implements TinCanManagerInterface {

  protected $lrs;
  protected $package;
  protected $extractPath;

  function __construct(LRSInterface $lrs) {
    $this->lrs = $lrs;
    parent::__construct($lrs->getEndpoint(), $lrs->getVersion(), $lrs->getAuth());
  }
  
    /**
   * Extract tincan zip file to specify directory.
   * @return boolean
   */
  protected function unZip($filePath, $extractPath) {
    $this->$extractPath = $extractPath;
    $zip = new \ZipArchive;
    if ($zip->open($filePath) === TRUE) {
      $zip->extractTo($this->$extractPath);
      $zip->close();
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Get url to launch package from agent
   * @param Agent $agent
   * @return boolean
   */
  public function launch(Agent $agent) {
    $package = new TinCanPackage($this->extractPath . '/tincan.xml');
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
        $query_string = $this->buidQuery($params);
        return $activity['launch'] . '?' . $query_string;
      }
    }
    return FALSE;
  }

  /**
   * Handle verify tincan.xml base on tincan.xsd
   * @return boolean
   */
  public function verify() {
    $xml = new \DOMDocument();
    $xml->load($this->extractPath . '/tincan.xml');

    if (!$xml->schemaValidate(__DIR__ . '/static/tincan.xsd')) {
      return array(
        'error' => TRUE,
        'messages' => libxml_get_errors()
      );
    }
    return TRUE;
  }

  /**
   * @see drupal_http_build_query
   * @param array $query
   * @param type $parent
   * @return type
   */
  protected function buidQuery(array $query, $parent = '') {
    $params = array();

    foreach ($query as $key => $value) {
      $key = ($parent ? $parent . '[' . rawurlencode($key) . ']' : rawurlencode($key));

      // Recurse into children.
      if (is_array($value)) {
        $params[] = $this->buidQuery($value, $key);
      }
      // If a query parameter value is NULL, only append its key.
      elseif (!isset($value)) {
        $params[] = $key;
      }
      else {
        // For better readability of paths in query strings, we decode slashes.
        $params[] = $key . '=' . str_replace('%2F', '/', rawurlencode($value));
      }
    }

    return implode('&', $params);
  }

}
