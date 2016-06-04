<?php

namespace Coblog\Form;

class Field
{
    private $name;

    private $type;

    private $attributes;

    private $value;

    private $errors = [];

    public function __construct($name, $type = 'text', array $attributes = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->attributes = $attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Returns attrbute of field
     *
     * @param $key string
     * @param $default mixed
     *
     * @return mixed
     */
    public function getAttribute($key, $default = null)
    {
        return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default;
    }

    /**
     * Check whether field required
     *
     * @return bool
     */
    public function isRequired()
    {
        return (bool) $this->getAttribute('required', false);
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
