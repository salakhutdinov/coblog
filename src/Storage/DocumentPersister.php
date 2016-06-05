<?php

namespace Coblog\Storage;

class DocumentPersister
{
    public function convertFromDatabaseValue($document, $className)
    {
        $reflectionClass = new \ReflectionClass($className);
        $model = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionObject = new \ReflectionObject($model);
        $properties = $reflectionObject->getProperties();
        foreach ($properties as $property) {
            if ($property->getName() === 'id') {
                $value = (string) $document['_id'];
                $this->updateProperty($property, $model, $value);
            } elseif (array_key_exists($property->getName(), $document)) {
                $value = $this->convertPropertyFromDatabaseValue($document[$property->getName()]);
                $this->updateProperty($property, $model, $value);
            }
        }

        return $model;
    }

    public function convertToDatabaseValue($model)
    {
        $document = [];

        $reflectionObject = new \ReflectionObject($model);
        $properties = $reflectionObject->getProperties();
        foreach ($properties as $property) {
            $property->setAccessible(true);
            if ($property->getName() === 'id') {
                $document['_id'] = new \MongoId($property->getValue($model));
            } else {
                $value = $this->convertPropertyToDatabaseValue($property->getValue($model));
                $document[$property->getName()] = $value;
            }
        }

        return $document;
    }

    private function convertPropertyFromDatabaseValue($value)
    {
        if ($value instanceof \MongoDate) {
            $datetime = new \DateTime;
            $datetime->setTimestamp($value->sec);

            return $datetime;
        } else {
            return $value;
        }
    }

    private function convertPropertyToDatabaseValue($value)
    {
        if ($value instanceof \DateTime) {
            return new \MongoDate($value->getTimestamp());
        } else {
            return $value;
        }
    }

    private function updateProperty($property, $object, $value)
    {
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
