<?php

namespace Covery\Client\Transport;

use Covery\Client\IoException;
use Covery\Client\TimeoutException;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * Class PersistentCurl
 *
 * CURL implementation of Covery Transport, which does not close connections.
 * For usage in workers only - in most cases this implementation will reduce impact of SSL and improve latency
 * This transport is experimental
 *
 * @package Covery\Client\Transport
 */
class PersistentCurl implements TransportInterface
{
    private $timeoutMillis;
    private $curl;

    /**
     * Curl constructor.
     *
     * @param int|float $timeout Timeout in seconds
     * @throws \Exception
     */
    public function __construct($timeout)
    {
        if (!is_int($timeout) && !is_float($timeout)) {
            throw new \InvalidArgumentException('Timeout must be integer or float');
        }
        if (!function_exists('curl_init')) {
            throw new \Exception('cURL extension not installed/enabled');
        }

        $this->timeoutMillis = floor($timeout * 1000);
        $this->curl = null;
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
        if ($this->curl == null) {
            $this->curl = curl_init();
        }
        curl_setopt($this->curl, CURLOPT_URL, strval($request->getUri()));
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT_MS, $this->timeoutMillis);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $request->getBody()->getContents());
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);

        try {
            $request->getBody()->close();
        } catch (\Exception $ignore) {
        }

        $response = curl_exec($this->curl);

        $status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $errno  = curl_errno($this->curl);
        $error  = curl_error($this->curl);

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
            $this->curl = null;
            // SSL error
            throw new IoException('Transport SSL error ' . $error, intval($errno));
        } elseif ($errno !== CURLE_OK) {
            $this->curl = null;
            // Other error
            throw new IoException('Curl error ' . $error, intval($errno));
        }

        if ($response === false) {
            $this->curl = null;
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
