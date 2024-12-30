<?php

use PHPUnit\Framework\TestCase;

class CredentialsSha256Test extends TestCase
{
    public function invalidTokens() {
        return array(
            array(null, null, "Token must be string"),
            array("12345678901234567890123456789012", null, "Secret must be string"),
            array(null, "12345678901234567890123456789012", "Token must be string"),
            array("12345678901234567890123456789012", "12345", "Secret must be exact 32 characters long"),
            array("12345", "12345678901234567890123456789012", "Token must be exact 32 characters long"),
        );
    }

    /**
     * @dataProvider invalidTokens
     */
    public function testInvalidCredentials($token, $secret, $expectedMessage)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        new \Covery\Client\Credentials\Sha256($token, $secret);
    }

    public function testSign()
    {
        $maker = new \Covery\Client\Credentials\Sha256(
            '12345678901234567890123456789012',
            'asjdh283ysfjhbkjKHGV^7ra/adf2145'
        );

        $req = new \GuzzleHttp\Psr7\Request('POST', 'http://localhost/foo', [], "Hello, world");
        $signed = $maker->signRequest($req);

        self::assertNotSame($req, $signed);
        self::assertEquals($req->getMethod(), $signed->getMethod());
        self::assertEquals($req->getUri(), $signed->getUri());
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertTrue($signed->hasHeader('X-Auth-Token'));
        self::assertTrue($signed->hasHeader('X-Auth-Signature'));
        self::assertTrue($signed->hasHeader('X-Auth-Nonce'));

        self::assertEquals(
            hash('sha256', $signed->getHeaderLine('X-Auth-Nonce') . 'Hello, world' .  'asjdh283ysfjhbkjKHGV^7ra/adf2145'),
            $signed->getHeaderLine('X-Auth-Signature')
        );
    }

    public function testBodyPresence()
    {
        $maker = new \Covery\Client\Credentials\Sha256(
            '12345678901234567890123456789012',
            'asjdh283ysfjhbkjKHGV^7ra/adf2145'
        );

        $body = "Hello, world";
        $req = new \GuzzleHttp\Psr7\Request('POST', 'http://localhost/foo', [], $body);
        $signed = $maker->signRequest($req);
        self::assertSame($body, $signed->getBody()->getContents());
    }
}