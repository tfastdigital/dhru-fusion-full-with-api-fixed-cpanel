<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class ApplicationFeeRefund
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $balance_transaction
 * @property int $created
 * @property string $currency
 * @property string $fee
 * @property StripeObject $metadata
 *
 * @package Stripe
 */
class ApplicationFeeRefund extends ApiResource
{
    use ApiOperations\Update;
    const OBJECT_NAME = "fee_refund";
    public function instanceUrl()
    {
        $id = $this["id"];
        $fee = $this["fee"];
        if (!$id) {
            throw new Error\InvalidRequest("Could not determine which URL to request: " . "class instance has invalid ID: " . $id, NULL);
        }
        $id = Util\Util::utf8($id);
        $fee = Util\Util::utf8($fee);
        $base = ApplicationFee::classUrl();
        $feeExtn = urlencode($fee);
        $extn = urlencode($id);
        return $base . "/" . $feeExtn . "/refunds/" . $extn;
    }
    public function save($opts = NULL)
    {
        return $this->_save($opts);
    }
}

?>