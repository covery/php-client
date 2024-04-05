<?php

class BuildLoginEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::loginEvent(
            'someSequenceId',
            'someUserId',
            123456,
            'foo@bar.com',
            true,
            'male',
            'someTrafficSource',
            'someAffiliateId',
            "somePassword",
            "email campaign",
            "group id value",
            [1, 2]
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('login', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(11, $result);
        self::assertSame('someUserId', $result['user_merchant_id']);
        self::assertSame(123456, $result['login_timestamp']);
        self::assertSame('foo@bar.com', $result['email']);
        self::assertSame('male', $result['gender']);
        self::assertSame('someTrafficSource', $result['traffic_source']);
        self::assertSame('someAffiliateId', $result['affiliate_id']);
        self::assertSame('somePassword', $result['password']);
        self::assertSame('email campaign', $result['campaign']);
        self::assertSame('group id value', $result['group_id']);
        self::assertSame([1, 2], $result['document_id']);

        self::assertTrue($result['login_failed']);
        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::loginEvent(
            'someSequenceId2',
            'someUserId5'
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();
        self::assertSame('login', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId2', $result->getSequenceId());
        self::assertCount(2, $result);
        self::assertSame('someUserId5', $result['user_merchant_id']);
        self::assertTrue($result['login_timestamp'] >= $current);
        self::assertArrayNotHasKey('email', $result);
        self::assertArrayNotHasKey('login_failed', $result);
        self::assertArrayNotHasKey('gender', $result);
        self::assertArrayNotHasKey('traffic_source', $result);
        self::assertArrayNotHasKey('affiliate_id', $result);
        self::assertArrayNotHasKey('password', $result);
        $validator->validate($result);
    }
}
