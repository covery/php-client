<?php

namespace Covery\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface TransportInterface
{
    const DEFAULT_URL = "https://covery.maxpay.com/";

    /**
     * Sends request
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function send(RequestInterface $request);
}
