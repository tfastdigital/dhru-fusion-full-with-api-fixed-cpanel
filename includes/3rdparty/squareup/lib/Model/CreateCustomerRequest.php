<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateCustomerRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateCustomerRequest implements \ArrayAccess
{
    /**
     * $idempotency_key The idempotency key for the request. See the [Idempotency](/basics/api101/idempotency) guide for more information.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $given_name The customer's given (i.e., first) name.
     * @var string
     */
    protected $given_name = NULL;
    /**
     * $family_name The customer's family (i.e., last) name.
     * @var string
     */
    protected $family_name = NULL;
    /**
     * $company_name The name of the customer's company.
     * @var string
     */
    protected $company_name = NULL;
    /**
     * $nickname A nickname for the customer.
     * @var string
     */
    protected $nickname = NULL;
    /**
     * $email_address The customer's email address.
     * @var string
     */
    protected $email_address = NULL;
    /**
     * $address The customer's physical address.
     * @var \SquareConnect\Model\Address
     */
    protected $address = NULL;
    /**
     * $phone_number The customer's phone number.
     * @var string
     */
    protected $phone_number = NULL;
    /**
     * $reference_id An optional second ID you can set to associate the customer with an entity in another system.
     * @var string
     */
    protected $reference_id = NULL;
    /**
     * $note An optional note to associate with the customer.
     * @var string
     */
    protected $note = NULL;
    /**
     * $birthday The customer birthday in RFC-3339 format. Year is optional, timezone and times are not allowed. Example: `0000-09-01T00:00:00-00:00` for a birthday on September 1st. `1998-09-01T00:00:00-00:00` for a birthday on September 1st 1998.
     * @var string
     */
    protected $birthday = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["idempotency_key" => "string", "given_name" => "string", "family_name" => "string", "company_name" => "string", "nickname" => "string", "email_address" => "string", "address" => "\\SquareConnect\\Model\\Address", "phone_number" => "string", "reference_id" => "string", "note" => "string", "birthday" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["idempotency_key" => "idempotency_key", "given_name" => "given_name", "family_name" => "family_name", "company_name" => "company_name", "nickname" => "nickname", "email_address" => "email_address", "address" => "address", "phone_number" => "phone_number", "reference_id" => "reference_id", "note" => "note", "birthday" => "birthday"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["idempotency_key" => "setIdempotencyKey", "given_name" => "setGivenName", "family_name" => "setFamilyName", "company_name" => "setCompanyName", "nickname" => "setNickname", "email_address" => "setEmailAddress", "address" => "setAddress", "phone_number" => "setPhoneNumber", "reference_id" => "setReferenceId", "note" => "setNote", "birthday" => "setBirthday"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["idempotency_key" => "getIdempotencyKey", "given_name" => "getGivenName", "family_name" => "getFamilyName", "company_name" => "getCompanyName", "nickname" => "getNickname", "email_address" => "getEmailAddress", "address" => "getAddress", "phone_number" => "getPhoneNumber", "reference_id" => "getReferenceId", "note" => "getNote", "birthday" => "getBirthday"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["given_name"])) {
                $this->given_name = $data["given_name"];
            } else {
                $this->given_name = NULL;
            }
            if (isset($data["family_name"])) {
                $this->family_name = $data["family_name"];
            } else {
                $this->family_name = NULL;
            }
            if (isset($data["company_name"])) {
                $this->company_name = $data["company_name"];
            } else {
                $this->company_name = NULL;
            }
            if (isset($data["nickname"])) {
                $this->nickname = $data["nickname"];
            } else {
                $this->nickname = NULL;
            }
            if (isset($data["email_address"])) {
                $this->email_address = $data["email_address"];
            } else {
                $this->email_address = NULL;
            }
            if (isset($data["address"])) {
                $this->address = $data["address"];
            } else {
                $this->address = NULL;
            }
            if (isset($data["phone_number"])) {
                $this->phone_number = $data["phone_number"];
            } else {
                $this->phone_number = NULL;
            }
            if (isset($data["reference_id"])) {
                $this->reference_id = $data["reference_id"];
            } else {
                $this->reference_id = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
            }
            if (isset($data["birthday"])) {
                $this->birthday = $data["birthday"];
            } else {
                $this->birthday = NULL;
            }
        }
    }
    public function getIdempotencyKey()
    {
        return $this->idempotency_key;
    }
    public function setIdempotencyKey($idempotency_key)
    {
        $this->idempotency_key = $idempotency_key;
        return $this;
    }
    public function getGivenName()
    {
        return $this->given_name;
    }
    public function setGivenName($given_name)
    {
        $this->given_name = $given_name;
        return $this;
    }
    public function getFamilyName()
    {
        return $this->family_name;
    }
    public function setFamilyName($family_name)
    {
        $this->family_name = $family_name;
        return $this;
    }
    public function getCompanyName()
    {
        return $this->company_name;
    }
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
        return $this;
    }
    public function getNickname()
    {
        return $this->nickname;
    }
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }
    public function getEmailAddress()
    {
        return $this->email_address;
    }
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
        return $this;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }
    public function getReferenceId()
    {
        return $this->reference_id;
    }
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
    public function getBirthday()
    {
        return $this->birthday;
    }
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
    public function __toString()
    {
        if (defined("JSON_PRETTY_PRINT")) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }
        return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
    }
}

?>