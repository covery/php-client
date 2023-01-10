<?php

namespace Covery\Client\Requests;

use GuzzleHttp\Psr7\Request;

class MediaStorageUploadStream extends Request
{
    public function __construct(string $url, string $stream, string $filename)
    {
        parent::__construct(
            'PUT',
            $url,
            array(
                'content_type' => 'application/octet-stream',
                'fileName' => $filename
            ),
            $stream
        );
    }
}
