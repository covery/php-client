<?php

namespace Covery\Client\Requests;

use Covery\Client\CardIdInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class KycProof
 *
 * Contains kyc_start_id data
 *
 * @package Covery\Client\Requests
 */
class CardId extends Request
{
    /**
     * @param CardIdInterface $cardId
     */
    public function __construct(CardIdInterface $cardId)
    {
        // Building request
        parent::__construct(
            'POST',
            '/api/cardId',
            array(),
            json_encode($cardId->toArray())
        );
    }
}
