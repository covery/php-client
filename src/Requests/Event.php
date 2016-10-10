<?php

namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class Event
 *
 * Contains event data, that must be stored on Covery without
 * decision making
 *
 * @package Covery\Client\Requests
 */
class Event extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('api/sendEvent', $envelope);
    }
}
