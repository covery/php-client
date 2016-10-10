<?php

class BuildConfirmationEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::confirmationEvent(
            'sequenceIdSome',
            'ababagalamaga',
            42342352,
            true,
            false
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('confirmation', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceIdSome', $result->getSequenceId());
        self::assertCount(4, $result);
        self::assertSame('ababagalamaga', $result['user_merchant_id']);
        self::assertSame(42342352, $result['confirmation_timestamp']);
        self::assertTrue($result['email_confirmed']);
        self::assertFalse($result['phone_confirmed']);
        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::confirmationEvent(
            'sequenceIdSome2',
            'suchwowmuchcovery'
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();
        self::assertSame('confirmation', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceIdSome2', $result->getSequenceId());
        self::assertCount(2, $result);
        self::assertSame('suchwowmuchcovery', $result['user_merchant_id']);
        self::assertTrue($result['confirmation_timestamp'] >= $current);
        self::assertArrayNotHasKey('email_confirmed', $result);
        self::assertArrayNotHasKey('phone_confirmed', $result);
        $validator->validate($result);
    }
}