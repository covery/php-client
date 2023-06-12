<?php

namespace Covery\Client;

use Covery\Client\Transport\Curl;
use Covery\Client\Requests\MediaFileUploader as MediaFileUploaderRequest;

class MediaFileUploader
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $file;

    public function __construct($url, $file)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Url must be string');
        }

        if (!is_resource($file)) {
            throw new \InvalidArgumentException('File must be resource');
        }

        $this->url = $url;
        $this->file = $file;
    }

    /**
     * Upload media file
     *
     * @return int
     * @throws Exception
     * @throws IoException
     * @throws TimeoutException
     */
    public function upload()
    {
        $connectionTimeout = 60;
        $transport = new Curl($connectionTimeout);
        $response = $transport->send(new MediaFileUploaderRequest($this->url, $this->file));
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 300) {
            $response = json_decode($response->getBody()->getContents());
            throw new Exception($response->message, $response->code);
        }

        return $statusCode;
    }
}
