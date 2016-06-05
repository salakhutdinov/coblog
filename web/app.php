<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

require __DIR__ . '/../src/autoload.php';

$config = require __DIR__ . '/../var/config/config.php';

$app = new Coblog\Application($config);
$app->run();
