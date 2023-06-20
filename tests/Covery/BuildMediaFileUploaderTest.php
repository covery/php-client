<?php

class BuildMediaFileUploaderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $testString = 'Test file content';
        $stream = fopen('data://text/plain,' . $testString, 'r');
        $mediaUrl = 'https://covery.devafenv.net/media/v1/1/1';
        $fileStream = new \GuzzleHttp\Psr7\Stream($stream);
        $mediaStorageResult = \Covery\Client\MediaFileUploader\Builder::mediaFileUploaderEvent(
            $mediaUrl,
            $fileStream
        )->build();

        self::assertSame($mediaUrl, $mediaStorageResult['url']);
        self::assertInstanceOf('Psr\Http\Message\StreamInterface', $mediaStorageResult['file']);
        self::assertEquals($fileStream, $mediaStorageResult['file']);
        self::assertSame($testString, (string)$fileStream);
    }
}
