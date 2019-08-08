<?php

class BuildPostbackEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::postBackEvent(
            "someRequestId",
            "someTransactionId",
            "someTransactionStatus",
            "someCode",
            "someReason",
            "someSecure3d",
            "someAvsResult",
            "someCvvResult",
            "somePspCode",
            "somePspReason",
            "someArn"
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('postback', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(11, $result);
        $validator->validate($result);


        // Minimal data with request id
        $result = \Covery\Client\Envelopes\Builder::postBackEvent("someRequestId")->build();
        self::assertSame('postback', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);

        // Minimal data with transaction id
        $result = \Covery\Client\Envelopes\Builder::postBackEvent(null, "transactionId")->build();
        self::assertSame('postback', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);

    }
}