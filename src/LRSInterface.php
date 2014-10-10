<?php

namespace GO1\Aduro\TinCan;

interface LRSInterface {

  function getEndpoint();

  function getUsername();
  
  function getPassword();

  function getAuth();

  function setEndpoint($endpoint);

  function setUserName($username);

  function setPassword($password);
}
