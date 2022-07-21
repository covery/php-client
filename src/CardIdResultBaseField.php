<?php

namespace Covery\Client;

/**
 * Class CardIdResultBaseField
 * @package Covery\Client
 */
class CardIdResultBaseField
{
    const REQUEST_ID = 'requestId';
    const CARD_ID = 'cardId';
    const CREATED_AT = 'createdAt';

    /**
     * Get all fields
     *
     * @return string[]
     */
    public static function getAll()
    {
        return [
            self::REQUEST_ID,
            self::CARD_ID,
            self::CREATED_AT,
        ];
    }
}
