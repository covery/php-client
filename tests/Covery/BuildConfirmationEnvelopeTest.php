<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildConfirmationEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::confirmationEvent(
            'sequenceIdSome',
            'ababagalamaga',
            42342352,
            true,
            false
        )->addIdentity(new Stub())->build();

        self::assertSame('confirmation', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceIdSome', $result->getSequenceId());
        self::assertCount(4, $result);
        self::assertSame('ababagalamaga', $result['user_merchant_id']);
        self::assertSame(42342352, $result['confirmation_timestamp']);
        self::assertTrue($result['email_confirmed']);
        self::assertFalse($result['phone_confirmed']);
        self::assertArrayNotHasKey('email', $result);
        self::assertArrayNotHasKey('phone', $result);
        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = Builder::confirmationEvent(
            'sequenceIdSome2',
            'suchwowmuchcovery'
        )->addIdentity(new Stub())->build();
        self::assertSame('confirmation', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceIdSome2', $result->getSequenceId());
        self::assertCount(2, $result);
        self::assertSame('suchwowmuchcovery', $result['user_merchant_id']);
        self::assertTrue($result['confirmation_timestamp'] >= $current);
        self::assertArrayNotHasKey('email_confirmed', $result);
        self::assertArrayNotHasKey('phone_confirmed', $result);
        self::assertArrayNotHasKey('email', $result);
        self::assertArrayNotHasKey('phone', $result);
        $validator->validate($result);

        // Optional email and phone
        // Full data
        $result = Builder::confirmationEvent(
            'sequenceIdSome',
            'ababagalamaga',
            42342352,
            false,
            true,
            'foo@bar.com',
            '+1234567890'
        )->addIdentity(new Stub())->build();

        self::assertSame('confirmation', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceIdSome', $result->getSequenceId());
        self::assertCount(6, $result);
        self::assertSame('ababagalamaga', $result['user_merchant_id']);
        self::assertSame(42342352, $result['confirmation_timestamp']);
        self::assertFalse($result['email_confirmed']);
        self::assertTrue($result['phone_confirmed']);
        self::assertSame('foo@bar.com', $result['email']);
        self::assertSame('+1234567890', $result['phone']);
        $validator->validate($result);
    }
}
