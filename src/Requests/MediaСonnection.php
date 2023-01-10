<?php

namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;

class MediaСonnection extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('/api/mediaConnection', $envelope);
    }
}
