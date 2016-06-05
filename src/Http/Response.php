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

    public function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $name => $value) {
            header($name.': '.$value, false, $this->statusCode);
        }
    }

    public function sendContent()
    {
        echo $this->content;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }
}
