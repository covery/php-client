<?php

class BuildRefundEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::refundEvent(
            'someSequenceId',
            'refundLargeId',
            0.12,
            'GBP',
            123456,
            0.22,
            'source',
            'type',
            '1234',
            'reason',
            'someAgentId1234',
            'someMethod',
            'someSystem',
            'someMid',
            'someEmail',
            'somePhone',
            'someUid'
        )->addBrowserData(
            '88889',
            'Test curl',
            'cpu',
            'screen',
            'resolution',
            'os',
            2,
            'languages',
            'lang',
            'langBrowser',
            'langUser',
            'langSystem',
            true,
            true,
            true,
            "id",
            "ipList",
            "plugins",
            "refUrl",
            "originUrl",
            "clientResolution"
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('refund', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(37, $result);
        self::assertSame('refundLargeId', $result['refund_id']);
        self::assertSame(0.12, $result['refund_amount']);
        self::assertSame('GBP', $result['refund_currency']);
        self::assertSame(123456, $result['refund_timestamp']);
        self::assertSame(0.22, $result['refund_amount_converted']);
        self::assertSame('source', $result['refund_source']);
        self::assertSame('type', $result['refund_type']);
        self::assertSame('1234', $result['refund_code']);
        self::assertSame('reason', $result['refund_reason']);
        self::assertSame('someAgentId1234', $result['agent_id']);
        self::assertSame('someMethod', $result['refund_method']);
        self::assertSame('someSystem', $result['refund_system']);
        self::assertSame('someMid', $result['refund_mid']);
        self::assertSame('someEmail', $result['email']);
        self::assertSame('somePhone', $result['phone']);
        self::assertSame(true, $result['ajax_validation']);
        self::assertSame(true, $result['cookie_enabled']);
        self::assertSame('cpu', $result['cpu_class']);
        self::assertSame('88889', $result['device_fingerprint']);
        self::assertSame('id', $result['device_id']);
        self::assertSame(true, $result['do_not_track']);
        self::assertSame('lang', $result['language']);
        self::assertSame('langBrowser', $result['language_browser']);
        self::assertSame('langSystem', $result['language_system']);
        self::assertSame('langUser', $result['language_user']);
        self::assertSame('languages', $result['languages']);
        self::assertSame('os', $result['os']);
        self::assertSame('screen', $result['screen_orientation']);
        self::assertSame('resolution', $result['screen_resolution']);
        self::assertSame(2, $result['timezone_offset']);
        self::assertSame('Test curl', $result['user_agent']);
        self::assertSame('ipList', $result['local_ip_list']);
        self::assertSame('plugins', $result['plugins']);
        self::assertSame('refUrl', $result['referrer_url']);
        self::assertSame('originUrl', $result['origin_url']);
        self::assertSame('clientResolution', $result['client_resolution']);
        $validator->validate($result);

        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::refundEvent(
            'someSequenceId',
            'refundLargeId',
            0.12,
            'GBP'
        )->build();
        self::assertSame('refund', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someSequenceId', $result->getSequenceId());
        self::assertCount(4, $result);
        self::assertSame('refundLargeId', $result['refund_id']);
        self::assertSame(0.12, $result['refund_amount']);
        self::assertSame('GBP', $result['refund_currency']);
        $validator->validate($result);
    }
}