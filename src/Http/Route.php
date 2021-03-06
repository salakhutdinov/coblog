<?php

namespace Coblog\Http;

class Route
{
    private $url;
    private $regex;
    private $methods;
    private $controller;

    public function __construct($url, array $methods, $controller)
    {
        $this->url = $url;
        $this->regex = $this->createRegex($url);
        $this->methods = $methods;
        $this->controller = $controller;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getRegex()
    {
        return $this->regex;
    }

    private function createRegex($url)
    {
        $regex = preg_replace('#\{(\w+)\}#', '(?<$1>\w+)', $url);

        return '#^' . $regex . '$#';
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getController()
    {
        return $this->controller;
    }
}
