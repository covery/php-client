<?php

namespace Covery\Client\Transport;

use Covery\Client\TransportInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class WithCustomHost
 *
 * Special transport implementation, that allows replacement
 * of Covery hostname
 *
 * @package Covery\Client\Transport
 */
class WithCustomHost implements TransportInterface
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * WithCustomUrl constructor.
     *
     * @param TransportInterface $transport
     * @param string $host
     * @param string $scheme
     */
    public function __construct(TransportInterface $transport, $host, $scheme = 'https')
    {
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Host must be string');
        } elseif (empty($host)) {
            throw new \InvalidArgumentException('Host must be not empty');
        }

        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Scheme must be string');
        }

        $this->transport = $transport;
        $this->host = $host;
        $this->scheme = $scheme;
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request)
    {
        $request = $request->withUri(
            $request->getUri()->withHost($this->host)->withScheme($this->scheme)
        );

        return $this->transport->send($request);
    }
}
