<?php

use PHPUnit\Framework\TestCase;

class BuildKYCStartEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::kycStartEvent(
            'kycStartSequenceId',
            'kycStartEventId',
            "kycStartUserMerchantId",
            "kycStartVerificationMode",
            "kycStartVerificationSource",
            true,
            444,
            false,
            true,
            false,
            "kycStartGroupId",
            "kycStartCountry",
            "kycStartLanguage",
            "kycStartRedirectUrl",
            "kycStartEmail",
            "kycStartFirstName",
            "kycStartLastName",
            "kycStartProfileId",
            "kycStartPhone",
            789,
            "kycStartRegNumber",
            123,
            456,
            1,
            'kycStartAllowedDocumentFormat'
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_start', $result->getType());
        self::assertSame('kycStartSequenceId', $result->getSequenceId());
        self::assertCount(24, $result);
        self::assertSame('kycStartEventId', $result['event_id']);
        self::assertSame('kycStartUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycStartVerificationMode', $result['verification_mode']);
        self::assertSame('kycStartVerificationSource', $result['verification_source']);
        self::assertSame(true, $result['consent']);
        self::assertSame(444, $result['event_timestamp']);
        self::assertSame(false, $result['allow_na_ocr_inputs']);
        self::assertSame(true, $result['decline_on_single_step']);
        self::assertSame(false, $result['backside_proof']);
        self::assertSame('kycStartGroupId', $result['group_id']);
        self::assertSame('kycStartCountry', $result['country']);
        self::assertSame('kycStartLanguage', $result['kyc_language']);
        self::assertSame('kycStartRedirectUrl', $result['redirect_url']);
        self::assertSame('kycStartEmail', $result['email']);
        self::assertSame('kycStartFirstName', $result['firstname']);
        self::assertSame('kycStartLastName', $result['lastname']);
        self::assertSame('kycStartProfileId', $result['profile_id']);
        self::assertSame('kycStartPhone', $result['phone']);
        self::assertSame(789, $result['birth_date']);
        self::assertSame('kycStartRegNumber', $result['reg_number']);
        self::assertSame(123, $result['issue_date']);
        self::assertSame(456, $result['expiry_date']);
        self::assertSame(1, $result['number_of_documents']);
        self::assertSame('kycStartAllowedDocumentFormat', $result['allowed_document_format']);

        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::kycStartEvent(
            'kycStartSequenceId',
            'kycStartEventId',
            "kycStartUserMerchantId",
            "kycStartVerificationMode",
            "kycStartVerificationSource",
            true,
            555
        )->build();

        self::assertSame('kyc_start', $result->getType());
        self::assertSame('kycStartSequenceId', $result->getSequenceId());
        self::assertCount(6, $result);
        self::assertSame('kycStartEventId', $result['event_id']);
        self::assertSame('kycStartUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycStartVerificationMode', $result['verification_mode']);
        self::assertSame('kycStartVerificationSource', $result['verification_source']);
        self::assertSame(true, $result['consent']);
        self::assertSame(555, $result['event_timestamp']);

        $validator->validate($result);

        // With device fingerprint fields
        $result = \Covery\Client\Envelopes\Builder::kycStartEvent(
            'kycStartSequenceId',
            'kycStartEventId',
            "kycStartUserMerchantId",
            "kycStartVerificationMode",
            "kycStartVerificationSource",
            true,
            555
        )->addBrowserData(
            "deviceFingerprint",
            "userAgent",
            "cpuClass"
        )->build();
        self::assertSame('kyc_start', $result->getType());
        self::assertSame('kycStartSequenceId', $result->getSequenceId());
        self::assertCount(9, $result);
        self::assertSame('kycStartEventId', $result['event_id']);
        self::assertSame('kycStartUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycStartVerificationMode', $result['verification_mode']);
        self::assertSame('kycStartVerificationSource', $result['verification_source']);
        self::assertSame(true, $result['consent']);
        self::assertSame(555, $result['event_timestamp']);
        self::assertSame('deviceFingerprint', $result['device_fingerprint']);
        self::assertSame('userAgent', $result['user_agent']);
        self::assertSame('cpuClass', $result['cpu_class']);

        $validator->validate($result);
    }
}
