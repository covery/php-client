<?php

namespace Covery\Client;

class RelationshipType
{
    const OWNER_PERSON = 'owner_person';
    const OWNER_COMPANY = 'owner_company';
    const RELATED_PERSON = 'related_person';
    const RELATED_COMPANY = 'related_company';

    public static function getAll()
    {
        return [
            self::OWNER_PERSON,
            self::OWNER_COMPANY,
            self::RELATED_PERSON,
            self::RELATED_COMPANY,
        ];
    }
}
