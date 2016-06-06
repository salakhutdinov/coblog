<?php

namespace tests;

use phpunit\framework\TestCase;
use Coblog\Application;

class WebTestCase extends TestCase
{
    protected function createKernel()
    {
        $config = require getenv('CONFIG_DIR') . '/config.php';
        $app = new Application($config);

        return $app;
    }

    public function createClient()
    {
        return new Client($this->createKernel());
    }
}
