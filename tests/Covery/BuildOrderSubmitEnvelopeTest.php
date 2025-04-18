<?php

use PHPUnit\Framework\TestCase;

class BuildOrderSubmitEnvelopeTest extends TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();
        // Full data
        $result = \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            3,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            3,
            3.3,
            "taxCurrency",
            123,
            1,
            "userMerchantId",
            "websiteUrl",
            "productUrl",
            "productImageUrl",
            [1, 2]
        )->addIdentity(new \Covery\Client\Identities\Stub()
        )->addBrowserData(
            "deviceFingerprint",
            "userAgent",
            "cpuClass",
            "screenOrientation",
            "screenResolution",
            "os",
            3,
            "languages",
            "language",
            "languageBrowser",
            "languageUser",
            "languageSystem",
            true,
            false,
            true,
            "deviceId",
            "ipList",
            "plugins",
            "refererUrl",
            "originUrl",
            "clientResolution",
            true
        )->build();

        self::assertSame('order_submit', $result->getType());
        self::assertCount(67, $result);
        self::assertCount(1, $result->getIdentities());
        self::assertSame('sequenceId', $result->getSequenceId());
        self::assertSame(123.456, $result["amount"]);
        self::assertSame("currency", $result["currency"]);
        self::assertSame("eventId", $result["event_id"]);
        self::assertSame(123456, $result["event_timestamp"]);
        self::assertSame(111, $result['items_quantity']);
        self::assertSame("transactionId", $result["transaction_id"]);
        self::assertSame("groupId", $result["group_id"]);
        self::assertSame("affiliateId", $result["affiliate_id"]);
        self::assertSame(123, $result["amount_converted"]);
        self::assertSame("campaign", $result["campaign"]);
        self::assertSame("carrier", $result["carrier"]);
        self::assertSame("carrierShippingId", $result["carrier_shipping_id"]);
        self::assertSame("carrierUrl", $result["carrier_url"]);
        self::assertSame("carrierPhone", $result["carrier_phone"]);
        self::assertSame(2, $result["coupon_start_date"]);
        self::assertSame(4, $result["coupon_end_date"]);
        self::assertSame("couponId", $result["coupon_id"]);
        self::assertSame("couponName", $result["coupon_name"]);
        self::assertSame("customerComment", $result["customer_comment"]);
        self::assertSame(126, $result["delivery_estimate"]);
        self::assertSame("email", $result["email"]);
        self::assertSame("firstName", $result["firstname"]);
        self::assertSame("lastName", $result["lastname"]);
        self::assertSame("phone", $result["phone"]);
        self::assertSame("shippingAddress", $result["shipping_address"]);
        self::assertSame("shippingCity", $result["shipping_city"]);
        self::assertSame("shippingCountry", $result["shipping_country"]);
        self::assertSame("shippingCurrency", $result["shipping_currency"]);
        self::assertSame(2.2, $result["shipping_fee"]);
        self::assertSame(3, $result["shipping_fee_converted"]);
        self::assertSame("shippingState", $result["shipping_state"]);
        self::assertSame("shippingZip", $result["shipping_zip"]);
        self::assertSame("socialType", $result["social_type"]);
        self::assertSame("source", $result["order_source"]);
        self::assertSame("sourceFeeCurrency", $result["source_fee_currency"]);
        self::assertSame(3, $result["source_fee"]);
        self::assertSame(3.3, $result["source_fee_converted"]);
        self::assertSame("taxCurrency", $result["tax_currency"]);
        self::assertSame(123, $result["tax_fee"]);
        self::assertSame(1, $result["tax_fee_converted"]);
        self::assertSame("userMerchantId", $result["user_merchant_id"]);
        self::assertSame("websiteUrl", $result["website_url"]);
        self::assertSame("productUrl", $result["product_url"]);
        self::assertSame("productImageUrl", $result["product_image_url"]);
        self::assertSame("deviceFingerprint", $result["device_fingerprint"]);
        self::assertSame("userAgent", $result["user_agent"]);
        self::assertSame("cpuClass", $result["cpu_class"]);
        self::assertSame("screenOrientation", $result["screen_orientation"]);
        self::assertSame("screenResolution", $result["screen_resolution"]);
        self::assertSame("os", $result["os"]);
        self::assertSame(3, $result["timezone_offset"]);
        self::assertSame("languages", $result["languages"]);
        self::assertSame("language", $result["language"]);
        self::assertSame("languageBrowser", $result["language_browser"]);
        self::assertSame("languageUser", $result["language_user"]);
        self::assertSame("languageSystem", $result["language_system"]);
        self::assertSame("deviceId", $result["device_id"]);
        self::assertSame("ipList", $result["local_ip_list"]);
        self::assertSame("plugins", $result["plugins"]);
        self::assertSame("refererUrl", $result["referer_url"]);
        self::assertSame("originUrl", $result["origin_url"]);
        self::assertSame("clientResolution", $result["client_resolution"]);
        self::assertSame(true, $result["cookie_enabled"]);
        self::assertSame(false, $result["do_not_track"]);
        self::assertSame(true, $result['anonymous']);
        self::assertSame(true, $result["ajax_validation"]);
        self::assertSame([1, 2], $result["document_id"]);

        $validator->validate($result);

        // Minimal data
        $result = \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            222
        )->addIdentity(new \Covery\Client\Identities\Stub()
        )->build();
        self::assertSame('order_submit', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertCount(5, $result);
        self::assertSame('sequenceId', $result->getSequenceId());
        self::assertSame(123.456, $result["amount"]);
        self::assertSame("currency", $result["currency"]);
        self::assertSame("eventId", $result["event_id"]);
        self::assertSame(123456, $result["event_timestamp"]);
        self::assertSame(222, $result["items_quantity"]);
    }

    public function testZeroValueForFloatWithAllowedZero()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();
        $result = \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            0.0,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            0.0,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            0.0,
            0.0,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            0.0,
            0.0,
            "taxCurrency",
            0.0,
            0.0
        )->build();
        self::assertSame(0.0, $result['amount']);
        self::assertSame(0.0, $result['amount_converted']);
        self::assertSame(0.0, $result['shipping_fee']);
        self::assertSame(0.0, $result['shipping_fee_converted']);
        self::assertSame(0.0, $result['source_fee']);
        self::assertSame(0.0, $result['source_fee_converted']);
        self::assertSame(0.0, $result['tax_fee']);
        self::assertSame(0.0, $result['tax_fee_converted']);
        $validator->validate($result);
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Amount cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            -2.4,
            "currency",
            "eventId",
            123456,
            111
        )->build();
    }
    
    public function testEventExpectInvalidArgumentExceptionForNegativeAmountConverted()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Amount converted cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            2.0,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            -3.5,
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeShippingFee()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Shipping fee cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            -2.2,
            3,
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeShippingFeeConverted()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Shipping fee converted cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            -0.3,
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeSourceFee()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Source fee cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            3,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            -0.3
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeSourceFeeConverted()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Source fee converted cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            0.3,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            0.0,
            -1.2
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeTaxFee()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Tax fee cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            3,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            1.0,
            1.0,
            "taxCurrency",
            -1.1
        )->build();
    }

    public function testEventExpectInvalidArgumentExceptionForNegativeTaxFeeConverted()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Tax fee converted cannot be negative");
        \Covery\Client\Envelopes\Builder::orderSubmitEvent(
            "sequenceId",
            123.456,
            "currency",
            "eventId",
            123456,
            111,
            "transactionId",
            "groupId",
            "affiliateId",
            123,
            "campaign",
            "carrier",
            "carrierShippingId",
            "carrierUrl",
            "carrierPhone",
            2,
            4,
            "couponId",
            "couponName",
            "customerComment",
            126,
            "email",
            "firstName",
            "lastName",
            "phone",
            "shippingAddress",
            "shippingCity",
            "shippingCountry",
            "shippingCurrency",
            2.2,
            0.3,
            "shippingState",
            "shippingZip",
            "socialType",
            "source",
            "sourceFeeCurrency",
            1.0,
            1.0,
            "taxCurrency",
            1.0,
            -0.7
        )->build();
    }
}