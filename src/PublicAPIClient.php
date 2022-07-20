<?php

namespace Covery\Client;

use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Requests\CardId;
use Covery\Client\Requests\Decision;
use Covery\Client\Requests\Event;
use Covery\Client\Requests\KycProof;
use Covery\Client\Requests\Ping;
use Covery\Client\Requests\Postback;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Covery\Client\CardId\ValidatorV1 as CardIdValidator;

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
     * @var CardIdValidator
     */
    private $cardIdValidator;

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
        $this->cardIdValidator = new CardIdValidator();
    }

    /**
     * Sends PSR-7 compatible request to Covery and returns
     *
     * @param RequestInterface $request
     * @return string
     * @throws IoException
     */
    public function send(RequestInterface $request)
    {
        $request = $this->prepareRequest($request);
        try {
            $this->logger->info('Sending request to ' . $request->getUri());
            $before = microtime(true);
            $response = $this->transport->send($request);
            $this->logger->info(sprintf('Request done in %.2f', microtime(true) - $before));
        } catch (\Exception $inner) {
            $this->logger->error($inner->getMessage(), ['exception' => $inner]);
            // Wrapping exception
            throw new IoException('Error sending request', 0, $inner);
        }
        $code = $response->getStatusCode();
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

        return $this->credentials->signRequest($request);
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
     * Sends request to Covery and returns access level, associated with
     * used credentials
     *
     * This method can be used for Covery health check and availability
     * On any problem (network, credentials, server side) this method
     * will throw an exception
     *
     * @return string
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
     * @throws CardIdValidationException
     * @throws Exception
     * @throws IoException
     */
    public function sendCardId(CardIdInterface $cardId)
    {
        // Validating
        $this->cardIdValidator->validate($cardId);

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
}
