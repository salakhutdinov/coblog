<?php

use phpunit\framework\TestCase;
use Coblog\

class WebTestCase extends TestCase
{
    protected function createKernel()
    {
        $config = getenv('CONFIG_DIR') . '/config.php';
        $app = new Application($config);
    }

    public function createClient()
    {
        
    }
}
