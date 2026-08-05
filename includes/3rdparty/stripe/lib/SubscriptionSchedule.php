<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class SubscriptionSchedule
 *
 * @property string $id
 * @property string $object
 * @property string $billing
 * @property mixed $billing_thresholds
 * @property int $canceled_at
 * @property int $completed_at
 * @property int $created
 * @property mixed $current_phase
 * @property string $customer
 * @property mixed $invoice_settings
 * @property boolean $livemode
 * @property StripeObject $metadata
 * @property mixed $phases
 * @property int $released_at
 * @property string $released_subscription
 * @property string $renewal_behavior
 * @property mixed $renewal_interval
 * @property string $revision
 * @property string $status
 * @property string $subscription
 *
 * @package Stripe
 */
class SubscriptionSchedule extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    use ApiOperations\NestedResource;
    const OBJECT_NAME = "subscription_schedule";
    const PATH_REVISIONS = "/revisions";
    public function cancel($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/cancel";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function release($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/release";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function revisions($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/revisions";
        list($response, $opts) = $this->_request("get", $url, $params, $options);
        $obj = Util\Util::convertToStripeObject($response, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
    public static function retrieveRevision($id, $personId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_REVISIONS, $personId, $params, $opts);
    }
    public static function allRevisions($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_REVISIONS, $params, $opts);
    }
}

?>