<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait TransactionBuilder
{
    /**
     * Returns builder for transaction request
     *
     * @param string $sequenceId
     * @param string $userId
     * @param string $transactionId
     * @param int|float $transactionAmount
     * @param string $transactionCurrency
     * @param int|null $transactionTimestamp
     * @param string|null $transactionMode
     * @param string|null $transactionType
     * @param int|null $cardBin
     * @param string|null $cardId
     * @param string|null $cardLast4
     * @param int|null $expirationMonth
     * @param int|null $expirationYear
     * @param int|null $age
     * @param string|null $country
     * @param string|null $email
     * @param string|null $gender
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $userName
     * @param string|null $paymentAccountId
     * @param string|null $paymentMethod
     * @param string|null $paymentMidName
     * @param string|null $paymentSystem
     * @param int|float|null $transactionAmountConverted
     * @param string|null $transactionSource
     * @param string|null $billingAddress
     * @param string|null $billingCity
     * @param string|null $billingCountry
     * @param string|null $billingFirstName
     * @param string|null $billingLastName
     * @param string|null $billingFullName
     * @param string|null $billingState
     * @param string|null $billingZip
     * @param string|null $productDescription
     * @param string|null $productName
     * @param int|float|null $productQuantity
     * @param string|null $websiteUrl
     * @param string|null $merchantIp
     * @param string|null $affiliateId
     * @param string|null $campaign
     * @param string|null $merchantCountry
     * @param string|null $mcc
     * @param string|null $acquirerMerchantId
     * @param string|null $groupId
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function transactionEvent(
        $sequenceId,
        $userId,
        $transactionId,
        $transactionAmount,
        $transactionCurrency,
        $transactionTimestamp = null,
        $transactionMode = null,
        $transactionType = null,
        $cardBin = null,
        $cardId = null,
        $cardLast4 = null,
        $expirationMonth = null,
        $expirationYear = null,
        $age = null,
        $country = null,
        $email = null,
        $gender = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $userName = null,
        $paymentAccountId = null,
        $paymentMethod = null,
        $paymentMidName = null,
        $paymentSystem = null,
        $transactionAmountConverted = null,
        $transactionSource = null,
        $billingAddress = null,
        $billingCity = null,
        $billingCountry = null,
        $billingFirstName = null,
        $billingLastName = null,
        $billingFullName = null,
        $billingState = null,
        $billingZip = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $websiteUrl = null,
        $merchantIp = null,
        $affiliateId = null,
        $campaign = null,
        $merchantCountry = null,
        $mcc = null,
        $acquirerMerchantId = null,
        $groupId = null,
        $linksToDocuments = null,
        $documentId = null
    ) {
        $builder = new Builder('transaction', $sequenceId);
        if ($transactionTimestamp === null) {
            $transactionTimestamp = time();
        }

        return $builder
            ->addCCTransactionData(
                $transactionId,
                $transactionSource,
                $transactionType,
                $transactionMode,
                $transactionTimestamp,
                $transactionCurrency,
                $transactionAmount,
                $transactionAmountConverted,
                $paymentMethod,
                $paymentSystem,
                $paymentMidName,
                $paymentAccountId,
                $merchantCountry,
                $mcc,
                $acquirerMerchantId
            )
            ->addBillingData(
                $billingFirstName,
                $billingLastName,
                $billingFullName,
                $billingCountry,
                $billingState,
                $billingCity,
                $billingAddress,
                $billingZip
            )
            ->addCardData($cardBin, $cardLast4, $expirationMonth, $expirationYear, $cardId)
            ->addUserData(
                $email,
                $userId,
                $phone,
                $userName,
                $firstName,
                $lastName,
                $gender,
                $age,
                $country
            )
            ->addProductData($productQuantity, $productName, $productDescription)
            ->addWebsiteData($websiteUrl, null, $affiliateId, $campaign)
            ->addIpData(null, null, $merchantIp)
            ->addGroupId($groupId)
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);

    }

    /**
     * Returns builder for transfer request
     *
     * @param string $sequenceId
     * @param string $eventId
     * @param float $amount
     * @param string $currency
     * @param string $userId
     * @param string $accountId
     * @param string $secondAccountId
     * @param string $accountSystem
     * @param string|null $method
     * @param int|null $eventTimestamp
     * @param float|null $amountConverted
     * @param string|null $email
     * @param string|null $phone
     * @param int|null $birthDate
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $fullname
     * @param string|null $state
     * @param string|null $city
     * @param string|null $address
     * @param string|null $zip
     * @param string|null $gender
     * @param string|null $country
     * @param string|null $operation
     * @param string|null $secondEmail
     * @param string|null $secondPhone
     * @param int|null $secondBirthDate
     * @param string|null $secondFirstname
     * @param string|null $secondLastname
     * @param string|null $secondFullname
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $secondGender
     * @param string|null $secondCountry
     * @param string|null $productDescription
     * @param string|null $productName
     * @param int|float|null $productQuantity
     * @param string|null $iban
     * @param string|null $secondIban
     * @param string|null $bic
     * @param string|null $source
     * @param string|null $groupId
     * @param string|null $secondUserMerchantId
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function transferEvent(
        $sequenceId,
        $eventId,
        $amount,
        $currency,
        $userId,
        $accountId = null,
        $secondAccountId = null,
        $accountSystem = null,
        $method = null,
        $eventTimestamp = null,
        $amountConverted = null,
        $email = null,
        $phone = null,
        $birthDate = null,
        $firstname = null,
        $lastname = null,
        $fullname = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $gender = null,
        $country = null,
        $operation = null,
        $secondEmail = null,
        $secondPhone = null,
        $secondBirthDate = null,
        $secondFirstname = null,
        $secondLastname = null,
        $secondFullname = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $secondGender = null,
        $secondCountry = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $iban = null,
        $secondIban = null,
        $bic = null,
        $source = null,
        $groupId = null,
        $secondUserMerchantId = null,
        $linksToDocuments = null,
        $documentId = null
    ) {
        $builder = new Builder('transfer', $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }

        return $builder
            ->addTransferData(
               $eventId,
               $eventTimestamp,
               $amount,
               $currency,
               $accountId,
               $secondAccountId,
               $accountSystem,
               $amountConverted,
               $method,
               $operation,
               $secondEmail,
               $secondPhone,
               $secondBirthDate,
               $secondFirstname,
               $secondLastname,
               $secondFullname,
               $secondState,
               $secondCity,
               $secondAddress,
               $secondZip,
               $secondGender,
               $secondCountry,
               $iban,
               $secondIban,
               $bic,
               $source,
               $secondUserMerchantId
            )
            ->addUserData(
                $email,
                $userId,
                $phone,
                null,
                $firstname,
                $lastname,
                $gender,
                null,
                $country,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $birthDate,
                $fullname,
                $state,
                $city,
                $address,
                $zip,
                null
            )
            ->addProductData($productQuantity, $productName, $productDescription)
            ->addGroupId($groupId)
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);
    }

    /**
     * Provides credit card data to envelope
     *
     * @param string|null $transactionId
     * @param string|null $transactionSource
     * @param string|null $transactionType
     * @param string|null $transactionMode
     * @param int|null $transactionTimestamp
     * @param string|null $transactionCurrency
     * @param int|float|null $transactionAmount
     * @param float|null $amountConverted
     * @param string|null $paymentMethod
     * @param string|null $paymentSystem
     * @param string|null $paymentMidName
     * @param string|null $paymentAccountId
     * @param string|null $merchantCountry
     * @param string|null $mcc
     * @param string|null $acquirerMerchantId
     * @return $this
     */
    public function addCCTransactionData(
        $transactionId,
        $transactionSource,
        $transactionType,
        $transactionMode,
        $transactionTimestamp,
        $transactionCurrency,
        $transactionAmount,
        $amountConverted = null,
        $paymentMethod = null,
        $paymentSystem = null,
        $paymentMidName = null,
        $paymentAccountId = null,
        $merchantCountry = null,
        $mcc = null,
        $acquirerMerchantId = null
    ) {
        $this->assertOptionalString($transactionId, 'Transaction ID must be string');
        $this->assertOptionalString($transactionSource, 'Transaction source must be string');
        $this->assertOptionalString($transactionType, 'Transaction type must be string');
        $this->assertOptionalString($transactionMode, 'Transaction mode must be string');
        $this->assertOptionalInt($transactionTimestamp, 'Transaction timestamp must be integer');
        $this->assertOptionalNonNegativeNumber($transactionAmount, 'Transaction amount must be float', 'Transaction amount cannot be negative');
        $this->assertOptionalString($transactionCurrency, 'Transaction currency must be string');
        $this->assertOptionalString($paymentMethod, 'Payment method must be string');
        $this->assertOptionalString($paymentSystem, 'Payment system must be string');
        $this->assertOptionalString($paymentMidName, 'Payment MID name must be string');
        $this->assertOptionalString($paymentAccountId, 'Payment account id must be string');
        $this->assertOptionalNonNegativeNumber($amountConverted, 'Transaction amount converted must be float', 'Transaction amount converted cannot be negative');
        $this->assertOptionalString($merchantCountry, 'Merchant country must be string');
        $this->assertOptionalString($mcc, 'MCC must be string');
        $this->assertOptionalString($acquirerMerchantId, 'Acquirer merchant id be string');
        $this->replace('transaction_id', $transactionId);
        $this->replace('transaction_source', $transactionSource);
        $this->replace('transaction_type', $transactionType);
        $this->replace('transaction_mode', $transactionMode);
        $this->replace('transaction_timestamp', $transactionTimestamp);
        $this->replaceZeroAllowed(
            'transaction_amount',
            !is_null($transactionAmount) ? floatval($transactionAmount) : null
        );
        $this->replaceZeroAllowed(
            'transaction_amount_converted',
            !is_null($amountConverted) ? floatval($amountConverted) : null
        );
        $this->replace('transaction_currency', $transactionCurrency);
        $this->replace('payment_method', $paymentMethod);
        $this->replace('payment_system', $paymentSystem);
        $this->replace('payment_mid', $paymentMidName);
        $this->replace('payment_account_id', $paymentAccountId);
        $this->replace('merchant_country', $merchantCountry);
        $this->replace('mcc', $mcc);
        $this->replace('acquirer_merchant_id', $acquirerMerchantId);

        return $this;
    }

    /**
     * Provides transfer information to envelope
     *
     * @param string $eventId
     * @param int $eventTimestamp
     * @param float $amount
     * @param string $currency
     * @param string $accountId
     * @param string $secondAccountId
     * @param string $accountSystem
     * @param float|null $amountConverted
     * @param string|null $method
     * @param string|null $operation
     * @param string|null $secondEmail
     * @param string|null $secondPhone
     * @param string|int $secondBirthDate
     * @param string|null $secondFirstname
     * @param string|null $secondLastname
     * @param string|null $secondFullname
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $secondGender
     * @param string|null $secondCountry
     * @param string|null $iban
     * @param string|null $secondIban
     * @param string|null $bic
     * @param string|null $source
     * @param string|null $secondUserMerchantId
     *
     * @return $this
     */
    public function addTransferData(
        $eventId,
        $eventTimestamp,
        $amount,
        $currency,
        $accountId,
        $secondAccountId,
        $accountSystem,
        $amountConverted = null,
        $method = null,
        $operation = null,
        $secondEmail = null,
        $secondPhone = null,
        $secondBirthDate = null,
        $secondFirstname = null,
        $secondLastname = null,
        $secondFullname = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $secondGender = null,
        $secondCountry = null,
        $iban = null,
        $secondIban = null,
        $bic = null,
        $source = null,
        $secondUserMerchantId = null
    ) {
        $this->assertString($eventId, 'Event ID must be string');
        $this->assertInt($eventTimestamp, 'Event timestamp must be int');
        $this->assertNonNegativeNumber($amount, 'Amount must be number', 'Amount cannot be negative');
        $this->assertString($currency, 'Currency must be string');
        $this->assertOptionalString($accountId, 'Account id must be string');
        $this->assertOptionalString($secondAccountId, 'Second account id must be string');
        $this->assertOptionalString($accountSystem, 'Account system must be string');
        $this->assertOptionalNonNegativeNumber($amountConverted, 'Amount converted must be number', 'Amount converted cannot be negative');
        $this->assertOptionalString($method, 'Method must be string');
        $this->assertOptionalString($operation, 'Operation must be string');
        $this->assertOptionalString($secondPhone, 'Second phone must be string');
        $this->assertOptionalString($secondEmail, 'Second email must be string');
        $this->assertOptionalInt($secondBirthDate, 'Second birth date must be int');
        $this->assertOptionalString($secondFirstname, 'Second firstname must be string');
        $this->assertOptionalString($secondLastname, 'Second lastname must be string');
        $this->assertOptionalString($secondFullname, 'Second fullname must be string');
        $this->assertOptionalString($secondState, 'Second state must be string');
        $this->assertOptionalString($secondCity, 'Second city must be string');
        $this->assertOptionalString($secondAddress, 'Second address must be string');
        $this->assertOptionalString($secondZip, 'Second zip must be string');
        $this->assertOptionalString($secondGender, 'Second gender must be string');
        $this->assertOptionalString($secondCountry, 'Second country must be string');
        $this->assertOptionalString($iban, 'Iban must be string');
        $this->assertOptionalString($secondIban, 'Second iban must be string');
        $this->assertOptionalString($bic, 'Bic must be string');
        $this->assertOptionalString($source, 'Transfer source must be string');
        $this->assertOptionalString($secondUserMerchantId, 'Transfer second user merchant id must be string');

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replaceZeroAllowed('amount', $amount);
        $this->replace('currency', $currency);
        $this->replace('account_id', $accountId);
        $this->replace('second_account_id', $secondAccountId);
        $this->replace('account_system', $accountSystem);
        $this->replaceZeroAllowed('amount_converted', $amountConverted);
        $this->replace('method', $method);
        $this->replace('operation', $operation);
        $this->replace('second_email', $secondEmail);
        $this->replace('second_phone', $secondPhone);
        $this->replace('second_birth_date', $secondBirthDate);
        $this->replace('second_firstname', $secondFirstname);
        $this->replace('second_lastname', $secondLastname);
        $this->replace('second_fullname', $secondFullname);
        $this->replace('second_state', $secondState);
        $this->replace('second_city', $secondCity);
        $this->replace('second_address', $secondAddress);
        $this->replace('second_zip', $secondZip);
        $this->replace('second_gender', $secondGender);
        $this->replace('second_country', $secondCountry);
        $this->replace('iban', $iban);
        $this->replace('second_iban', $secondIban);
        $this->replace('bic', $bic);
        $this->replace('transfer_source', $source);
        $this->replace('second_user_merchant_id', $secondUserMerchantId);

        return $this;
    }
}
