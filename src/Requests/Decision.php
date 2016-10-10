<?php

namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class Decision
 *
 * Contains envelope to analyze with Covery
 *
 * @package Covery\Client\Requests
 */
class Decision extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('api/makeDecision', $envelope);
    }
}
