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

    /**
     * @param CardIdInterface $cardId
     * @return CardIdResult
     * @throws Exception
     * @throws IoException
     */
    public static function sendCardId(CardIdInterface $cardId)
    {
        return self::getClient()->sendCardId($cardId);
    }

    /**
     * Send Media Storage data and return upload URL
     *
     * @param MediaStorageInterface $mediaStorage
     * @return MediaStorageResult
     * @throws Exception
     * @throws IoException
     */
    public static function sendMediaStorage(MediaStorageInterface $mediaStorage)
    {
        return self::getClient()->sendMediaStorage($mediaStorage);
    }

    /**
     * Attach media connection and return status code
     *
     * @param MediaConnectionInterface $mediaConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public static function attachMediaConnection(MediaConnectionInterface $mediaConnection)
    {
        return self::getClient()->attachMediaConnection($mediaConnection);
    }

    /**
     * Detach media connection and return status code
     *
     * @param MediaConnectionInterface $mediaConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public static function detachMediaConnection(MediaConnectionInterface $mediaConnection)
    {
        return self::getClient()->detachMediaConnection($mediaConnection);
    }

    /**
     * Upload Media file and returns status code
     *
     * @param $url
     * @param $file
     * @return int
     * @throws Exception
     * @throws IoException
     * @throws TimeoutException
     */
    public static function uploadMediaFile($url, $file)
    {
        $mediaFileUploader = new MediaFileUploader($url, $file);

        return $mediaFileUploader->upload();
    }

    /**
     * Get account configuration status and return result object
     *
     * @return AccountConfigurationStatusResult
     * @throws Exception
     * @throws IoException
     */
    public static function getAccountConfigurationStatus()
    {
        return self::getClient()->getAccountConfigurationStatus();
    }
}
