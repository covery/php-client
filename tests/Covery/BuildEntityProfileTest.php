<?php

use Covery\Client\EntityProfile\Builder;
use PHPUnit\Framework\TestCase;

class BuildEntityProfileTest extends TestCase
{
    public function testBuildForCreate()
    {
        $result = Builder::createEntityProfileEvent(
            'sequence123',
            'userMerchant1',
            'active',
            1600000000,
            '+123456789',
            true,
            'foo@bar.com',
            false,
            'acme_user',
            'secret',
            'ACME Ltd',
            'https://acme.example',
            'fintech',
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

        self::assertInstanceOf(\Covery\Client\EntityProfileInterface::class, $result);
        self::assertSame('sequence123', $result['sequence_id']);
        self::assertSame('userMerchant1', $result['user_merchant_id']);
        self::assertSame('ACME Ltd', $result['company_name']);
        self::assertSame('https://acme.example', $result['website_url']);
        self::assertSame('fintech', $result['industry']);
        self::assertTrue($result['phone_confirmed']);
        self::assertFalse($result['email_confirmed']);
        self::assertSame(25000.99, $result['annual_limit']);
        self::assertSame(['feature_a', 'feature_b'], $result['active_features']);
        self::assertFalse($result->offsetExists('client_profile_id'));
        // entity profile must NOT carry individual-only fields
        self::assertFalse($result->offsetExists('fullname'));
        self::assertFalse($result->offsetExists('gender'));
    }

    public function testBuildForUpdate()
    {
        $result = Builder::updateEntityProfileEvent(555, 'userMerchant1')->build();

        self::assertSame(555, $result['client_profile_id']);
        self::assertSame('userMerchant1', $result['user_merchant_id']);
        self::assertFalse($result->offsetExists('sequence_id'));
    }

    public function testMinimalForCreate()
    {
        $result = Builder::createEntityProfileEvent('sequence123')->build();
        self::assertCount(1, $result);
        self::assertSame('sequence123', $result['sequence_id']);
    }

    public function testMinimalForUpdate()
    {
        // PUT replaces all data: every field is sent (null for unset)
        $result = Builder::updateEntityProfileEvent(42)->build();
        self::assertCount(36, $result); // client_profile_id + 35 optional
        self::assertSame(42, $result['client_profile_id']);
        self::assertTrue($result->offsetExists('company_name'));
        self::assertNull($result['company_name']);
    }

    public function testResultIsJsonSerializable()
    {
        $result = new \Covery\Client\EntityProfileResult(456, 'entity', 1700000000);
        self::assertSame(
            '{"client_profile_id":456,"profile_type":"entity","created_at":1700000000}',
            json_encode($result)
        );
    }

    public function testCreateRequiresSequenceId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::createEntityProfileEvent('');
    }

    public function testUpdateRequiresIntClientProfileId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::updateEntityProfileEvent('not-an-int');
    }

    public function testCompanyNameTypeValidation()
    {
        $this->expectException(\InvalidArgumentException::class);
        // company_name is the 10th optional param (position 11) - must be string
        Builder::createEntityProfileEvent(
            'sequence123', null, null, null, null, null, null, null, null, null, 12345
        );
    }
}
