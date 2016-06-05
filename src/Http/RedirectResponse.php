<?php

namespace Coblog\Http;

class RedirectResponse extends Response
{
    public function __construct($url, $statusCode = 302, array $headers = [])
    {
        parent::__construct('', $statusCode, $headers);

        $this->headers['Location'] = $url;
    }
}
