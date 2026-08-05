<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait AccountEventBuilder
{
    /**
     * Returns builder for confirmation event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp If null provided, takes current time
     * @param bool|null $isEmailConfirmed
     * @param bool|null $idPhoneConfirmed
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $groupId
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function confirmationEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $isEmailConfirmed = null,
        $idPhoneConfirmed = null,
        $email = null,
        $phone = null,
        $groupId = null,
        $documentId = null
    ) {
        $builder = new Builder('confirmation', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addUserData(
            $email,
            $userId,
            $phone,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $timestamp,
            $isEmailConfirmed,
            $idPhoneConfirmed,
            null
        )
            ->addGroupId($groupId)
            ->addDocumentData($documentId);
    }

    /**
     * Returns builder for login event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp
     * @param string|null $email
     * @param bool|null $failed
     * @param string|null $gender
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     * @param string|null $password
     * @param string|null $campaign
     * @param string|null $groupId
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function loginEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $email = null,
        $failed = null,
        $gender = null,
        $trafficSource = null,
        $affiliateId = null,
        $password = null,
        $campaign = null,
        $groupId = null,
        $documentId = null
    ) {
        $builder = new Builder('login', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addUserData(
            $email,
            $userId,
            null,
            null,
            null,
            null,
            $gender,
            null,
            null,
            null,
            null,
            $timestamp,
            null,
            null,
            null,
            $failed,
            null,
            null,
            null,
            null,
            null,
            null,
            $password
        )
            ->addWebsiteData(null, $trafficSource, $affiliateId, $campaign)
            ->addGroupId($groupId)
            ->addDocumentData($documentId);
    }

    /**
     * Returns builder for registration event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp
     * @param string|null $email
     * @param string|null $userName
     * @param string|null $firstName
     * @param string|null $lastName
     * @param int|null $age
     * @param string|null $gender
     * @param string|null $phone
     * @param string|null $country
     * @param string|null $socialType
     * @param string|null $websiteUrl
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     * @param string|null $password
     * @param string|null $campaign
     * @param string|null $groupId
     * @param array|null $documentId
     *
     * @return Builder
     */
    public static function registrationEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $email = null,
        $userName = null,
        $firstName = null,
        $lastName = null,
        $age = null,
        $gender = null,
        $phone = null,
        $country = null,
        $socialType = null,
        $websiteUrl = null,
        $trafficSource = null,
        $affiliateId = null,
        $password = null,
        $campaign = null,
        $groupId = null,
        $documentId = null
    ) {
        $builder = new Builder('registration', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addWebsiteData(
            $websiteUrl,
            $trafficSource,
            $affiliateId,
            $campaign
        )->addUserData(
            $email,
            $userId,
            $phone,
            $userName,
            $firstName,
            $lastName,
            $gender,
            $age,
            $country,
            $socialType,
            $timestamp,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $password
        )
            ->addGroupId($groupId)
            ->addDocumentData($documentId);
    }

    /**
     * Returns builder for install request
     *
     * @param string $sequenceId
     * @param string|null $userId
     * @param int|null $installTimestamp
     * @param string|null $country
     * @param string|null $websiteUrl
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     * @param string|null $campaign
     * @param string|null $groupId
     * @param array|null $documentId
     * @return Builder
     */
    public static function installEvent(
        $sequenceId,
        $userId = null,
        $installTimestamp = null,
        $country = null,
        $websiteUrl = null,
        $trafficSource = null,
        $affiliateId = null,
        $campaign = null,
        $groupId = null,
        $documentId = null
    ) {
        $builder = new Builder('install', $sequenceId);
        if ($installTimestamp === null) {
            $installTimestamp = time();
        }

        return $builder->addInstallData(
            $installTimestamp
        )->addWebsiteData($websiteUrl, $trafficSource, $affiliateId, $campaign)
        ->addShortUserData(null, $userId, null, null, null, $country)
        ->addGroupId($groupId)
        ->addDocumentData($documentId);
    }

    /**
     * Provides install information to envelope
     *
     * @param int $installTimestamp
     *
     * @return $this
     */
    public function addInstallData($installTimestamp)
    {
        $this->assertInt($installTimestamp, 'Install timestamp must be int');

        $this->replace('install_timestamp', $installTimestamp);

        return $this;
    }
}
