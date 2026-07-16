<?php

namespace Covery\Client\Relationships;

use Covery\Client\RelationshipType;

class Builder
{
    /**
     * @var array
     */
    private $relationships = [];

    /**
     * Returns new relationships builder
     *
     * @return Builder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Adds a single relationship between two client profiles
     *
     * @param int $relationshipReceiver clientProfileId of relationship receiver
     * @param int $relationshipProvider clientProfileId of relationship provider
     * @param string $relationshipType One of RelationshipType::getAll()
     * @param string|null $providerRole
     * @param float|null $providerShareOfOwnership
     * @return Builder
     */
    public function addRelationship(
        $relationshipReceiver,
        $relationshipProvider,
        $relationshipType,
        $providerRole = null,
        $providerShareOfOwnership = null
    ) {
        if (!is_int($relationshipReceiver) || $relationshipReceiver <= 0) {
            throw new \InvalidArgumentException('Relationship receiver must be positive integer');
        }
        if (!is_int($relationshipProvider) || $relationshipProvider <= 0) {
            throw new \InvalidArgumentException('Relationship provider must be positive integer');
        }
        if (!is_string($relationshipType) || !in_array($relationshipType, RelationshipType::getAll(), true)) {
            throw new \InvalidArgumentException(sprintf(
                'Relationship type must be one of: %s',
                implode(', ', RelationshipType::getAll())
            ));
        }
        if ($providerRole !== null) {
            if (!is_string($providerRole)) {
                throw new \InvalidArgumentException('Provider role must be string');
            }
            if (strlen($providerRole) > 255) {
                throw new \InvalidArgumentException('Provider role is too long, max 255 bytes allowed');
            }
        }
        if ($providerShareOfOwnership !== null && !is_int($providerShareOfOwnership) && !is_float($providerShareOfOwnership)) {
            throw new \InvalidArgumentException('Provider share of ownership must be float');
        }

        $relationship = [
            'relationship_receiver' => $relationshipReceiver,
            'relationship_provider' => $relationshipProvider,
            'relationship_type' => $relationshipType,
        ];
        if ($providerRole !== null && $providerRole !== '') {
            $relationship['provider_role'] = $providerRole;
        }
        if ($providerShareOfOwnership !== null) {
            $relationship['provider_share_of_ownership'] = $providerShareOfOwnership;
        }

        $this->relationships[] = $relationship;

        return $this;
    }

    /**
     * Returns built Relationships
     *
     * @return Relationships
     */
    public function build()
    {
        return new Relationships(['relationships' => $this->relationships]);
    }

    /**
     * Builds a review query packet (POST). At least one of receiver/provider is required.
     *
     * @param int|null $relationshipReceiver clientProfileId of relationship receiver
     * @param int|null $relationshipProvider clientProfileId of relationship provider
     * @return Relationships
     */
    public static function reviewQuery($relationshipReceiver = null, $relationshipProvider = null)
    {
        $data = [];
        if ($relationshipReceiver !== null) {
            if (!is_int($relationshipReceiver) || $relationshipReceiver <= 0) {
                throw new \InvalidArgumentException('Relationship receiver must be positive integer');
            }
            $data['relationship_receiver'] = $relationshipReceiver;
        }
        if ($relationshipProvider !== null) {
            if (!is_int($relationshipProvider) || $relationshipProvider <= 0) {
                throw new \InvalidArgumentException('Relationship provider must be positive integer');
            }
            $data['relationship_provider'] = $relationshipProvider;
        }
        if (empty($data)) {
            throw new \InvalidArgumentException('At least one of relationship receiver or provider is required');
        }

        return new Relationships($data);
    }
}
