<?php

namespace Coblog;

class Container implements \ArrayAccess
{
    private $services = [];

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->services);
    }

    public function offsetGet($offset)
    {
        return $this->services[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->services[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->services[$offset]);
    }

    public function register(ServiceProviderInterface $serviceProvider)
    {
        $serviceProvider->register($this);
    }
}
