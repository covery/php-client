<?php

use PHPUnit\Framework\TestCase;

class BuildDocumentStorageTest extends TestCase
{
    public function testBuild()
    {
        $documentStorageResult = \Covery\Client\DocumentStorage\Builder::documentStorageEvent(
            "documentStorageUserMerchantId",
            \Covery\Client\DocumentType::INTERNATIONAL_PASSPORT,
            "documentStorageCountry",
            "documentStorageSequenceIdSome",
            "documentStorageGroupIdSome",
            "passport.jpeg",
            false,
            2,
            "documentStorageTranslatedFrom",
            "documentStorageTranslatedTo"
        )->build();

        $request = new \Covery\Client\Requests\DocumentStorage($documentStorageResult);

        self::assertEquals('POST', $request->getMethod());
        self::assertStringContainsString($request->getUri()->getPath(), '/api/documentStorage');
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $request);
        self::assertCount(10, $documentStorageResult);
        self::assertSame("documentStorageUserMerchantId", $documentStorageResult['user_merchant_id']);
        self::assertSame(\Covery\Client\DocumentType::INTERNATIONAL_PASSPORT, $documentStorageResult['document_type']);
        self::assertSame("documentStorageCountry", $documentStorageResult['document_country']);
        self::assertSame("documentStorageSequenceIdSome", $documentStorageResult['sequence_id']);
        self::assertSame("documentStorageGroupIdSome", $documentStorageResult['group_id']);
        self::assertSame("passport.jpeg", $documentStorageResult['file_name']);
        self::assertSame(false, $documentStorageResult['ocr']);
        self::assertSame(2, $documentStorageResult['number_of_pages']);
        self::assertSame("documentStorageTranslatedFrom", $documentStorageResult['translated_from']);
        self::assertSame("documentStorageTranslatedTo", $documentStorageResult['translated_to']);
        self::assertJson($request->getBody()->getContents());
    }

    public function testEventExpectsInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Document Type must be a string');
        $documentStorage = \Covery\Client\DocumentStorage\Builder::documentStorageEvent(
            "documentStorageUserMerchantId",
            null,
            "documentStorageCountry",
            "documentStorageSequenceIdSome",
            "documentStorageGroupIdSome",
            "passport.jpeg",
            false,
            2,
            "documentStorageTranslatedFrom",
            "documentStorageTranslatedTo"
        )->build();
    }

    public function testEventExpectsInvalidDocumentType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Document Type must be one of the types: international_passport, national_passport, id_card, residence_permit, drivers_license, bank_statement, tax_declaration, invoice, receipt, utility_bill, personal_photo, other');
        $documentStorage = \Covery\Client\DocumentStorage\Builder::documentStorageEvent(
            "documentStorageUserMerchantId",
            "regional_password",
            "documentStorageCountry",
            "documentStorageSequenceIdSome",
            "documentStorageGroupIdSome",
            "passport.jpeg",
            false,
            2,
            "documentStorageTranslatedFrom",
            "documentStorageTranslatedTo"
        )->build();
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
