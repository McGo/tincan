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
   * @return array|NULL
   */
  function parseStatements($jsonObject);

  /**
   * 
   * @param stdClass $actorJsonObject
   * @return ActorInterface
   */
  function parseActor($actorJsonObject);

  /**
   * 
   * @param stdClass $jsonObject
   * @return InverseIdentity|NULL
   */
  function parseInverseIdentity($jsonObject);

  /**
   * 
   * @param stdClass $jsonObject
   * @return Verb|NULL
   */
  function parseVerb($jsonObject);
}
