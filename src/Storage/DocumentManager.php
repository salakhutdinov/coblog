<?php

namespace Coblog\Storage;

use MongoClient;

class DocumentManager
{
    private $repositories = [];

    private $prefix;

    private $db;

    private $documentPersister;

    public function __construct($server, $databaseName, DocumentPersister $documentPersister, $classPrefix)
    {
        $client = new MongoClient($server);
        $this->db = $client->$databaseName;
        $this->documentPersister = $documentPersister;
        $this->prefix = $classPrefix;
    }

    public function getRepository($className)
    {
        if (!array_key_exists($className, $this->repositories)) {
            $this->repositories[$className] = new Repository($this, $className);
        }

        return $this->repositories[$className];
    }

    public function save($model)
    {
        $collection = $this->getCollectionForClass(get_class($model));
        $data = $this->documentPersister->convertToDatabaseValue($model);

        return $collection->save($data);
    }

    public function getCollectionForClass($className)
    {
        $collectionName = trim(str_replace($this->prefix, '', $className), '\\');

        return $this->db->$collectionName;
    }

    public function createModel($data, $className)
    {
        return $this->documentPersister->convertFromDatabaseValue($data, $className);
    }
}
