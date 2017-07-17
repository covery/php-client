<?php

class BuildRefundEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::refundEvent(
            'someSequenceId',
            'refundLargeId',
            0.12,
            'GBP',
            123456,
            0.22,
            'source',
            'type',
            '1234',
            'reason',
            'someAgentId1234'
        )->addBrowserData('88889', 'Test curl')->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('refund', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(12, $result);
        self::assertSame('refundLargeId', $result['refund_id']);
        self::assertSame(0.12, $result['refund_amount']);
        self::assertSame('GBP', $result['refund_currency']);
        self::assertSame(123456, $result['refund_timestamp']);
        self::assertSame(0.22, $result['refund_amount_converted']);
        self::assertSame('source', $result['refund_source']);
        self::assertSame('type', $result['refund_type']);
        self::assertSame('1234', $result['refund_code']);
        self::assertSame('reason', $result['refund_reason']);
        self::assertSame('someAgentId1234', $result['agent_id']);
        $validator->validate($result);

        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::refundEvent(
            'someSequenceId',
            'refundLargeId',
            0.12,
            'GBP'
        )->build();
        self::assertSame('refund', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(4, $result);
        self::assertSame('refundLargeId', $result['refund_id']);
        self::assertSame(0.12, $result['refund_amount']);
        self::assertSame('GBP', $result['refund_currency']);
        $validator->validate($result);
    }
}