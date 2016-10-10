<?php

namespace Covery\Client\Transport;

use Covery\Client\TransportInterface;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class OverGuzzle implements TransportInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    public function __construct(ClientInterface $client)
    {
        $this->guzzle = $client;
    }

    /**
     * @inheritdoc
     */
    public function send(RequestInterface $request)
    {
        return $this->guzzle->send($request, ['http_errors' => false]);
    }
}
