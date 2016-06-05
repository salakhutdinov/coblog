<?php

namespace Coblog\Storage;

class Repository
{
    private $documentManager;

    private $className;

    private $collection;

    public function __construct(DocumentManager $documentManager, $className)
    {
        $this->documentManager = $documentManager;
        $this->className = $className;
        $this->collection = $this->documentManager->getCollectionForClass($className);
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function find($id)
    {
        return $this->findOneBy(['_id' => new \MongoId($id)]);
    }

    public function findBy(array $criteria = [], array $sort = [])
    {
        $cursor = $this->collection->find($criteria)->sort($sort);
        
        return $this->wrapCursor($cursor);
    }

    public function findOneBy(array $criteria = [])
    {
        $document = $this->collection->findOne($criteria);

        return $document ? $this->documentManager->createModel($document, $this->className) : null;
    }

    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    private function wrapCursor($cursor)
    {
        return new Cursor($this->documentManager, $cursor, $this->className);
    }
}
