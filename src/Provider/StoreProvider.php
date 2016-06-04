<?php

namespace Coblog\Provider;

use Coblog\Store\DocumentManager;
use Coblog\Store\DocumentPersister;

use Coblog\ServiceProviderInterface;
use Coblog\Container;

class StoreProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $config = $container->getConfig();

        $documentPersister = new DocumentPersister;
        $documentManager = new DocumentManager(
            $config['db_server'],
            $config['db_name'],
            $documentPersister,
            $config['model_prefix']
        );

        $container['document_manager'] = $documentManager;
    }
}
