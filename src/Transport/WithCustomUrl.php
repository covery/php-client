<?php

namespace Covery\Client\Transport;

use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Class WithCustomUrl
 *
 * Special transport implementation, that allows replacement
 * of Covery URL
 *
 * @package Covery\Client\Transport
 */
class WithCustomUrl implements TransportInterface
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * WithCustomUrl constructor.
     *
     * @param string $url
     * @param TransportInterface $transport
     */
    public function __construct($url, TransportInterface $transport)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('URL must be string');
        }
        if ($url !== null) {
            if (substr($url, -1) != '/') {
                $url .= '/';
            }

            $this->url = $url;
        }
        $this->url = $url;
        $this->transport = $transport;
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request)
    {
        $requestUrl = strval($request->getUri());
        if ($this->url !== null
            && substr($requestUrl, 0, strlen(TransportInterface::DEFAULT_URL)) === TransportInterface::DEFAULT_URL
        ) {
            // Replacing
            $request = $request->withUri(
                new Uri(str_replace(TransportInterface::DEFAULT_URL, $this->url, $requestUrl))
            );
        }

        return $this->transport->send($request);
    }
}
