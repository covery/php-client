<?php

namespace Covery\Client;

use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Requests\CardId;
use Covery\Client\Requests\Decision;
use Covery\Client\Requests\Event;
use Covery\Client\Requests\KycProof;
use Covery\Client\Requests\DocumentStorage;
use Covery\Client\Requests\Postback;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Covery\Client\Requests\DocumentFileUploader as DocumentFileUploaderRequest;

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
     * @var ResponseHandler
     */
    private $responseHandler;

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
        $this->responseHandler = new ResponseHandler($this->logger);
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
        $requestPrepared = $this->responseHandler->prepareRequest($request);
        if ($sign) {
            $requestSigned = $this->credentials->signRequest($requestPrepared);
        } else {
            $requestSigned = $requestPrepared;
        }
        try {
            $this->logger->info('Sending request to ' . $requestSigned->getUri());
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
            $this->responseHandler->handleNot200($response);
        }

        return $response->getBody()->getContents();
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
        $data = $this->responseHandler->readJson($this->send(new Event($envelope)));

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
        $data = $this->responseHandler->readJson($this->send(new Postback($envelope)));

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
        $data = $this->responseHandler->readJson($this->send(new Decision($envelope)));

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
                $this->optional($data, ResultBaseField::REASON),
                $this->optional($data, ResultBaseField::ACTION),
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
        $data = $this->responseHandler->readJson($this->send(new KycProof($envelope)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        try {
            return new KycProofResult(
                $data[KycProofResultBaseField::REQUEST_ID],
                $data[KycProofResultBaseField::TYPE],
                $data[KycProofResultBaseField::CREATED_AT],
                $this->optional($data, KycProofResultBaseField::VERIFICATION_VIDEO),
                $this->optional($data, KycProofResultBaseField::FACE_PROOF),
                $this->optional($data, KycProofResultBaseField::DOCUMENT_PROOF),
                $this->optional($data, KycProofResultBaseField::DOCUMENT_TWO_PROOF),
                $this->optional($data, KycProofResultBaseField::CONSENT_PROOF)
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
        $data = $this->responseHandler->readJson($this->send(new CardId($cardId)));

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
     * Send Document Storage data and return upload URL
     *
     * @param DocumentStorageInterface $document
     * @return DocumentStorageResult
     * @throws Exception
     * @throws IoException
     */
    public function sendDocumentStorage(DocumentStorageInterface $document)
    {
        $data = $this->responseHandler->readJson($this->send(new DocumentStorage($document)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new DocumentStorageResult(
            $data[DocumentStorageResultBaseField::UPLOAD_URL],
            $data[DocumentStorageResultBaseField::DOCUMENT_ID],
            $data[DocumentStorageResultBaseField::CREATED_AT]
        );
    }

    /**
     * @param DocumentConnectionInterface $documentConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function attachDocumentConnection(DocumentConnectionInterface $documentConnection)
    {
        return $this->sendDocumentConnection($documentConnection, 'PUT');
    }

    /**
     * @param DocumentConnectionInterface $documentConnection
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function detachDocumentConnection(DocumentConnectionInterface $documentConnection)
    {
        return $this->sendDocumentConnection($documentConnection, 'DELETE');
    }

    /**
     * Upload Document file and returns status code
     *
     * @param DocumentFileUploaderInterface $documentFileUploader
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function uploadDocumentFile(DocumentFileUploaderInterface $documentFileUploader)
    {
        $this->send(new DocumentFileUploaderRequest($documentFileUploader), false);

        if ($this->responseStatusCode >= 300) {
            throw new Exception("Malformed response");
        }

        return $this->responseStatusCode;
    }

    /**
     * Send document connection and return status code
     *
     * @param DocumentConnectionInterface $documentConnection
     * @param $method
     * @return int
     * @throws Exception
     * @throws IoException
     */
    private function sendDocumentConnection(DocumentConnectionInterface $documentConnection, $method)
    {
        $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\DocumentConnection($documentConnection, $method)));
        if ($this->responseStatusCode >= 300) {
            throw new Exception("Malformed response");
        }

        return $this->responseStatusCode;
    }

    /**
     * Creates client management individual profile (POST) and returns result
     *
     * @param IndividualProfileInterface $profile
     * @return IndividualProfileResult
     * @throws Exception
     * @throws IoException
     */
    public function createIndividualProfile(IndividualProfileInterface $profile)
    {
        return $this->sendIndividualProfile($profile, 'POST');
    }

    /**
     * Updates client management individual profile (PUT) and returns result
     *
     * @param IndividualProfileInterface $profile
     * @return IndividualProfileResult
     * @throws Exception
     * @throws IoException
     */
    public function updateIndividualProfile(IndividualProfileInterface $profile)
    {
        return $this->sendIndividualProfile($profile, 'PUT');
    }

    /**
     * Sends individual profile with given HTTP method and parses the result
     *
     * @param IndividualProfileInterface $profile
     * @param string $method
     * @return IndividualProfileResult
     * @throws Exception
     * @throws IoException
     */
    private function sendIndividualProfile(IndividualProfileInterface $profile, $method)
    {
        $data = $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\IndividualProfile($profile, $method)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new IndividualProfileResult(
            $data[IndividualProfileResultBaseField::CLIENT_PROFILE_ID],
            $data[IndividualProfileResultBaseField::PROFILE_TYPE],
            $data[IndividualProfileResultBaseField::CREATED_AT]
        );
    }

    /**
     * Fetches current relationships (POST) for a given receiver and/or provider
     *
     * @param RelationshipsInterface $query Built via Relationships\Builder::reviewQuery()
     * @return RelationshipsResult
     * @throws Exception
     * @throws IoException
     */
    public function getRelationships(RelationshipsInterface $query)
    {
        $data = $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\Relationships($query, 'POST')));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        try {
            return new RelationshipsResult($data);
        } catch (\Exception $error) {
            throw new Exception('Malformed response', 0, $error);
        }
    }

    /**
     * Creates or changes relationships between client profiles (PUT)
     *
     * @param RelationshipsInterface $relationships
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function putRelationships(RelationshipsInterface $relationships)
    {
        return $this->sendRelationships($relationships, 'PUT');
    }

    /**
     * Deletes relationships between client profiles (DELETE)
     *
     * @param RelationshipsInterface $relationships
     * @return int
     * @throws Exception
     * @throws IoException
     */
    public function deleteRelationships(RelationshipsInterface $relationships)
    {
        return $this->sendRelationships($relationships, 'DELETE');
    }

    /**
     * Sends relationships with given HTTP method and returns status code
     *
     * @param RelationshipsInterface $relationships
     * @param string $method
     * @return int
     * @throws Exception
     * @throws IoException
     */
    private function sendRelationships(RelationshipsInterface $relationships, $method)
    {
        $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\Relationships($relationships, $method)));
        if ($this->responseStatusCode >= 300) {
            throw new Exception("Malformed response");
        }

        return $this->responseStatusCode;
    }

    /**
     * Creates client management entity profile (POST) and returns result
     *
     * @param EntityProfileInterface $profile
     * @return EntityProfileResult
     * @throws Exception
     * @throws IoException
     */
    public function createEntityProfile(EntityProfileInterface $profile)
    {
        return $this->sendEntityProfile($profile, 'POST');
    }

    /**
     * Updates client management entity profile (PUT) and returns result
     *
     * @param EntityProfileInterface $profile
     * @return EntityProfileResult
     * @throws Exception
     * @throws IoException
     */
    public function updateEntityProfile(EntityProfileInterface $profile)
    {
        return $this->sendEntityProfile($profile, 'PUT');
    }

    /**
     * Sends entity profile with given HTTP method and parses the result
     *
     * @param EntityProfileInterface $profile
     * @param string $method
     * @return EntityProfileResult
     * @throws Exception
     * @throws IoException
     */
    private function sendEntityProfile(EntityProfileInterface $profile, $method)
    {
        $data = $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\EntityProfile($profile, $method)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new EntityProfileResult(
            $data[EntityProfileResultBaseField::CLIENT_PROFILE_ID],
            $data[EntityProfileResultBaseField::PROFILE_TYPE],
            $data[EntityProfileResultBaseField::CREATED_AT]
        );
    }

    /**
     * Fetches client management client profile (POST) by client_profile_id
     *
     * @param ClientProfileInterface $profile
     * @return ClientProfileResult
     * @throws Exception
     * @throws IoException
     */
    public function getClientProfile(ClientProfileInterface $profile)
    {
        $data = $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\ClientProfile($profile)));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new ClientProfileResult(
            $data[ClientProfileResultBaseField::CLIENT_PROFILE_ID],
            $this->optional($data, ClientProfileResultBaseField::SEQUENCE_ID),
            $this->optional($data, ClientProfileResultBaseField::USER_MERCHANT_ID),
            $this->optional($data, ClientProfileResultBaseField::ACCOUNT_STATUS),
            $this->optional($data, ClientProfileResultBaseField::REG_DATE),
            $this->optional($data, ClientProfileResultBaseField::PHONE),
            $this->optional($data, ClientProfileResultBaseField::PHONE_CONFIRMED),
            $this->optional($data, ClientProfileResultBaseField::EMAIL),
            $this->optional($data, ClientProfileResultBaseField::EMAIL_CONFIRMED),
            $this->optional($data, ClientProfileResultBaseField::USER_NAME),
            $this->optional($data, ClientProfileResultBaseField::PASSWORD),
            $this->optional($data, ClientProfileResultBaseField::COMPANY_NAME),
            $this->optional($data, ClientProfileResultBaseField::WEBSITE_URL),
            $this->optional($data, ClientProfileResultBaseField::INDUSTRY),
            $this->optional($data, ClientProfileResultBaseField::FULLNAME),
            $this->optional($data, ClientProfileResultBaseField::HAS_MIDDLE_NAME),
            $this->optional($data, ClientProfileResultBaseField::BIRTH_DATE),
            $this->optional($data, ClientProfileResultBaseField::GENDER),
            $this->optional($data, ClientProfileResultBaseField::MARITAL_STATUS),
            $this->optional($data, ClientProfileResultBaseField::NATIONALITY),
            $this->optional($data, ClientProfileResultBaseField::EDUCATION),
            $this->optional($data, ClientProfileResultBaseField::EMPLOYMENT_STATUS),
            $this->optional($data, ClientProfileResultBaseField::SOURCE_OF_FUNDS),
            $this->optional($data, ClientProfileResultBaseField::DOCUMENT_COUNTRY),
            $this->optional($data, ClientProfileResultBaseField::DOCUMENT_CONFIRMED),
            $this->optional($data, ClientProfileResultBaseField::REG_NUMBER),
            $this->optional($data, ClientProfileResultBaseField::ISSUE_DATE),
            $this->optional($data, ClientProfileResultBaseField::EXPIRY_DATE),
            $this->optional($data, ClientProfileResultBaseField::VAT_NUMBER),
            $this->optional($data, ClientProfileResultBaseField::VAT_CONFIRMED),
            $this->optional($data, ClientProfileResultBaseField::DECLARATION_OF_TRUST),
            $this->optional($data, ClientProfileResultBaseField::DESCRIPTION),
            $this->optional($data, ClientProfileResultBaseField::COUNTRY),
            $this->optional($data, ClientProfileResultBaseField::STATE),
            $this->optional($data, ClientProfileResultBaseField::CITY),
            $this->optional($data, ClientProfileResultBaseField::ZIP),
            $this->optional($data, ClientProfileResultBaseField::ADDRESS),
            $this->optional($data, ClientProfileResultBaseField::ADDRESS_CONFIRMED),
            $this->optional($data, ClientProfileResultBaseField::PURPOSE_TO_OPEN_ACCOUNT),
            $this->optional($data, ClientProfileResultBaseField::ONE_OPERATION_LIMIT),
            $this->optional($data, ClientProfileResultBaseField::DAILY_LIMIT),
            $this->optional($data, ClientProfileResultBaseField::WEEKLY_LIMIT),
            $this->optional($data, ClientProfileResultBaseField::MONTHLY_LIMIT),
            $this->optional($data, ClientProfileResultBaseField::ANNUAL_LIMIT),
            $this->optional($data, ClientProfileResultBaseField::ACTIVE_FEATURES),
            $this->optional($data, ClientProfileResultBaseField::PROMOTIONS)
        );
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
        $data = $this->responseHandler->readJson($this->send(new \Covery\Client\Requests\AccountConfigurationStatus()));

        if (!is_array($data)) {
            throw new Exception("Malformed response");
        }

        return new AccountConfigurationStatusResult(
            $data[AccountConfigurationStatusResultBaseField::ACTUAL_EVENT_TYPES],
            $data[AccountConfigurationStatusResultBaseField::BASE_CURRENCY],
            $data[AccountConfigurationStatusResultBaseField::DECISION_CALLBACK_URL],
            $data[AccountConfigurationStatusResultBaseField::MANUAL_DECISION_CALLBACK_URL],
            $data[AccountConfigurationStatusResultBaseField::ONGOING_MONITORING_WEBHOOK_URL],
            $data[AccountConfigurationStatusResultBaseField::DOCUMENT_STORAGE_WEBHOOK_URL],
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

    /**
     * Returns $data[$key] when present, null otherwise.
     *
     * @param array $data
     * @param string $key
     * @return mixed|null
     */
    private function optional(array $data, $key)
    {
        return isset($data[$key]) ? $data[$key] : null;
    }
}
