<?php

use PHPUnit\Framework\TestCase;

class BuildKYCSubmitEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::kycSubmitEvent(
            'kycSubmitSequenceIdSome',
            'kycSubmitEventId',
            "kycSubmitUserMerchantId",
            1234568,
            "kycSubmitGroupId",
            "kycSubmitStatus",
            "kycSubmitCode",
            "kycSubmitReason",
            "kySubmitProviderResult",
            "kycSubmitProviderCode",
            "kycSubmitProviderReason",
            "linksToDocuments",
            "kySubmitProviderId",
            'kycSubmitProfileId',
            'kycSubmitProfileType',
            'kycSubmitProfileSubType',
            'kycSubmitFirstName',
            'kycSubmitLastName',
            'kycSubmitFullName',
            'kycSubmitMale',
            'kycSubmitIndustry',
            'kycSubmitWalletType',
            'kycSubmitWebsiteUrl',
            'kycSubmitDescription',
            'kycSubmitEmploymentStatus',
            'kycSubmitSourceOfFunds',
            12345678,
            123456789,
            12345,
            123,
            'kycSubmitRegNumber',
            'kycSubmitVatNumber',
            'kycSubmitEmail@gmail.com',
            true,
            '380500300309',
            false,
            'kycSubmitContact@email.com',
            '380998473672',
            'ukr',
            'ki',
            'kiev',
            'address 1',
            'zp-1292',
            'ukr',
            'usa',
            'texas',
            'dallas',
            'address 2',
            'zp-8473',
            true,
            false,
            'KycSubmitCpuClass',
            'KycSubmitDeviceFingerPrint',
            'KycSubmitDeviceId',
            false,
            'KycSubmitIp',
            'KycSubmitRealIp',
            'KycSubmitLocalIpList',
            'KycSubmitLanguage',
            'KycSubmitLanguages',
            'KycSubmitLanguageBrowser',
            'KycSubmitLanguageUser',
            'KycSubmitLanguageSystem',
            'KycSubmitOs',
            'KycSubmitScreenResolution',
            'KycSubmitScreenOrientation',
            'KycSubmitClientResolution',
            123,
            'KycSubmitUserAgent',
            'KycSubmitPlugins',
            'KycSubmitRefererUrl',
            'KycSubmitOriginUrl',
            [1, 2],
            true,
            true,
            true

        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_submit', $result->getType());
        self::assertSame('kycSubmitSequenceIdSome', $result->getSequenceId());
        self::assertCount(75, $result);
        self::assertSame('kycSubmitEventId', $result['event_id']);
        self::assertSame(1234568, $result['event_timestamp']);
        self::assertSame('kycSubmitUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycSubmitGroupId', $result['group_id']);
        self::assertSame('kycSubmitStatus', $result['status']);
        self::assertSame('kycSubmitCode', $result['code']);
        self::assertSame('kycSubmitReason', $result['reason']);
        self::assertSame('kySubmitProviderId', $result['provider_id']);
        self::assertSame('kySubmitProviderResult', $result['provider_result']);
        self::assertSame('kycSubmitProviderCode', $result['provider_code']);
        self::assertSame('kycSubmitProviderReason', $result['provider_reason']);
        self::assertSame('linksToDocuments', $result['links_to_documents']);
        self::assertSame('kycSubmitProfileId', $result['profile_id']);
        self::assertSame('kycSubmitProfileType', $result['profile_type']);
        self::assertSame('kycSubmitProfileSubType', $result['profile_sub_type']);
        self::assertSame('kycSubmitFirstName', $result['firstname']);
        self::assertSame('kycSubmitLastName', $result['lastname']);
        self::assertSame('kycSubmitFullName', $result['fullname']);
        self::assertSame('kycSubmitMale', $result['gender']);
        self::assertSame('kycSubmitIndustry', $result['industry']);
        self::assertSame('kycSubmitWalletType', $result['wallet_type']);
        self::assertSame('kycSubmitWebsiteUrl', $result['website_url']);
        self::assertSame('kycSubmitDescription', $result['description']);
        self::assertSame('kycSubmitEmploymentStatus', $result['employment_status']);
        self::assertSame('kycSubmitSourceOfFunds', $result['source_of_funds']);
        self::assertSame(12345678, $result['birth_date']);
        self::assertSame(123456789, $result['reg_date']);
        self::assertSame(12345, $result['issue_date']);
        self::assertSame(123, $result['expiry_date']);
        self::assertSame('kycSubmitRegNumber', $result['reg_number']);
        self::assertSame('kycSubmitVatNumber', $result['vat_number']);
        self::assertSame('kycSubmitEmail@gmail.com', $result['email']);
        self::assertSame(true, $result['email_confirmed']);
        self::assertSame('380500300309', $result['phone']);
        self::assertSame(false, $result['phone_confirmed']);
        self::assertSame('kycSubmitContact@email.com', $result['contact_email']);
        self::assertSame('380998473672', $result['contact_phone']);
        self::assertSame('ukr', $result['country']);
        self::assertSame('ki', $result['state']);
        self::assertSame('kiev', $result['city']);
        self::assertSame('address 1', $result['address']);
        self::assertSame('zp-1292', $result['zip']);
        self::assertSame('ukr', $result['nationality']);
        self::assertSame('usa', $result['second_country']);
        self::assertSame('texas', $result['second_state']);
        self::assertSame('dallas', $result['second_city']);
        self::assertSame('address 2', $result['second_address']);
        self::assertSame('zp-8473', $result['second_zip']);
        self::assertSame(true, $result['ajax_validation']);
        self::assertSame(false, $result['cookie_enabled']);
        self::assertSame('KycSubmitCpuClass', $result['cpu_class']);
        self::assertSame('KycSubmitDeviceFingerPrint', $result['device_fingerprint']);
        self::assertSame('KycSubmitDeviceId', $result['device_id']);
        self::assertSame(false, $result['do_not_track']);
        self::assertSame(true, $result['anonymous']);
        self::assertSame('KycSubmitIp', $result['ip']);
        self::assertSame('KycSubmitRealIp', $result['real_ip']);
        self::assertSame('KycSubmitLocalIpList', $result['local_ip_list']);
        self::assertSame('KycSubmitLanguage', $result['language']);
        self::assertSame('KycSubmitLanguages', $result['languages']);
        self::assertSame('KycSubmitLanguageBrowser', $result['language_browser']);
        self::assertSame('KycSubmitLanguageUser', $result['language_user']);
        self::assertSame('KycSubmitLanguageSystem', $result['language_system']);
        self::assertSame('KycSubmitOs', $result['os']);
        self::assertSame('KycSubmitScreenResolution', $result['screen_resolution']);
        self::assertSame('KycSubmitScreenOrientation', $result['screen_orientation']);
        self::assertSame('KycSubmitClientResolution', $result['client_resolution']);
        self::assertSame(123, $result['timezone_offset']);
        self::assertSame('KycSubmitUserAgent', $result['user_agent']);
        self::assertSame('KycSubmitPlugins', $result['plugins']);
        self::assertSame('KycSubmitRefererUrl', $result['referer_url']);
        self::assertSame('KycSubmitOriginUrl', $result['origin_url']);
        self::assertSame([1, 2], $result['document_id']);
        self::assertTrue($result['address_confirmed']);
        self::assertTrue($result['second_address_confirmed']);


        $validator->validate($result);


        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::kycSubmitEvent(
            'seqIdValue',
            'eventId',
            "userId",
            $current
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_submit', $result->getType());
        self::assertSame('seqIdValue', $result->getSequenceId());
        self::assertCount(1, $result->getIdentities());
        self::assertCount(3, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertTrue($result['event_timestamp'] >= $current);

        $validator->validate($result);

        // With device fingerprint fields
        $result = \Covery\Client\Envelopes\Builder::kycSubmitEvent(
            'seqIdValue',
            'eventId',
            "userId",
            333
        )->addBrowserData(
            "deviceFingerprint",
            "userAgent",
            "cpuClass"
        )->build();
        self::assertSame('kyc_submit', $result->getType());
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
