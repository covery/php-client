<?php

namespace Covery\Client\MediaStorage;

use Covery\Client\ContentDescription;
use Covery\Client\ContentType;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Returns builder for media request
     *
     * @param $contentType
     * @param $contentDescription
     * @param $fileName
     * @param $ocr
     * @return Builder
     */
    public static function mediaStorageEvent($contentType, $contentDescription, $fileName = null, $ocr = false)
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
    public function addMediaStorageData($contentType, $contentDescription, $fileName = null, $ocr = false)
    {
        if (!is_string($contentType)) {
            throw new \InvalidArgumentException('Content type must be a string');
        }
        if (empty($contentType)) {
            throw new \InvalidArgumentException('Content type is empty');
        }
        if (!in_array($contentType, ContentType::getAll())) {
            throw new \InvalidArgumentException('Content type must be one of the types: ' . implode(
                    ', ',
                    ContentType::getAll()
                )
            );
        }

        if (!is_string($contentDescription)) {
            throw new \InvalidArgumentException('Content description must be string');
        }
        if (empty($contentDescription)) {
            throw new \InvalidArgumentException('Content description is empty');
        }
        if (!in_array($contentDescription, ContentDescription::getAll())) {
            throw new \InvalidArgumentException('Content description must be one of the types: ' . implode(
                    ', ',
                    ContentDescription::getAll()
                )
            );
        }

        if (!empty($fileName)) {
            if (!is_string($fileName)) {
                throw new \InvalidArgumentException('File name is empty');
            }
            if(strlen($fileName) > 255) {
                throw new \InvalidArgumentException('File name must contain no more than 255 characters');
            }
        }

        if (!is_bool($ocr)) {
            throw new \InvalidArgumentException('OCR must be boolean');
        }
        if ($ocr && !in_array($contentType, ContentType::getOCRAllowed())) {
            throw new \InvalidArgumentException('Allowed Content type for OCR: ' . implode(
                    ', ',
                    ContentType::getOCRAllowed()
                )
            );
        }

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
