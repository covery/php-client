<?php

namespace Covery\Client;

class DocumentType
{
    CONST INTERNATIONAL_PASSPORT = 'international_passport';
    CONST NATIONAL_PASSPORT = 'national_passport';
    const ID_CARD = 'id_card';
    const RESIDENCE_PERMIT = 'residence_permit';
    const DRIVERS_LICENSE = 'drivers_license';
    const BANK_STATEMENT = 'bank_statement';
    const TAX_DECLARATION = 'tax_declaration';
    const INVOICE = 'invoice';
    const RECEIPT = 'receipt';
    const UTILITY_BILL = 'utility_bill';
    const PERSINAL_PHOTO = 'personal_photo';
    const OTHER = 'other';

    public static function getAll()
    {
        return [
            self::INTERNATIONAL_PASSPORT,
            self::NATIONAL_PASSPORT,
            self::ID_CARD,
            self::RESIDENCE_PERMIT,
            self::DRIVERS_LICENSE,
            self::BANK_STATEMENT,
            self::TAX_DECLARATION,
            self::INVOICE,
            self::RECEIPT,
            self::UTILITY_BILL,
            self::PERSINAL_PHOTO,
            self::OTHER
        ];
    }

    public static function getShortList()
    {
        return [
            self::INTERNATIONAL_PASSPORT,
            self::NATIONAL_PASSPORT,
            self::DRIVERS_LICENSE,
            self::ID_CARD
        ];
    }
}