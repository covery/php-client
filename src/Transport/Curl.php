<?php

namespace Covery\Client\Transport;

use Covery\Client\IoException;
use Covery\Client\TimeoutException;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * Class Curl
 *
 * CURL implementation of Covery Transport
 *
 * @package Covery\Client\Transport
 */
class Curl implements TransportInterface
{
    private $connectTimeoutMillis;
    private $requestTimeoutMillis;

    /**
     * Curl constructor.
     *
     * @param int|float $connectTimeout Connection timeout in seconds
     * @param int|float $requestTimeout Request timeout in seconds.
     *   Default is 0, which means it never times out during transfer.
     * @throws \Exception
     */
    public function __construct($connectTimeout, $requestTimeout = 0)
    {
        if (!is_int($connectTimeout) && !is_float($connectTimeout)) {
            throw new \InvalidArgumentException('Connect timeout must be integer or float');
        }
        if (!is_int($requestTimeout) && !is_float($requestTimeout)) {
            throw new \InvalidArgumentException('Request timeout must be integer or float');
        }
        if (!function_exists('curl_init')) {
            throw new \Exception('cURL extension not installed/enabled');
        }

        $this->connectTimeoutMillis = floor($connectTimeout * 1000);
        $this->requestTimeoutMillis = floor($requestTimeout * 1000);
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request)
    {
        $headers = [];
        foreach ($request->getHeaders() as $name => $values) {
            $headers[] = $name . ': ' . implode(', ', $values);
        }

        $before = microtime(true);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, strval($request->getUri()));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, $this->connectTimeoutMillis);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, $this->requestTimeoutMillis);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getBody()->getContents());
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, 1);

        try {
            $request->getBody()->close();
        } catch (\Exception $ignore) {
        }

        $response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $errno  = curl_errno($curl);
        $error  = curl_error($curl);
        curl_close($curl);

        if ($errno === CURLE_OPERATION_TIMEOUTED) {
            // Timeout
            throw new TimeoutException(sprintf('Transport timeout after %.2f seconds wait', microtime(true) - $before));
        } elseif ($errno === CURLE_SSL_CACERT
            || $errno === CURLE_SSL_CERTPROBLEM
            || $errno === CURLE_SSL_CIPHER
            || $errno === CURLE_SSL_CONNECT_ERROR
            || $errno === CURLE_SSL_PEER_CERTIFICATE
            || $errno === CURLE_SSL_ENGINE_NOTFOUND
            || $errno === CURLE_SSL_ENGINE_SETFAILED
        ) {
            // SSL error
            throw new IoException('Transport SSL error ' . $error, intval($errno));
        } elseif ($errno !== CURLE_OK) {
            // Other error
            throw new IoException('Curl error ' . $error, intval($errno));
        }

        if ($response === false) {
            throw new IoException(sprintf('Curl error. Received status %s, curl error %s', $status, $error));
        }

        $rawHeaders = substr($response, 0, $headerSize);
        $body = trim(substr($response, $headerSize));

        $rawHeaders = explode("\n", $rawHeaders);
        $headers = array();
        foreach ($rawHeaders as $row) {
            $row = trim($row);
            $index = strpos($row, ':');
            if ($index > 0) {
                $headers[substr($row, 0, $index)] = trim(substr($row, $index + 1));
            }
        }

        // Building response
        return new Response($status, $headers, $body);
    }
}
