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
        $this->assertString($userMerchantId, 'User Merchant Id must be string');
        if (empty($userMerchantId)) {
            throw new \InvalidArgumentException('User Merchant Id type is empty');
        }

        $this->assertString($documentType, 'Document Type must be a string');
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

        $this->assertOptionalString($documentCountry, 'Document Country Id must be string');
        $this->assertOptionalString($sequenceId, 'Sequence Id must be string');
        $this->assertOptionalString($groupId, 'Group Id must be string');

        if (!empty($fileName)) {
            if (!is_string($fileName)) {
                throw new \InvalidArgumentException('File name is empty');
            }
            if (strlen($fileName) > 255) {
                throw new \InvalidArgumentException('File name must contain no more than 255 characters');
            }
        }

        $this->assertBool($ocr, 'OCR must be boolean');
        $this->assertInt($numberOfPages, 'Number Of Pages must be int');

        $this->assertOptionalString($translatedFrom, 'Translated From must be string');
        $this->assertOptionalString($translatedTo, 'Translated To must be string');

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

    private function assertString($value, $message)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertOptionalString($value, $message)
    {
        if ($value !== null && !is_string($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertBool($value, $message)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertInt($value, $message)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
