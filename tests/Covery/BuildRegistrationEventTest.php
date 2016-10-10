<?php

class BuildRegistrationEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        // Full data
        $result = \Covery\Client\Envelopes\Builder::registrationEvent(
            'someLongString',
            'thisisuser',
            320746,
            'user@site.net',
            'thisisusername',
            'alex',
            'porohov',
            32,
            'female',
            '+34235522',
            'New zealand',
            'facebook'
        )->build();

        self::assertSame('registration', $result->getType());
        self::assertCount(0, $result->getIdentities());
        self::assertSame('someLongString', $result->getSequenceId());
        self::assertCount(11, $result);
        self::assertSame('thisisuser', $result['user_merchant_id']);
        self::assertSame(320746, $result['registration_timestamp']);
        self::assertSame('user@site.net', $result['email']);
        self::assertSame('thisisusername', $result['user_name']);
        self::assertSame('alex', $result['firstname']);
        self::assertSame('porohov', $result['lastname']);
        self::assertSame(32, $result['age']);
        self::assertSame('female', $result['gender']);
        self::assertSame('+34235522', $result['phone']);
        self::assertSame('New zealand', $result['country']);
        self::assertSame('facebook', $result['social_type']);
    }
}