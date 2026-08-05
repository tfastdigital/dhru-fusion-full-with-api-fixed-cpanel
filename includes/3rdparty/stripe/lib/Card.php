<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Card
 *
 * @property string $id
 * @property string $object
 * @property string $account
 * @property string $address_city
 * @property string $address_country
 * @property string $address_line1
 * @property string $address_line1_check
 * @property string $address_line2
 * @property string $address_state
 * @property string $address_zip
 * @property string $address_zip_check
 * @property string[] $available_payout_methods
 * @property string $brand
 * @property string $country
 * @property string $currency
 * @property string $customer
 * @property string $cvc_check
 * @property bool $default_for_currency
 * @property string $dynamic_last4
 * @property int $exp_month
 * @property int $exp_year
 * @property string $fingerprint
 * @property string $funding
 * @property string $last4
 * @property StripeObject $metadata
 * @property string $name
 * @property string $recipient
 * @property string $tokenization_method
 *
 * @package Stripe
 */
class Card extends ApiResource
{
    use ApiOperations\Delete;
    use ApiOperations\Update;
    const OBJECT_NAME = "card";
    const CVC_CHECK_FAIL = "fail";
    const CVC_CHECK_PASS = "pass";
    const CVC_CHECK_UNAVAILABLE = "unavailable";
    const CVC_CHECK_UNCHECKED = "unchecked";
    const FUNDING_CREDIT = "credit";
    const FUNDING_DEBIT = "debit";
    const FUNDING_PREPAID = "prepaid";
    const FUNDING_UNKNOWN = "unknown";
    const TOKENIZATION_METHOD_APPLE_PAY = "apple_pay";
    const TOKENIZATION_METHOD_GOOGLE_PAY = "google_pay";
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
                if ($this["recipient"]) {
                    $base = Recipient::classUrl();
                    $parent = $this["recipient"];
                    $path = "cards";
                } else {
                    $msg = "Cards cannot be accessed without a customer ID, account ID or recipient ID.";
                    throw new Error\InvalidRequest($msg, NULL);
                }
            }
        }
        $parentExtn = urlencode(Util\Util::utf8($parent));
        $extn = urlencode(Util\Util::utf8($this["id"]));
        return $base . "/" . $parentExtn . "/" . $path . "/" . $extn;
    }
    public static function retrieve($_id, $_opts = NULL)
    {
        $msg = "Cards cannot be accessed without a customer, recipient or account ID. Retrieve a card using \$customer->sources->retrieve('card_id'), \$recipient->cards->retrieve('card_id'), or \$account->external_accounts->retrieve('card_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public static function update($_id, $_params = NULL, $_options = NULL)
    {
        $msg = "Cards cannot be accessed without a customer, recipient or account ID. Call save() on \$customer->sources->retrieve('card_id'), \$recipient->cards->retrieve('card_id'), or \$account->external_accounts->retrieve('card_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
}

?>