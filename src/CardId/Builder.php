<?php

namespace Covery\Client\CardId;

use Covery\Client\CardIdInterface;

class Builder
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * Returns builder for card id request
     *
     * @param string $cardNumber
     */
    public static function cardIdEvent($cardNumber)
    {
        $builder = new self();

        return $builder
            ->addCardIdData($cardNumber);
    }

    /**
     * Provides cardId value
     *
     * @param string $cardNumber
     * @return \Covery\Client\CardId\Builder
     */
    public function addCardIdData($cardNumber)
    {
        if (!is_string($cardNumber)) {
            throw new \InvalidArgumentException('Card number must be string');
        } elseif (strlen($cardNumber) < 10 || strlen($cardNumber) > 20) {
            throw new \InvalidArgumentException('The length of the card number must be between 10 and 20 characters');
        }

        $this->replace('card_number', $cardNumber);

        return $this;
    }

    /**
     * Returns built cardId
     *
     * @return CardIdInterface
     */
    public function build()
    {
        return new CardId(
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|null $value
     */
    private function replace($key, $value)
    {
        if ($value !== null && $value !== '' && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }
}
