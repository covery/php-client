<?php

namespace Covery\Client\Requests;

use Covery\Client\DocumentFileUploaderInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class DocumentFileUploader
 *
 * Upload Document file
 *
 * @package Covery\Client\Requests
 */
class DocumentFileUploader extends Request
{
    /**
     * @param DocumentFileUploaderInterface $documentFileUploader
     */
    public function __construct(DocumentFileUploaderInterface $documentFileUploader)
    {
        parent::__construct(
            'PUT',
            $documentFileUploader['url'],
            [
                'Content-Type' => 'application/octet-stream',
            ],
            $documentFileUploader['file']
        );
    }
}
