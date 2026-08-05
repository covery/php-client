<?php

namespace Covery\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Handles low-level HTTP request preparation and response decoding for
 * PublicAPIClient. Extracted to keep the API client focused on endpoints.
 */
class ResponseHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Prepares request, ensuring a hostname is present.
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function prepareRequest(RequestInterface $request)
    {
        // Checking hostname presence
        $uri = $request->getUri();
        if ($uri->getHost() == '') {
            $request = $request->withUri(
                $uri->withHost(TransportInterface::DEFAULT_HOST)->withScheme(TransportInterface::DEFAULT_SCHEME)
            );
        }

        return $request;
    }

    /**
     * Handles error response from Covery.
     *
     * @param ResponseInterface $response
     * @throws Exception
     */
    public function handleNot200(ResponseInterface $response)
    {
        // Analyzing response
        if ($response->hasHeader('X-Maxwell-Status') && $response->hasHeader('X-Maxwell-Error-Message')) {
            // Extended data available
            $message = $response->getHeaderLine('X-Maxwell-Error-Message');
            $type = $response->getHeaderLine('X-Maxwell-Error-Type');

            //throw slate data exception
            if (strpos($type, 'StaleDataException') !== false) {
                $this->logger->error($message);
                throw new StaleDataException($message, $response->getStatusCode());
            }

            if (strpos($type, 'AuthorizationRequiredException') !== false) {
                $this->logger->error('Authentication failure ' . $message);
                throw new AuthException($message, $response->getStatusCode());
            }

            switch ($message) {
                case 'Empty auth token':
                case 'Empty signature':
                case 'Empty nonce':
                    $this->logger->error('Authentication failure ' . $message);
                    throw new AuthException($message, $response->getStatusCode());
            }

            $this->logger->error('Covery error ' . $message);
            throw new DeliveredException($message, $response->getStatusCode());
        } elseif ($response->hasHeader('X-General-Failure')) {
            // Remote fatal error
            throw new DeliveredException('Antifraud fatal error', $response->getStatusCode());
        }

        throw new Exception("Communication failed with status code {$response->getStatusCode()}");
    }

    /**
     * Reads JSON data from a response body string.
     *
     * @param mixed $string
     * @return mixed|null
     * @throws Exception
     */
    public function readJson($string)
    {
        if (!is_string($string)) {
            throw new Exception("Unable to read JSON - not a string received");
        }
        if (strlen($string) === 0) {
            return null;
        }

        $data = json_decode($string, true);
        if ($data === null) {
            $message = 'Unable to decode JSON';
            if (function_exists('json_last_error_msg')) {
                $message = json_last_error_msg();
            }

            throw new Exception($message);
        }

        return $data;
    }
}
