<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class BankAccount
 *
 * @property string $id
 * @property string $object
 * @property string $account
 * @property string $account_holder_name
 * @property string $account_holder_type
 * @property string $bank_name
 * @property string $country
 * @property string $currency
 * @property string $customer
 * @property bool $default_for_currency
 * @property string $fingerprint
 * @property string $last4
 * @property StripeObject $metadata
 * @property string $routing_number
 * @property string $status
 *
 * @package Stripe
 */
class BankAccount extends ApiResource
{
    use ApiOperations\Delete;
    use ApiOperations\Update;
    const OBJECT_NAME = "bank_account";
    public function instanceUrl()
    {
        if ($this["customer"]) {
            $base = Customer::classUrl();
            $parent = $this["customer"];
            $path = "sources";
        } else {
            if ($this["account"]) {
                $base = Account::classUrl();
                $parent = $this["account"];
                $path = "external_accounts";
            } else {
                $msg = "Bank accounts cannot be accessed without a customer ID or account ID.";
                throw new Error\InvalidRequest($msg, NULL);
            }
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this["id"]));
        return $base . "/" . $parentExtn . "/" . $path . "/" . $extn;
    }
    public static function retrieve($_id, $_opts = NULL)
    {
        $msg = "Bank accounts cannot be accessed without a customer ID or account ID. Retrieve a bank account using \$customer->sources->retrieve('bank_account_id') or \$account->external_accounts->retrieve('bank_account_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public static function update($_id, $_params = NULL, $_options = NULL)
    {
        $msg = "Bank accounts cannot be accessed without a customer ID or account ID. Call save() on \$customer->sources->retrieve('bank_account_id') or \$account->external_accounts->retrieve('bank_account_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public function verify($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/verify";
        list($response, $opts) = $this->_request("post", $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>