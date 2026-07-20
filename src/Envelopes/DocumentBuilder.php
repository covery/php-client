<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait DocumentBuilder
{
    /**
     * Returns builder for document request
     *
     * @param string $eventId
     * @param int|null $eventTimestamp
     * @param string $userId
     * @param string $documentType
     * @param string|null $sequenceId
     * @param string|null $groupId
     * @param string|null $documentCountry
     * @param string|null $documentNumber
     * @param string|null $fileName
     * @param string|null $email
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $fullname
     * @param int|null $birthDate
     * @param int|null $age
     * @param string|null $gender
     * @param string|null $nationality
     * @param string|null $country
     * @param string|null $city
     * @param string|null $zip
     * @param string|null $address
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $authority
     * @param string|null $recordNumber
     * @param string|null $personalNumber
     * @param string|null $description
     * @param float|null $productQuantity
     * @param string|null $paymentMethod
     * @param float|null $amount
     * @param float|null $amountConverted
     * @param string|null $currency
     * @param string|null $mrzDocumentType
     * @param string|null $mrzCountry
     * @param string|null $mrzLastname
     * @param string|null $mrzFirstname
     * @param string|null $mrzFullname
     * @param string|null $mrzDocumentNumber
     * @param string|null $mrzNationality
     * @param string|null $mrzPersonalNumber
     * @param int|null $mrzBirthDate
     * @param string|null $mrzGender
     * @param int|null $mrzExpiryDate
     * @param string|null $mrzRecordNumber
     * @param bool|null $mrzCheckDigitsValidation
     * @param string|null $mrzAuthority
     * @param int|null $mrzIssueDate
     * @param string|null $extractedTest
     * @param array|null $textLanguageDetails
     * @param string|null $translatedExtractedText
     * @param string|null $translatedFrom
     * @param string|null $translatedTo
     * @param string|null $deepfake
     * @param int|float|null $deepfakeConfidence
     *
     * @return Builder
     */
    public static function documentEvent(
        $eventId,
        $eventTimestamp,
        $userId,
        $documentType,
        $sequenceId = null,
        $groupId = null,
        $documentCountry = null,
        $documentNumber = null,
        $fileName = null,
        $email = null,
        $firstname = null,
        $lastname = null,
        $fullname = null,
        $birthDate = null,
        $age = null,
        $gender = null,
        $nationality = null,
        $country = null,
        $city = null,
        $zip = null,
        $address = null,
        $issueDate = null,
        $expiryDate = null,
        $authority = null,
        $recordNumber = null,
        $personalNumber = null,
        $description = null,
        $productQuantity = null,
        $paymentMethod = null,
        $amount = null,
        $amountConverted = null,
        $currency = null,
        $mrzDocumentType = null,
        $mrzCountry = null,
        $mrzLastname = null,
        $mrzFirstname = null,
        $mrzFullname = null,
        $mrzDocumentNumber = null,
        $mrzNationality = null,
        $mrzPersonalNumber = null,
        $mrzBirthDate = null,
        $mrzGender = null,
        $mrzExpiryDate = null,
        $mrzRecordNumber = null,
        $mrzCheckDigitsValidation = null,
        $mrzAuthority = null,
        $mrzIssueDate = null,
        $extractedTest = null,
        $textLanguageDetails = null,
        $translatedExtractedText = null,
        $translatedFrom = null,
        $translatedTo = null,
        $deepfake = null,
        $deepfakeConfidence = null
    ) {
        $sequenceId = $sequenceId ?? '';
        $builder = new Builder(Builder::EVENT_DOCUMENT, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addDocumentEventData(
                $eventId,
                $eventTimestamp,
                $documentType,
                $groupId,
                $documentCountry,
                $documentNumber,
                $fileName,
                $nationality,
                $issueDate,
                $expiryDate,
                $authority,
                $recordNumber,
                $personalNumber,
                $description,
                $productQuantity,
                $paymentMethod,
                $amount,
                $amountConverted,
                $currency,
                $mrzDocumentType,
                $mrzCountry,
                $mrzLastname,
                $mrzFirstname,
                $mrzFullname,
                $mrzDocumentNumber,
                $mrzNationality,
                $mrzPersonalNumber,
                $mrzBirthDate,
                $mrzGender,
                $mrzExpiryDate,
                $mrzRecordNumber,
                $mrzCheckDigitsValidation,
                $mrzAuthority,
                $mrzIssueDate,
                $extractedTest,
                $textLanguageDetails,
                $translatedExtractedText,
                $translatedFrom,
                $translatedTo,
                $deepfake,
                $deepfakeConfidence
            )
            ->addUserData(
                $email,
                $userId,
                null,
                null,
                $firstname,
                $lastname,
                $gender,
                $age,
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
                null,
                $city,
                $address,
                $zip
            );
    }

    /**
     * Provides document id value to envelope
     *
     * @param array|null $documentId
     * @return $this
     */
    public function addDocumentData($documentId = null)
    {
        if ($documentId !== null) {
            if (!is_array($documentId)) {
                throw new \InvalidArgumentException('Document id must be array');
            }

            foreach ($documentId as $id) {
                if (!is_int($id) || $id <= 0) {
                    throw new \InvalidArgumentException('Document id must be list of int');
                }
            }
        }
        $this->replace('document_id', $documentId);

        return $this;
    }

    /**
     * Add links to documents
     *
     * @param string|null $linksToDocuments
     * @return $this
     */
    public function addLinksToDocuments($linksToDocuments = null)
    {
        $this->assertOptionalString($linksToDocuments, 'Links to documents must be string');
        $this->replace('links_to_documents', $linksToDocuments);

        return $this;
    }

    /**
     * Provides document information to envelope
     *
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string $documentType
     * @param string|null $groupId
     * @param string|null $documentCountry
     * @param string|null $documentNumber
     * @param string|null $fileName
     * @param string|null $nationality
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $authority
     * @param string|null $recordNumber
     * @param string|null $personalNumber
     * @param string|null $description
     * @param float|null $productQuantity
     * @param string|null $paymentMethod
     * @param float|null $amount
     * @param float|null $amountConverted
     * @param string|null $currency
     * @param string|null $mrzDocumentType
     * @param string|null $mrzCountry
     * @param string|null $mrzLastname
     * @param string|null $mrzFirstname
     * @param string|null $mrzFullname
     * @param string|null $mrzDocumentNumber
     * @param string|null $mrzNationality
     * @param string|null $mrzPersonalNumber
     * @param int|null $mrzBirthDate
     * @param string|null $mrzGender
     * @param int|null $mrzExpiryDate
     * @param string|null $mrzRecordNumber
     * @param bool|null $mrzCheckDigitsValidation
     * @param string|null $mrzAuthority
     * @param int|null $mrzIssueDate
     * @param string|null $extractedTest
     * @param array|null $textLanguageDetails
     * @param string|null $translatedExtractedText
     * @param string|null $translatedFrom
     * @param string|null $translatedTo
     * @param string|null $deepfake
     * @param int|float|null $deepfakeConfidence
     * @return Builder
     */
    public function addDocumentEventData(
        $eventId,
        $eventTimestamp,
        $documentType,
        $groupId = null,
        $documentCountry = null,
        $documentNumber = null,
        $fileName = null,
        $nationality = null,
        $issueDate = null,
        $expiryDate = null,
        $authority = null,
        $recordNumber = null,
        $personalNumber = null,
        $description = null,
        $productQuantity = null,
        $paymentMethod = null,
        $amount = null,
        $amountConverted = null,
        $currency = null,
        $mrzDocumentType = null,
        $mrzCountry = null,
        $mrzLastname = null,
        $mrzFirstname = null,
        $mrzFullname = null,
        $mrzDocumentNumber = null,
        $mrzNationality = null,
        $mrzPersonalNumber = null,
        $mrzBirthDate = null,
        $mrzGender = null,
        $mrzExpiryDate = null,
        $mrzRecordNumber = null,
        $mrzCheckDigitsValidation = null,
        $mrzAuthority = null,
        $mrzIssueDate = null,
        $extractedTest = null,
        $textLanguageDetails = null,
        $translatedExtractedText = null,
        $translatedFrom = null,
        $translatedTo = null,
        $deepfake = null,
        $deepfakeConfidence = null
    ) {
        $this->assertString($eventId, 'Event ID must be string');
        $this->assertInt($eventTimestamp, 'Event timestamp must be int');
        if (empty($documentType)) {
            throw new \InvalidArgumentException('Document Type is empty');
        }
        if (!in_array($documentType, DocumentType::getShortList())) {
            throw new \InvalidArgumentException('Document Type must be one of the types: ' . implode(
                    ', ',
                    DocumentType::getShortList()
                )
            );
        }
        $this->assertOptionalString($groupId, 'Group ID must be string');
        $this->assertOptionalString($documentCountry, 'Document Country must be string');
        $this->assertOptionalString($documentNumber, 'Document Number must be string');
        $this->assertOptionalString($fileName, 'File Name must be string');
        $this->assertOptionalString($nationality, 'Nationality must be string');
        $this->assertOptionalInt($issueDate, 'Issue Date must be int');
        $this->assertOptionalInt($expiryDate, 'Expiry Date must be int');
        $this->assertOptionalString($authority, 'Authority must be string');
        $this->assertOptionalString($recordNumber, 'Record Number must be string');
        $this->assertOptionalString($personalNumber, 'Personal Number must be string');
        $this->assertOptionalString($description, 'Description must be string');
        $this->assertOptionalFloat($productQuantity, 'Product Quantity must be float');
        $this->assertOptionalString($paymentMethod, 'Payment Method must be string');
        if ($amount !== null) {
            $this->assertFloat($amount, 'Amount must be float');
            if ($amount < 0) {
                throw new \InvalidArgumentException('Amount cannot be negative');
            }
        }
        $this->assertOptionalNonNegativeNumber($amountConverted, 'Amount converted must be number', 'Amount converted cannot be negative');
        $this->assertOptionalString($currency, 'Currency must be string');
        $this->assertOptionalString($mrzDocumentType, 'Mrz Document Type must be string');
        $this->assertOptionalString($mrzCountry, 'Mrz Country must be string');
        $this->assertOptionalString($mrzLastname, 'Mrz Lastname must be string');
        $this->assertOptionalString($mrzFirstname, 'Mrz Firstname must be string');
        $this->assertOptionalString($mrzFullname, 'Mrz Fullname must be string');
        $this->assertOptionalString($mrzDocumentNumber, 'Mrz Document Number must be string');
        $this->assertOptionalString($mrzNationality, 'Mrz Nationality must be string');
        $this->assertOptionalString($mrzPersonalNumber, 'Mrz Personal Number must be string');
        $this->assertOptionalInt($mrzBirthDate, 'Mrz Birth Date must be int');
        $this->assertOptionalString($mrzGender, 'Mrz Gender must be string');
        $this->assertOptionalInt($mrzExpiryDate, 'Mrz Expiry Date must be int');
        $this->assertOptionalString($mrzRecordNumber, 'Mrz Record Number must be string');
        $this->assertOptionalBool($mrzCheckDigitsValidation, 'Mrz Check Digits Validation enabled flag must be boolean');
        $this->assertOptionalString($mrzAuthority, 'Mrz Authority must be string');
        $this->assertOptionalInt($mrzIssueDate, 'Mrz Issue Date must be int');
        $this->assertOptionalString($extractedTest, 'Extracted Test must be string');
        if ($textLanguageDetails !== null) {
            if (!is_array($textLanguageDetails)) {
                throw new \InvalidArgumentException('Text Language Details must be array');
            }

            foreach ($textLanguageDetails as $detail) {
                $this->assertString($detail, 'Text Language Details must be list of string');
            }
        }
        $this->assertOptionalString($translatedExtractedText, 'Translated Extracted Text must be string');
        $this->assertOptionalString($translatedFrom, 'Translated From must be string');
        $this->assertOptionalString($translatedTo, 'Translated To must be string');
        $this->assertOptionalBool($deepfake, 'Deepfake enabled flag must be boolean');
        if ($deepfakeConfidence !== null) {
            $this->assertNonNegativeNumber($deepfakeConfidence, 'Deepfake confidence must be number', 'Deepfake confidence cannot be negative');
            if ($deepfakeConfidence > 1) {
                throw new \InvalidArgumentException('Deepfake confidence cannot be greater than 1');
            }
        }

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('document_type', $documentType);
        $this->replace('group_id', $groupId);
        $this->replace('document_country', $documentCountry);
        $this->replace('document_number', $documentNumber);
        $this->replace('file_name', $fileName);
        $this->replace('nationality', $nationality);
        $this->replace('issue_date', $issueDate);
        $this->replace('expiry_date', $expiryDate);
        $this->replace('authority', $authority);
        $this->replace('record_number', $recordNumber);
        $this->replace('personal_number', $personalNumber);
        $this->replace('description', $description);
        $this->replace('product_quantity', $productQuantity);
        $this->replace('payment_method', $paymentMethod);
        $this->replaceZeroAllowed('amount', $amount);
        $this->replaceZeroAllowed('amount_converted', $amountConverted);
        $this->replace('currency', $currency);
        $this->replace('mrz_document_type', $mrzDocumentType);
        $this->replace('mrz_country', $mrzCountry);
        $this->replace('mrz_lastname', $mrzLastname);
        $this->replace('mrz_firstname', $mrzFirstname);
        $this->replace('mrz_fullname', $mrzFullname);
        $this->replace('mrz_document_number', $mrzDocumentNumber);
        $this->replace('mrz_nationality', $mrzNationality);
        $this->replace('mrz_personal_number', $mrzPersonalNumber);
        $this->replace('mrz_birth_date', $mrzBirthDate);
        $this->replace('mrz_gender', $mrzGender);
        $this->replace('mrz_expiry_date', $mrzExpiryDate);
        $this->replace('mrz_record_number', $mrzRecordNumber);
        $this->replace('mrz_check_digits_validation', $mrzCheckDigitsValidation);
        $this->replace('mrz_authority', $mrzAuthority);
        $this->replace('mrz_issue_date', $mrzIssueDate);
        $this->replace('extracted_text', $extractedTest);
        $this->replace('text_language_details', $textLanguageDetails);
        $this->replace('translated_extracted_text', $translatedExtractedText);
        $this->replace('translated_from', $translatedFrom);
        $this->replace('translated_to', $translatedTo);
        $this->replace('deepfake', $deepfake);
        $this->replaceZeroAllowed('deepfake_confidence', $deepfakeConfidence);

        return $this;
    }
}
