<?php

namespace GO1\Aduro\TinCan;
use GO1\Aduro\TinCan\LRSManager;
use TinCan\Agent;

interface TinCanPackageInterface {
    
  function __construct(LRSManager $lrs, $filePath, $extractPath);
  function verify();
  function launch(Agent $agent);
}

