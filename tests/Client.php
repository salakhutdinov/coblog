<?php

namespace tests;

use Coblog\Http\Request;
use Coblog\Kernel;

class Client
{
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getKernel()
    {
        return $this->kernel;
    }

    public function request($method, $url, array $get = [], array $post = [])
    {
        $server = [
            'REQUEST_URI' => $url,
            'REQUEST_METHOD' => $method,
        ];

        $request = new Request($get, $post, $server);
        $response = $this->kernel->handle($request);

        return $response;
    }
}
