<?php

class BuildCardIdTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cardNumber = "123456789012345";
        $result = \Covery\Client\CardId\Builder::cardIdEvent($cardNumber)->build();
        self::assertCount(1, $result);
        self::assertSame($cardNumber, $result['card_number']);
    }
}
