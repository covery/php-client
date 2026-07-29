<?php

namespace Covery\Client\Requests;

use Covery\Client\IndividualProfileInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class IndividualProfile
 *
 * Contains client management individual profile data
 *
 * @package Covery\Client\Requests
 */
class IndividualProfile extends Request
{
    /**
     * @param IndividualProfileInterface $profile
     * @param string $method POST to create, PUT to update
     */
    public function __construct(IndividualProfileInterface $profile, $method = 'POST')
    {
        // Building request
        parent::__construct(
            $method,
            '/api/clientManagement/individualProfile',
            [],
            json_encode($profile->toArray())
        );
    }
}
