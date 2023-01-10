<?php

class Psr7RequestsTest extends \PHPUnit_Framework_TestCase
{
    public function testPing()
    {
        $req = new \Covery\Client\Requests\Ping();
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('/api/ping', strval($req->getUri()));
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
        self::assertSame('/api/sendEvent', strval($req->getUri()));

        $req = new \Covery\Client\Requests\Event($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/sendEvent', strval($req->getUri()));
    }

    public function testPostback()
    {
        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new \Covery\Client\Requests\Postback($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/postback', strval($req->getUri()));

        $req = new \Covery\Client\Requests\Postback($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/postback', strval($req->getUri()));
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
        self::assertSame('/api/makeDecision', strval($req->getUri()));

        $req = new \Covery\Client\Requests\Decision($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/makeDecision', strval($req->getUri()));
    }

    public function testKycProof()
    {
        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)->addWebsiteData('google.com')->build();

        $req = new \Covery\Client\Requests\KycProof($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"foo","sequence_id":"bar"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/kycProof', strval($req->getUri()));

        $req = new \Covery\Client\Requests\KycProof($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"baz","sequence_id":"yolo","website_url":"google.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/kycProof', strval($req->getUri()));
    }

    public function testMediaStorage()
    {
        $contentType = 'image/jpeg';
        $contentDescription = 'personal_photo';
        $fileContent = "test.jpeg";

        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->addMediaStorageData($contentType, $contentDescription, $fileContent)
            ->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)
            ->addWebsiteData('google.com')
            ->addMediaStorageData($contentType, $contentDescription, $fileContent)
            ->build();

        $req = new \Covery\Client\Requests\MediaStorage($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame(
            '{"type":"foo","sequence_id":"bar","content_type":"image\/jpeg","content_description":"personal_photo","file_name":"test.jpeg"}',
            $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/mediaStorage', strval($req->getUri()));

        $req = new \Covery\Client\Requests\MediaStorage($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame(
            '{"type":"baz","sequence_id":"yolo","website_url":"google.com","content_type":"image\/jpeg","content_description":"personal_photo","file_name":"test.jpeg"}',
            $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/mediaStorage', strval($req->getUri()));
    }

    public function testMediaConnection()
    {
        $requestId = 22222;
        $mediaId = [11111];

        $noIdentities = new \Covery\Client\Envelopes\Builder('foo', 'bar');
        $noIdentities = $noIdentities->addMediaConnectionData($requestId, $mediaId)->build();
        $withStub = new \Covery\Client\Envelopes\Builder('baz', 'yolo');
        $stub = new \Covery\Client\Identities\Stub();
        $withStub = $withStub->addIdentity($stub)
            ->addMediaConnectionData($requestId, $mediaId)
            ->addWebsiteData('google.com')
            ->build();

        $req = new \Covery\Client\Requests\MediaСonnection($noIdentities);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"type":"foo","sequence_id":"bar","request_id":22222,"media_id":[11111]}',
            $req->getBody()->getContents());
        self::assertSame('PUT', $req->getMethod());
        self::assertSame('', $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/mediaConnection', strval($req->getUri()));

        $req = new \Covery\Client\Requests\MediaСonnection($withStub);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame(
            '{"type":"baz","sequence_id":"yolo","request_id":22222,"media_id":[11111],"website_url":"google.com"}',
            $req->getBody()->getContents());
        self::assertSame('PUT', $req->getMethod());
        self::assertSame($stub->getType() . '=' . $stub->getId(), $req->getHeaderLine('X-Identities'));
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/mediaConnection', strval($req->getUri()));
    }
}
