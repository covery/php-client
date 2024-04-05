<?php

namespace Covery\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface TransportInterface
{
    const DEFAULT_HOST = "127.0.0.1:8221";
    const DEFAULT_SCHEME = "http";

    /**
     * Sends request
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request);
}
