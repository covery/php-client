<?php

namespace Covery\Client;

use Psr\Http\Message\RequestInterface;

interface CredentialsInterface
{
    /**
     * Signs provided request, injecting necessary data into it
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function signRequest(RequestInterface $request);
}
