<?php

namespace Covery\Client\DocumentStorage;

use Covery\Client\DocumentType;
use Covery\Client\ContentType;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Returns builder for document request
     *
     * @param string $userId
     * @param string $documentType
     * @param string|null $documentCountry
     * @param string|null $sequenceId
     * @param string|null $groupId
     * @param string|null $fileName
     * @param bool|null $ocr
     * @param int|null $numberOfPages
     * @param string|null $translatedFrom
     * @param string|null $translatedTo
     * 
     * @return Builder
     */
    public static function documentStorageEvent(
        $userId,
        $documentType,
        $documentCountry = null,
        $sequenceId = null,
        $groupId = null,
        $fileName = null,
        $ocr = false,
        $numberOfPages = 1,
        $translatedFrom = null,
        $translatedTo = null
    ) {
        $builder = new self();

        return $builder
            ->addDocumentStorageData(
                $userId,
                $documentType,
                $documentCountry,
                $sequenceId,
                $groupId,
                $fileName,
                $ocr,
                $numberOfPages,
                $translatedFrom,
                $translatedTo
            );
    }

    /**
     * Provides DocumentStorage value
     *
     * @param string $userId
     * @param string $documentType
     * @param string|null $documentCountry
     * @param string|null $sequenceId
     * @param string|null $groupId
     * @param string|null $fileName
     * @param bool|null $ocr
     * @param int|null $numberOfPages
     * @param string|null $translatedFrom
     * @param string|null $translatedTo
     * 
     * @return Builder
     */
    public function addDocumentStorageData(
        $userMerchantId,
        $documentType,
        $documentCountry = null,
        $sequenceId = null,
        $groupId = null,
        $fileName = null,
        $ocr = false,
        $numberOfPages = 1,
        $translatedFrom = null,
        $translatedTo = null
    ) {
        if (!is_string($userMerchantId)) {
            throw new \InvalidArgumentException('User Merchant Id must be string');
        }
        if (empty($userMerchantId)) {
            throw new \InvalidArgumentException('User Merchant Id type is empty');
        }

        if (!is_string($documentType)) {
            throw new \InvalidArgumentException('Document Type must be a string');
        }
        if (empty($documentType)) {
            throw new \InvalidArgumentException('Document Type is empty');
        }
        if (!in_array($documentType, DocumentType::getAll())) {
            throw new \InvalidArgumentException('Document Type must be one of the types: ' . implode(
                    ', ',
                    DocumentType::getAll()
                )
            );
        }

        if ($documentCountry !== null && !is_string($documentCountry)) {
            throw new \InvalidArgumentException('Document Country Id must be string');
        }

        if ($sequenceId !== null && !is_string($sequenceId)) {
            throw new \InvalidArgumentException('Sequence Id must be string');
        }

        if ($groupId !== null && !is_string($groupId)) {
            throw new \InvalidArgumentException('Group Id must be string');
        }

        if (!empty($fileName)) {
            if (!is_string($fileName)) {
                throw new \InvalidArgumentException('File name is empty');
            }
            if (strlen($fileName) > 255) {
                throw new \InvalidArgumentException('File name must contain no more than 255 characters');
            }
        }

        if (!is_bool($ocr)) {
            throw new \InvalidArgumentException('OCR must be boolean');
        }

        if (!is_int($numberOfPages)) {
            throw new \InvalidArgumentException('Number Of Pages must be int');
        }

        if ($translatedFrom !== null && !is_string($translatedFrom)) {
            throw new \InvalidArgumentException('Translated From must be string');
        }

        if ($translatedTo !== null && !is_string($translatedTo)) {
            throw new \InvalidArgumentException('Translated To must be string');
        }

        $this->replace('user_merchant_id', $userMerchantId);
        $this->replace('document_type', $documentType);
        $this->replace('document_country', $documentCountry);
        $this->replace('sequence_id', $sequenceId);
        $this->replace('group_id', $groupId);
        $this->replace('file_name', $fileName);
        $this->replace('ocr', $ocr);
        $this->replace('number_of_pages', $numberOfPages);
        $this->replace('translated_from', $translatedFrom);
        $this->replace('translated_to', $translatedTo);

        return $this;
    }

    /**
     * Returns built DocumentStorage
     *
     * @return DocumentStorage
     */
    public function build()
    {
        return new DocumentStorage(
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
