<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\Envelope;
use Covery\Client\Envelopes\ValidatorV1;
use Covery\Client\EnvelopeValidationException;
use Covery\Client\Identities\Stub;
use Covery\Client\IdentityNodeInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class ValidatorV1Test extends TestCase
{
    /**
     * @var ValidatorV1
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new ValidatorV1();
    }

    public function testAnalyzeSequenceId()
    {
        self::assertCount(0, $this->validator->analyzeSequenceId("123456"));
        self::assertCount(0, $this->validator->analyzeSequenceId("324ubcjdf7923bjh"));
        self::assertCount(0, $this->validator->analyzeSequenceId(str_repeat('x', 40)));
        self::assertCount(1, $this->validator->analyzeSequenceId(str_repeat('x', 41)));
        self::assertCount(1, $this->validator->analyzeSequenceId(12345));
        self::assertCount(1, $this->validator->analyzeSequenceId("foo12"));
    }

    public function testAnalyzeIdentitites()
    {
        self::assertCount(0, $this->validator->analyzeIdentities(array()));
        self::assertCount(1, $this->validator->analyzeIdentities(array("foo")));
        self::assertCount(0, $this->validator->analyzeIdentities(array(new Stub())));
        self::assertCount(0, $this->validator->analyzeIdentities(array(
            new Stub(),
            $this->getMockBuilder(IdentityNodeInterface::class)->getMock()
        )));
    }

    public function testAnalyzeTypeAndMandatoryFields()
    {
        $env = new Envelope("foo", "123456", array(), array());
        $result = $this->validator->analyzeTypeAndMandatoryFields($env);
        self::assertCount(1, $result);
        self::assertSame('Envelope type "foo" not supported by this client version', $result[0]);

        $env = new Envelope("login", "123456", array(), array('login_timestamp' => 1, 'foo' => 'bar'));
        $result = $this->validator->analyzeTypeAndMandatoryFields($env);
        self::assertCount(2, $result);
        self::assertSame('Field "user_merchant_id" is mandatory for "login", but not provided', $result[0]);
        self::assertSame('Field "foo" not found in "login"', $result[1]);
    }

    public function testAnalyzeOptionalFieldsWithShared()
    {
        $env = new Envelope(
            "login",
            "123456",
            array(),
            array(
                'login_timestamp' => 1,
                'user_merchant_id' => 'x',
                'os' => 'Some OS',
                'real_ip' => '8.8.3.3',
            )
        );
        $result = $this->validator->analyzeTypeAndMandatoryFields($env);
        self::assertCount(0, $result);
    }

    public function testAnalyzeFieldTypes()
    {
        $env = new Envelope("login", "123456", array(), array(
            'login_timestamp' => 1,
            'user_merchant_id' => 2,
            'user_merchant_id2' => 2,
            'email' => str_repeat('x', 256),
            'login_failed' => null,
        ));
        $result = $this->validator->analyzeFieldTypes($env);
        self::assertCount(4, $result);
        self::assertSame('Field "user_merchant_id" must be string, but integer provided', $result[0]);
        self::assertSame('Unknown type for "user_merchant_id2"', $result[1]);
        self::assertSame('Received 256 bytes of 255 allowed for string key "email" - value is too long', $result[2]);
        self::assertSame('Field "login_failed" must be boolean, but null provided', $result[3]);
    }

    public function testComposition()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|ValidatorV1 $mock */
        $mock = self::getMockBuilder(ValidatorV1::class)
            ->setMethods([
                'analyzeSequenceId',
                'analyzeIdentities',
                'analyzeTypeAndMandatoryFields',
                'analyzeFieldTypes',
            ])
            ->getMock();

        $mock->expects(self::once())->method('analyzeSequenceId')->willReturn(array());
        $mock->expects(self::once())->method('analyzeIdentities')->willReturn(array());
        $mock->expects(self::once())->method('analyzeTypeAndMandatoryFields')->willReturn(array());
        $mock->expects(self::once())->method('analyzeFieldTypes')->willReturn(array());

        $mock->validate(Builder::loginEvent("", "")->build());
    }

    public function testCompositionWithError()
    {
        $this->expectException(EnvelopeValidationException::class);
        $this->expectExceptionMessage('Envelope validation failed');

        /** @var PHPUnit_Framework_MockObject_MockObject|ValidatorV1 $mock */
        $mock = self::getMockBuilder(ValidatorV1::class)
            ->setMethods([
                'analyzeSequenceId',
                'analyzeIdentities',
                'analyzeTypeAndMandatoryFields',
                'analyzeFieldTypes',
            ])
            ->getMock();

        $mock->expects(self::once())->method('analyzeSequenceId')->willReturn(array('foo'));
        $mock->expects(self::once())->method('analyzeIdentities')->willReturn(array());
        $mock->expects(self::once())->method('analyzeTypeAndMandatoryFields')->willReturn(array('bar'));
        $mock->expects(self::once())->method('analyzeFieldTypes')->willReturn(array());

        $mock->validate(Builder::loginEvent("", "")->build());
    }
}
