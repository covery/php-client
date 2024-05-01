<?php

namespace Covery\Client\DocumentConnection;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Returns builder for document request
     *
     * @param $requestId
     * @param $documentId
     * @return Builder
     */
    public static function documentConnectionEvent($requestId, $documentId)
    {
        $builder = new self();

        return $builder
            ->addConnectionData($requestId, $documentId);
    }

    /**
     * Provides DocumentConnection value
     *
     * @param $requestId
     * @param $documentId
     * @return Builder
     */
    public function addConnectionData($requestId, $documentId)
    {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request Id must be integer');
        }
        if ($requestId <= 0) {
            throw new \InvalidArgumentException('Request Id must be positive integer');
        }
        if (!is_array($documentId)) {
            throw new \InvalidArgumentException('Document Id must be array');
        }
        if (!$this->isListOfPositiveInt($documentId)) {
            throw new \InvalidArgumentException('Document Id must be list of positive int');
        }

        $this->replace('request_id', $requestId);
        $this->replace('document_id', $documentId);

        return $this;
    }

    /**
     * Returns built DocumentConnection
     *
     * @return DocumentConnection
     */
    public function build()
    {
        return new DocumentConnection(
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

    /**
     * @param array $ids
     * @return bool
     */
    private function isListOfPositiveInt(array $ids)
    {
        foreach ($ids as $id) {
            if (!is_int($id) || $id <= 0) {
                return false;
            }
        }

        return true;
    }
}
