<?php

class BuildDocumentConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $requestId = 51876931;
        $documentId = [119961];

        $documentConnectionResult = \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();

        $request = new \Covery\Client\Requests\DocumentConnection($documentConnectionResult);
        self::assertEquals('PUT', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/documentConnection');
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $request);
        self::assertCount(2, $documentConnectionResult);
        self::assertSame($documentId, $documentConnectionResult['document_id']);
        self::assertSame($requestId, $documentConnectionResult['request_id']);
        self::assertJson($request->getBody()->getContents());
    }

    public function testEventExpectsInvalidArgumentException()
    {
        $requestId = -1;
        $documentId = -1;

        self::setExpectedException('InvalidArgumentException');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }

    public function testEventExpectsInvalidArgumentExceptionCheckZeroFields()
    {
        $requestId = 0;
        $documentId = [1, 0, -1];

        self::setExpectedException('InvalidArgumentException');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }
}
