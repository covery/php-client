<?php

use \Covery\Client\Envelopes\Builder;
use Covery\Client\Envelopes\ValidatorV1;
use PHPUnit\Framework\TestCase;

class BuildKycProofEventTest extends TestCase
{
    public function testBuild()
    {
        $kycStartId = 1234567890;
        $validator = new ValidatorV1();

        $result = Builder::kycProofEvent($kycStartId)->build();

        self::assertSame(Builder::EVENT_KYC_PROOF, $result->getType());
        self::assertCount(1, $result);
        self::assertSame($kycStartId, $result['kyc_start_id']);
        $validator->validate($result);
    }
}
