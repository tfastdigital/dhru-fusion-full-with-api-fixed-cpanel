<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "currentLocation" collection of methods.
 * Typical usage is:
 *  <code>
 *   $latitudeService = new Google_LatitudeService(...);
 *   $currentLocation = $latitudeService->currentLocation;
 *  </code>
 */
class Google_CurrentLocationServiceResource extends Google_ServiceResource
{
    public function insert(Google_Location $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Location($data);
        }
        return $data;
    }
    public function get($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Location($data);
        }
        return $data;
    }
    public function delete($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "location" collection of methods.
 * Typical usage is:
 *  <code>
 *   $latitudeService = new Google_LatitudeService(...);
 *   $location = $latitudeService->location;
 *  </code>
 */
class Google_LocationServiceResource extends Google_ServiceResource
{
    public function insert(Google_Location $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Location($data);
        }
        return $data;
    }
    public function get($locationId, $optParams = [])
    {
        $params = ["locationId" => $locationId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Location($data);
        }
        return $data;
    }
    public function listLocation($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_LocationFeed($data);
        }
        return $data;
    }
    public function delete($locationId, $optParams = [])
    {
        $params = ["locationId" => $locationId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * Service definition for Google_Latitude (v1).
 *
 * <p>
 * Lets you read and update your current location and work with your location history
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/latitude/v1/using" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_LatitudeService extends Google_Service
{
    public $currentLocation = NULL;
    public $location = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "latitude/v1/";
        $this->version = "v1";
        $this->serviceName = "latitude";
        $client->addService($this->serviceName, $this->version);
        $this->currentLocation = new Google_CurrentLocationServiceResource($this, $this->serviceName, "currentLocation", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\", \"https://www.googleapis.com/auth/latitude.current.best\", \"https://www.googleapis.com/auth/latitude.current.city\"], \"request\": {\"\$ref\": \"LatitudeCurrentlocationResourceJson\"}, \"response\": {\"\$ref\": \"LatitudeCurrentlocationResourceJson\"}, \"httpMethod\": \"POST\", \"path\": \"currentLocation\", \"id\": \"latitude.currentLocation.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\", \"https://www.googleapis.com/auth/latitude.current.best\", \"https://www.googleapis.com/auth/latitude.current.city\"], \"parameters\": {\"granularity\": {\"default\": \"city\", \"enum\": [\"best\", \"city\"], \"type\": \"string\", \"location\": \"query\"}}, \"response\": {\"\$ref\": \"LatitudeCurrentlocationResourceJson\"}, \"httpMethod\": \"GET\", \"path\": \"currentLocation\", \"id\": \"latitude.currentLocation.get\"}, \"delete\": {\"path\": \"currentLocation\", \"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\", \"https://www.googleapis.com/auth/latitude.current.best\", \"https://www.googleapis.com/auth/latitude.current.city\"], \"id\": \"latitude.currentLocation.delete\", \"httpMethod\": \"DELETE\"}}}", true));
        $this->location = new Google_LocationServiceResource($this, $this->serviceName, "location", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\"], \"request\": {\"\$ref\": \"Location\"}, \"response\": {\"\$ref\": \"Location\"}, \"httpMethod\": \"POST\", \"path\": \"location\", \"id\": \"latitude.location.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\"], \"parameters\": {\"locationId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"granularity\": {\"default\": \"city\", \"enum\": [\"best\", \"city\"], \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"latitude.location.get\", \"httpMethod\": \"GET\", \"path\": \"location/{locationId}\", \"response\": {\"\$ref\": \"Location\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\"], \"parameters\": {\"max-results\": {\"type\": \"string\", \"location\": \"query\"}, \"max-time\": {\"type\": \"string\", \"location\": \"query\"}, \"min-time\": {\"type\": \"string\", \"location\": \"query\"}, \"granularity\": {\"default\": \"city\", \"enum\": [\"best\", \"city\"], \"type\": \"string\", \"location\": \"query\"}}, \"response\": {\"\$ref\": \"LocationFeed\"}, \"httpMethod\": \"GET\", \"path\": \"location\", \"id\": \"latitude.location.list\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/latitude.all.best\", \"https://www.googleapis.com/auth/latitude.all.city\"], \"path\": \"location/{locationId}\", \"id\": \"latitude.location.delete\", \"parameters\": {\"locationId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
    }
}
class Google_Location extends Google_Model
{
    public $kind = NULL;
    public $altitude = NULL;
    public $longitude = NULL;
    public $activityId = NULL;
    public $latitude = NULL;
    public $altitudeAccuracy = NULL;
    public $timestampMs = NULL;
    public $speed = NULL;
    public $heading = NULL;
    public $accuracy = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }
    public function getAltitude()
    {
        return $this->altitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setActivityId($activityId)
    {
        $this->activityId = $activityId;
    }
    public function getActivityId()
    {
        return $this->activityId;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setAltitudeAccuracy($altitudeAccuracy)
    {
        $this->altitudeAccuracy = $altitudeAccuracy;
    }
    public function getAltitudeAccuracy()
    {
        return $this->altitudeAccuracy;
    }
    public function setTimestampMs($timestampMs)
    {
        $this->timestampMs = $timestampMs;
    }
    public function getTimestampMs()
    {
        return $this->timestampMs;
    }
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }
    public function getSpeed()
    {
        return $this->speed;
    }
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }
    public function getHeading()
    {
        return $this->heading;
    }
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    }
    public function getAccuracy()
    {
        return $this->accuracy;
    }
}
class Google_LocationFeed extends Google_Model
{
    protected $__itemsType = "Google_Location";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Location", "Google_LocationFeed::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}

?>