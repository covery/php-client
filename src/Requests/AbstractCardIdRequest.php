<?php

namespace Covery\Client\Requests;

use Covery\Client\CardIdInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class AbstractCardIdRequest
 *
 * Base class for requests, built over CardId
 *
 * @package Covery\Client\Requests
 */
abstract class AbstractCardIdRequest extends Request
{
    public function __construct($apiPath, CardIdInterface $cardId)
    {
        if (!is_string($apiPath) || empty($apiPath)) {
            throw new \InvalidArgumentException('API path must be non-empty string');
        }

        // Building request
        $packet = array('type' => $cardId->getType());

        parent::__construct(
            'POST',
            $apiPath,
            array(),
            json_encode(array_merge($packet, $cardId->toArray()))
        );
    }
}
