<?php

class BuildKYCProfileEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::kycProfileEvent(
            'kycProfileSequenceIdSome',
            'kycProfileEventId',
            "kycProfileUserMerchantId",
            123456,
            "kycProfileGroupId",
            "kycProfileStatus",
            "kycProfileCode",
            "kycProfileReason",
            "kycProfileProviderResult",
            "kycProfileProviderCode",
            "kycProfileProviderReason",
            "kycProfileId",
            "kycProfileType",
            "kycProfileSubType",
            "kycProfileFirstName",
            "kycProfileLastName",
            "kycProfileFullName",
            "kycProfileIndustry",
            "kycProfileWebsiteUrl",
            "kycProfileDescription",
            123,
            456,
            "kycProfileRegNumber",
            "kycProfileVatNumber",
            "kycProfileEmail@gmail.com",
            true,
            "123-456-321",
            false,
            "kycProfileCountry",
            "kycProfileState",
            "kycProfileCity",
            "kycProfileAddress",
            "kycProfileZip",
            "kycProfileSecondCountry",
            "kycProfileSecondState",
            "kycProfileSecondCity",
            "kycProfileSecondAddress",
            "kycProfileSecondZip",
            "kycProfileProviderId",
            "kycProfileContactEmail",
            "kycProfileContactPhone",
            "kycProfileWalletType",
            "kycProfileNationality",
            true,
            "kycProfileEmploymentStatus",
            "kycProfileSourceOfFunds",
            999,
            888,
            "male",
            'linksToDocuments',
            [1, 2],
            true,
            true
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_profile', $result->getType());
        self::assertSame('kycProfileSequenceIdSome', $result->getSequenceId());
        self::assertCount(52, $result);
        self::assertSame('kycProfileEventId', $result['event_id']);
        self::assertSame(123456, $result['event_timestamp']);
        self::assertSame('kycProfileUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycProfileGroupId', $result['group_id']);
        self::assertSame('kycProfileStatus', $result['status']);
        self::assertSame('kycProfileCode', $result['code']);
        self::assertSame('kycProfileReason', $result['reason']);
        self::assertSame('kycProfileProviderResult', $result['provider_result']);
        self::assertSame('kycProfileProviderCode', $result['provider_code']);
        self::assertSame('kycProfileProviderReason', $result['provider_reason']);
        self::assertSame('kycProfileId', $result['profile_id']);
        self::assertSame('kycProfileType', $result['profile_type']);
        self::assertSame('kycProfileSubType', $result['profile_sub_type']);
        self::assertSame('kycProfileFirstName', $result['firstname']);
        self::assertSame('kycProfileLastName', $result['lastname']);
        self::assertSame('kycProfileFullName', $result['fullname']);
        self::assertSame('kycProfileIndustry', $result['industry']);
        self::assertSame('kycProfileWebsiteUrl', $result['website_url']);
        self::assertSame('kycProfileDescription', $result['description']);
        self::assertSame(123, $result['birth_date']);
        self::assertSame(456, $result['reg_date']);
        self::assertSame('kycProfileRegNumber', $result['reg_number']);
        self::assertSame('kycProfileVatNumber', $result['vat_number']);
        self::assertSame('kycProfileEmail@gmail.com', $result['email']);
        self::assertTrue($result['email_confirmed']);
        self::assertSame('123-456-321', $result['phone']);
        self::assertFalse($result['phone_confirmed']);
        self::assertSame('kycProfileCountry', $result['country']);
        self::assertSame('kycProfileState', $result['state']);
        self::assertSame('kycProfileCity', $result['city']);
        self::assertSame('kycProfileAddress', $result['address']);
        self::assertSame('kycProfileZip', $result['zip']);
        self::assertSame('kycProfileSecondCountry', $result['second_country']);
        self::assertSame('kycProfileSecondState', $result['second_state']);
        self::assertSame('kycProfileSecondCity', $result['second_city']);
        self::assertSame('kycProfileSecondAddress', $result['second_address']);
        self::assertSame('kycProfileSecondZip', $result['second_zip']);
        self::assertSame('kycProfileProviderId', $result['provider_id']);
        self::assertSame('kycProfileContactEmail', $result['contact_email']);
        self::assertSame('kycProfileContactPhone', $result['contact_phone']);
        self::assertSame('kycProfileWalletType', $result['wallet_type']);
        self::assertSame('kycProfileNationality', $result['nationality']);
        self::assertSame(true, $result['final_beneficiary']);
        self::assertSame('kycProfileEmploymentStatus', $result['employment_status']);
        self::assertSame('kycProfileSourceOfFunds', $result['source_of_funds']);
        self::assertSame(999, $result['issue_date']);
        self::assertSame(888, $result['expiry_date']);
        self::assertSame('male', $result['gender']);
        self::assertSame('linksToDocuments', $result['links_to_documents']);
        self::assertSame([1, 2], $result['media_id']);
        self::assertTrue($result['address_confirmed']);
        self::assertTrue($result['second_address_confirmed']);

        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::kycProfileEvent(
            'seqIdValue',
            'eventId',
            "userId",
            $current
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_profile', $result->getType());
        self::assertSame('seqIdValue', $result->getSequenceId());
        self::assertCount(1, $result->getIdentities());
        self::assertCount(5, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertTrue($result['event_timestamp'] >= $current);

        $validator->validate($result);

        // With device fingerprint fields
        $result = \Covery\Client\Envelopes\Builder::kycProfileEvent(
            'seqIdValue',
            'eventId',
            "userId",
            333
        )->addBrowserData(
            "deviceFingerprint",
            "userAgent",
            "cpuClass"
        )->build();
        self::assertSame('kyc_profile', $result->getType());
        self::assertSame('seqIdValue', $result->getSequenceId());
        self::assertCount(0, $result->getIdentities());
        self::assertCount(8, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertSame(333, $result['event_timestamp']);
        self::assertSame('deviceFingerprint', $result['device_fingerprint']);
        self::assertSame('userAgent', $result['user_agent']);
        self::assertSame('cpuClass', $result['cpu_class']);

        $validator->validate($result);
    }
}
