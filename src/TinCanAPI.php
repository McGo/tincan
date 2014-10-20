<?php

/**
 * 
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan;

class TinCanAPI {
  
  const VERSION = '1.0.2';
  
  /**
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#details-3
   *      mbox: string mailto IRI mailto:example@example.com 
   *      mbox_sha1sum: string SHA1 hash of mailto IRI f427d80dc332a166bf5f160ec15f009ce7e68c4c
   *      openid: string uri http://example.openid.example.com/
   *      account: array includes homePage and name
   */
  static $inverseIdentityTypes = array(
    'mbox',
    'mbox_sha1sum',
    'openid',
    'account'
  );
  
  /**
   *
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#4162-contextactivities-property 
   */
  static $contextActivityKeys = array(
    'parent',
    'grouping',
    'category',
    'other'
  );
  
  /**
   *
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#details-9 
   */
  static $interactionTypes = array(
    'choice',
    'sequencing',
    'likert',
    'matching',
    'performance',
    'true-false',
    'fill-in',
    'long-fill-in',
    'numeric',
    'other'
  );
  
  /**
   *
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#interaction-components
   */
  static $componentLists = array(
    'choices',
    'scale',
    'source', 
    'target',
    'steps'
  );
  
  /**
   *
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#interaction-components
   */
  static $interactionComponentMap = array(
    'choice' => array('choices'),
    'sequencing' => array('choices'),
    'likert' => array('scale'),
    'matching' => array('source', 'target'),
    'performance' => array('steps'),
    'true-false' => array(), 
    'fill-in' => array(), 
    'long-fill-in' => array(), 
    'numeric' => array(), 
    'other' => array()
  );
  
  /**
   *
   * @see https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#requirements-8
   */
  static $subStatementExcludeProperties = array(
    'id', 
    'stored', 
    'version', 
    'authority'
  );
}

