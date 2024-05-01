<?php

namespace Covery\Client\Requests;

use Covery\Client\DocumentConnectionInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class DocumentConnection
 *
 * Contains Document data
 *
 * @package Covery\Client\Requests
 */
class DocumentConnection extends Request
{
    /**
     * @param DocumentConnectionInterface $document
     * @param string $method
     */
    public function __construct(DocumentConnectionInterface $document, $method = 'PUT')
    {
        // Building request
        parent::__construct(
            $method,
            '/api/documentConnection',
            [],
            json_encode($document->toArray())
        );
    }
}
