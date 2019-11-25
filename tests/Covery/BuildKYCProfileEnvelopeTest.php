<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildKYCProfileEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::kycProfileEvent(
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
            "profile1,profile2,profile3"
        )->addIdentity(new Stub())->build();

        self::assertSame('kyc_profile', $result->getType());
        self::assertSame('kycProfileSequenceIdSome', $result->getSequenceId());
        self::assertCount(38, $result);
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
        self::assertSame('profile1,profile2,profile3', $result['related_profiles']);

        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = Builder::kycProfileEvent(
            'seqIdValue',
            'eventId',
            "userId",
            $current
        )->addIdentity(new Stub())->build();

        self::assertSame('kyc_profile', $result->getType());
        self::assertSame('seqIdValue', $result->getSequenceId());
        self::assertCount(1, $result->getIdentities());
        self::assertCount(3, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertTrue($result['event_timestamp'] >= $current);

        $validator->validate($result);

        // With device fingerprint fields
        $result = Builder::kycProfileEvent(
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
        self::assertCount(6, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertSame(333, $result['event_timestamp']);
        self::assertSame('deviceFingerprint', $result['device_fingerprint']);
        self::assertSame('userAgent', $result['user_agent']);
        self::assertSame('cpuClass', $result['cpu_class']);

        $validator->validate($result);
    }
}
