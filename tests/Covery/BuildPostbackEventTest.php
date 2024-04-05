<?php

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;

class BuildPostbackEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::postBackEvent(
            123456,
            "someTransactionStatus",
            "someCode",
            "someReason",
            "someSecure3d",
            "someAvsResult",
            "someCvvResult",
            "somePspCode",
            "somePspReason",
            "someMerchantAdviceCode",
            "someMerchantAdviceText",
            "someArn"
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame(Builder::EVENT_POSTBACK, $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(12, $result);
        $validator->validate($result);

        // Minimal data with request id
        $result = Builder::postBackEvent(22222)->build();
        self::assertSame(Builder::EVENT_POSTBACK, $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);
    }
}