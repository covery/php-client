<?php

namespace Covery\Client;

use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Requests\CardId;
use Covery\Client\Requests\Decision;
use Covery\Client\Requests\Event;
use Covery\Client\Requests\KycProof;
use Covery\Client\Requests\MediaStorage;
use Covery\Client\Requests\Postback;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Covery\Client\Requests\MediaFileUploader as MediaFileUploaderRequest;

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
     * @var ValidatorV1
     */
    private $validator;
    /**
     * @var int
     */
    private $responseStatusCode;

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
        $this->validator = new ValidatorV1();
    }

    /**
     * Sends PSR-7 compatible request to Covery and returns
     *
     * @param RequestInterface $request
     * @param bool $sign
     * @return string
     * @throws Exception
     * @throws IoException
     */
    public function send(RequestInterface $request, $sign = true)
    {
        $requestPrepared = $this->prepareRequest($request);
        if ($sign) {
            $requestSigned = $this->credentials->signRequest($requestPrepared);
        } else {
            $requestSigned = $requestPrepared;
        }
        try {
            $this->logger->info('Sending request to ' . $request->getUri());
            $before = microtime(true);
            $response = $this->transport->send($requestSigned);
            $this->logger->info(sprintf('Request done in %.2f', microtime(true) - $before));
        } catch (\Exception $inner) {
            $this->logger->error($inner->getMessage(), ['exception' => $inner]);
            // Wrapping exception
            throw new IoException('Error sending request', 0, $inner);
        }
        $code = $response->getStatusCode();
        $this->responseStatusCode = $code;
        $this->logger->debug('Received status code ' . $code);

        if ($code >= 400) {
            $this->handleNot200($response);
        }

        return $response->getBody()->getContents();
    }

    /**
     * Utility method, that prepares and signs request
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function prepareRequest(RequestInterface $request)
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
     * Utility function, that handles error response from Covery
     *
     * @param ResponseInterface $response
     * @throws Exception
     */
    private function handleNot200(ResponseInterface $response)
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
     * Sends envelope to Covery and returns it's ID on Covery side
     * Before sending, validation is performed
     *
     * @param EnvelopeInterface $envelope
     * @return int
     * @throws Exception
     */
    public function sendEvent(EnvelopeInterface $envelope)
    {
        // Validating
        $this->validator->validate($envelope);

        // Sending
        $data = $this->readJson($this->send(new Event($envelope)));

        if (!is_array($data) || !isset($data['requestId']) || !is_int($data['requestId'])) {
            throw new Exception("Malformed response");
        }

        return $data['requestId'];
    }

    /**
     * Sends postback envelope to Covery and returns it's ID on Covery side
     * Before sending, validation is performed
     *
     * @param EnvelopeInterface $envelope
     * @return int
     * @throws Exception
     */
    public function sendPostback(EnvelopeInterface $envelope)
    {
        // Validating
        $this->validator->validate($envelope);

        // Sending
        $data = $this->readJson($this->send(new Postback($envelope)));

        if (!is_array($data) || !isset($data['requestId']) || empty($data['requestId']) || !is_int($data['requestId'])) {
            throw new Exception("Malformed response");
        }

        return $data['requestId'];
    }

    /**
     * Sends envelope to Covery for analysis
     *
     * @param EnvelopeInterface $envelope
     * @return Result
     * @throws Exception
     */
    public function makeDecision(EnvelopeInterface $envelope)
    {
        // Validating
        $this->validator->validate($envelope);

        // Sending
        $data = $this->readJson($this->send(new Decision($envelope)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        try {
            return new Result(
                $data[ResultBaseField::REQUEST_ID],
                $data[ResultBaseField::TYPE],
                $data[ResultBaseField::CREATED_AT],
                $data[ResultBaseField::SEQUENCE_ID],
                $data[ResultBaseField::MERCHANT_USER_ID],
                $data[ResultBaseField::SCORE],
                $data[ResultBaseField::ACCEPT],
                $data[ResultBaseField::REJECT],
                $data[ResultBaseField::MANUAL],
                isset($data[ResultBaseField::REASON]) ? $data[ResultBaseField::REASON] : null,
                isset($data[ResultBaseField::ACTION]) ? $data[ResultBaseField::ACTION] : null,
                array_filter($data, function ($field) {
                    return !in_array($field, ResultBaseField::getAll());
                }, ARRAY_FILTER_USE_KEY)
            );
        } catch (\Exception $error) {
            throw new Exception('Malformed response', 0, $error);
        }
    }

    /**
     * Sends kycProof envelope to Covery and returns KycProofResult on Covery side
     *
     * @param EnvelopeInterface $envelope
     * @return KycProofResult
     * @throws EnvelopeValidationException
     * @throws Exception
     * @throws IoException
     */
    public function sendKycProof(EnvelopeInterface $envelope)
    {
        // Validating
        $this->validator->validate($envelope);

        // Sending
        $data = $this->readJson($this->send(new KycProof($envelope)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        try {
            return new KycProofResult(
                $data[KycProofResultBaseField::REQUEST_ID],
                $data[KycProofResultBaseField::TYPE],
                $data[KycProofResultBaseField::CREATED_AT],
                isset($data[KycProofResultBaseField::VERIFICATION_VIDEO]) ? $data[KycProofResultBaseField::VERIFICATION_VIDEO] : null,
                isset($data[KycProofResultBaseField::FACE_PROOF]) ? $data[KycProofResultBaseField::FACE_PROOF] : null,
                isset($data[KycProofResultBaseField::DOCUMENT_PROOF]) ? $data[KycProofResultBaseField::DOCUMENT_PROOF] : null,
                isset($data[KycProofResultBaseField::DOCUMENT_TWO_PROOF]) ? $data[KycProofResultBaseField::DOCUMENT_TWO_PROOF] : null,
                isset($data[KycProofResultBaseField::CONSENT_PROOF]) ? $data[KycProofResultBaseField::CONSENT_PROOF] : null,
                array_filter($data, function ($field) {
                    return !in_array($field, KycProofResultBaseField::getAll());
                }, ARRAY_FILTER_USE_KEY)
            );
        } catch (\Exception $error) {
            throw new Exception('Malformed response', 0, $error);
        }
    }

    /**
     * @param CardIdInterface $cardId
     * @return CardIdResult
     * @throws Exception
     * @throws IoException
     */
    public function sendCardId(CardIdInterface $cardId)
    {
        // Sending
        $data = $this->readJson($this->send(new CardId($cardId)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new CardIdResult(
            $data[CardIdResultBaseField::REQUEST_ID],
            $data[CardIdResultBaseField::CARD_ID],
            $data[CardIdResultBaseField::CREATED_AT]
        );
    }

    /**
     * Send Media Storage data and return upload URL
     *
     * @param MediaStorageInterface $media
     * @return MediaStorageResult
     * @throws Exception
     * @throws IoException
     */
    public function sendMediaStorage(MediaStorageInterface $media)
    {
        $data = $this->readJson($this->send(new MediaStorage($media)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new MediaStorageResult(
            $data[MediaStorageResultBaseField::UPLOAD_URL],
            $data[MediaStorageResultBaseField::MEDIA_ID],
            $data[MediaStorageResultBaseField::CREATED_AT]
        );
    }

    /**
     * @param MediaConnectionInterface $mediaConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function attachMediaConnection(MediaConnectionInterface $mediaConnection)
    {
        return $this->sendMediaConnection($mediaConnection, 'PUT');
    }

    /**
     * @param MediaConnectionInterface $mediaConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function detachMediaConnection(MediaConnectionInterface $mediaConnection)
    {
        return $this->sendMediaConnection($mediaConnection, 'DELETE');
    }

    /**
     * Upload Media file and returns status code
     *
     * @param MediaFileUploaderInterface $mediaFileUploader
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function uploadMediaFile(MediaFileUploaderInterface $mediaFileUploader)
    {
        $this->send(new MediaFileUploaderRequest($mediaFileUploader), false);

        if ($this->responseStatusCode >= 300) {
            throw new Exception("Malformed response");
        }

        return $this->responseStatusCode;
    }

    /**
     * Send media connection and return status code
     *
     * @param MediaConnectionInterface $mediaConnection
     * @param $method
     * @return int
     * @throws Exception
     * @throws IoException
     */
    private function sendMediaConnection(MediaConnectionInterface $mediaConnection, $method)
    {
        $this->readJson($this->send(new \Covery\Client\Requests\MediaConnection($mediaConnection, $method)));
        if ($this->responseStatusCode >= 300) {
            throw new Exception("Malformed response");
        }

        return $this->responseStatusCode;
    }

    /**
     * Get Account configuration status object from Covery
     *
     * @return AccountConfigurationStatusResult
     * @throws Exception
     * @throws IoException
     */
    public function getAccountConfigurationStatus()
    {
        // Sending
        $data = $this->readJson($this->send(new \Covery\Client\Requests\AccountConfigurationStatus()));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new AccountConfigurationStatusResult(
            $data[AccountConfigurationStatusResultBaseField::ACTUAL_EVENT_TYPES],
            $data[AccountConfigurationStatusResultBaseField::BASE_CURRENCY],
            $data[AccountConfigurationStatusResultBaseField::DECISION_CALLBACK_URL],
            $data[AccountConfigurationStatusResultBaseField::MANUAL_DECISION_CALLBACK_URL],
            $data[AccountConfigurationStatusResultBaseField::ONGOING_MONITORING_WEBHOOK_URL],
            $data[AccountConfigurationStatusResultBaseField::MEDIA_STORAGE_WEBHOOK_URL],
            $data[AccountConfigurationStatusResultBaseField::FRAUD_ALERT_CALLBACK_URL],
            $data[AccountConfigurationStatusResultBaseField::CARD_ID_GENERATION],
            $data[AccountConfigurationStatusResultBaseField::DEVICE_FINGERPRINT_GENERATION],
            $data[AccountConfigurationStatusResultBaseField::SEQUENCE_ID_GENERATION],
            $data[AccountConfigurationStatusResultBaseField::SEQUENCE_ID_GENERATION_METHOD],
            $data[AccountConfigurationStatusResultBaseField::AML_SERVICE],
            $data[AccountConfigurationStatusResultBaseField::AML_SERVICE_STATUS],
            $data[AccountConfigurationStatusResultBaseField::DOW_JONES_DATA_BASE_DATE],
            $data[AccountConfigurationStatusResultBaseField::KYC_PROVIDER]
        );
    }
}
