<?php

class BuildKYCSubmitEnvelopeTest extends \PHPUnit_Framework_TestCase
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
            "linksToDocuments"
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('kyc_submit', $result->getType());
        self::assertSame('kycSubmitSequenceIdSome', $result->getSequenceId());
        self::assertCount(11, $result);
        self::assertSame('kycSubmitEventId', $result['event_id']);
        self::assertSame(1234568, $result['event_timestamp']);
        self::assertSame('kycSubmitUserMerchantId', $result['user_merchant_id']);
        self::assertSame('kycSubmitGroupId', $result['group_id']);
        self::assertSame('kycSubmitStatus', $result['status']);
        self::assertSame('kycSubmitCode', $result['code']);
        self::assertSame('kycSubmitReason', $result['reason']);
        self::assertSame('kySubmitProviderResult', $result['provider_result']);
        self::assertSame('kycSubmitProviderCode', $result['provider_code']);
        self::assertSame('kycSubmitProviderReason', $result['provider_reason']);
        self::assertSame('linksToDocuments', $result['links_to_documents']);

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
