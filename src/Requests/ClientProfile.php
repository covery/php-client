<?php

namespace Covery\Client\Requests;

use Covery\Client\ClientProfileInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class ClientProfile
 *
 * Contains client management client profile request data
 *
 * @package Covery\Client\Requests
 */
class ClientProfile extends Request
{
    /**
     * @param ClientProfileInterface $profile
     */
    public function __construct(ClientProfileInterface $profile)
    {
        // Building request
        parent::__construct(
            'POST',
            '/api/clientManagement/clientProfile',
            [],
            json_encode($profile->toArray())
        );
    }
}
