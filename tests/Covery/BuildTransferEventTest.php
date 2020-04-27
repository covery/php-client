<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildTransferEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::transferEvent(
            'someSequenceId',
            'someEventId',
            0.42,
            'GBP',
            "accountId",
            'secondAccountId',
            'paypal',
            'uid42',
            'foo',
            123123,
            42,
            'test@test.com',
            '911',
            424242,
            'John',
            'Snow',
            'John Snow',
            'WT',
            'Winterfell',
            'North st. 9',
            '77777',
            'male',
            'US',
            'DEBIT',
            'second_test@test.com',
            '937992',
            242424,
            'Bruce',
            'Lee',
            'Bruce Lee',
            'LA',
            'Santa Monica',
            'Seaview st. 7',
            '10001',
            'male',
            'US',
            'productDesc',
            'productName',
            42,
            'iban',
            'second_iban',
            'bic value'
        )
            ->addBrowserData('88889', 'Test curl')
            ->addIdentity(new Stub())
            ->addCustomField('test1', 'test1')
            ->build();

        self::assertSame('transfer', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(44, $result);

        self::assertSame('someEventId', $result['event_id']);
        self::assertSame(0.42, $result['amount']);
        self::assertSame('GBP', $result['currency']);
        self::assertSame("accountId", $result['account_id']);
        self::assertSame('secondAccountId', $result['second_account_id']);
        self::assertSame('paypal', $result['account_system']);
        self::assertSame('uid42', $result['user_merchant_id']);
        self::assertSame('foo', $result['method']);
        self::assertSame(123123, $result['event_timestamp']);
        self::assertSame(42, $result['amount_converted']);
        self::assertSame('test@test.com', $result['email']);
        self::assertSame('911', $result['phone']);
        self::assertSame(424242, $result['birth_date']);
        self::assertSame('John', $result['firstname']);
        self::assertSame('Snow', $result['lastname']);
        self::assertSame('John Snow', $result['fullname']);
        self::assertSame('WT', $result['state']);
        self::assertSame('Winterfell', $result['city']);
        self::assertSame('North st. 9', $result['address']);
        self::assertSame('77777', $result['zip']);
        self::assertSame('male', $result['gender']);
        self::assertSame('US', $result['country']);
        self::assertSame('DEBIT', $result['operation']);
        self::assertSame('second_test@test.com', $result['second_email']);
        self::assertSame('937992', $result['second_phone']);
        self::assertSame(242424, $result['second_birth_date']);
        self::assertSame('Bruce', $result['second_firstname']);
        self::assertSame('Lee', $result['second_lastname']);
        self::assertSame('Bruce Lee', $result['second_fullname']);
        self::assertSame('LA', $result['second_state']);
        self::assertSame('Santa Monica', $result['second_city']);
        self::assertSame('Seaview st. 7', $result['second_address']);
        self::assertSame('10001', $result['second_zip']);
        self::assertSame('male', $result['second_gender']);
        self::assertSame('US', $result['second_country']);
        self::assertSame('productDesc', $result['product_description']);
        self::assertSame('productName', $result['product_name']);
        self::assertSame(42, $result['product_quantity']);
        self::assertSame('iban', $result['iban']);
        self::assertSame('second_iban', $result['second_iban']);
        self::assertSame('bic value', $result['bic']);


        $validator->validate($result);

        // Minimal data
        $result = Builder::transferEvent(
            'someSequenceId',
            'someEventId',
            0.42,
            'GBP',
            "accountId",
            'secondAccountId',
            'paypal',
            'uid42'
        )->build();
        self::assertSame('transfer', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(8, $result);
        self::assertSame('someEventId', $result['event_id']);
        self::assertSame(0.42, $result['amount']);
        self::assertSame('GBP', $result['currency']);
        self::assertSame('accountId', $result['account_id']);
        self::assertSame("secondAccountId", $result['second_account_id']);
        self::assertSame('paypal', $result['account_system']);
        self::assertSame('uid42', $result['user_merchant_id']);
        $validator->validate($result);
    }
}
