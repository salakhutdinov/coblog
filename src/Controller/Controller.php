<?php

namespace Coblog\Controller;

use Coblog\Application;

class Controller
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
