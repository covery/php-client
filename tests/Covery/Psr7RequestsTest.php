<?php

namespace Tests\Covery;

use Covery\Client\Envelopes\Builder;
use Covery\Client\Identities\Stub;
use Covery\Client\Requests\Decision;
use Covery\Client\Requests\Event;
use Covery\Client\Requests\Ping;
use Covery\Client\Requests\Postback;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class Psr7RequestsTest extends TestCase
{
    public function testPing()
    {
        $req = new Ping();
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('api/ping', strval($req->getUri()));
    }

    public function testEvent()
    {
        $noIdentities = new Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new Builder('baz', 'yolo');
        $stub = new Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new Event($noIdentities);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/sendEvent', strval($req->getUri()));

        $req = new Event($withStub);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/sendEvent', strval($req->getUri()));
    }

    public function testPostback()
    {
        $noIdentities = new Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new Builder('baz', 'yolo');
        $stub = new Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new Postback($noIdentities);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/postback', strval($req->getUri()));

        $req = new Postback($withStub);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/postback', strval($req->getUri()));
    }

    public function testDecision()
    {
        $noIdentities = new Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new Builder('baz', 'yolo');
        $stub = new Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new Decision($noIdentities);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/makeDecision', strval($req->getUri()));

        $req = new Decision($withStub);
        self::assertInstanceOf(RequestInterface::class, $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('api/makeDecision', strval($req->getUri()));
    }
}
