<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Account
 *
 * @property string $id
 * @property string $object
 * @property mixed $business_profile
 * @property string $business_type
 * @property mixed $capabilities
 * @property bool $charges_enabled
 * @property mixed $company
 * @property string $country
 * @property int $created
 * @property string $default_currency
 * @property bool $details_submitted
 * @property string $email
 * @property Collection $external_accounts
 * @property mixed $individual
 * @property StripeObject $metadata
 * @property bool $payouts_enabled
 * @property mixed $requirements
 * @property mixed $settings
 * @property mixed $tos_acceptance
 * @property string $type
 *
 * @package Stripe
 */
class Account extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\NestedResource;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "account";
    const BUSINESS_TYPE_COMPANY = "company";
    const BUSINESS_TYPE_INDIVIDUAL = "individual";
    const CAPABILITY_CARD_PAYMENTS = "card_payments";
    const CAPABILITY_LEGACY_PAYMENTS = "legacy_payments";
    const CAPABILITY_PLATFORM_PAYMENTS = "platform_payments";
    const CAPABILITY_STATUS_ACTIVE = "active";
    const CAPABILITY_STATUS_INACTIVE = "inactive";
    const CAPABILITY_STATUS_PENDING = "pending";
    const TYPE_CUSTOM = "custom";
    const TYPE_EXPRESS = "express";
    const TYPE_STANDARD = "standard";
    const PATH_EXTERNAL_ACCOUNTS = "/external_accounts";
    const PATH_LOGIN_LINKS = "/login_links";
    const PATH_PERSONS = "/persons";
    public static function getSavedNestedResources()
    {
        static $savedNestedResources = NULL;
        if ($savedNestedResources === NULL) {
            $savedNestedResources = new Util\Set(["external_account", "bank_account"]);
        }
        return $savedNestedResources;
    }
    public function instanceUrl()
    {
        if ($this["id"] === NULL) {
            return "/v1/account";
        }
        return parent::instanceUrl();
    }
    public static function retrieve($id = NULL, $opts = NULL)
    {
        if (!$opts && is_string($id) && substr($id, 0, 3) === "sk_") {
            $opts = $id;
            $id = NULL;
        }
        return self::_retrieve($id, $opts);
    }
    public function reject($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/reject";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function persons($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/persons";
        list($response, $opts) = $this->_request("get", $url, $params, $options);
        $obj = Util\Util::convertToStripeObject($response, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
    public function deauthorize($clientId = NULL, $opts = NULL)
    {
        $params = ["client_id" => $clientId, "stripe_user_id" => $this->id];
        return OAuth::deauthorize($params, $opts);
    }
    public static function createExternalAccount($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }
    public static function retrieveExternalAccount($id, $externalAccountId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }
    public static function updateExternalAccount($id, $externalAccountId, $params = NULL, $opts = NULL)
    {
        return self::_updateNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }
    public static function deleteExternalAccount($id, $externalAccountId, $params = NULL, $opts = NULL)
    {
        return self::_deleteNestedResource($id, static::PATH_EXTERNAL_ACCOUNTS, $externalAccountId, $params, $opts);
    }
    public static function allExternalAccounts($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_EXTERNAL_ACCOUNTS, $params, $opts);
    }
    public static function createLoginLink($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_LOGIN_LINKS, $params, $opts);
    }
    public static function createPerson($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_PERSONS, $params, $opts);
    }
    public static function retrievePerson($id, $personId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }
    public static function updatePerson($id, $personId, $params = NULL, $opts = NULL)
    {
        return self::_updateNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }
    public static function deletePerson($id, $personId, $params = NULL, $opts = NULL)
    {
        return self::_deleteNestedResource($id, static::PATH_PERSONS, $personId, $params, $opts);
    }
    public static function allPersons($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_PERSONS, $params, $opts);
    }
    public function serializeParameters($force = false)
    {
        $update = parent::serializeParameters($force);
        if (isset($this->_values["legal_entity"])) {
            $entity = $this["legal_entity"];
            if (isset($entity->_values["additional_owners"])) {
                $owners = $entity["additional_owners"];
                $entityUpdate = isset($update["legal_entity"]) ? $update["legal_entity"] : [];
                $entityUpdate["additional_owners"] = $this->serializeAdditionalOwners($entity, $owners);
                $update["legal_entity"] = $entityUpdate;
            }
        }
        if (isset($this->_values["individual"])) {
            $individual = $this["individual"];
            if ($individual instanceof Person && !isset($update["individual"])) {
                $update["individual"] = $individual->serializeParameters($force);
            }
        }
        return $update;
    }
    private function serializeAdditionalOwners($legalEntity, $additionalOwners)
    {
        if (isset($legalEntity->_originalValues["additional_owners"])) {
            $originalValue = $legalEntity->_originalValues["additional_owners"];
        } else {
            $originalValue = [];
        }
        if ($originalValue && count($additionalOwners) < count($originalValue)) {
            throw new \InvalidArgumentException("You cannot delete an item from an array, you must instead set a new array");
        }
        $updateArr = [];
        foreach ($additionalOwners as $i => $v) {
            $update = $v instanceof StripeObject ? $v->serializeParameters() : $v;
            if ($update !== [] && (!$originalValue || !array_key_exists($i, $originalValue) || $update != $legalEntity->serializeParamsValue($originalValue[$i], NULL, false, true))) {
                $updateArr[$i] = $update;
            }
        }
        return $updateArr;
    }
}

?>