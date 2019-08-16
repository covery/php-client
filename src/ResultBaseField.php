<?php


namespace Covery\Client;


class ResultBaseField
{
    const REQUEST_ID = 'requestId';
    const TYPE = 'type';
    const CREATED_AT = 'createdAt';
    const SEQUENCE_ID = 'sequenceId';
    const MERCHANT_USER_ID = 'merchantUserId';
    const SCORE = 'score';
    const ACCEPT = 'accept';
    const REJECT = 'reject';
    const MANUAL = 'manual';
    const REASON = 'reason';
    const ACTION = 'action';

    public static function getAll()
    {
        return [
            self::REQUEST_ID,
            self::TYPE,
            self::CREATED_AT,
            self::SEQUENCE_ID,
            self::MERCHANT_USER_ID,
            self::SCORE,
            self::ACCEPT,
            self::REJECT,
            self::MANUAL,
            self::REASON,
            self::ACTION
        ];
    }
}