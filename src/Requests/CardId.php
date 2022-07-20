<?php

namespace Covery\Client\Requests;

use Covery\Client\CardIdInterface;

/**
 * Class KycProof
 *
 * Contains kyc_start_id data
 *
 * @package Covery\Client\Requests
 */
class CardId extends AbstractCardIdRequest
{
    public function __construct(CardIdInterface $cardId)
    {
        parent::__construct('/api/cardId', $cardId);
    }
}
