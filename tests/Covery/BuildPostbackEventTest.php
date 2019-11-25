<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildPostbackEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::postBackEvent(
            123456,
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
        )->addIdentity(new Stub())->build();

        self::assertSame('postback', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(11, $result);
        $validator->validate($result);


        // Minimal data with request id
        $result = Builder::postBackEvent(22222)->build();
        self::assertSame('postback', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);

        // Minimal data with transaction id
        $result = Builder::postBackEvent(null, "transactionId")->build();
        self::assertSame('postback', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);

    }
}
