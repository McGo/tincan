<?php

namespace GO1\Aduro\TinCan;

interface LRSInterface {

  function getEndpoint();

  function setEndpoint($endpoint);
  
  function getAuth();

  function setAuth($password);
}
