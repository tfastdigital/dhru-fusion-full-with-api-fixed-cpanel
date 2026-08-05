<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class SubscriptionItem
 *
 * @property string $id
 * @property string $object
 * @property mixed $billing_thresholds
 * @property int $created
 * @property StripeObject $metadata
 * @property Plan $plan
 * @property int $quantity
 * @property string $subscription
 * @property array $tax_rates
 *
 * @package Stripe
 */
class SubscriptionItem extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "subscription_item";
    public function usageRecordSummaries($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/usage_record_summaries";
        list($response, $opts) = $this->_request("get", $url, $params, $options);
        $obj = Util\Util::convertToStripeObject($response, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
}

?>