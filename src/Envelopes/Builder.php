<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

class Builder
{
    use KycBuilder;
    use OrderBuilder;
    use TransactionBuilder;
    use PayoutRefundBuilder;
    use DocumentBuilder;
    use ProfileBuilder;
    use AccountEventBuilder;
    use UserBuilder;
    use PostbackBuilder;

    const EVENT_PROFILE_UPDATE = 'profile_update';

    const EVENT_POSTBACK = 'postback';

    const EVENT_KYC_PROOF = 'kyc_proof';

    const EVENT_DOCUMENT = 'document';

    const LIMITED_VALIDATION_EVENTS = [
        self::EVENT_PROFILE_UPDATE,
        self::EVENT_POSTBACK,
        self::EVENT_KYC_PROOF,
        self::EVENT_DOCUMENT
    ];

    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $sequenceId;
    /**
     * @var IdentityNodeInterface[]
     */
    private $identities = array();
    /**
     * @var array
     */
    private $data = array();

    /**
     * Builder constructor.
     *
     * @param string $envelopeType
     * @param string $sequenceId
     */
    public function __construct($envelopeType, $sequenceId)
    {
        $this->assertString($envelopeType, 'Envelope type must be string');

        if ($envelopeType == self::EVENT_PROFILE_UPDATE || $envelopeType == self::EVENT_DOCUMENT) {
            if (!is_null($sequenceId) && !is_string($sequenceId)) {
                throw new \InvalidArgumentException('Sequence ID must be string or null');
            }
        } else {
            $this->assertString($sequenceId, 'Sequence ID must be string');
        }

        $this->type = $envelopeType;
        $this->sequenceId = $sequenceId;
    }

    /**
     * Returns built envelope
     *
     * @return EnvelopeInterface
     */
    public function build()
    {
        return new Envelope(
            $this->type,
            $this->sequenceId,
            $this->identities,
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|array|null $value
     */
    private function replace($key, $value)
    {
        if ($this->isNotNullAndNotEmptyString($value) && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Replaces the value in the internal array if the provided value is not null, not an empty string, and positive
     *
     * @param string $key
     * @param string|int|float|bool|null $value
     */
    private function replaceZeroAllowed($key, $value)
    {
        if ($this->isNotNullAndNotEmptyString($value) && $value >= 0) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Check if the value is not null and not an empty string
     *
     * @param string|int|float|bool|null $value
     */
    private function isNotNullAndNotEmptyString($value)
    {
        return $value !== null && $value !== '';
    }

    /**
     * Adds identity node
     *
     * @param IdentityNodeInterface $identity
     *
     * @return $this
     */
    public function addIdentity(IdentityNodeInterface $identity)
    {
        $this->identities[] = $identity;
        return $this;
    }

    private function assertString($value, $message)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertOptionalString($value, $message)
    {
        if ($value !== null && !is_string($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertInt($value, $message)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertOptionalInt($value, $message)
    {
        if ($value !== null && !is_int($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertOptionalBool($value, $message)
    {
        if ($value !== null && !is_bool($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertFloat($value, $message)
    {
        if (!is_float($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    private function assertOptionalFloat($value, $message)
    {
        if ($value !== null && !is_float($value)) {
            throw new \InvalidArgumentException($message);
        }
    }


    private function assertNonNegativeNumber($value, $numberMessage, $negativeMessage)
    {
        if (!is_int($value) && !is_float($value)) {
            throw new \InvalidArgumentException($numberMessage);
        }
        if ($value < 0) {
            throw new \InvalidArgumentException($negativeMessage);
        }
    }

    private function assertOptionalNonNegativeNumber($value, $numberMessage, $negativeMessage)
    {
        if ($value !== null) {
            $this->assertNonNegativeNumber($value, $numberMessage, $negativeMessage);
        }
    }
}
