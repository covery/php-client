<?php

namespace Covery\Client;

use Covery\Client\Requests\Ping;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class PublicAPIClient
{
    /**
     * @var CredentialsInterface
     */
    private $credentials;

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Client constructor.
     * @param CredentialsInterface $credentials
     * @param TransportInterface $transport
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        CredentialsInterface $credentials,
        TransportInterface $transport,
        LoggerInterface $logger = null
    ) {
        $this->credentials = $credentials;
        $this->transport = $transport;
        $this->logger = $logger === null ? new NullLogger() : $logger;
    }

    private function send(RequestInterface $request)
    {
        $request = $this->credentials->signRequest($request);
        $response = $this->transport->send($request);
        $code = $response->getStatusCode();

        if ($code >= 400) {
            // Analyzing response
            if ($response->hasHeader('X-Maxwell-Status') && $response->hasHeader('X-Maxwell-Error-Message')) {
                // Extended data available
                $message = $response->getHeaderLine('X-Maxwell-Error-Message');
                $type = $response->getHeaderLine('X-Maxwell-Error-Type');
                if (strpos($type, 'AuthorizationRequiredException') !== false) {
                    throw new AuthException($message);
                }

                switch ($message) {
                    case 'Empty auth token':
                    case 'Empty signature':
                    case 'Empty nonce':
                        throw new AuthException($message);
                }
            }

            throw new Exception("Communication failed with status code {$code}");
        }

        return $response->getBody()->getContents();
    }

    /**
     * Utility method, that reads JSON data
     *
     * @param $string
     * @return mixed|null
     * @throws Exception
     */
    private function readJson($string)
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

    /**
     * Sends request to Covery and returns access level, associated with
     * used credentials
     *
     * This method can be used for Covery health check and availability
     * On any problem (network, credentials, server side) this method
     * will throw an exception
     *
     * @return mixed
     * @throws Exception
     */
    public function ping()
    {
        $data = $this->readJson($this->send(new Ping()));
        if (!is_array($data) || !isset($data['level'])) {
            throw new Exception("Malformed response");
        }

        return $data['level'];
    }
}
