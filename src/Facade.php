<?php

namespace Covery\Client;
use Psr\Log\LoggerInterface;

/**
 * Class Facade
 *
 * Static access facade to covery client
 *
 * @package Covery\Client
 */
class Facade
{
    /**
     * @var CredentialsInterface
     */
    private static $credentials;
    /**
     * @var TransportInterface
     */
    private static $transport;
    /**
     * @var PublicAPIClient
     */
    private static $client;
    /**
     * @var LoggerInterface|null
     */
    private static $logger;

    /**
     * Set logger
     *
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * Sets (or replaces) credentials
     *
     * @param CredentialsInterface $credentials
     */
    public static function setCredentials(CredentialsInterface $credentials)
    {
        self::$credentials = $credentials;
        if (self::$transport !== null) {
            self::$client = new PublicAPIClient(self::$credentials, self::$transport, self::$logger);
        }
    }

    /**
     * Sets (or replaces) transport
     *
     * @param TransportInterface $transport
     */
    public static function setTransport(TransportInterface $transport)
    {
        self::$transport = $transport;
        if (self::$credentials !== null) {
            self::$client = new PublicAPIClient(self::$credentials, self::$transport, self::$logger);
        }
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
    public static function ping()
    {
        if (self::$client === null) {
            throw new Exception('Credentials and/or transport not provided');
        }

        return self::$client->ping();
    }
}
