<?php

use \Covery\Client\Envelopes\ValidatorV1;
use \Covery\Client\Envelopes\Builder;
use PHPUnit\Framework\TestCase;

class BuildDocumentEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            23.6,
            34.5,
            'testCurrency',
            'testMrzDocumentType',
            'testMrzCountry',
            'testMrzLastname',
            'testMrzFirstname',
            'testMrzFullname',
            'testMrzDocumentNumber',
            'testMrzNationality',
            'testMrzPersonalNumber',
            123456,
            'testMrzGender',
            123456,
            'testMrzRecordNumber',
            false,
            'tempMrzAuthority',
            123456,
            'testExtractedText',
            ['en'],
            'testTranslatedExtractedText',
            'testTranslatedFrom',
            'testTranslatedTo',
            false,
            0.12
        )->build();

        self::assertCount(53, $result);
        self::assertSame(Builder::EVENT_DOCUMENT, $result->getType());
        self::assertSame('tempSequenceId', $result->getSequenceId());
        self::assertSame('tempEventId', $result['event_id']);
        self::assertSame(123456, $result['event_timestamp']);
        self::assertSame('tempUserId', $result['user_merchant_id']);
        self::assertSame(\Covery\Client\DocumentType::INTERNATIONAL_PASSPORT, $result['document_type']);
        self::assertSame('tempGroupId', $result['group_id']);
        self::assertSame("tempDocumentCountry", $result['document_country']);
        self::assertSame("tempDocumentNumber", $result['document_number']);
        self::assertSame("tempFileName", $result['file_name']);
        self::assertSame("tempEmail", $result['email']);
        self::assertSame("tempFirstName", $result['firstname']);
        self::assertSame("tempLastName", $result['lastname']);
        self::assertSame("tempFullname", $result['fullname']);
        self::assertSame(123456, $result['birth_date']);
        self::assertSame(18, $result['age']);
        self::assertSame("tempGender", $result['gender']);
        self::assertSame("tempNationality", $result['nationality']);
        self::assertSame("tempCountry", $result['country']);
        self::assertSame("tempCity", $result['city']);
        self::assertSame("tempZip", $result['zip']);
        self::assertSame("tempAddress", $result['address']);
        self::assertSame(123456, $result['issue_date']);
        self::assertSame(123456, $result['expiry_date']);
        self::assertSame("tempAuthority", $result['authority']);
        self::assertSame("testRecordNumber", $result['record_number']);
        self::assertSame("testPersonalNumber", $result['personal_number']);
        self::assertSame("testDescription", $result['description']);
        self::assertSame(10.4, $result['product_quantity']);
        self::assertSame("testPaymentMethod", $result['payment_method']);
        self::assertSame(23.6, $result['amount']);
        self::assertSame(34.5, $result['amount_converted']);
        self::assertSame("testCurrency", $result['currency']);
        self::assertSame("testMrzDocumentType", $result['mrz_document_type']);
        self::assertSame("testMrzCountry", $result['mrz_country']);
        self::assertSame("testMrzLastname", $result['mrz_lastname']);
        self::assertSame("testMrzFirstname", $result['mrz_firstname']);
        self::assertSame("testMrzFullname", $result['mrz_fullname']);
        self::assertSame("testMrzDocumentNumber", $result['mrz_document_number']);
        self::assertSame("testMrzNationality", $result['mrz_nationality']);
        self::assertSame("testMrzPersonalNumber", $result['mrz_personal_number']);
        self::assertSame(123456, $result['mrz_birth_date']);
        self::assertSame("testMrzGender", $result['mrz_gender']);
        self::assertSame(123456, $result['mrz_expiry_date']);
        self::assertSame("testMrzRecordNumber", $result['mrz_record_number']);
        self::assertSame(false, $result['mrz_check_digits_validation']);
        self::assertSame("tempMrzAuthority", $result['mrz_authority']);
        self::assertSame(123456, $result['mrz_issue_date']);
        self::assertSame("testExtractedText", $result['extracted_text']);
        self::assertSame(['en'], $result['text_language_details']);
        self::assertSame("testTranslatedExtractedText", $result['translated_extracted_text']);
        self::assertSame("testTranslatedFrom", $result['translated_from']);
        self::assertSame(false, $result['deepfake']);
        self::assertSame(0.12, $result['deepfake_confidence']);

        $validator->validate($result);

        // Minimal data
        $result = Builder::documentEvent(
            'tempEventId',
            123456789,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
        )->build();

        self::assertCount(4, $result);
        self::assertSame(Builder::EVENT_DOCUMENT, $result->getType());
        self::assertSame('tempEventId', $result['event_id']);
        self::assertSame(123456789, $result['event_timestamp']);
        self::assertSame('tempUserId', $result['user_merchant_id']);
        self::assertSame(\Covery\Client\DocumentType::INTERNATIONAL_PASSPORT, $result['document_type']);

        $validator->validate($result);
    }

    public function testZeroValueForFloatWithAllowedZero()
    {
        $validator = new ValidatorV1();
        $result = Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            0.0,
            0.0
        )->build();
        self::assertSame(0.0, $result['amount']);
        self::assertSame(0.0, $result['amount_converted']);
        $validator->validate($result);
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Amount cannot be negative");
        Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            -23.6
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeAmountConverted()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Amount converted cannot be negative");
        Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            23.6,
            -34.5
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeDeepfakeConfidence()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Deepfake confidence cannot be negative");
        Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            23.6,
            34.5,
            'testCurrency',
            'testMrzDocumentType',
            'testMrzCountry',
            'testMrzLastname',
            'testMrzFirstname',
            'testMrzFullname',
            'testMrzDocumentNumber',
            'testMrzNationality',
            'testMrzPersonalNumber',
            123456,
            'testMrzGender',
            123456,
            'testMrzRecordNumber',
            false,
            'tempMrzAuthority',
            123456,
            'testExtractedText',
            ['en'],
            'testTranslatedExtractedText',
            'testTranslatedFrom',
            'testTranslatedTo',
            false,
            -0.12
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForGreaterThanOneDeepfakeConfidence()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Deepfake confidence cannot be greater than 1");
        Builder::documentEvent(
            'tempEventId',
            123456,
            'tempUserId',
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            'tempSequenceId',
            'tempGroupId',
            'tempDocumentCountry',
            'tempDocumentNumber',
            'tempFileName',
            'tempEmail',
            'tempFirstName',
            'tempLastName',
            'tempFullname',
            123456,
            18,
            'tempGender',
            'tempNationality',
            'tempCountry',
            'tempCity',
            'tempZip',
            'tempAddress',
            123456,
            123456,
            'tempAuthority',
            'testRecordNumber',
            'testPersonalNumber',
            'testDescription',
            10.4,
            'testPaymentMethod',
            23.6,
            34.5,
            'testCurrency',
            'testMrzDocumentType',
            'testMrzCountry',
            'testMrzLastname',
            'testMrzFirstname',
            'testMrzFullname',
            'testMrzDocumentNumber',
            'testMrzNationality',
            'testMrzPersonalNumber',
            123456,
            'testMrzGender',
            123456,
            'testMrzRecordNumber',
            false,
            'tempMrzAuthority',
            123456,
            'testExtractedText',
            ['en'],
            'testTranslatedExtractedText',
            'testTranslatedFrom',
            'testTranslatedTo',
            false,
            1.12
        )->build();
    }
}
