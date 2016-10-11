<?php

namespace Covery\Client\Requests;

use Covery\Client\EnvelopeInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class AbstractEnvelopeRequest
 *
 * Base class for requests, built over Envelopes
 *
 * @package Covery\Client\Requests
 */
abstract class AbstractEnvelopeRequest extends Request
{
    public function __construct($apiPath, EnvelopeInterface $envelope)
    {
        if (!is_string($apiPath) || empty($apiPath)) {
            throw new \InvalidArgumentException('API path must be non-empty string');
        }

        // Building request
        $ids = array();
        foreach ($envelope->getIdentities() as $id) {
            $ids[] = $id->getType() . '=' . $id->getId();
        }

        $packet = array('type' => $envelope->getType(), 'sequence_id' => $envelope->getSequenceId());

        parent::__construct(
            'POST',
            $apiPath,
            array(
                'X-Identities' => implode('&', $ids)
            ),
            json_encode(array_merge($packet, $envelope->toArray()))
        );

    }
}
