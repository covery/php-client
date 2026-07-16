<?php

namespace Covery\Client;

/**
 * Class RelationshipResultItem
 *
 * Single relationship entry received from Covery
 *
 * @package Covery\Client
 */
class RelationshipResultItem implements \JsonSerializable
{
    /**
     * @var int
     */
    private $relationshipReceiver;

    /**
     * @var int
     */
    private $relationshipProvider;

    /**
     * @var string
     */
    private $relationshipType;

    /**
     * @var string|null
     */
    private $providerRole;

    /**
     * @var float|null
     */
    private $providerShareOfOwnership;

    /**
     * RelationshipResultItem constructor.
     *
     * @param int $relationshipReceiver
     * @param int $relationshipProvider
     * @param string $relationshipType
     * @param string|null $providerRole
     * @param float|null $providerShareOfOwnership
     */
    public function __construct(
        $relationshipReceiver,
        $relationshipProvider,
        $relationshipType,
        $providerRole = null,
        $providerShareOfOwnership = null
    ) {
        if (!is_int($relationshipReceiver)) {
            throw new \InvalidArgumentException('Relationship receiver must be int');
        }
        if (!is_int($relationshipProvider)) {
            throw new \InvalidArgumentException('Relationship provider must be int');
        }
        if (!is_string($relationshipType)) {
            throw new \InvalidArgumentException('Relationship type must be string');
        }
        if (!empty($providerRole) && !is_string($providerRole)) {
            throw new \InvalidArgumentException('Provider role must be string');
        }
        if (!empty($providerShareOfOwnership) && !is_int($providerShareOfOwnership) && !is_float($providerShareOfOwnership)) {
            throw new \InvalidArgumentException('Provider share of ownership must be float');
        }

        $this->relationshipReceiver = $relationshipReceiver;
        $this->relationshipProvider = $relationshipProvider;
        $this->relationshipType = $relationshipType;
        $this->providerRole = $providerRole;
        $this->providerShareOfOwnership = $providerShareOfOwnership;
    }

    /**
     * @return int
     */
    public function getRelationshipReceiver()
    {
        return $this->relationshipReceiver;
    }

    /**
     * @return int
     */
    public function getRelationshipProvider()
    {
        return $this->relationshipProvider;
    }

    /**
     * @return string
     */
    public function getRelationshipType()
    {
        return $this->relationshipType;
    }

    /**
     * @return string|null
     */
    public function getProviderRole()
    {
        return $this->providerRole;
    }

    /**
     * @return float|null
     */
    public function getProviderShareOfOwnership()
    {
        return $this->providerShareOfOwnership;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            'relationship_receiver'       => $this->relationshipReceiver,
            'relationship_provider'       => $this->relationshipProvider,
            'relationship_type'           => $this->relationshipType,
            'provider_role'               => $this->providerRole,
            'provider_share_of_ownership' => $this->providerShareOfOwnership,
        ];
    }
}
