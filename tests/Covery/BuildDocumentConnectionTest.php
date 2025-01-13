<?php

use PHPUnit\Framework\TestCase;

class BuildDocumentConnectionTest extends TestCase
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
        self::assertStringContainsString($request->getUri()->getPath(), '/api/documentConnection');
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $request);
        self::assertCount(2, $documentConnectionResult);
        self::assertSame($documentId, $documentConnectionResult['document_id']);
        self::assertSame($requestId, $documentConnectionResult['request_id']);
        self::assertJson($request->getBody()->getContents());
    }

    public function testEventExpectInvalidArgumentExceptionForRequestId()
    {
        $requestId = -1;
        $documentId = -1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Request Id must be positive integer');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }

    public function testEventExpectsInvalidArgumentExceptionCheckZeroFieldsForRequestId()
    {
        $requestId = 0;
        $documentId = [1, 0, -1];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Request Id must be positive integer');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForDocumentId()
    {
        $requestId = 1;
        $documentId = -1;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Document Id must be array');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }

    public function testEventExpectsInvalidArgumentExceptionCheckZeroFieldsForDocumentId()
    {
        $requestId = 1;
        $documentId = [1, 0, -1];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Document Id must be list of positive int');
        \Covery\Client\DocumentConnection\Builder::documentConnectionEvent(
            $requestId,
            $documentId
        )->build();
    }
}
