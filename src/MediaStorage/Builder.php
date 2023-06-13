<?php

namespace Covery\Client\MediaStorage;


class Builder
{
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var string
     */
    private $contentType;
    /**
     * @var string
     */
    private $contentDescription;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var bool
     */
    private $ocr;

    /**
     * Returns builder for media request
     *
     * @param $contentType
     * @param $contentDescription
     * @param $fileName
     * @param $ocr
     * @return Builder
     */
    public static function mediaStorageEvent($contentType, $contentDescription, $fileName = '', $ocr = false)
    {
        $builder = new self();

        return $builder
            ->addMediaStorageData($contentType, $contentDescription, $fileName, $ocr);
    }

    /**
     * Provides MediaStorage value
     *
     * @param $contentType
     * @param $contentDescription
     * @param $fileName
     * @param $ocr
     * @return Builder
     */
    public function addMediaStorageData($contentType, $contentDescription, $fileName = '', $ocr = false)
    {
        if (!is_string($contentType)) {
            throw new \InvalidArgumentException('Content type must be string');
        }
        if (!is_string($contentDescription)) {
            throw new \InvalidArgumentException('Content Description must be string');
        }
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('File name must be string');
        }
        if (!is_bool($ocr)) {
            throw new \InvalidArgumentException('Ocr must be bool');
        }

        $this->contentType = $contentType;
        $this->contentDescription = $contentDescription;
        $this->fileName = $fileName;
        $this->ocr = $ocr;

        $this->replace('content_type', $contentType);
        $this->replace('content_description', $contentDescription);
        $this->replace('file_name', $fileName);
        $this->replace('ocr', $ocr);

        return $this;
    }

    /**
     * Returns built MediaStorage
     *
     * @return MediaStorage
     */
    public function build()
    {
        return new MediaStorage(
            $this->contentType,
            $this->contentDescription,
            $this->fileName,
            $this->ocr,
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|null $value
     */
    private function replace($key, $value)
    {
        if ($value !== null && $value !== '' && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }
}
