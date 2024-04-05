<?php

namespace Covery\Client\Requests;

use Covery\Client\DocumentStorageInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class DocumentStorage
 *
 * Contains Document data
 *
 * @package Covery\Client\Requests
 */
class DocumentStorage extends Request
{
    /**
     * @param DocumentStorageInterface $document
     */
    public function __construct(DocumentStorageInterface $document)
    {
        // Building request
        parent::__construct(
            'POST',
            '/api/documentStorage',
            [],
            json_encode($document->toArray())
        );
    }
}
