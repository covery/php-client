<?php

class BuildCardIdTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cardNumber = "123456789012345";
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        $result = \Covery\Client\Envelopes\Builder::cardIdEvent($cardNumber)->build();

        self::assertSame('card_id', $result->getType());
        self::assertCount(1, $result);
        self::assertSame($cardNumber, $result['card_number']);
        $validator->validate($result);
    }
}
