<?php


namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;

/**
 * Class KycProof
 *
 * Contains kyc_start_id data
 *
 * @package Covery\Client\Requests
 */
class KycProof extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('/api/kycProof', $envelope);
    }
}
