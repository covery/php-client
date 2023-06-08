<?php

class BuildMediaConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $requestId = 51876931;
        $mediaId = [119961];

        $mediaConnection = \Covery\Client\MediaConnection\Builder::mediaConnectionEvent(
            $requestId,
            $mediaId
        )->build();

        $request = new \Covery\Client\Requests\MediaConnection($mediaConnection);
        self::assertEquals('PUT', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/mediaConnection');
    }
}
