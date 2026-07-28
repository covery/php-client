<?php

use Covery\Client\IndividualProfile\Builder;
use PHPUnit\Framework\TestCase;

class BuildIndividualProfileTest extends TestCase
{
    public function testBuildForCreate()
    {
        $result = Builder::createIndividualProfileEvent(
            'sequence123',
            'userMerchant1',
            'active',
            1600000000,
            '+123456789',
            true,
            'foo@bar.com',
            false,
            'johndoe',
            'secret',
            'John Doe',
            true,
            946684800,
            'male',
            'single',
            'usa',
            'higher',
            'employed',
            'salary',
            'usa',
            true,
            'RN123',
            1600000000,
            1700000000,
            'VAT123',
            false,
            true,
            'some description',
            'usa',
            'CA',
            'LA',
            '90001',
            'Some street 1',
            true,
            'savings',
            10.5,
            100.0,
            500.25,
            2000.0,
            25000.99,
            ['feature_a', 'feature_b'],
            ['promo_1']
        )->build();

        self::assertInstanceOf(\Covery\Client\IndividualProfileInterface::class, $result);
        self::assertSame('sequence123', $result['sequence_id']);
        self::assertSame('userMerchant1', $result['user_merchant_id']);
        self::assertSame('active', $result['account_status']);
        self::assertSame(1600000000, $result['reg_date']);
        self::assertSame('+123456789', $result['phone']);
        self::assertTrue($result['phone_confirmed']);
        self::assertSame('foo@bar.com', $result['email']);
        self::assertFalse($result['email_confirmed']);
        self::assertSame('John Doe', $result['fullname']);
        self::assertTrue($result['has_middle_name']);
        self::assertSame('male', $result['gender']);
        self::assertSame(10.5, $result['one_operation_limit']);
        self::assertSame(25000.99, $result['annual_limit']);
        self::assertSame(['feature_a', 'feature_b'], $result['active_features']);
        self::assertSame(['promo_1'], $result['promotions']);
        self::assertFalse($result->offsetExists('client_profile_id'));
    }

    public function testBuildForUpdate()
    {
        $result = Builder::updateIndividualProfileEvent(555, 'userMerchant1')->build();

        self::assertSame(555, $result['client_profile_id']);
        self::assertSame('userMerchant1', $result['user_merchant_id']);
        self::assertFalse($result->offsetExists('sequence_id'));
    }

    public function testMinimalForCreate()
    {
        $result = Builder::createIndividualProfileEvent('sequence123')->build();
        self::assertCount(1, $result);
        self::assertSame('sequence123', $result['sequence_id']);
    }

    public function testMinimalForUpdate()
    {
        // PUT replaces all data: every field is sent (null for unset) so the
        // server overwrites omitted fields with NULL.
        $result = Builder::updateIndividualProfileEvent(42)->build();
        self::assertCount(42, $result); // client_profile_id + 41 optional
        self::assertSame(42, $result['client_profile_id']);
        self::assertTrue($result->offsetExists('fullname'));
        self::assertNull($result['fullname']);
    }

    public function testUpdateSendsExplicitNullsToClearFields()
    {
        // Set email only; everything else must be present as null so PUT clears them
        $result = Builder::updateIndividualProfileEvent(
            555, null, null, null, null, null, 'new@bar.com'
        )->build();

        self::assertSame('new@bar.com', $result['email']);
        self::assertTrue($result->offsetExists('phone'));
        self::assertNull($result['phone']);
        self::assertTrue($result->offsetExists('annual_limit'));
        self::assertNull($result['annual_limit']);
        // JSON must contain explicit nulls
        self::assertStringContainsString('"phone":null', json_encode($result->toArray()));
    }

    public function testResultIsJsonSerializable()
    {
        $result = new \Covery\Client\IndividualProfileResult(123, 'individual', 1700000000);
        self::assertSame(
            '{"client_profile_id":123,"profile_type":"individual","created_at":1700000000}',
            json_encode($result)
        );
    }

    public function testCreateRequiresSequenceId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::createIndividualProfileEvent('');
    }

    public function testUpdateRequiresIntClientProfileId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::updateIndividualProfileEvent('not-an-int');
    }

    public function testStringFieldTypeValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::createIndividualProfileEvent('sequence123', 12345);
    }

    public function testBoolFieldTypeValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        // phone_confirmed must be bool
        Builder::createIndividualProfileEvent('sequence123', null, null, null, null, 'yes');
    }

    public function testTooLongStringValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::createIndividualProfileEvent('sequence123', str_repeat('a', 256));
    }

    public function testStringListRejectsNonString()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::createIndividualProfileEvent(
            'sequence123', null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null,
            [123]
        );
    }
}
