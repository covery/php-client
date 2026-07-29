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
     * @var int|null
     */
    private $port;
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
     * @param string $host Hostname, optionally with port ("example.com:8083")
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

        // Split an optional port off the host so it is applied via
        // Uri::withPort() instead of being stuffed into the host component.
        // A port inside the host component is not valid per RFC 3986 and may
        // be rejected by stricter PSR-7 host validation.
        $parsed = parse_url('//' . $host);
        if ($parsed === false || !isset($parsed['host'])) {
            throw new \InvalidArgumentException('Host is malformed');
        }

        $this->transport = $transport;
        $this->host = $parsed['host'];
        $this->port = isset($parsed['port']) ? $parsed['port'] : null;
        $this->scheme = $scheme;
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request)
    {
        $uri = $request->getUri()->withHost($this->host)->withScheme($this->scheme);
        if ($this->port !== null) {
            $uri = $uri->withPort($this->port);
        }

        return $this->transport->send($request->withUri($uri));
    }
}
