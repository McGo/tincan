<?php

namespace GO1\Aduro\TinCan;

use GO1\Aduro\TinCan\LRSManager;
use TinCan\Agent;

class TinCanPackage implements TinCanPackageInterface {

  protected $filePath;
  protected $extractPath;
  protected $manifest;
  protected $lrs;

  public function __construct(LRSManager $lrs, $filePath, $extractPath) {
    $this->filePath = $filePath;
    $this->extractPath = $extractPath;
    $this->lrs = $lrs;
  }

  /**
   * Extract tincan zip file to specify directory.
   * @return boolean
   */
  public function extract() {
    $zip = new \ZipArchive;
    if ($zip->open($this->filePath) === TRUE) {
      $zip->extractTo($this->extractPath);
      $zip->close();
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Pase tincan.xml to array.
   * @return type
   */
  protected function parseManifest() {
    $content = simplexml_load_file($this->extractPath . '/tincan.xml');
    $this->manifest = json_decode(json_encode($content), TRUE);
    return $this->manifest;
  }

  /**
   * Get url to launch package from agent
   * @param Agent $agent
   * @return boolean
   */
  public function launch(Agent $agent) {
    $this->parseManifest();
    foreach ($this->manifest['activities'] as $activity) {
      if (isset($activity['launch'])) {
        $params['endpoint'] = $this->lrs->getEndpoint();
        $params['auth'] = $this->lrs->getEndpoint();
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
