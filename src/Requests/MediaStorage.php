<?php

namespace Covery\Client\Requests;

use Covery\Client\MediaStorageInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class MediaStorage
 *
 * Contains Media data
 *
 * @package Covery\Client\Requests
 */
class MediaStorage extends Request
{
    /**
     * @param MediaStorageInterface $media
     */
    public function __construct(MediaStorageInterface $media)
    {
        // Building request
        parent::__construct(
            'POST',
            '/api/mediaStorage',
            array(),
            json_encode($media->toArray())
        );
    }
}
