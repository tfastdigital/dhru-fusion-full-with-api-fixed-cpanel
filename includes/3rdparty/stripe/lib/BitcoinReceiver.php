<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class BitcoinReceiver
 *
 * @package Stripe
 *
 * @deprecated Bitcoin receivers are deprecated. Please use the sources API instead.
 * @link https://stripe.com/docs/sources/bitcoin
 */
class BitcoinReceiver extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "bitcoin_receiver";
    public static function classUrl()
    {
        return "/v1/bitcoin/receivers";
    }
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
        $base = BitcoinReceiver::classUrl();
        $extn = urlencode(Util\Util::utf8($this["id"]));
        return $base . "/" . $extn;
    }
}

?>