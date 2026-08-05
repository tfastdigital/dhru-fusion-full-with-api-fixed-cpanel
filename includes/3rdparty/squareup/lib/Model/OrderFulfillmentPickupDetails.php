<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderFulfillmentPickupDetails Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderFulfillmentPickupDetails implements \ArrayAccess
{
    /**
     * $recipient The recipient of this pickup fulfillment.
     * @var \SquareConnect\Model\OrderFulfillmentRecipient
     */
    protected $recipient = NULL;
    /**
     * $expires_at The expiry [timestamp](#workingwithdates) in RFC 3339 format, e.g., \"2016-09-04T23:59:33.123Z\". This timestamp indicates when the pickup fulfillment will expire if it is not accepted by the merchant. Expiration time can only be set up to 7 days in the future. If not set, this pickup fulfillment will be automatically accepted when placed.
     * @var string
     */
    protected $expires_at = NULL;
    /**
     * $auto_complete_duration The auto completion duration in RFC3339 duration format, e.g., \"P1W3D\". If set, an open and accepted pickup fulfillment will automatically move to the `COMPLETED` state after this period of time. If not set, this pickup fulfillment will remain accepted until it is canceled or completed.
     * @var string
     */
    protected $auto_complete_duration = NULL;
    /**
     * $schedule_type The schedule type of the pickup fulfillment. Defaults to `SCHEDULED`. See [OrderFulfillmentPickupDetailsScheduleType](#type-orderfulfillmentpickupdetailsscheduletype) for possible values
     * @var string
     */
    protected $schedule_type = NULL;
    /**
     * $pickup_at The pickup [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\". For fulfillments with the schedule type `ASAP`, this is automatically set to the current time plus the expected duration to prepare the fulfillment. This represents the start of the pickup window.
     * @var string
     */
    protected $pickup_at = NULL;
    /**
     * $pickup_window_duration The pickup window duration in RFC3339 duration format, e.g., \"P1W3D\". This duration represents the window of time for which the order should be picked up after the `pickup_at` time. Can be used as an informational guideline for merchants.
     * @var string
     */
    protected $pickup_window_duration = NULL;
    /**
     * $prep_time_duration The preparation time duration in RFC3339 duration format, e.g., \"P1W3D\". This duration indicates how long it takes the merchant to prepare this fulfillment.
     * @var string
     */
    protected $prep_time_duration = NULL;
    /**
     * $note A general note about the pickup fulfillment.  Notes are useful for providing additional instructions and are displayed in Square apps.
     * @var string
     */
    protected $note = NULL;
    /**
     * $placed_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment was placed.
     * @var string
     */
    protected $placed_at = NULL;
    /**
     * $accepted_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment was accepted by the merchant.
     * @var string
     */
    protected $accepted_at = NULL;
    /**
     * $rejected_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment was rejected.
     * @var string
     */
    protected $rejected_at = NULL;
    /**
     * $ready_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the merchant set the fulfillment as ready for pickup.
     * @var string
     */
    protected $ready_at = NULL;
    /**
     * $expired_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment expired.
     * @var string
     */
    protected $expired_at = NULL;
    /**
     * $picked_up_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment was picked up by the recipient.
     * @var string
     */
    protected $picked_up_at = NULL;
    /**
     * $canceled_at The [timestamp](#workingwithdates) in RFC3339 timestamp format, e.g., \"2016-09-04T23:59:33.123Z\", indicating when the fulfillment was canceled by the merchant or buyer.
     * @var string
     */
    protected $canceled_at = NULL;
    /**
     * $cancel_reason A description of why the pickup was canceled. Max length is 100 characters.
     * @var string
     */
    protected $cancel_reason = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["recipient" => "\\SquareConnect\\Model\\OrderFulfillmentRecipient", "expires_at" => "string", "auto_complete_duration" => "string", "schedule_type" => "string", "pickup_at" => "string", "pickup_window_duration" => "string", "prep_time_duration" => "string", "note" => "string", "placed_at" => "string", "accepted_at" => "string", "rejected_at" => "string", "ready_at" => "string", "expired_at" => "string", "picked_up_at" => "string", "canceled_at" => "string", "cancel_reason" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["recipient" => "recipient", "expires_at" => "expires_at", "auto_complete_duration" => "auto_complete_duration", "schedule_type" => "schedule_type", "pickup_at" => "pickup_at", "pickup_window_duration" => "pickup_window_duration", "prep_time_duration" => "prep_time_duration", "note" => "note", "placed_at" => "placed_at", "accepted_at" => "accepted_at", "rejected_at" => "rejected_at", "ready_at" => "ready_at", "expired_at" => "expired_at", "picked_up_at" => "picked_up_at", "canceled_at" => "canceled_at", "cancel_reason" => "cancel_reason"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["recipient" => "setRecipient", "expires_at" => "setExpiresAt", "auto_complete_duration" => "setAutoCompleteDuration", "schedule_type" => "setScheduleType", "pickup_at" => "setPickupAt", "pickup_window_duration" => "setPickupWindowDuration", "prep_time_duration" => "setPrepTimeDuration", "note" => "setNote", "placed_at" => "setPlacedAt", "accepted_at" => "setAcceptedAt", "rejected_at" => "setRejectedAt", "ready_at" => "setReadyAt", "expired_at" => "setExpiredAt", "picked_up_at" => "setPickedUpAt", "canceled_at" => "setCanceledAt", "cancel_reason" => "setCancelReason"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["recipient" => "getRecipient", "expires_at" => "getExpiresAt", "auto_complete_duration" => "getAutoCompleteDuration", "schedule_type" => "getScheduleType", "pickup_at" => "getPickupAt", "pickup_window_duration" => "getPickupWindowDuration", "prep_time_duration" => "getPrepTimeDuration", "note" => "getNote", "placed_at" => "getPlacedAt", "accepted_at" => "getAcceptedAt", "rejected_at" => "getRejectedAt", "ready_at" => "getReadyAt", "expired_at" => "getExpiredAt", "picked_up_at" => "getPickedUpAt", "canceled_at" => "getCanceledAt", "cancel_reason" => "getCancelReason"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["recipient"])) {
                $this->recipient = $data["recipient"];
            } else {
                $this->recipient = NULL;
            }
            if (isset($data["expires_at"])) {
                $this->expires_at = $data["expires_at"];
            } else {
                $this->expires_at = NULL;
            }
            if (isset($data["auto_complete_duration"])) {
                $this->auto_complete_duration = $data["auto_complete_duration"];
            } else {
                $this->auto_complete_duration = NULL;
            }
            if (isset($data["schedule_type"])) {
                $this->schedule_type = $data["schedule_type"];
            } else {
                $this->schedule_type = NULL;
            }
            if (isset($data["pickup_at"])) {
                $this->pickup_at = $data["pickup_at"];
            } else {
                $this->pickup_at = NULL;
            }
            if (isset($data["pickup_window_duration"])) {
                $this->pickup_window_duration = $data["pickup_window_duration"];
            } else {
                $this->pickup_window_duration = NULL;
            }
            if (isset($data["prep_time_duration"])) {
                $this->prep_time_duration = $data["prep_time_duration"];
            } else {
                $this->prep_time_duration = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
            }
            if (isset($data["placed_at"])) {
                $this->placed_at = $data["placed_at"];
            } else {
                $this->placed_at = NULL;
            }
            if (isset($data["accepted_at"])) {
                $this->accepted_at = $data["accepted_at"];
            } else {
                $this->accepted_at = NULL;
            }
            if (isset($data["rejected_at"])) {
                $this->rejected_at = $data["rejected_at"];
            } else {
                $this->rejected_at = NULL;
            }
            if (isset($data["ready_at"])) {
                $this->ready_at = $data["ready_at"];
            } else {
                $this->ready_at = NULL;
            }
            if (isset($data["expired_at"])) {
                $this->expired_at = $data["expired_at"];
            } else {
                $this->expired_at = NULL;
            }
            if (isset($data["picked_up_at"])) {
                $this->picked_up_at = $data["picked_up_at"];
            } else {
                $this->picked_up_at = NULL;
            }
            if (isset($data["canceled_at"])) {
                $this->canceled_at = $data["canceled_at"];
            } else {
                $this->canceled_at = NULL;
            }
            if (isset($data["cancel_reason"])) {
                $this->cancel_reason = $data["cancel_reason"];
            } else {
                $this->cancel_reason = NULL;
            }
        }
    }
    public function getRecipient()
    {
        return $this->recipient;
    }
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }
    public function getExpiresAt()
    {
        return $this->expires_at;
    }
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }
    public function getAutoCompleteDuration()
    {
        return $this->auto_complete_duration;
    }
    public function setAutoCompleteDuration($auto_complete_duration)
    {
        $this->auto_complete_duration = $auto_complete_duration;
        return $this;
    }
    public function getScheduleType()
    {
        return $this->schedule_type;
    }
    public function setScheduleType($schedule_type)
    {
        $this->schedule_type = $schedule_type;
        return $this;
    }
    public function getPickupAt()
    {
        return $this->pickup_at;
    }
    public function setPickupAt($pickup_at)
    {
        $this->pickup_at = $pickup_at;
        return $this;
    }
    public function getPickupWindowDuration()
    {
        return $this->pickup_window_duration;
    }
    public function setPickupWindowDuration($pickup_window_duration)
    {
        $this->pickup_window_duration = $pickup_window_duration;
        return $this;
    }
    public function getPrepTimeDuration()
    {
        return $this->prep_time_duration;
    }
    public function setPrepTimeDuration($prep_time_duration)
    {
        $this->prep_time_duration = $prep_time_duration;
        return $this;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
    public function getPlacedAt()
    {
        return $this->placed_at;
    }
    public function setPlacedAt($placed_at)
    {
        $this->placed_at = $placed_at;
        return $this;
    }
    public function getAcceptedAt()
    {
        return $this->accepted_at;
    }
    public function setAcceptedAt($accepted_at)
    {
        $this->accepted_at = $accepted_at;
        return $this;
    }
    public function getRejectedAt()
    {
        return $this->rejected_at;
    }
    public function setRejectedAt($rejected_at)
    {
        $this->rejected_at = $rejected_at;
        return $this;
    }
    public function getReadyAt()
    {
        return $this->ready_at;
    }
    public function setReadyAt($ready_at)
    {
        $this->ready_at = $ready_at;
        return $this;
    }
    public function getExpiredAt()
    {
        return $this->expired_at;
    }
    public function setExpiredAt($expired_at)
    {
        $this->expired_at = $expired_at;
        return $this;
    }
    public function getPickedUpAt()
    {
        return $this->picked_up_at;
    }
    public function setPickedUpAt($picked_up_at)
    {
        $this->picked_up_at = $picked_up_at;
        return $this;
    }
    public function getCanceledAt()
    {
        return $this->canceled_at;
    }
    public function setCanceledAt($canceled_at)
    {
        $this->canceled_at = $canceled_at;
        return $this;
    }
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }
    public function setCancelReason($cancel_reason)
    {
        $this->cancel_reason = $cancel_reason;
        return $this;
    }
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
    public function __toString()
    {
        if (defined("JSON_PRETTY_PRINT")) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }
        return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
    }
}

?>