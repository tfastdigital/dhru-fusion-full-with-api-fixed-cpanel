<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class CreditNote
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $created
 * @property string $currency
 * @property string $customer
 * @property string $invoice
 * @property bool $livemode
 * @property string $memo
 * @property StripeObject $metadata
 * @property string $number
 * @property string $pdf
 * @property string $reason
 * @property string $refund
 * @property string $status
 * @property string $type
 *
 * @package Stripe
 */
class CreditNote extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "credit_note";
    const REASON_DUPLICATE = "duplicate";
    const REASON_FRAUDULENT = "fraudulent";
    const REASON_ORDER_CHANGE = "order_change";
    const REASON_PRODUCT_UNSATISFACTORY = "product_unsatisfactory";
    const STATUS_ISSUED = "issued";
    const STATUS_VOID = "void";
    const TYPE_POST_PAYMENT = "post_payment";
    const TYPE_PRE_PAYMENT = "pre_payment";
    public function voidCreditNote($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/void";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>