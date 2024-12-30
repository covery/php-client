<?php

use PHPUnit\Framework\TestCase;

class BuildAccountConfigurationStatusTest extends TestCase
{
    public function testRequest()
    {
        $request = new \Covery\Client\Requests\AccountConfigurationStatus();

        self::assertEquals('GET', $request->getMethod());
        self::assertStringContainsString($request->getUri()->getPath(), '/api/accountConfigurationStatus');
    }
}