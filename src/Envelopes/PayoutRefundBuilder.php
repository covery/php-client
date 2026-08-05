<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait PayoutRefundBuilder
{
    /**
     * Returns builder for payout request
     *
     * @param string $sequenceId
     * @param string $userId
     * @param string $payoutId
     * @param string $currency
     * @param int|float $amount
     * @param int|null $payoutTimestamp
     * @param string|null $cardId
     * @param string|null $accountId
     * @param string|null $method
     * @param string|null $system
     * @param string|null $mid
     * @param int|float $amountConverted
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $country
     * @param string|null $email
     * @param string|null $phone
     * @param int|null $cardBin
     * @param string|null $cardLast4
     * @param int|null $cardExpirationMonth
     * @param int|null $cardExpirationYear
     * @param string|null $groupId
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function payoutEvent(
        $sequenceId,
        $userId,
        $payoutId,
        $currency,
        $amount,
        $payoutTimestamp = null,
        $cardId = null,
        $accountId = null,
        $method = null,
        $system = null,
        $mid = null,
        $amountConverted = null,
        $firstName = null,
        $lastName = null,
        $country = null,
        $email = null,
        $phone = null,
        $cardBin = null,
        $cardLast4 = null,
        $cardExpirationMonth = null,
        $cardExpirationYear = null,
        $groupId = null,
        $linksToDocuments = null,
        $documentId = null
    ) {
        $builder = new Builder('payout', $sequenceId);
        if ($payoutTimestamp === null) {
            $payoutTimestamp = time();
        }
        return $builder
            ->addPayoutData(
                $payoutId,
                $payoutTimestamp,
                $amount,
                $currency,
                $cardId,
                $accountId,
                $method,
                $system,
                $mid,
                $amountConverted,
                $cardBin,
                $cardLast4,
                $cardExpirationMonth,
                $cardExpirationYear
            )
            ->addShortUserData($email, $userId, $phone, $firstName, $lastName, $country)
            ->addGroupId($groupId)
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);
    }

    /**
     * Returns builder for refund request
     *
     * @param string $sequenceId
     * @param string $refundId
     * @param int|float $refundAmount
     * @param string $refundCurrency
     * @param int|null $refundTimestamp
     * @param int|float|null $refundAmountConverted
     * @param string|null $refundSource
     * @param string|null $refundType
     * @param string|null $refundCode
     * @param string|null $refundReason
     * @param string|null $agentId
     * @param string|null $refundMethod
     * @param string|null $refundSystem
     * @param string|null $refundMid
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $userId
     * @param string|null $groupId
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function refundEvent(
        $sequenceId,
        $refundId,
        $refundAmount,
        $refundCurrency,
        $refundTimestamp = null,
        $refundAmountConverted = null,
        $refundSource = null,
        $refundType = null,
        $refundCode = null,
        $refundReason = null,
        $agentId = null,
        $refundMethod = null,
        $refundSystem = null,
        $refundMid = null,
        $email = null,
        $phone = null,
        $userId = null,
        $groupId = null,
        $linksToDocuments = null,
        $documentId = null
    ) {
        $builder = new Builder('refund', $sequenceId);
        if ($refundTimestamp === null) {
            $refundTimestamp = time();
        }

        return $builder
            ->addRefundData(
                $refundId,
                $refundTimestamp,
                $refundAmount,
                $refundCurrency,
                $refundAmountConverted,
                $refundSource,
                $refundType,
                $refundCode,
                $refundReason,
                $agentId,
                $refundMethod,
                $refundSystem,
                $refundMid
            )
            ->addUserData($email, $userId, $phone)
            ->addGroupId($groupId)
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);
    }

    /**
     * Provides payout information to envelope
     *
     * @param string $payoutId
     * @param int $payoutTimestamp
     * @param int|float $payoutAmount
     * @param string $payoutCurrency
     * @param string|null $payoutCardId
     * @param string|null $payoutAccountId
     * @param string|null $payoutMethod
     * @param string|null $payoutSystem
     * @param string|null $payoutMid
     * @param int|float|null $amountConverted
     * @param int|null $payoutCardBin
     * @param string|null $payoutCardLast4
     * @param int|null $payoutExpirationMonth
     * @param int|null $payoutExpirationYear
     *
     * @return $this
     */
    public function addPayoutData(
        $payoutId,
        $payoutTimestamp,
        $payoutAmount,
        $payoutCurrency,
        $payoutCardId =  null,
        $payoutAccountId = null,
        $payoutMethod = null,
        $payoutSystem = null,
        $payoutMid = null,
        $amountConverted = null,
        $payoutCardBin = null,
        $payoutCardLast4 = null,
        $payoutExpirationMonth = null,
        $payoutExpirationYear = null
    ) {
        $this->assertString($payoutId, 'Payout ID must be string');
        $this->assertInt($payoutTimestamp, 'Payout timestamp must be int');
        if (!is_float($payoutAmount) && !is_int($payoutAmount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if ($payoutAmount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }
        $this->assertString($payoutCurrency, 'Payout currency must be string');
        $this->assertOptionalString($payoutAccountId, 'Account ID must be string');
        $this->assertOptionalString($payoutCardId, 'Card ID must be string');
        $this->assertOptionalString($payoutMethod, 'Payout method must be string');
        $this->assertOptionalString($payoutSystem, 'Payout system must be string');
        $this->assertOptionalString($payoutMid, 'Payout MID must be string');
        $this->assertOptionalNonNegativeNumber($amountConverted, 'Payout amount converted must be float', 'Payout amount converted cannot be negative');
        $this->assertOptionalInt($payoutCardBin, 'Payout card BIN must be integer');
        $this->assertOptionalString($payoutCardLast4, 'Payout last 4 must be string');
        $this->assertOptionalInt($payoutExpirationMonth, 'Payout card expiration month must be integer');
        $this->assertOptionalInt($payoutExpirationYear, 'Payout card expiration year must be integer');

        $this->replace('payout_id', $payoutId);
        $this->replace('payout_timestamp', $payoutTimestamp);
        $this->replace('payout_card_id', $payoutCardId);
        $this->replace('payout_account_id', $payoutAccountId);
        $this->replaceZeroAllowed(
            'payout_amount',
            !is_null($payoutAmount) ? (float) $payoutAmount : null
        );
        $this->replace('payout_currency', $payoutCurrency);
        $this->replace('payout_method', $payoutMethod);
        $this->replace('payout_system', $payoutSystem);
        $this->replace('payout_mid', $payoutMid);
        $this->replaceZeroAllowed(
            'payout_amount_converted',
            !is_null($amountConverted) ? (float) $amountConverted : null
        );
        $this->replace('payout_card_bin', $payoutCardBin);
        $this->replace('payout_card_last4', $payoutCardLast4);
        $this->replace('payout_expiration_month', $payoutExpirationMonth);
        $this->replace('payout_expiration_year', $payoutExpirationYear);

        return $this;
    }

    /**
     * Provides refund information to envelope
     *
     * @param string $refundId
     * @param int|float $refundAmount
     * @param string $refundCurrency
     * @param int|null $refundTimestamp
     * @param int|float|null $refundAmountConverted
     * @param string|null $refundSource
     * @param string|null $refundType
     * @param string|null $refundCode
     * @param string|null $refundReason
     * @param string|null $agentId
     * @param string|null $refundMethod
     * @param string|null $refundSystem
     * @param string|null $refundMid
     *
     * @return $this
     */
    public function addRefundData(
        $refundId,
        $refundTimestamp,
        $refundAmount,
        $refundCurrency,
        $refundAmountConverted = null,
        $refundSource = null,
        $refundType = null,
        $refundCode = null,
        $refundReason = null,
        $agentId = null,
        $refundMethod = null,
        $refundSystem = null,
        $refundMid = null
    ) {
        $this->assertString($refundId, 'Refund ID must be string');
        $this->assertInt($refundTimestamp, 'Refund timestamp must be int');
        if (!is_float($refundAmount) && !is_int($refundAmount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if ($refundAmount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }
        $this->assertString($refundCurrency, 'Refund currency must be string');
        $this->assertOptionalNonNegativeNumber($refundAmountConverted, 'Refund amount converted must be float', 'Refund amount converted cannot be negative');
        $this->assertOptionalString($refundSource, 'Refund source must be string');
        $this->assertOptionalString($refundType, 'Refund type must be string');
        $this->assertOptionalString($refundCode, 'Refund code must be string');
        $this->assertOptionalString($refundReason, 'Refund reason must be string');
        $this->assertOptionalString($agentId, 'Agent id must be string');
        $this->assertOptionalString($refundMethod, 'Refund method must be string');
        $this->assertOptionalString($refundSystem, 'Refund system must be string');
        $this->assertOptionalString($refundMid, 'Refund mid must be string');

        $this->replace('refund_id', $refundId);
        $this->replace('refund_timestamp', $refundTimestamp);
        $this->replaceZeroAllowed('refund_amount', $refundAmount);
        $this->replace('refund_currency', $refundCurrency);
        $this->replaceZeroAllowed('refund_amount_converted', $refundAmountConverted);
        $this->replace('refund_source', $refundSource);
        $this->replace('refund_type', $refundType);
        $this->replace('refund_code', $refundCode);
        $this->replace('refund_reason', $refundReason);
        $this->replace('agent_id', $agentId);
        $this->replace('refund_method', $refundMethod);
        $this->replace('refund_system', $refundSystem);
        $this->replace('refund_mid', $refundMid);

        return $this;
    }
}
