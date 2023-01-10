<?php

namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;

class MediaStorage extends AbstractEnvelopeRequest
{
    public function __construct(EnvelopeInterface $envelope)
    {
        parent::__construct('/api/mediaStorage', $envelope);
    }
}
