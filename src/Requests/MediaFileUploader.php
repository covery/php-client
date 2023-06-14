<?php

namespace Covery\Client\Requests;

use GuzzleHttp\Psr7\Request;

/**
 * Class MediaFileUploader
 *
 * Upload Media file
 *
 * @package Covery\Client\Requests
 */
class MediaFileUploader extends Request
{
    /**
     * @param $url
     * @param $file
     */
    public function __construct($url, $file)
    {
        parent::__construct(
            'PUT',
            $url,
            [
                'Content-Type' => 'application/octet-stream',
            ],
            $file
        );
    }
}
