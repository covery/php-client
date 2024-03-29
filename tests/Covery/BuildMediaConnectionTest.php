<?php

class BuildMediaConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $requestId = 51876931;
        $mediaId = [119961];

        $mediaConnectionResult = \Covery\Client\MediaConnection\Builder::mediaConnectionEvent(
            $requestId,
            $mediaId
        )->build();

        $request = new \Covery\Client\Requests\MediaConnection($mediaConnectionResult);
        self::assertEquals('PUT', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/mediaConnection');
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $request);
        self::assertCount(2, $mediaConnectionResult);
        self::assertSame($mediaId, $mediaConnectionResult['media_id']);
        self::assertSame($requestId, $mediaConnectionResult['request_id']);
        self::assertJson($request->getBody()->getContents());
    }

    public function testEventExpectsInvalidArgumentException()
    {
        $requestId = -1;
        $mediaId = -1;

        self::setExpectedException('InvalidArgumentException');
        \Covery\Client\MediaConnection\Builder::mediaConnectionEvent(
            $requestId,
            $mediaId
        )->build();
    }

    public function testEventExpectsInvalidArgumentExceptionCheckZeroFields()
    {
        $requestId = 0;
        $mediaId = [1, 0, -1];

        self::setExpectedException('InvalidArgumentException');
        \Covery\Client\MediaConnection\Builder::mediaConnectionEvent(
            $requestId,
            $mediaId
        )->build();
    }
}
