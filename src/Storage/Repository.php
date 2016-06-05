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
        return $this->collection->findBy(['_id' => $id]);
    }

    public function findAll()
    {
        return $this->findBy();
    }

    public function findBy(array $criteria = [])
    {
        $cursor = $this->collection->find($criteria);
        
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
