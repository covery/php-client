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
class Decision extends Request
{
    public function __construct(EnvelopeInterface $envelope)
    {
        // Building request
        $ids = array();
        foreach ($envelope->getIdentities() as $id) {
            $ids[] = $id->getType() . '=' . $id->getId();
        }

        $packet = array('type' => $envelope->getType(), 'sequence_id' => $envelope->getSequenceId());

        parent::__construct(
            'POST',
            TransportInterface::DEFAULT_URL . 'api/makeDecision',
            array(
                'X-Identities' => implode('&', $ids)
            ),
            json_encode(array_merge($packet, $envelope->toArray()))
        );
    }
}