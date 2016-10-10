<?php

namespace Covery\Client\Requests;

use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Request;

class Ping extends Request
{
    public function __construct()
    {
        parent::__construct("POST", TransportInterface::DEFAULT_URL . "api/ping");
    }
}
