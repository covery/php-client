<?php

class BuildMediaStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $contentType = \Covery\Client\ContentType::PNG;
        $contentDescription = \Covery\Client\ContentDescription::PERSONAL_PHOTO;
        $fileName = 'passport.jpeg';
        $ocr = false;

        $mediaStorageResult = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            $contentType,
            $contentDescription,
            $fileName,
            $ocr
        )->build();

        $request = new \Covery\Client\Requests\MediaStorage($mediaStorageResult);

        self::assertEquals('POST', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/mediaStorage');
        self::assertInstanceOf('Psr\Http\Message\RequestInterface', $request);
        self::assertCount(4, $mediaStorageResult);
        self::assertSame($contentType, $mediaStorageResult['content_type']);
        self::assertSame($contentDescription, $mediaStorageResult['content_description']);
        self::assertSame($fileName, $mediaStorageResult['file_name']);
        self::assertSame($ocr, $mediaStorageResult['ocr']);
        self::assertJson($request->getBody()->getContents());
    }

    public function testBuildExpectsInvalidArgumentFileName()
    {
        self::setExpectedException('InvalidArgumentException');
        $mediaStorage = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            \Covery\Client\ContentType::PNG,
            \Covery\Client\ContentDescription::GENERAL_DOCUMENT,
            $this->generateRandomString(256),
            false
        )->build();
    }

    public function testEventExpectsInvalidArgumentException()
    {
        self::setExpectedException('InvalidArgumentException');
        $mediaStorage = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            'Unique content type',
            'Unique content description',
            null,
            false
        )->build();
    }
    public function testEmptyFileNameIsValidString()
    {
        $mediaStorage = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            \Covery\Client\ContentType::PNG,
            \Covery\Client\ContentDescription::GENERAL_DOCUMENT,
            null,
            false
        )->build();
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
