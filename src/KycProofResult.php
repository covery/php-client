<?php

namespace Covery\Client;

/**
 * Class KycProofResult
 *
 * Contains keyProof result data, received from Covery
 *
 * @package Covery\Client
 */
class KycProofResult
{
    /**
     * @var int
     */
    private $requestId;
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $createdAt;
    /**
     * @var string
     */
    private $verificationVideo;
    /**
     * @var string
     */
    private $faceProof;
    /**
     * @var string
     */
    private $documentProof;
    /**
     * @var string
     */
    private $documentTwoProof;
    /**
     * @var string
     */
    private $consentProof;

    /**
     * KycProofResult constructor.
     *
     * @param $requestId
     * @param $type
     * @param $createdAt
     * @param null|string $verificationVideo
     * @param null|string $faceProof
     * @param null|string $documentProof
     * @param null|string $documentTwoProof
     * @param null|string $consentProof
     */
    public function __construct(
        $requestId,
        $type,
        $createdAt,
        $verificationVideo = null,
        $faceProof = null,
        $documentProof = null,
        $documentTwoProof = null,
        $consentProof = null

    ) {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request ID must be integer');
        }

        if (!is_string($type)) {
            throw new \InvalidArgumentException('Type must be string');
        }

        if (!is_int($createdAt)) {
            throw new \InvalidArgumentException('Created At must be integer');
        }

        if ($verificationVideo !== null && !is_string($verificationVideo)) {
            throw new \InvalidArgumentException('Verification Video must be string');
        }

        if ($faceProof !== null && !is_string($faceProof)) {
            throw new \InvalidArgumentException('Face Proof must be string');
        }

        if ($documentProof !== null && !is_string($documentProof)) {
            throw new \InvalidArgumentException('Document Proof must be string');
        }

        if ($documentTwoProof !== null && !is_string($documentTwoProof)) {
            throw new \InvalidArgumentException('Document Two Proof must be string');
        }

        if ($consentProof !== null && !is_string($consentProof)) {
            throw new \InvalidArgumentException('Consent Proof must be string');
        }
        $this->requestId = $requestId;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->verificationVideo = $verificationVideo;
        $this->faceProof = $faceProof;
        $this->documentProof = $documentProof;
        $this->documentTwoProof = $documentTwoProof;
        $this->consentProof = $consentProof;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getVerificationVideo()
    {
        return $this->verificationVideo;
    }

    /**
     * @return string|null
     */
    public function getFaceProof()
    {
        return $this->faceProof;
    }

    /**
     * @return string|null
     */
    public function getDocumentProof()
    {
        return $this->documentProof;
    }

    /**
     * @return string|null
     */
    public function getDocumentTwoProof()
    {
        return $this->documentTwoProof;
    }

    /**
     * @return string|null
     */
    public function getConsentProof()
    {
        return $this->consentProof;
    }


}
