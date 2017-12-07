<?php

class BuildPostbackEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::postBackEvent(
            "someSequenceId",
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
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(9, $result);
        $validator->validate($result);


        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::postBackEvent("someSequenceId")->build();
        self::assertSame('postback', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(0, $result);
        $validator->validate($result);
    }
}