<?php

namespace Covery\Client;

/**
 * Class RelationshipsResult
 *
 * Contains relationships review result data, received from Covery
 *
 * @package Covery\Client
 */
class RelationshipsResult implements \JsonSerializable
{
    /**
     * @var RelationshipResultItem[]
     */
    private $relationships = [];

    /**
     * RelationshipsResult constructor.
     *
     * @param array $data Decoded response body
     */
    public function __construct(array $data)
    {
        // Covery may return either a wrapped object {"relationships": [...]}
        // or a bare JSON array [...] of relationship entries.
        if (isset($data[RelationshipsResultBaseField::RELATIONSHIPS])) {
            $list = $data[RelationshipsResultBaseField::RELATIONSHIPS];
        } else {
            $list = $data;
        }

        if (!is_array($list)) {
            throw new \InvalidArgumentException('Relationships must be array');
        }

        foreach ($list as $relationship) {
            if (!is_array($relationship)) {
                throw new \InvalidArgumentException('Relationship must be array');
            }

            $this->relationships[] = new RelationshipResultItem(
                isset($relationship[RelationshipsResultBaseField::RELATIONSHIP_RECEIVER]) ? $relationship[RelationshipsResultBaseField::RELATIONSHIP_RECEIVER] : null,
                isset($relationship[RelationshipsResultBaseField::RELATIONSHIP_PROVIDER]) ? $relationship[RelationshipsResultBaseField::RELATIONSHIP_PROVIDER] : null,
                isset($relationship[RelationshipsResultBaseField::RELATIONSHIP_TYPE]) ? $relationship[RelationshipsResultBaseField::RELATIONSHIP_TYPE] : null,
                isset($relationship[RelationshipsResultBaseField::PROVIDER_ROLE]) ? $relationship[RelationshipsResultBaseField::PROVIDER_ROLE] : null,
                isset($relationship[RelationshipsResultBaseField::PROVIDER_SHARE_OF_OWNERSHIP]) ? $relationship[RelationshipsResultBaseField::PROVIDER_SHARE_OF_OWNERSHIP] : null
            );
        }
    }

    /**
     * @return RelationshipResultItem[]
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            RelationshipsResultBaseField::RELATIONSHIPS => $this->relationships,
        ];
    }
}
