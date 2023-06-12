<?php

class BuildPayoutEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::payoutEvent(
            'someSequenceId',
            'fooUserId',
            'payoutLargeId',
            'GBP',
            0.12,
            5566,
            'someCard0001',
            'someAccountId',
            'mtd',
            'sts',
            'midnight',
            23,
            'tony',
            'hawk',
            'zimbabwe',
            'jjj@xx.zzz',
            '+323423234',
            123456,
            '4445',
            11,
            22,
            "group id value",
            'links to documents',
            [1, 2]
        )->addBrowserData('88889', 'Test curl')->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('payout', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(25, $result);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame(5566, $result['payout_timestamp']);
        self::assertSame('payoutLargeId', $result['payout_id']);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame('someCard0001', $result['payout_card_id']);
        self::assertSame('someAccountId', $result['payout_account_id']);
        self::assertSame(.12, $result['payout_amount']);
        self::assertSame('GBP', $result['payout_currency']);
        self::assertSame('mtd', $result['payout_method']);
        self::assertSame('sts', $result['payout_system']);
        self::assertSame('midnight', $result['payout_mid']);
        self::assertSame(23., $result['payout_amount_converted']);
        self::assertSame('tony', $result['firstname']);
        self::assertSame('hawk', $result['lastname']);
        self::assertSame('zimbabwe', $result['country']);
        self::assertSame('jjj@xx.zzz', $result['email']);
        self::assertSame('+323423234', $result['phone']);
        self::assertSame(123456, $result['payout_card_bin']);
        self::assertSame('4445', $result['payout_card_last4']);
        self::assertSame(11, $result['payout_expiration_month']);
        self::assertSame(22, $result['payout_expiration_year']);
        self::assertSame('88889', $result['device_fingerprint']);
        self::assertSame('Test curl', $result['user_agent']);
        self::assertSame('group id value', $result['group_id']);
        self::assertSame('links to documents', $result['links_to_documents']);
        self::assertSame([1, 2], $result['media_id']);
        $validator->validate($result);

        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::payoutEvent(
            'someSequenceId',
            'fooUserId',
            'payoutLargeId',
            'GBP',
            0.12
        )->build();
        self::assertSame('payout', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(5, $result);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame('payoutLargeId', $result['payout_id']);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame(.12, $result['payout_amount']);
        self::assertSame('GBP', $result['payout_currency']);
        $validator->validate($result);
    }
}
