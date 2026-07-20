<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait OrderBuilder
{
    /**
     * Returns builder for order_item request
     *
     * @param string $sequenceId
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int|null $eventTimestamp
     * @param string $orderType
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param string|null $affiliateId
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $productDescription
     * @param string|null $productName
     * @param float|null $productQuantity
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $socialType
     * @param string|null $source
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFee
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $userMerchantId
     * @param string|null $websiteUrl
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @param array|null $documentId
     * @return Builder
     */
    public static function orderItemEvent(
        $sequenceId,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $orderType,
        $transactionId = null,
        $groupId = null,
        $affiliateId = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $email = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $socialType = null,
        $source = null,
        $sourceFeeCurrency = null,
        $sourceFee = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $userMerchantId = null,
        $websiteUrl = null,
        $productUrl = null,
        $productImageUrl = null,
        $documentId = null
    ) {
        $envelopeType = 'order_item';
        $builder = new Builder($envelopeType, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addOrderData(
                $envelopeType,
                $amount,
                $currency,
                $eventId,
                $eventTimestamp,
                $transactionId,
                $groupId,
                null,
                $orderType,
                $amountConverted,
                $campaign,
                $carrier,
                $carrierShippingId,
                $carrierUrl,
                $carrierPhone,
                $couponStartDate,
                $couponEndDate,
                $couponId,
                $couponName,
                $customerComment,
                $deliveryEstimate,
                $shippingAddress,
                $shippingCity,
                $shippingCountry,
                $shippingCurrency,
                $shippingFee,
                $shippingFeeConverted,
                $shippingState,
                $shippingZip,
                $source,
                $sourceFee,
                $sourceFeeCurrency,
                $sourceFeeConverted,
                $taxCurrency,
                $taxFee,
                $taxFeeConverted,
                $productUrl,
                $productImageUrl
            )
            ->addUserData(
                $email,
                $userMerchantId,
                $phone,
                '',
                $firstName,
                $lastName,
                '',
                0,
                '',
                $socialType
            )
            -> addProductData(
                $productQuantity,
                $productName,
                $productDescription
            )
            ->addWebsiteData(
                $websiteUrl,
                null,
                $affiliateId
            )
            ->addDocumentData($documentId);
    }

    /**
     * Returns builder for order_submit request
     *
     * @param string $sequenceId
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int|null $eventTimestamp
     * @param int $itemsQuantity
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param string|null $affiliateId
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $socialType
     * @param string|null $source
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFee
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $userMerchantId
     * @param string|null $websiteUrl
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @param array|null $documentId
     * @return Builder
     */
    public static function orderSubmitEvent(
        $sequenceId,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $itemsQuantity,
        $transactionId = null,
        $groupId = null,
        $affiliateId = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $email = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $socialType = null,
        $source = null,
        $sourceFeeCurrency = null,
        $sourceFee = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $userMerchantId = null,
        $websiteUrl = null,
        $productUrl = null,
        $productImageUrl = null,
        $documentId = null
    ) {
        $envelopeType = 'order_submit';
        $builder = new Builder($envelopeType, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addOrderData(
                $envelopeType,
                $amount,
                $currency,
                $eventId,
                $eventTimestamp,
                $transactionId,
                $groupId,
                $itemsQuantity,
                null,
                $amountConverted,
                $campaign,
                $carrier,
                $carrierShippingId,
                $carrierUrl,
                $carrierPhone,
                $couponStartDate,
                $couponEndDate,
                $couponId,
                $couponName,
                $customerComment,
                $deliveryEstimate,
                $shippingAddress,
                $shippingCity,
                $shippingCountry,
                $shippingCurrency,
                $shippingFee,
                $shippingFeeConverted,
                $shippingState,
                $shippingZip,
                $source,
                $sourceFee,
                $sourceFeeCurrency,
                $sourceFeeConverted,
                $taxCurrency,
                $taxFee,
                $taxFeeConverted,
                $productUrl,
                $productImageUrl
            )
            ->addUserData(
                $email,
                $userMerchantId,
                $phone,
                '',
                $firstName,
                $lastName,
                '',
                0,
                '',
                $socialType
            )
            ->addWebsiteData(
                $websiteUrl,
                null,
                $affiliateId
            )
            ->addDocumentData($documentId);
    }

    /**
     * Provides product information to envelope
     *
     * @param float|null $productQuantity
     * @param string|null $productName
     * @param string|null $productDescription
     *
     * @return $this
     */
    public function addProductData(
        $productQuantity = null,
        $productName = null,
        $productDescription = null
    ) {
        if ($productQuantity !== null && !is_int($productQuantity) && !is_float($productQuantity)) {
            throw new \InvalidArgumentException('Product quantity must be int or float');
        }
        $this->assertOptionalString($productName, 'Product name must be string');
        $this->assertOptionalString($productDescription, 'Product description must be string');

        $this->replace('product_quantity', $productQuantity);
        $this->replace('product_name', $productName);
        $this->replace('product_description', $productDescription);

        return $this;
    }

    /**
     * Provides order information to envelope
     *
     * @param string $envelopeType
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param int|null $itemsQuantity
     * @param string|null $orderType
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $source
     * @param float|null $sourceFee
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @return Builder
     */
    public function addOrderData(
        $envelopeType,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $transactionId = null,
        $groupId = null,
        $itemsQuantity = null,
        $orderType = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $source = null,
        $sourceFee = null,
        $sourceFeeCurrency = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $productUrl = null,
        $productImageUrl = null
    ) {
        $this->assertString($envelopeType, 'Envelope type must be string');
        $this->assertNonNegativeNumber($amount, 'Amount must be number', 'Amount cannot be negative');
        $this->assertString($currency, 'Currency must be string');
        $this->assertString($eventId, 'Event ID must be string');
        $this->assertInt($eventTimestamp, 'Event timestamp must be int');
        if ($envelopeType === 'order_submit' && !is_int($itemsQuantity)) {
            throw new \InvalidArgumentException('Items quantity must be int');
        }
        if ($envelopeType === 'order_item' && !is_string($orderType)) {
            throw new \InvalidArgumentException('Order type must be string');
        }
        $this->assertOptionalString($transactionId, 'Transaction id must be string');
        $this->assertOptionalString($groupId, 'Group id must be string');
        $this->assertOptionalNonNegativeNumber($amountConverted, 'Amount converted must be number', 'Amount converted cannot be negative');
        $this->assertOptionalString($campaign, 'Campaign must be string');
        $this->assertOptionalString($carrier, 'Carrier must be string');
        $this->assertOptionalString($carrierShippingId, 'Carrier shipping id must be string');
        $this->assertOptionalString($carrierUrl, 'Carrier url must be string');
        $this->assertOptionalString($carrierPhone, 'Carrier phone must be string');
        $this->assertOptionalInt($couponStartDate, 'Coupon start date must be int');
        $this->assertOptionalInt($couponEndDate, 'Coupon end date must be int');
        $this->assertOptionalString($couponId, 'Coupon id must be string');
        $this->assertOptionalString($couponName, 'Coupon name must be string');
        $this->assertOptionalString($customerComment, 'Customer comment must be string');
        $this->assertOptionalInt($deliveryEstimate, 'Delivery estimate must be int');
        $this->assertOptionalString($shippingAddress, 'Shipping address must be string');
        $this->assertOptionalString($shippingCity, 'Shipping city must be string');
        $this->assertOptionalString($shippingCountry, 'Shipping country must be string');
        $this->assertOptionalString($shippingCurrency, 'Shipping currency must be string');
        $this->assertOptionalNonNegativeNumber($shippingFee, 'Shipping fee must be number', 'Shipping fee cannot be negative');
        $this->assertOptionalNonNegativeNumber($shippingFeeConverted, 'Shipping fee converted must be number', 'Shipping fee converted cannot be negative');
        $this->assertOptionalString($shippingState, 'Shipping state must be string');
        $this->assertOptionalString($shippingZip, 'Shipping zip must be string');
        $this->assertOptionalString($source, 'Order source must be string');
        $this->assertOptionalNonNegativeNumber($sourceFee, 'Source fee must be number', 'Source fee cannot be negative');
        $this->assertOptionalNonNegativeNumber($sourceFeeConverted, 'Source fee converted must be number', 'Source fee converted cannot be negative');
        $this->assertOptionalString($sourceFeeCurrency, 'Source fee currency must be string');
        $this->assertOptionalString($taxCurrency, 'Tax currency must be string');
        $this->assertOptionalNonNegativeNumber($taxFee, 'Tax fee must be number', 'Tax fee cannot be negative');
        $this->assertOptionalNonNegativeNumber($taxFeeConverted, 'Tax fee converted must be number', 'Tax fee converted cannot be negative');
        $this->assertOptionalString($productUrl, 'Product url must be string');
        $this->assertOptionalString($productImageUrl, 'Product image url must be string');
        $this->assertOptionalString($productImageUrl, 'Product image url must be string');
        $this->replaceZeroAllowed('amount', $amount);
        $this->replace('currency', $currency);
        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('items_quantity', $itemsQuantity);
        $this->replace('order_type', $orderType);
        $this->replace('transaction_id', $transactionId);
        $this->replace('group_id', $groupId);
        $this->replaceZeroAllowed('amount_converted', $amountConverted);
        $this->replace('campaign', $campaign);
        $this->replace('carrier', $carrier);
        $this->replace('carrier_shipping_id', $carrierShippingId);
        $this->replace('carrier_url', $carrierUrl);
        $this->replace('carrier_phone', $carrierPhone);
        $this->replace('coupon_start_date', $couponStartDate);
        $this->replace('coupon_end_date', $couponEndDate);
        $this->replace('coupon_id', $couponId);
        $this->replace('coupon_name', $couponName);
        $this->replace('customer_comment', $customerComment);
        $this->replace('delivery_estimate', $deliveryEstimate);
        $this->replace('shipping_address', $shippingAddress);
        $this->replace('shipping_city', $shippingCity);
        $this->replace('shipping_country', $shippingCountry);
        $this->replace('shipping_currency', $shippingCurrency);
        $this->replaceZeroAllowed('shipping_fee', $shippingFee);
        $this->replaceZeroAllowed('shipping_fee_converted', $shippingFeeConverted);
        $this->replace('shipping_state', $shippingState);
        $this->replace('shipping_zip', $shippingZip);
        $this->replace('order_source', $source);
        $this->replaceZeroAllowed('source_fee', $sourceFee);
        $this->replace('source_fee_currency', $sourceFeeCurrency);
        $this->replaceZeroAllowed('source_fee_converted', $sourceFeeConverted);
        $this->replace('tax_currency', $taxCurrency);
        $this->replaceZeroAllowed('tax_fee', $taxFee);
        $this->replaceZeroAllowed('tax_fee_converted', $taxFeeConverted);
        $this->replace('product_url', $productUrl);
        $this->replace('product_image_url', $productImageUrl);

        return $this;
    }
}
