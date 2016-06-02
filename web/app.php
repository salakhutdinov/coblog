<?php

require '../src/autoload.php';

use Coblog\Http\Request;

$config = require '../src/config.php';

$app = new Coblog\App($config);

$app->get('/', function (Request $request) use ($app) {
    return $app->render('index.html');
});

//$app->get();

$app->run();
