<?php

namespace Covery\Client;

class MediaConnectionBaseField
{
    const REQUEST_ID = 'requestId';
    const MEDIA_ID = 'mediaId';

    public static function getAll()
    {
        return [
            self::REQUEST_ID,
            self::MEDIA_ID
        ];
    }
}
