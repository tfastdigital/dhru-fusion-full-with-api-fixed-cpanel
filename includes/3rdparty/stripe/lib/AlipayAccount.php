<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class AlipayAccount
 *
 * @package Stripe
 *
 * @deprecated Alipay accounts are deprecated. Please use the sources API instead.
 * @link https://stripe.com/docs/sources/alipay
 */
class AlipayAccount extends ApiResource
{
    use ApiOperations\Delete;
    use ApiOperations\Update;
    const OBJECT_NAME = "alipay_account";
    public function instanceUrl()
    {
        if ($this["customer"]) {
            $base = Customer::classUrl();
            $parent = $this["customer"];
            $path = "sources";
            $parentExtn = urlencode(Util\Util::utf8($parent));
            $extn = urlencode(Util\Util::utf8($this["id"]));
            return $base . "/" . $parentExtn . "/" . $path . "/" . $extn;
        }
        $msg = "Alipay accounts cannot be accessed without a customer ID.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public static function retrieve($_id, $_opts = NULL)
    {
        $msg = "Alipay accounts cannot be accessed without a customer ID. Retrieve an Alipay account using \$customer->sources->retrieve('alipay_account_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public static function update($_id, $_params = NULL, $_options = NULL)
    {
        $msg = "Alipay accounts cannot be accessed without a customer ID. Call save() on \$customer->sources->retrieve('alipay_account_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
}

?>