<?php

use Covery\Client\Relationships\Builder;
use Covery\Client\RelationshipType;
use PHPUnit\Framework\TestCase;

class BuildRelationshipsTest extends TestCase
{
    public function testBuildSingle()
    {
        $result = Builder::create()
            ->addRelationship(1449049571, 1449049572, RelationshipType::OWNER_COMPANY)
            ->build();

        self::assertInstanceOf(\Covery\Client\RelationshipsInterface::class, $result);
        self::assertSame([
            'relationships' => [
                [
                    'relationship_receiver' => 1449049571,
                    'relationship_provider' => 1449049572,
                    'relationship_type' => 'owner_company',
                ],
            ],
        ], $result->toArray());
    }

    public function testBuildMultipleWithOptionalFields()
    {
        $result = Builder::create()
            ->addRelationship(1449049571, 1449049572, RelationshipType::OWNER_COMPANY)
            ->addRelationship(1449049571, 1449049572, RelationshipType::OWNER_COMPANY, 'KKK', 100.00)
            ->build();

        $arr = $result->toArray();
        self::assertCount(2, $arr['relationships']);
        self::assertArrayNotHasKey('provider_role', $arr['relationships'][0]);
        self::assertSame('KKK', $arr['relationships'][1]['provider_role']);
        self::assertSame(100.00, $arr['relationships'][1]['provider_share_of_ownership']);
    }

    public function testRejectsUnknownType()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::create()->addRelationship(1, 2, 'not_a_type');
    }

    public function testRejectsNonPositiveReceiver()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::create()->addRelationship(0, 2, RelationshipType::OWNER_PERSON);
    }

    public function testRejectsNonPositiveProvider()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::create()->addRelationship(1, 0, RelationshipType::OWNER_PERSON);
    }

    public function testRejectsTooLongRole()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::create()->addRelationship(1, 2, RelationshipType::RELATED_PERSON, str_repeat('a', 256));
    }

    public function testRejectsNonNumericShare()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::create()->addRelationship(1, 2, RelationshipType::RELATED_COMPANY, null, 'lots');
    }

    public function testReviewQueryByReceiver()
    {
        $query = Builder::reviewQuery(1449049571);
        self::assertSame(['relationship_receiver' => 1449049571], $query->toArray());
    }

    public function testReviewQueryByProvider()
    {
        $query = Builder::reviewQuery(null, 1449049572);
        self::assertSame(['relationship_provider' => 1449049572], $query->toArray());
    }

    public function testReviewQueryByBoth()
    {
        $query = Builder::reviewQuery(1, 2);
        self::assertSame(['relationship_receiver' => 1, 'relationship_provider' => 2], $query->toArray());
    }

    public function testReviewQueryRequiresAtLeastOne()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::reviewQuery();
    }

    public function testReviewQueryRejectsNonPositive()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::reviewQuery(-1);
    }
}
