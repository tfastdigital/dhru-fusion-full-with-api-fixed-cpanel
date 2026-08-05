<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Refund
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $balance_transaction
 * @property string $charge
 * @property int $created
 * @property string $currency
 * @property string $description
 * @property string $failure_balance_transaction
 * @property string $failure_reason
 * @property StripeObject $metadata
 * @property string $reason
 * @property string $receipt_number
 * @property string $source_transfer_reversal
 * @property string $status
 * @property string $transfer_reversal
 *
 * @package Stripe
 */
class Refund extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "refund";
    const FAILURE_REASON = "expired_or_canceled_card";
    const FAILURE_REASON_LOST_OR_STOLEN_CARD = "lost_or_stolen_card";
    const FAILURE_REASON_UNKNOWN = "unknown";
    const REASON_DUPLICATE = "duplicate";
    const REASON_FRAUDULENT = "fraudulent";
    const REASON_REQUESTED_BY_CUSTOMER = "requested_by_customer";
    const STATUS_CANCELED = "canceled";
    const STATUS_FAILED = "failed";
    const STATUS_PENDING = "pending";
    const STATUS_SUCCEEDED = "succeeded";
}

?>