<?php


namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;

/**
 * Class Postback
 *
 * Contains postback data, that must be stored on Covery without
 * decision making
 *
 * @package Covery\Client\Requests
 */
class Postback extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('/api/postback', $envelope);
    }
}