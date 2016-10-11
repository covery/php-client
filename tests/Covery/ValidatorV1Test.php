<?php

class ValidatorV1Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Covery\Client\Envelopes\ValidatorV1
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new \Covery\Client\Envelopes\ValidatorV1();
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
        self::assertCount(1, $this->validator->analyzeIdentities(array()));
        self::assertCount(1, $this->validator->analyzeIdentities(array("foo")));
        self::assertCount(0, $this->validator->analyzeIdentities(array(new \Covery\Client\Identities\Stub())));
        self::assertCount(0, $this->validator->analyzeIdentities(array(
            new \Covery\Client\Identities\Stub(),
            $this->getMock('Covery\\Client\\IdentityNodeInterface')
        )));
    }

    public function testAnalyzeTypeAndMandatoryFields()
    {
        $env = new \Covery\Client\Envelopes\Envelope("foo", "123456", array(), array());
        $result = $this->validator->analyzeTypeAndMandatoryFields($env);
        self::assertCount(1, $result);
        self::assertSame('Envelope type "foo" not supported by this client version', $result[0]);

        $env = new \Covery\Client\Envelopes\Envelope("login", "123456", array(), array('login_timestamp' => 1, 'foo' => 'bar'));
        $result = $this->validator->analyzeTypeAndMandatoryFields($env);
        self::assertCount(2, $result);
        self::assertSame('Field "user_merchant_id" is mandatory for "login", but not provided', $result[0]);
        self::assertSame('Field "foo" not found in "login"', $result[1]);
    }

    public function testAnalyzeFieldTypes()
    {
        $env = new \Covery\Client\Envelopes\Envelope("login", "123456", array(), array(
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
        self::assertSame('Received 256 bytes to string key "email" - value is too long', $result[2]);
        self::assertSame('Field "login_failed" must be boolean, but null provided', $result[3]);
    }

    public function testComposition()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|\Covery\Client\Envelopes\ValidatorV1 $mock */
        $mock = self::getMock('Covery\\Client\\Envelopes\\ValidatorV1', [
            'analyzeSequenceId',
            'analyzeIdentities',
            'analyzeTypeAndMandatoryFields',
            'analyzeFieldTypes',
        ]);

        $mock->expects(self::once())->method('analyzeSequenceId')->willReturn(array());
        $mock->expects(self::once())->method('analyzeIdentities')->willReturn(array());
        $mock->expects(self::once())->method('analyzeTypeAndMandatoryFields')->willReturn(array());
        $mock->expects(self::once())->method('analyzeFieldTypes')->willReturn(array());

        $mock->validate(\Covery\Client\Envelopes\Builder::loginEvent("", "")->build());
    }

    /**
     * @expectedException \Covery\Client\EnvelopeValidationException
     * @expectedExceptionMessage Envelope validation failed
     */
    public function testCompositionWithError()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|\Covery\Client\Envelopes\ValidatorV1 $mock */
        $mock = self::getMock('Covery\\Client\\Envelopes\\ValidatorV1', [
            'analyzeSequenceId',
            'analyzeIdentities',
            'analyzeTypeAndMandatoryFields',
            'analyzeFieldTypes',
        ]);

        $mock->expects(self::once())->method('analyzeSequenceId')->willReturn(array('foo'));
        $mock->expects(self::once())->method('analyzeIdentities')->willReturn(array());
        $mock->expects(self::once())->method('analyzeTypeAndMandatoryFields')->willReturn(array('bar'));
        $mock->expects(self::once())->method('analyzeFieldTypes')->willReturn(array());

        $mock->validate(\Covery\Client\Envelopes\Builder::loginEvent("", "")->build());
    }
}
