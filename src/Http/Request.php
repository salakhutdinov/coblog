<?php

namespace Coblog\Http;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    private $get;
    private $post;
    private $cookies;
    private $files;
    private $server;

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

    public function getUri()
    {
        return $this->server->get('REQUEST_URI');
    }
}
