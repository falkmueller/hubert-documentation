<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set("display_errors", 1);

//load autoloader
require_once './vendor/autoload.php';

//init app
hubert(__dir__.'/config/');
//hubert(__dir__.'/config/container/', __dir__.'/data/cache/config_cache.php');

//run and emit app
hubert()->core->run();

