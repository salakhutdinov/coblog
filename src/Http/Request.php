<?php

namespace Coblog\Http;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public $get;
    public $post;
    public $cookies;
    public $files;
    public $server;

    private $method;
    private $uri;

    public function __construct(array $get = array(), array $post = array(), array $cookies = array(), array $files = array(), array $server = array())
    {
        $this->get = new ParameterBag($get);
        $this->post = new ParameterBag($post);
        $this->cookies = new ParameterBag($cookies);
        $this->files = new ParameterBag($files);
        $this->server = new ParameterBag($server);
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD');
    }

    public function isMethod($method)
    {
        return $this->getMethod() === $method;
    }

    public function getUri()
    {
        return $this->server->get('REQUEST_URI');
    }
}
