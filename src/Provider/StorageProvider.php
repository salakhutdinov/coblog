<?php

namespace Coblog\Provider;

use Coblog\Storage\DocumentManager;
use Coblog\Storage\DocumentPersister;

use Coblog\ServiceProviderInterface;
use Coblog\Container;

class StorageProvider implements ServiceProviderInterface
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
