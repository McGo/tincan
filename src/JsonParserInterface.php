<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

interface JsonParserInterface {
  
  /**
   * 
   * @param string $json LRS json response
   */
  function parse($json);
  
  /**
   * 
   * @param stdClass $jsonObject
   */
  function parseStatements($jsonObject);
  
  /**
   * 
   * @param stdClass $actorJsonObject
   */
  function parseActor($actorJsonObject);
  
  /**
   * 
   * @param stdClass $jsonObject
   * @return mixed
   */
  function parseInverseIdentity($jsonObject);
}

