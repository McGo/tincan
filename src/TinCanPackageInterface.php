<?php

namespace GO1\Aduro\TinCan;

interface TinCanPackageInterface {

  function getActivities();

  function getProvider();

  function getSchemaFile();
  
  function getManifest();
}
