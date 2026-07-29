<?php

use PHPUnit\Framework\TestCase;

class Psr7RequestsTest extends TestCase
{
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

    public function testIndividualProfile()
    {
        $profile = \Covery\Client\IndividualProfile\Builder::createIndividualProfileEvent('sequence123', null, null, null, null, null, 'foo@bar.com')
            ->build();

        // POST (create) - default method
        $req = new \Covery\Client\Requests\IndividualProfile($profile);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"sequence_id":"sequence123","email":"foo@bar.com"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/clientManagement/individualProfile', strval($req->getUri()));

        // PUT (update)
        // PUT sends the full field set (null for unset) so the server overwrites omitted fields with NULL
        $updateProfile = \Covery\Client\IndividualProfile\Builder::updateIndividualProfileEvent(777)->build();
        $req = new \Covery\Client\Requests\IndividualProfile($updateProfile, 'PUT');
        $body = json_decode($req->getBody()->getContents(), true);
        self::assertSame(777, $body['client_profile_id']);
        self::assertArrayHasKey('fullname', $body);
        self::assertNull($body['fullname']);
        self::assertSame('PUT', $req->getMethod());
        self::assertSame('/api/clientManagement/individualProfile', strval($req->getUri()));
    }

    public function testClientProfile()
    {
        $profile = \Covery\Client\ClientProfile\Builder::clientProfileEvent(12345)->build();

        $req = new \Covery\Client\Requests\ClientProfile($profile);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"client_profile_id":12345}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertFalse($req->hasHeader('X-Auth-Signature'));
        self::assertFalse($req->hasHeader('X-Auth-Nonce'));
        self::assertSame('/api/clientManagement/clientProfile', strval($req->getUri()));
    }

    public function testEntityProfile()
    {
        $profile = \Covery\Client\EntityProfile\Builder::createEntityProfileEvent('sequence123', null, null, null, null, null, null, null, null, null, 'ACME Ltd')
            ->build();

        // POST (create) - default method
        $req = new \Covery\Client\Requests\EntityProfile($profile);
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $req);
        self::assertSame('{"sequence_id":"sequence123","company_name":"ACME Ltd"}', $req->getBody()->getContents());
        self::assertSame('POST', $req->getMethod());
        self::assertFalse($req->hasHeader('X-Auth-Token'));
        self::assertSame('/api/clientManagement/entityProfile', strval($req->getUri()));

        // PUT sends the full field set (null for unset) so the server overwrites omitted fields with NULL
        $updateProfile = \Covery\Client\EntityProfile\Builder::updateEntityProfileEvent(777)->build();
        $req = new \Covery\Client\Requests\EntityProfile($updateProfile, 'PUT');
        $body = json_decode($req->getBody()->getContents(), true);
        self::assertSame(777, $body['client_profile_id']);
        self::assertArrayHasKey('company_name', $body);
        self::assertNull($body['company_name']);
        self::assertSame('PUT', $req->getMethod());
        self::assertSame('/api/clientManagement/entityProfile', strval($req->getUri()));
    }
}
