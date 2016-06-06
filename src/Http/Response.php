<?php

namespace Coblog\Http;

class Response
{
    protected $content;

    protected $statusCode;

    protected $headers = [];

    public function __construct($content, $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $name => $value) {
            header($name.': '.$value, false, $this->statusCode);
        }
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function sendContent()
    {
        echo $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }
}
