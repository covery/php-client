<?php

class Psr7RequestsTest extends \PHPUnit_Framework_TestCase
{
    public function testPing()
    {
        $req = new \Covery\Client\Requests\Ping();
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame(\Covery\Client\TransportInterface::DEFAULT_URL . 'api/ping', strval($req->getUri()));
    }

    public function testEvent()
    {
        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new \Covery\Client\Requests\Event($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame(\Covery\Client\TransportInterface::DEFAULT_URL . 'api/sendEvent', strval($req->getUri()));

        $req = new \Covery\Client\Requests\Event($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame(\Covery\Client\TransportInterface::DEFAULT_URL . 'api/sendEvent', strval($req->getUri()));
    }

    public function testDecision()
    {
        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new \Covery\Client\Requests\Decision($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame(\Covery\Client\TransportInterface::DEFAULT_URL . 'api/makeDecision', strval($req->getUri()));

        $req = new \Covery\Client\Requests\Decision($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame(\Covery\Client\TransportInterface::DEFAULT_URL . 'api/makeDecision', strval($req->getUri()));
    }
}