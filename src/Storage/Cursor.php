<?php

namespace Coblog\Storage;

use Iterator;
use MongoCursor;

class Cursor implements Iterator
{
    private $documentManager;

    private $cursor;

    private $className;

    public function __construct(DocumentManager $documentManager, MongoCursor $cursor, $className)
    {
        $this->documentManager = $documentManager;
        $this->cursor = $cursor;
        $this->className = $className;
    }

    public function current()
    {
        $document = $this->cursor->current();

        return $this->documentManager->createModel($document, $this->className);
    }

    public function key()
    {
        return $this->cursor->key;
    }

    public function next()
    {
        $this->cursor->next();
    }

    public function rewind()
    {
        $this->cursor->rewind();
    }

    public function valid()
    {
        return $this->cursor->valid();
    }
}
