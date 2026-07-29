<?php

namespace Covery\Client\Requests;

use Covery\Client\RelationshipsInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class Relationships
 *
 * Contains client management relationships data
 *
 * @package Covery\Client\Requests
 */
class Relationships extends Request
{
    /**
     * @param RelationshipsInterface $relationships
     * @param string $method PUT to create/change, DELETE to delete
     */
    public function __construct(RelationshipsInterface $relationships, $method = 'PUT')
    {
        // Building request
        parent::__construct(
            $method,
            '/api/clientManagement/relationships',
            [],
            json_encode($relationships->toArray())
        );
    }
}
