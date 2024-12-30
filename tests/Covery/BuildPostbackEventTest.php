<?php

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use PHPUnit\Framework\TestCase;

class BuildPostbackEventTest extends TestCase
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
            "someArn",
            "z1234fcdfd23",
            "someMerchantAdviceCode",
            "someMerchantAdviceText"
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame(Builder::EVENT_POSTBACK, $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someTransactionStatus', $result['transaction_status']);
        self::assertSame('someCode', $result['code']);
        self::assertSame('someReason', $result['reason']);
        self::assertSame('someSecure3d', $result['secure3d']);
        self::assertSame('someAvsResult', $result['avs_result']);
        self::assertSame('someCvvResult', $result['cvv_result']);
        self::assertSame('somePspCode', $result['psp_code']);
        self::assertSame('somePspReason', $result['psp_reason']);
        self::assertSame('someArn', $result['arn']);
        self::assertSame('z1234fcdfd23', $result['payment_account_id']);
        self::assertSame('someMerchantAdviceCode', $result['merchant_advice_code']);
        self::assertSame('someMerchantAdviceText', $result['merchant_advice_text']);
        self::assertCount(13, $result);
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