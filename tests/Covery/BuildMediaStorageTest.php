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

    public function testBuildFileLengthException()
    {
        $fileNameWith256Symbols = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque consectetur doloremque ducimus est eum hic illum incidunt, labore, minus optio reiciendis totam velit vero. Animi asperiores autem consequuntur cupiditate deleniti dignissimos dolor dolore doloribus eaque esse, et, eum facere facilis id illo impedit iusto laborum magni molestias nemo nihil nobis nulla, omnis perferendis quam quasi qui quia sint sit suscipit tempora tempore ullam veniam veritatis vitae voluptatem voluptates. A aliquid aspernatur autem blanditiis consequatur cum dolores, eligendi inventore ipsa libero necessitatibus nisi, odit praesentium repellat repellendus unde voluptatum? Beatae est facilis magni odio optio. Ab accusamus asperiores autem consequuntur debitis dolor dolorum, ducimus est eum excepturi fugiat fugit neque nihil nobis, non obcaecati perferendis quaerat quasi quo reiciendis sapiente similique sint tempore tenetur ullam veniam vitae! Adipisci atque aut consequuntur ea eligendi illo impedit incidunt ipsa, laborum laudantium modi odit officiis pariatur porro quaerat qui similique suscipit tempora tempore temporibus. Aperiam at cupiditate dolorum eius et explicabo fuga ipsum libero maxime minus necessitatibus neque pariatur reiciendis, rem sint sit unde velit voluptates? Consequatur dolor dolores doloribus eaque earum et excepturi incidunt inventore iste laboriosam minima mollitia nobis odio, officiis perspiciatis quia recusandae rerum saepe sed soluta tempora totam voluptatibus. Ad aperiam commodi expedita facere ipsam iste laboriosam obcaecati perferendis, quam quidem repellendus rerum totam voluptate. Ab aliquam amet atque autem, fugiat maxime mollitia odit, praesentium quibusdam, ratione repellendus suscipit. Asperiores consequatur exercitationem iusto nesciunt nulla? Dolorum earum ipsum, nostrum provident totam ullam voluptatibus. Ad animi, asperiores atque delectus dolore dolorem facere harum ipsam maiores natus nihil non officiis, perferendis repellendus repudiandae sed similique tempore vero vitae?';

        self::setExpectedException('InvalidArgumentException');
        $mediaStorage = \Covery\Client\MediaStorage\Builder::mediaStorageEvent(
            \Covery\Client\ContentType::PNG,
            \Covery\Client\ContentDescription::GENERAL_DOCUMENT,
            $fileNameWith256Symbols,
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
}
