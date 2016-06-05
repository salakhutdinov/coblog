<?php

namespace Coblog;

use Coblog\Provider\StorageProvider;
use Coblog\Provider\SecurityProvider;
use Coblog\Provider\ControllersProvider;

class Application extends Kernel
{
    public function registerProviders()
    {
        $providers = [
            new StorageProvider,
            new SecurityProvider,
            new ControllersProvider,
        ];

        return $providers;
    }
}
