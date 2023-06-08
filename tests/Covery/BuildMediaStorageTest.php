<?php

class BuildMediaStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $contentType = 'image/jpeg';
        $contentDescription = 'personal_photo';
        $fileName = 'passport.jpeg';
        $ocr = false;

        $mediaStorage = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            $contentType,
            $contentDescription,
            $fileName,
            $ocr
        )->build();

        $request = new \Covery\Client\Requests\MediaStorage($mediaStorage);

        self::assertEquals('POST', $request->getMethod());
        self::assertContains($request->getUri()->getPath(), '/api/mediaStorage');
    }
}
