<?php

namespace Covery\Client\Requests;

use Covery\Client\EntityProfileInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class EntityProfile
 *
 * Contains client management entity profile data
 *
 * @package Covery\Client\Requests
 */
class EntityProfile extends Request
{
    /**
     * @param EntityProfileInterface $profile
     * @param string $method POST to create, PUT to update
     */
    public function __construct(EntityProfileInterface $profile, $method = 'POST')
    {
        // Building request
        parent::__construct(
            $method,
            '/api/clientManagement/entityProfile',
            [],
            json_encode($profile->toArray())
        );
    }
}
