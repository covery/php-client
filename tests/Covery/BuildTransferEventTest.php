<?php

use PHPUnit\Framework\TestCase;

class BuildTransferEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::transferEvent(
            'someSequenceId',
            'someEventId',
            0.42,
            'GBP',
            'uid42',
            "accountId",
            'secondAccountId',
            'paypal',
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
            'bic value',
            'source value',
            "group id value",
            "second user merchant id value",
            'links to documents',
            [1, 2]
        )
            ->addBrowserData('88889', 'Test curl')
            ->addIdentity(new \Covery\Client\Identities\Stub())
            ->addCustomField('test1', 'test1')
            ->build();

        self::assertSame('transfer', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(49, $result);

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
        self::assertSame('source value', $result['transfer_source']);
        self::assertSame('group id value', $result['group_id']);
        self::assertSame('second user merchant id value', $result['second_user_merchant_id']);
        self::assertSame('links to documents', $result['links_to_documents']);
        self::assertSame([1, 2], $result['document_id']);

        $validator->validate($result);

        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::transferEvent(
            'someSequenceId',
            'someEventId',
            0.42,
            'GBP',
            'uid42'

        )->build();
        self::assertSame('transfer', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(5, $result);
        self::assertSame('someEventId', $result['event_id']);
        self::assertSame(0.42, $result['amount']);
        self::assertSame('GBP', $result['currency']);
        self::assertSame('uid42', $result['user_merchant_id']);
        $validator->validate($result);
    }
}
