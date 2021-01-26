<?php

class BuildKycProofEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $kycStartId = 1234567890;
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        $result = \Covery\Client\Envelopes\Builder::kycProofEvent($kycStartId)->build();

        self::assertSame('kyc_proof', $result->getType());
        self::assertCount(1, $result);
        self::assertSame($kycStartId, $result['kyc_start_id']);
        $validator->validate($result);
    }
}
