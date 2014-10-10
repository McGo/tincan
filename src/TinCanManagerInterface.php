<?php

namespace GO1\Aduro\TinCan;
use TinCan\Agent;
use GO1\Aduro\TinCan\TinCanPackageInterface;

interface TinCanManagerInterface {
  
  function verify();
  
  function launch(TinCanPackageInterface $package, Agent $agent);
}