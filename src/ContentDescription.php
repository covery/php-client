<?php

namespace Covery\Client;

class ContentDescription
{
    CONST PERSONAL_PHOTO = 'personal_photo';
    CONST LINKED_DOCUMENT = 'linked_document';
    const GENERAL_DOCUMENT = 'general_document';

    public static function getAll()
    {
        return [
            self::PERSONAL_PHOTO,
            self::LINKED_DOCUMENT,
            self::GENERAL_DOCUMENT,
        ];
    }
}