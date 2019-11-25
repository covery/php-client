<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildTransactionEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::transactionEvent(
            'someSequenceId',
            'fooUserId',
            'transactionId',
            0.12,
            'GBP',
            123456,
            'mode',
            'type',
            444444,
            'qwef53f12e1s121sd34f',
            '1234',
            12,
            2017,
            21,
            'ukr',
            'test@test.com',
            'male',
            'John',
            'Snow',
            '380501234567',
            'Lord of north',
            'z1234fcdfd23',
            'method',
            'mid',
            'system',
            0.22,
            'source',
            'castle',
            'Winterfell',
            'Westeros',
            'John',
            'Targarien',
            'John Targarien',
            'north',
            '123',
            'Rusted swords',
            'Sword',
            1000,
            'http://example.com',
            '127.0.0.1',
            'affiliateId'
        )
            ->addBrowserData('88889', 'Test curl')
            ->addIdentity(new Stub())
            ->addCustomField('test1', 'test1')
            ->build();

        self::assertSame('transaction', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(43, $result);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame('transactionId', $result['transaction_id']);
        self::assertSame(0.12, $result['transaction_amount']);
        self::assertSame('GBP', $result['transaction_currency']);
        self::assertSame(123456, $result['transaction_timestamp']);
        self::assertSame(21, $result['age']);
        self::assertSame('ukr', $result['country']);
        self::assertSame('test@test.com', $result['email']);
        self::assertSame('male', $result['gender']);
        self::assertSame('John', $result['firstname']);
        self::assertSame('Snow', $result['lastname']);
        self::assertSame('380501234567', $result['phone']);
        self::assertSame('Lord of north', $result['user_name']);
        self::assertSame('z1234fcdfd23', $result['payment_account_id']);
        self::assertSame('method', $result['payment_method']);
        self::assertSame('mid', $result['payment_mid']);
        self::assertSame('system', $result['payment_system']);
        self::assertSame(0.22, $result['transaction_amount_converted']);
        self::assertSame('source', $result['transaction_source']);
        self::assertSame('castle', $result['billing_address']);
        self::assertSame('Winterfell', $result['billing_city']);
        self::assertSame('Westeros', $result['billing_country']);
        self::assertSame('John', $result['billing_firstname']);
        self::assertSame('Targarien', $result['billing_lastname']);
        self::assertSame('John Targarien', $result['billing_fullname']);
        self::assertSame('north', $result['billing_state']);
        self::assertSame('123', $result['billing_zip']);
        self::assertSame('Rusted swords', $result['product_description']);
        self::assertSame('Sword', $result['product_name']);
        self::assertSame(1000, $result['product_quantity']);
        self::assertSame('http://example.com', $result['website_url']);
        self::assertSame('127.0.0.1', $result['merchant_ip']);
        self::assertSame(444444, $result['card_bin']);
        self::assertSame('qwef53f12e1s121sd34f', $result['card_id']);
        self::assertSame('1234', $result['card_last4']);
        self::assertSame(12, $result['expiration_month']);
        self::assertSame(2017, $result['expiration_year']);
        self::assertSame('mode', $result['transaction_mode']);
        self::assertSame('type', $result['transaction_type']);
        self::assertSame('affiliateId', $result['affiliate_id']);
        self::assertSame('test1', $result['custom_test1']);

        $validator->validate($result);

        // Minimal data
        $result = Builder::transactionEvent(
            'someSequenceId',
            'fooUserId',
            'transactionId',
            0.12,
            'GBP'
        )->build();
        self::assertSame('transaction', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(5, $result);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame('transactionId', $result['transaction_id']);
        self::assertSame(0.12, $result['transaction_amount']);
        self::assertSame('GBP', $result['transaction_currency']);
        $validator->validate($result);
    }
}
