<?php

namespace Covery\Client\Credentials;

use Covery\Client\CredentialsInterface;
use Psr\Http\Message\RequestInterface;

class Sha256 implements CredentialsInterface
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $secret;

    /**
     * Sha256 credentials constructor
     *
     * @param string $token
     * @param string $secret
     * @throws \Exception
     */
    public function __construct($token, $secret)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token must be string');
        }
        if (!is_string($secret)) {
            throw new \InvalidArgumentException('Secret must be string');
        }
        if (!function_exists('hash')) {
            throw new \Exception('Unable to build Sha256 credentials - function "hash" not exists');
        }

        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * Signs provided HTTP request
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function signRequest(RequestInterface $request)
    {
        // Generating random NONCE
        $nonce = microtime(true) . mt_rand();

        // Generating signature
        $signature = hash('sha256', $nonce . $request->getBody()->getContents() . $this->secret);

        return $request
            ->withHeader('X-Auth-Token', $this->token)
            ->withHeader('X-Auth-Nonce', $nonce)
            ->withHeader('X-Auth-Signature', $signature)
            ->withHeader('X-Auth-Version', '1.0');
    }
}
