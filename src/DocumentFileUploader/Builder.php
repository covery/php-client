<?php

namespace Covery\Client\DocumentFileUploader;

use Psr\Http\Message\StreamInterface;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Returns builder for document request
     *
     * @param $url
     * @param $file
     * @return Builder
     */
    public static function documentFileUploaderEvent($url, $file)
    {
        $builder = new self();

        return $builder
            ->addDocumentFileUploaderData($url, $file);
    }

    /**
     * Provides Upload data value
     *
     * @param $url
     * @param $file
     * @return Builder
     */
    public function addDocumentFileUploaderData($url, $file)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Url must be string');
        }
        if (empty($url)) {
            throw new \InvalidArgumentException('URL is empty');
        }

        if (!($file instanceof StreamInterface)) {
            throw new \InvalidArgumentException('File must be instance of StreamInterface');
        }

        $this->replace('url', $url);
        $this->replace('file', $file);

        return $this;
    }

    /**
     * Returns built DocumentFileUploader
     *
     * @return DocumentFileUploader
     */
    public function build()
    {
        return new DocumentFileUploader(
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|array|null $value
     */
    private function replace($key, $value)
    {
        if ($value !== null && $value !== '' && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }
}
