<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class TransferReversal
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $balance_transaction
 * @property int $created
 * @property string $currency
 * @property string $destination_payment_refund
 * @property StripeObject $metadata
 * @property string $source_refund
 * @property string $transfer
 *
 * @package Stripe
 */
class TransferReversal extends ApiResource
{
    use ApiOperations\Update;
    const OBJECT_NAME = "transfer_reversal";
    public function instanceUrl()
    {
        $id = $this["id"];
        $transfer = $this["transfer"];
        if (!$id) {
            throw new Error\InvalidRequest("Could not determine which URL to request: " . "class instance has invalid ID: " . $id, NULL);
        }
        $id = Util\Util::utf8($id);
        $transfer = Util\Util::utf8($transfer);
        $base = Transfer::classUrl();
        $transferExtn = urlencode($transfer);
        $extn = urlencode($id);
        return $base . "/" . $transferExtn . "/reversals/" . $extn;
    }
    public function save($opts = NULL)
    {
        return $this->_save($opts);
    }
}

?>