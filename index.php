<?php

define("DS", DIRECTORY_SEPARATOR);

define("APP_PATH", 'application' . DS);

define("BASE_PATH", "framework" . DS);

define("PUBLIC_PATH", "public" . DS);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoloader.php';
require_once 'framework/core/Framework.class.php';

$framework = new Framework();
$framework->run();
