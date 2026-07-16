<?php

use Covery\Client\Credentials\Sha256;
use Covery\Client\PublicAPIClient;
use Covery\Client\Relationships\Builder;
use Covery\Client\TransportInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class RelationshipsReviewTest extends TestCase
{
    public $lastRequest;

    private function clientReturning(array $json): PublicAPIClient
    {
        $self = $this;
        $transport = new class($json, $self) implements TransportInterface {
            private $json;
            private $test;
            public function __construct(array $json, $test) { $this->json = $json; $this->test = $test; }
            public function send(RequestInterface $request): \Psr\Http\Message\ResponseInterface
            {
                $this->test->lastRequest = $request;
                return new Response(200, [], json_encode($this->json));
            }
        };

        return new PublicAPIClient(new Sha256(str_repeat('a', 32), str_repeat('b', 32)), $transport);
    }

    public function testReviewReturnsList()
    {
        $client = $this->clientReturning([
            'relationships' => [
                [
                    'relationship_receiver' => 1449049571,
                    'relationship_provider' => 1449049572,
                    'relationship_type' => 'owner_company',
                ],
                [
                    'relationship_receiver' => 1449049571,
                    'relationship_provider' => 1449049572,
                    'relationship_type' => 'owner_company',
                    'provider_role' => 'KKK',
                    'provider_share_of_ownership' => 100.50,
                ],
            ],
        ]);

        $result = $client->getRelationships(Builder::reviewQuery(1449049571));

        // request assertions
        self::assertSame('POST', $this->lastRequest->getMethod());
        self::assertSame('/api/clientManagement/relationships', $this->lastRequest->getUri()->getPath());
        self::assertSame('{"relationship_receiver":1449049571}', (string)$this->lastRequest->getBody());

        // response assertions
        $items = $result->getRelationships();
        self::assertCount(2, $items);
        self::assertSame(1449049571, $items[0]->getRelationshipReceiver());
        self::assertSame(1449049572, $items[0]->getRelationshipProvider());
        self::assertSame('owner_company', $items[0]->getRelationshipType());
        self::assertNull($items[0]->getProviderRole());
        self::assertNull($items[0]->getProviderShareOfOwnership());
        self::assertSame('KKK', $items[1]->getProviderRole());
        self::assertSame(100.5, $items[1]->getProviderShareOfOwnership());

        // JsonSerializable: {"relationships":[{...},{...}]}
        $json = json_decode(json_encode($result), true);
        self::assertCount(2, $json['relationships']);
        self::assertSame('owner_company', $json['relationships'][0]['relationship_type']);
        self::assertSame('KKK', $json['relationships'][1]['provider_role']);
        self::assertSame(100.5, $json['relationships'][1]['provider_share_of_ownership']);
    }

    public function testReviewBareArrayResponse()
    {
        // Covery actually returns a bare JSON array, not wrapped in "relationships"
        $client = $this->clientReturning([
            [
                'relationship_receiver' => 10,
                'relationship_provider' => 8,
                'relationship_type'     => 'owner_company',
            ],
            [
                'relationship_receiver'       => 5,
                'relationship_provider'       => 6,
                'relationship_type'           => 'related_person',
                'provider_role'               => 'Director',
                'provider_share_of_ownership' => 100.5,
            ],
        ]);

        $result = $client->getRelationships(Builder::reviewQuery(10));

        $items = $result->getRelationships();
        self::assertCount(2, $items);
        self::assertSame(10, $items[0]->getRelationshipReceiver());
        self::assertSame(8, $items[0]->getRelationshipProvider());
        self::assertSame('owner_company', $items[0]->getRelationshipType());
        self::assertSame('Director', $items[1]->getProviderRole());
        self::assertSame(100.5, $items[1]->getProviderShareOfOwnership());

        // still normalizes to {"relationships":[...]} on output
        $json = json_decode(json_encode($result), true);
        self::assertCount(2, $json['relationships']);
    }

    public function testReviewEmptyList()
    {
        $client = $this->clientReturning(['relationships' => []]);
        $result = $client->getRelationships(Builder::reviewQuery(null, 999));
        self::assertSame([], $result->getRelationships());
    }
}
