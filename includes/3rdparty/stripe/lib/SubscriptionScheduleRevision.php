<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class SubscriptionScheduleRevision
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property mixed $invoice_settings
 * @property boolean $livemode
 * @property mixed $phases
 * @property string $previous_revision
 * @property string $renewal_behavior
 * @property mixed $renewal_interval
 * @property string $schedule
 *
 * @package Stripe
 */
class SubscriptionScheduleRevision extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "subscription_schedule_revision";
    public function instanceUrl()
    {
        $id = $this["id"];
        $schedule = $this["schedule"];
        if (!$id) {
            throw new Error\InvalidRequest("Could not determine which URL to request: " . "class instance has invalid ID: " . $id, NULL);
        }
        $id = Util\Util::utf8($id);
        $schedule = Util\Util::utf8($schedule);
        $base = SubscriptionSchedule::classUrl();
        $scheduleExtn = urlencode($schedule);
        $extn = urlencode($id);
        return $base . "/" . $scheduleExtn . "/revisions/" . $extn;
    }
    public static function retrieve($_id, $_opts = NULL)
    {
        $msg = "Subscription Schedule Revisions cannot be accessed without a Subscription Schedule ID. Retrieve one using \$schedule->retrieveRevision('revision_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
    public static function all($params = NULL, $opts = NULL)
    {
        $msg = "Subscription Schedule Revisions cannot be listed without a Subscription Schedule ID. List those using \$schedule->allRevisions('revision_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
}

?>