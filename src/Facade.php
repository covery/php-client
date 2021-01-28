<?php

namespace Covery\Client;

use Covery\Client\Credentials\Sha256;
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
     * @param string $token
     * @param string $secret
     */
    public static function setCredentials($token, $secret)
    {
        self::$credentials = new Sha256($token, $secret);
    }

    /**
     * Sets (or replaces) transport
     *
     * @param TransportInterface $transport
     */
    public static function setTransport(TransportInterface $transport)
    {
        self::$transport = $transport;
    }

    /**
     * Utility method to take client
     *
     * @return PublicAPIClient
     * @throws Exception
     */
    private static function getClient()
    {
        if (self::$client === null) {
            if (self::$credentials !== null && self::$transport !== null) {
                self::$client = new PublicAPIClient(self::$credentials, self::$transport, self::$logger);
            } else {
                throw new Exception('Unable to obtain client - credentials and/or transport not set');
            }
        }

        return self::$client;
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
        return self::getClient()->ping();
    }

    /**
     * Sends envelope to Covery and returns it's ID on Covery side
     * Before sending, validation is performed
     *
     * @param EnvelopeInterface $envelope
     * @return int
     * @throws Exception
     */
    public static function sendEvent(EnvelopeInterface $envelope)
    {
        return self::getClient()->sendEvent($envelope);
    }

    /**
     * Sends postback envelope to Covery and returns it's ID on Covery side
     * Before sending, validation is performed
     *
     * @param EnvelopeInterface $envelope
     * @return int
     * @throws Exception
     */
    public static function sendPostback(EnvelopeInterface $envelope)
    {
        return self::getClient()->sendPostback($envelope);
    }

    /**
     * Sends envelope to Covery for analysis
     *
     * @param EnvelopeInterface $envelope
     * @return Result
     * @throws Exception
     */
    public static function makeDecision(EnvelopeInterface $envelope)
    {
        return self::getClient()->makeDecision($envelope);
    }

    /**
     * Sends KycProof envelope to Covery and returns data on Covery side
     *
     * @param EnvelopeInterface $envelope
     * @return KycProofResult
     * @throws Exception
     */
    public static function sendKycProof(EnvelopeInterface $envelope)
    {
        return self::getClient()->sendKycProof($envelope);
    }
}
