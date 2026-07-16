<?php

use Covery\Client\ClientProfile\Builder;
use PHPUnit\Framework\TestCase;

class BuildClientProfileTest extends TestCase
{
    public function testBuild()
    {
        $result = Builder::clientProfileEvent(987654321)->build();

        self::assertInstanceOf(\Covery\Client\ClientProfileInterface::class, $result);
        self::assertCount(1, $result);
        self::assertSame(987654321, $result['client_profile_id']);
    }

    public function testRequiresIntClientProfileId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::clientProfileEvent('not-an-int');
    }

    public function testRequiresPositiveClientProfileId()
    {
        $this->expectException(\InvalidArgumentException::class);
        Builder::clientProfileEvent(0);
    }
}
