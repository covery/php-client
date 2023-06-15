<?php

namespace Covery\Client;

class ContentType
{
    const JPEG = 'image/jpeg';
    const PNG = 'image/png';
    const GIF = 'image/gif';

    public static function getAll()
    {
        return [
            self::JPEG,
            self::PNG,
            self::GIF,
        ];
    }

    public static function getOCRAllowed()
    {
        return [
            self::JPEG,
            self::PNG,
            self::GIF,
        ];
    }
}