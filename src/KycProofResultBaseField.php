<?php

namespace Covery\Client;

/**
 * Class KycProofResultBaseField
 * @package Covery\Client
 */
class KycProofResultBaseField
{
    const REQUEST_ID = 'requestId';
    const TYPE = 'type';
    const CREATED_AT = 'createdAt';
    const VERIFICATION_VIDEO = 'verificationVideo';
    const FACE_PROOF = 'faceProof';
    const DOCUMENT_PROOF = 'documentProof';
    const DOCUMENT_TWO_PROOF = 'documentTwoProof';
    const CONSENT_PROOF = 'consentProof';

    /**
     * Get all fields
     *
     * @return string[]
     */
    public static function getAll()
    {
        return [
            self::REQUEST_ID,
            self::TYPE,
            self::CREATED_AT,
            self::VERIFICATION_VIDEO,
            self::FACE_PROOF,
            self::DOCUMENT_PROOF,
            self::DOCUMENT_TWO_PROOF,
            self::CONSENT_PROOF,
        ];
    }
}
