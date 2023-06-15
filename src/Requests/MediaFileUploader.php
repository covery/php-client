<?php

namespace Covery\Client\Requests;

use Covery\Client\MediaFileUploaderInterface;
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
     * @param MediaFileUploaderInterface $mediaFileUploader
     */
    public function __construct(MediaFileUploaderInterface $mediaFileUploader)
    {
        parent::__construct(
            'PUT',
            $mediaFileUploader['url'],
            [
                'Content-Type' => 'application/octet-stream',
            ],
            $mediaFileUploader['file']
        );
    }
}
