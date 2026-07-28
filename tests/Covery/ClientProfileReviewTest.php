<?php

use Covery\Client\ClientProfile\Builder;
use Covery\Client\Credentials\Sha256;
use Covery\Client\PublicAPIClient;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ClientProfileReviewTest extends TestCase
{
    private function clientReturning(array $json): PublicAPIClient
    {
        $transport = new class($json) implements TransportInterface {
            private $json;
            public function __construct(array $json) { $this->json = $json; }
            public function send(RequestInterface $request): \Psr\Http\Message\ResponseInterface
            {
                return new Response(200, [], json_encode($this->json));
            }
        };

        return new PublicAPIClient(new Sha256(str_repeat('a', 32), str_repeat('b', 32)), $transport);
    }

    public function testReviewIndividualProfile()
    {
        $client = $this->clientReturning([
            'client_profile_id' => 111,
            'sequence_id'       => 'seq1',
            'fullname'          => 'John Doe',
            'gender'            => 'male',
            'email_confirmed'   => false,
            'annual_limit'      => 1000.5,
            'active_features'   => ['a', 'b'],
        ]);

        $result = $client->getClientProfile(Builder::clientProfileEvent(111)->build());

        self::assertSame(111, $result->getClientProfileId());
        self::assertSame('seq1', $result->getSequenceId());
        self::assertSame('John Doe', $result->getFullname());
        self::assertSame('male', $result->getGender());
        self::assertFalse($result->getEmailConfirmed());
        self::assertSame(1000.5, $result->getAnnualLimit());
        self::assertSame(['a', 'b'], $result->getActiveFeatures());
        // entity-only fields are absent for individual profile
        self::assertNull($result->getCompanyName());
        self::assertNull($result->getWebsiteUrl());
        self::assertNull($result->getIndustry());
    }

    public function testReviewEntityProfile()
    {
        $client = $this->clientReturning([
            'client_profile_id' => 222,
            'sequence_id'       => 'seq2',
            'company_name'      => 'ACME Ltd',
            'website_url'       => 'https://acme.example',
            'industry'          => 'fintech',
        ]);

        $result = $client->getClientProfile(Builder::clientProfileEvent(222)->build());

        self::assertSame(222, $result->getClientProfileId());
        self::assertSame('ACME Ltd', $result->getCompanyName());
        self::assertSame('https://acme.example', $result->getWebsiteUrl());
        self::assertSame('fintech', $result->getIndustry());
        // individual-only fields are absent for entity profile
        self::assertNull($result->getFullname());
        self::assertNull($result->getGender());

        // JsonSerializable: encodes to snake_case profile fields
        $json = json_decode(json_encode($result), true);
        self::assertSame(222, $json['client_profile_id']);
        self::assertSame('ACME Ltd', $json['company_name']);
        self::assertArrayHasKey('fullname', $json);
        self::assertNull($json['fullname']);
    }
}
