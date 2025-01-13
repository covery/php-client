<?php

use PHPUnit\Framework\TestCase;

class BuildCardIdTest extends TestCase
{
    public function testBuild()
    {
        $cardNumber = "123456789012345";
        $result = \Covery\Client\CardId\Builder::cardIdEvent($cardNumber)->build();
        self::assertCount(1, $result);
        self::assertSame($cardNumber, $result['card_number']);
    }
}
