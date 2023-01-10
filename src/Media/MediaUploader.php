<?php

namespace Covery\Client\Media;

use Covery\Client\Requests\MediaStorageUploadStream;
use Covery\Client\Transport\Curl;
use GuzzleHttp\Psr7\Response;

class MediaUploader
{
    /**
     * @param $url
     * @param $content
     * @param $filename
     * @return Response
     * @throws \Covery\Client\IoException
     * @throws \Covery\Client\TimeoutException
     */
    public function uploadFile($url, $content, $filename)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Url must be string');
        }

        if (!is_string($content)) {
            throw new \InvalidArgumentException('Content must be string');
        }

        $transport = new Curl(60);
        return $transport->send(new MediaStorageUploadStream($url, $content, $filename));
    }
}
