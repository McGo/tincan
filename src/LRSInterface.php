<?php

namespace GO1\Aduro\TinCan;

interface LRSInterface {

  function getEndpoint();

  function getVersion();

  function getAuth();

  function setEndpoint();

  function setVersion();

  function setAuth();
}
