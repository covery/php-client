<?php

class BuildLoginEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        // Full data
        $result = \Covery\Client\Envelopes\Builder::loginEvent(
            'someSequenceId',
            'someUserId',
            123456,
            'foo@bar.com',
            true
        )->build();

        self::assertSame('login', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(4, $result);
        self::assertSame('someUserId', $result['user_merchant_id']);
        self::assertSame(123456, $result['login_timestamp']);
        self::assertSame('foo@bar.com', $result['email']);
        self::assertTrue($result['login_failed']);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::loginEvent(
            'someSequenceId2',
            'someUserId5'
        )->build();
        self::assertSame('login', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId2', $result->getSequenceId());
        self::assertCount(2, $result);
        self::assertSame('someUserId5', $result['user_merchant_id']);
        self::assertTrue($result['login_timestamp'] >= $current);
        self::assertArrayNotHasKey('email', $result);
        self::assertArrayNotHasKey('login_failed', $result);
    }
}
