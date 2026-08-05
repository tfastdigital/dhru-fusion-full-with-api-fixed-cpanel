<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Subscription
 *
 * @property string $id
 * @property string $object
 * @property float $application_fee_percent
 * @property string $billing
 * @property int $billing_cycle_anchor
 * @property mixed $billing_thresholds
 * @property bool $cancel_at_period_end
 * @property int $canceled_at
 * @property int $created
 * @property int $current_period_end
 * @property int $current_period_start
 * @property string $customer
 * @property int $days_until_due
 * @property string $default_payment_method
 * @property string $default_source
 * @property array $default_tax_rates
 * @property Discount $discount
 * @property int $ended_at
 * @property Collection $items
 * @property string $latest_invoice
 * @property boolean $livemode
 * @property StripeObject $metadata
 * @property Plan $plan
 * @property int $quantity
 * @property SubscriptionSchedule $schedule
 * @property int $start
 * @property string $status
 * @property float $tax_percent
 * @property int $trial_end
 * @property int $trial_start
 *
 * @package Stripe
 */
class Subscription extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "subscription";
    const STATUS_ACTIVE = "active";
    const STATUS_CANCELED = "canceled";
    const STATUS_PAST_DUE = "past_due";
    const STATUS_TRIALING = "trialing";
    const STATUS_UNPAID = "unpaid";
    const STATUS_INCOMPLETE = "incomplete";
    const STATUS_INCOMPLETE_EXPIRED = "incomplete_expired";
    public static function getSavedNestedResources()
    {
        static $savedNestedResources = NULL;
        if ($savedNestedResources === NULL) {
            $savedNestedResources = new Util\Set(["source"]);
        }
        return $savedNestedResources;
    }
    public function cancel($params = NULL, $opts = NULL)
    {
        return $this->_delete($params, $opts);
    }
    public function deleteDiscount()
    {
        $url = $this->instanceUrl() . "/discount";
        list($response, $opts) = $this->_request("delete", $url);
        $this->refreshFrom(["discount" => NULL], $opts, true);
    }
}

?>