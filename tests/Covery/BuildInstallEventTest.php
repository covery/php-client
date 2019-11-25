<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\Identities\Stub;
use PHPUnit\Framework\TestCase;

class BuildInstallEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::installEvent(
            'someSequenceId',
            'fooUserId',
            123456,
            'ukr',
            'http://example.com',
            'source',
            'affId12345'
        )->addBrowserData('88889', 'Test curl')->addIdentity(new Stub())->build();

        self::assertSame('install', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(8, $result);
        self::assertSame('fooUserId', $result['user_merchant_id']);
        self::assertSame(123456, $result['install_timestamp']);
        self::assertSame('ukr', $result['country']);
        self::assertSame('http://example.com', $result['website_url']);
        self::assertSame('source', $result['traffic_source']);
        self::assertSame('affId12345', $result['affiliate_id']);
        $validator->validate($result);

        // Minimal data
        $result = Builder::installEvent(
            'someSequenceId'
        )->build();
        self::assertSame('install', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(1, $result);
        $validator->validate($result);
    }
}
