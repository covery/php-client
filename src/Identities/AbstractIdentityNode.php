<?php

namespace Covery\Client\Identities;

use Covery\Client\IdentityNodeInterface;

/**
 * Class AbstractIdentityNode
 *
 * AbstractIdentityNode is template for identities usage
 * You must extend it and hardcode type before usage, for example:
 *
 * class WebsiteIdentity extends AbstractIdentityNode
 * {
 *   public function __construct($id)
 *   {
 *      parent::__construct("website", $id);
 *   }
 * }
 *
 * @package Covery\Client
 */
abstract class AbstractIdentityNode implements IdentityNodeInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $id;

    /**
     * AbstractIdentityNode constructor.
     *
     * @param string $type
     * @param int $id
     */
    public function __construct($type, $id)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException('Identity node type must be string');
        } elseif ($type === '') {
            throw new \InvalidArgumentException('Identity node type must be not empty');
        }

        if (!is_int($id)) {
            throw new \InvalidArgumentException('Identity node ID must be integer');
        } elseif ($id < 1) {
            throw new \InvalidArgumentException('Identity node ID must be positive non-zero integer');
        }

        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Returns Identity type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns Identity id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns string representation of identity
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Identity %s=%d',
            $this->getType(),
            $this->getId()
        );
    }
}
