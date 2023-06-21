<?php

namespace Covery\Client\Requests;

use Covery\Client\MediaConnectionInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class MediaConnection
 *
 * Contains Media data
 *
 * @package Covery\Client\Requests
 */
class MediaConnection extends Request
{
    /**
     * @param MediaConnectionInterface $media
     * @param string $method
     */
    public function __construct(MediaConnectionInterface $media, $method = 'PUT')
    {
        // Building request
        parent::__construct(
            $method,
            '/api/mediaConnection',
            [],
            json_encode($media->toArray())
        );
    }
}
