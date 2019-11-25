<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildKYCSubmitEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::kycSubmitEvent(
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
            "kycSubmitProviderReason"
        )->addIdentity(new Stub())->build();

        self::assertSame('kyc_submit', $result->getType());
        self::assertSame('kycSubmitSequenceIdSome', $result->getSequenceId());
        self::assertCount(10, $result);
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

        $validator->validate($result);


        // Minimal data
        $current = time();
        $result = Builder::kycSubmitEvent(
            'seqIdValue',
            'eventId',
            "userId",
            $current
        )->addIdentity(new Stub())->build();

        self::assertSame('kyc_submit', $result->getType());
        self::assertSame('seqIdValue', $result->getSequenceId());
        self::assertCount(1, $result->getIdentities());
        self::assertCount(3, $result);
        self::assertSame('eventId', $result['event_id']);
        self::assertSame('userId', $result['user_merchant_id']);
        self::assertTrue($result['event_timestamp'] >= $current);

        $validator->validate($result);

        // With device fingerprint fields
        $result = Builder::kycSubmitEvent(
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
