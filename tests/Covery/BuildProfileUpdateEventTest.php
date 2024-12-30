<?php

use \Covery\Client\Envelopes\ValidatorV1;
use \Covery\Client\Envelopes\Builder;
use PHPUnit\Framework\TestCase;

class BuildProfileUpdateEventTest extends TestCase
{
    public function testBuild()
    {
        $validator = new ValidatorV1();

        // Full data
        $result = Builder::profileUpdateEvent(
            'profileUpdateEventId',
            123456,
            'profileUpdateUserMerchantId',
            'profileUpdateSequenceId',
            "groupId",
            "profileUpdateOperation",
            "profileUpdateAccountId",
            "profileUpdateAccountSystem",
            "profileUpdateCurrency",
            "profileUpdatePhone",
            true,
            "profileUpdateEmail",
            false,
            "profileUpdateContactEmail",
            "profileUpdateContactPhone",
            true,
            "profileUpdateUserName",
            "profileUpdatePassword",
            "profileUpdateSocialType",
            "profileUpdateGameLevel",
            "profileUpdateFirstname",
            "profileUpdateLastname",
            "profileUpdateFullName",
            123456,
            22,
            "profileUpdateGender",
            "profileUpdateMaritalStatus",
            "profileUpdateNationality",
            "profileUpdatePhysique",
            16.4,
            44.4,
            "profileUpdateHair",
            "profileUpdateEyes",
            "profileUpdateEducation",
            "profileUpdateEmploymentStatus",
            "profileUpdateSourceOfFunds",
            "profileUpdateIndustry",
            false,
            "profileUpdateWalletType",
            "profileUpdateWebsiteUrl",
            "profileUpdateDescription",
            "profileUpdateCountry",
            "profileUpdateState",
            "profileUpdateCity",
            "profileUpdateZip",
            "profileUpdateAddress",
            true,
            "profileUpdateSecondCountry",
            "profileUpdateSecondState",
            "profileUpdateSecondCity",
            "profileUpdateSecondZip",
            "profileUpdateSecondAddress",
            false,
            "profileUpdateProfileId",
            "profileUpdateProfileType",
            "profileUpdateProfileSubType",
            "profileUpdateDocumentCountry",
            true,
            123456,
            123456,
            654321,
            "profileUpdateRegNumber",
            "profileUpdateVatNumber",
            "profileUpdatePurposeToOpenAccount",
            33.3,
            44.0,
            55.5,
            66.6,
            77.7,
            "profileUpdateActiveFeatures",
            "profileUpdatePromotions",
            true,
            false,
            "profileUpdateCpuClass",
            "profileUpdateDeviceFingerprint",
            "profileUpdateDeviceId",
            true,
            "profileUpdateIp",
            "profileUpdateRealIp",
            "profileUpdateLocalIpList",
            "profileUpdateLanguage",
            "profileUpdateLanguages",
            "profileUpdateLanguageBrowser",
            "profileUpdateLanguageUser",
            "profileUpdateLanguageSystem",
            "profileUpdateOs",
            "profileUpdateScreenResolution",
            "profileUpdateScreenOrientation",
            "profileUpdateClientResolution",
            7654321,
            "profileUpdateUserAgent",
            "profileUpdatePlugins",
            "profileUpdateRefererUrl",
            "profileUpdateOriginUrl",
            "linksToDocuments",
            [1, 2],
            false
        )->build();


        self::assertCount(96, $result);
        self::assertSame(Builder::EVENT_PROFILE_UPDATE, $result->getType());
        self::assertSame('profileUpdateSequenceId', $result->getSequenceId());
        self::assertSame('profileUpdateEventId', $result['event_id']);
        self::assertSame(123456, $result['event_timestamp']);
        self::assertSame('profileUpdateUserMerchantId', $result['user_merchant_id']);
        self::assertSame('groupId', $result['group_id']);
        self::assertSame("profileUpdateOperation", $result['operation']);
        self::assertSame("profileUpdateAccountId", $result['account_id']);
        self::assertSame("profileUpdateAccountSystem", $result['account_system']);
        self::assertSame("profileUpdateCurrency", $result['currency']);
        self::assertSame("profileUpdatePhone", $result['phone']);
        self::assertSame(true, $result['phone_confirmed']);
        self::assertSame("profileUpdateEmail", $result['email']);
        self::assertSame(false, $result['email_confirmed']);
        self::assertSame("profileUpdateContactEmail", $result['contact_email']);
        self::assertSame("profileUpdateContactPhone", $result['contact_phone']);
        self::assertSame(true, $result['2fa_allowed']);
        self::assertSame("profileUpdateUserName", $result['user_name']);
        self::assertSame("profileUpdatePassword", $result['password']);
        self::assertSame("profileUpdateSocialType", $result['social_type']);
        self::assertSame("profileUpdateGameLevel", $result['game_level']);
        self::assertSame("profileUpdateFirstname", $result['firstname']);
        self::assertSame("profileUpdateLastname", $result['lastname']);
        self::assertSame("profileUpdateFullName", $result['fullname']);
        self::assertSame(123456, $result['birth_date']);
        self::assertSame(22, $result['age']);
        self::assertSame("profileUpdateGender", $result['gender']);
        self::assertSame("profileUpdateMaritalStatus", $result['marital_status']);
        self::assertSame("profileUpdateNationality", $result['nationality']);
        self::assertSame("profileUpdatePhysique", $result['physique']);
        self::assertSame(16.4, $result['height']);
        self::assertSame(44.4, $result['weight']);
        self::assertSame("profileUpdateHair", $result['hair']);
        self::assertSame("profileUpdateEyes", $result['eyes']);
        self::assertSame("profileUpdateEducation", $result['education']);
        self::assertSame("profileUpdateEmploymentStatus", $result['employment_status']);
        self::assertSame("profileUpdateSourceOfFunds", $result['source_of_funds']);
        self::assertSame("profileUpdateIndustry", $result['industry']);
        self::assertSame(false, $result['final_beneficiary']);
        self::assertSame("profileUpdateWalletType", $result['wallet_type']);
        self::assertSame("profileUpdateWebsiteUrl", $result['website_url']);
        self::assertSame("profileUpdateDescription", $result['description']);
        self::assertSame("profileUpdateCountry", $result['country']);
        self::assertSame("profileUpdateState", $result['state']);
        self::assertSame("profileUpdateCity", $result['city']);
        self::assertSame("profileUpdateZip", $result['zip']);
        self::assertSame("profileUpdateAddress", $result['address']);
        self::assertSame(true, $result['address_confirmed']);
        self::assertSame("profileUpdateSecondCountry", $result['second_country']);
        self::assertSame("profileUpdateSecondState", $result['second_state']);
        self::assertSame("profileUpdateSecondCity", $result['second_city']);
        self::assertSame("profileUpdateSecondZip", $result['second_zip']);
        self::assertSame("profileUpdateSecondAddress", $result['second_address']);
        self::assertSame(false, $result['second_address_confirmed']);
        self::assertSame("profileUpdateProfileId", $result['profile_id']);
        self::assertSame("profileUpdateProfileType", $result['profile_type']);
        self::assertSame("profileUpdateProfileSubType", $result['profile_sub_type']);
        self::assertSame("profileUpdateDocumentCountry", $result['document_country']);
        self::assertSame(true, $result['document_confirmed']);
        self::assertSame(123456, $result['reg_date']);
        self::assertSame(123456, $result['issue_date']);
        self::assertSame(654321, $result['expiry_date']);
        self::assertSame("profileUpdateRegNumber", $result['reg_number']);
        self::assertSame("profileUpdateVatNumber", $result['vat_number']);
        self::assertSame("profileUpdatePurposeToOpenAccount", $result['purpose_to_open_account']);
        self::assertSame(33.3, $result['one_operation_limit']);
        self::assertSame(44.0, $result['daily_limit']);
        self::assertSame(55.5, $result['weekly_limit']);
        self::assertSame(66.6, $result['monthly_limit']);
        self::assertSame(77.7, $result['annual_limit']);
        self::assertSame("profileUpdateActiveFeatures", $result['active_features']);
        self::assertSame("profileUpdatePromotions", $result['promotions']);

        //Device fingerprint fields
        self::assertSame(true, $result['ajax_validation']);
        self::assertSame(false, $result['cookie_enabled']);
        self::assertSame("profileUpdateCpuClass", $result['cpu_class']);
        self::assertSame("profileUpdateDeviceFingerprint", $result['device_fingerprint']);
        self::assertSame("profileUpdateDeviceId", $result['device_id']);
        self::assertSame(true, $result['do_not_track']);
        self::assertSame(false, $result['anonymous']);
        self::assertSame("profileUpdateIp", $result['ip']);
        self::assertSame("profileUpdateRealIp", $result['real_ip']);
        self::assertSame("profileUpdateLocalIpList", $result['local_ip_list']);
        self::assertSame("profileUpdateLanguage", $result['language']);
        self::assertSame("profileUpdateLanguages", $result['languages']);
        self::assertSame("profileUpdateLanguageBrowser", $result['language_browser']);
        self::assertSame("profileUpdateLanguageUser", $result['language_user']);
        self::assertSame("profileUpdateLanguageSystem", $result['language_system']);
        self::assertSame("profileUpdateOs", $result['os']);
        self::assertSame("profileUpdateScreenResolution", $result['screen_resolution']);
        self::assertSame("profileUpdateScreenOrientation", $result['screen_orientation']);
        self::assertSame("profileUpdateClientResolution", $result['client_resolution']);
        self::assertSame(7654321, $result['timezone_offset']);
        self::assertSame("profileUpdateUserAgent", $result['user_agent']);
        self::assertSame("profileUpdatePlugins", $result['plugins']);
        self::assertSame("profileUpdateRefererUrl", $result['referer_url']);
        self::assertSame("profileUpdateOriginUrl", $result['origin_url']);
        self::assertSame("linksToDocuments", $result['links_to_documents']);
        self::assertSame([1, 2], $result['document_id']);

        $validator->validate($result);

        // Minimal data
        $result = Builder::profileUpdateEvent(
            "profileUpdateMinEventId",
            123456789,
            "profileUpdateMinUserMerchantId"
        )->build();

        self::assertCount(3, $result);
        self::assertSame(Builder::EVENT_PROFILE_UPDATE, $result->getType());
        self::assertSame('profileUpdateMinEventId', $result['event_id']);
        self::assertSame(123456789, $result['event_timestamp']);
        self::assertSame('profileUpdateMinUserMerchantId', $result['user_merchant_id']);

        $validator->validate($result);
    }
}
