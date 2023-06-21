<?php

class BuildAccountConfigurationStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = new \Covery\Client\Requests\AccountConfigurationStatus();

        self::assertEquals('GET', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/accountConfigurationStatus');
    }
}