<?php

namespace Covery\Client\Requests;

use GuzzleHttp\Psr7\Request;

/**
 * Class MediaFileUploaderRequest
 *
 * Upload Media file
 *
 * @package Covery\Client\Requests
 */
class MediaFileUploader extends Request
{
    /**
     * @param $url
     * @param $filePath
     */
    public function __construct($url, $filePath)
    {
        $resourceFileText = file_get_contents($filePath);

        parent::__construct(
            'PUT',
            $url,
            [
                'Content-Type' => 'application/octet-stream',
            ],
            $resourceFileText
        );
    }
}
