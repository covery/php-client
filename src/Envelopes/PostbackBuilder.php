<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait PostbackBuilder
{
    /**
     * Returns builder for postback request
     *
     * @param int $requestId
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $secure3d
     * @param string|null $avsResult
     * @param string|null $cvvResult
     * @param string|null $pspCode
     * @param string|null $pspReason
     * @param string|null $merchantAdviceCode
     * @param string|null $merchantAdviceText
     * @param string|null $arn
     * @param string|null $paymentAccountId
     * @return Builder
     */
    public static function postBackEvent(
        $requestId,
        $code = null,
        $reason = null,
        $secure3d = null,
        $avsResult = null,
        $cvvResult = null,
        $pspCode = null,
        $pspReason = null,
        $arn = null,
        $paymentAccountId = null,
        $merchantAdviceCode = null,
        $merchantAdviceText = null
    ) {
        $builder = new Builder(Builder::EVENT_POSTBACK, '');
        return $builder->addPostBackData(
            $requestId,
            $code,
            $reason,
            $secure3d,
            $avsResult,
            $cvvResult,
            $pspCode,
            $pspReason,
            $arn,
            $paymentAccountId,
            $merchantAdviceCode,
            $merchantAdviceText
       );
    }

    /**
     * Provides postback information to envelope
     *
     * @param int $requestId
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $secure3d
     * @param string|null $avsResult
     * @param string|null $cvvResult
     * @param string|null $pspCode
     * @param string|null $pspReason
     * @param string|null $arn
     * @param string|null $paymentAccountId
     * @param string|null $merchantAdviceCode
     * @param string|null $merchantAdviceText
     * @return $this
     */
    public function addPostbackData(
        $requestId,
        $code = null,
        $reason = null,
        $secure3d = null,
        $avsResult = null,
        $cvvResult = null,
        $pspCode = null,
        $pspReason = null,
        $arn = null,
        $paymentAccountId = null,
        $merchantAdviceCode = null,
        $merchantAdviceText = null
    ) {
        $this->assertInt($requestId, 'Request ID must be integer');
        $this->assertOptionalString($code, 'Code must be string');
        $this->assertOptionalString($reason, 'Reason must be string');
        $this->assertOptionalString($secure3d, 'Secure3d must be string');
        $this->assertOptionalString($avsResult, 'AvsResult must be string');
        $this->assertOptionalString($cvvResult, 'CvvResult must be string');
        $this->assertOptionalString($pspCode, 'PspCode must be string');
        $this->assertOptionalString($pspReason, 'PspReason must be string');
        $this->assertOptionalString($merchantAdviceCode, 'Merchant advice code must be string');
        $this->assertOptionalString($merchantAdviceText, 'Merchant advice text must be string');
        $this->assertOptionalString($arn, 'Arn must be string');
        $this->assertOptionalString($paymentAccountId, 'PaymentAccoutId must be string');

        $this->replace('request_id', $requestId);
        $this->replace('code', $code);
        $this->replace('reason', $reason);
        $this->replace('secure3d', $secure3d);
        $this->replace('avs_result', $avsResult);
        $this->replace('cvv_result', $cvvResult);
        $this->replace('psp_code', $pspCode);
        $this->replace('psp_reason', $pspReason);
        $this->replace('arn', $arn);
        $this->replace('payment_account_id', $paymentAccountId);
        $this->replace('merchant_advice_code', $merchantAdviceCode);
        $this->replace('merchant_advice_text', $merchantAdviceText);

        return $this;
    }

    /**
     * Adds custom data field to envelope
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addCustomField($name, $value)
    {
        $this->assertString($name, 'Custom field name must be string');
        $this->assertString($value, 'Custom field value must be string');

        if (strlen($name) < 8 || substr($name, 0, 7) !== 'custom_') {
            $name = 'custom_' . $name;
        }

        $this->replace($name, $value);
        return $this;
    }

    /**
     * Provides group id value to envelope
     *
     * @param string|null $groupId
     * @return $this
     */
    public function addGroupId($groupId = null)
    {
        $this->assertOptionalString($groupId, 'Group id must be string');
        $this->replace('group_id', $groupId);

        return $this;
    }
}
