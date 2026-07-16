<?php

namespace Covery\Client\ClientProfile;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Returns builder for client profile request (POST).
     * Requires client_profile_id.
     *
     * @param int $clientProfileId Internal Covery profile id
     * @return Builder
     */
    public static function clientProfileEvent($clientProfileId)
    {
        if (!is_int($clientProfileId)) {
            throw new \InvalidArgumentException('Client profile id must be integer');
        }
        if ($clientProfileId <= 0) {
            throw new \InvalidArgumentException('Client profile id must be positive integer');
        }

        $builder = new self();
        $builder->data['client_profile_id'] = $clientProfileId;

        return $builder;
    }

    /**
     * Returns built ClientProfile
     *
     * @return ClientProfile
     */
    public function build()
    {
        return new ClientProfile(
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }
}
