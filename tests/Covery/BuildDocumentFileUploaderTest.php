<?php

use PHPUnit\Framework\TestCase;

class BuildDocumentFileUploaderTest extends TestCase
{
    public function testBuild()
    {
        $testString = 'Test file content';
        $stream = fopen('data://text/plain,' . $testString, 'r');
        $documentUrl = 'https://covery.devafenv.net/media/v1/1/1';
        $fileStream = new \GuzzleHttp\Psr7\Stream($stream);
        $documentStorageResult = \Covery\Client\DocumentFileUploader\Builder::documentFileUploaderEvent(
            $documentUrl,
            $fileStream
        )->build();

        self::assertSame($documentUrl, $documentStorageResult['url']);
        self::assertInstanceOf('Psr\Http\Message\StreamInterface', $documentStorageResult['file']);
        self::assertEquals($fileStream, $documentStorageResult['file']);
        self::assertSame($testString, (string)$fileStream);
    }
}
