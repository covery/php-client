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
    private $filePath;

    public function __construct($url, $filePath)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Url must be string');
        }

        if (!is_string($filePath)) {
            throw new \InvalidArgumentException('File path must be string');
        }

        $this->url = $url;
        $this->filePath = $filePath;
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
        $response = $transport->send(new MediaFileUploaderRequest($this->url, $this->filePath));
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 300) {
            $response = json_decode($response->getBody()->getContents());
            throw new Exception($response->message, $response->code);
        }

        return $statusCode;
    }
}
