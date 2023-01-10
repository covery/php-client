<?php

namespace Covery\Client;

class MediaStorageBaseField
{
    const CREATED_AT = 'createdAt';
    const MEDIA_ID = 'mediaId';
    const UPLOAD_URL = 'uploadUrl';

    public static function getAll()
    {
        return [
            self::CREATED_AT,
            self::MEDIA_ID,
            self::UPLOAD_URL
        ];
    }
}
