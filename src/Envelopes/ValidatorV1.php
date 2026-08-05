<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\EnvelopeValidationException;
use Covery\Client\IdentityNodeInterface;

class ValidatorV1
{
    /**
     * @var FieldTypeChecker
     */
    private $fieldTypeChecker;

    public function __construct()
    {
        $this->fieldTypeChecker = new FieldTypeChecker();
    }

    /**
     * Analyzes SequenceID
     *
     * @param string $sequenceId
     * @return string[]
     */
    public function analyzeSequenceId($sequenceId)
    {
        if (!is_string($sequenceId)) {
            return array('SequenceID is not a string');
        }
        $len = strlen($sequenceId);
        if ($len < 6 || $len > 40) {
            return array(sprintf(
                'Invalid SequenceID length. It must be in range [6, 40], but %d received.',
                $len
            ));
        }

        return array();
    }

    /**
     * Analyzes identities from envelope
     *
     * @param IdentityNodeInterface[] $identities
     * @return string[]
     */
    public function analyzeIdentities(array $identities)
    {
        $detail = array();
        if (count($identities) > 0) {
            foreach ($identities as $i => $identity) {
                if (!$identity instanceof IdentityNodeInterface) {
                    $detail[] = $i . '-th elements of Identities not implements IdentityNodeInterface';
                }
            }
        }

        return $detail;
    }

    /**
     * Analyzes envelope type and mandatory fields
     *
     * @param EnvelopeInterface $envelope
     * @return string[]
     */
    public function analyzeTypeAndMandatoryFields(EnvelopeInterface $envelope)
    {
        $type = $envelope->getType();
        if (!is_string($type)) {
            return array('Envelope type must be string');
        } elseif (!isset(ValidatorV1Schema::$types[$type])) {
            return array(
                sprintf('Envelope type "%s" not supported by this client version', $type)
            );
        } else {
            $details = array();
            $typeInfo = ValidatorV1Schema::$types[$type];

            // Mandatory fields check
            foreach ($typeInfo['mandatory'] as $name) {
                if (
                    !isset($envelope[$name]) ||
                    $this->emptyConditionForMandatoryField($envelope, $name)
                ) {
                    $details[] = sprintf(
                        'Field "%s" is mandatory for "%s", but not provided',
                        $name,
                        $type
                    );
                }
            }

            // Field presence check
            $fields = array_merge($typeInfo['mandatory'], $typeInfo['optional'], ValidatorV1Schema::$sharedOptional);
            foreach ($envelope as $key => $value) {
                if (!$this->isCustom($key) && !in_array($key, $fields)) {
                    $details[] = sprintf('Field "%s" not found in "%s"', $key, $envelope->getType());
                }
            }

            return $details;
        }
    }

    /**
     * Analyzes field types
     *
     * @param EnvelopeInterface $envelope
     * @return array
     */
    public function analyzeFieldTypes(EnvelopeInterface $envelope)
    {
        $type = $envelope->getType();
        if (!is_string($type) || !isset(ValidatorV1Schema::$types[$type])) {
            return array();
        }

        $details = array();
        foreach ($envelope as $key => $value) {
            $details = array_merge($details, $this->fieldTypeChecker->analyze($key, $value));
        }

        return $details;
    }

    /**
     * Checks envelope validity and throws an exception on error
     *
     * @param EnvelopeInterface $envelope
     * @throws EnvelopeValidationException
     */
    public function validate(EnvelopeInterface $envelope)
    {
        if (in_array($envelope->getType(), Builder::LIMITED_VALIDATION_EVENTS)) {
            $details = array_merge(
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        } else {
            $details = array_merge(
                $this->analyzeSequenceId($envelope->getSequenceId()),
                $this->analyzeIdentities($envelope->getIdentities()),
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        }

        if (count($details) > 0) {
            throw new EnvelopeValidationException($details);
        }
    }

    /**
     * Returns true if provided key belongs to custom fields family
     *
     * @param string $key
     * @return bool
     */
    public function isCustom($key)
    {
        return is_string($key) && strlen($key) >= 7 && substr($key, 0, 7) === 'custom_';
    }

    private function emptyConditionForMandatoryField(EnvelopeInterface $envelope, $name)
    {
        if (in_array($name, ValidatorV1Schema::$fieldWithZeroAllowed)) {
            return is_null($envelope[$name]) || $envelope[$name] == '';
        } else {
            return empty($envelope[$name]);
        }
    }
}
