<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "freebusy" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $freebusy = $calendarService->freebusy;
 *  </code>
 */
class Google_FreebusyServiceResource extends Google_ServiceResource
{
    public function query(Google_FreeBusyRequest $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("query", [$params]);
        if ($this->useObjects()) {
            return new Google_FreeBusyResponse($data);
        }
        return $data;
    }
}
/**
 * The "settings" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $settings = $calendarService->settings;
 *  </code>
 */
class Google_SettingsServiceResource extends Google_ServiceResource
{
    public function listSettings($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Settings($data);
        }
        return $data;
    }
    public function get($setting, $optParams = [])
    {
        $params = ["setting" => $setting];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Setting($data);
        }
        return $data;
    }
}
/**
 * The "calendarList" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $calendarList = $calendarService->calendarList;
 *  </code>
 */
class Google_CalendarListServiceResource extends Google_ServiceResource
{
    public function insert(Google_CalendarListEntry $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_CalendarListEntry($data);
        }
        return $data;
    }
    public function get($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_CalendarListEntry($data);
        }
        return $data;
    }
    public function listCalendarList($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_CalendarList($data);
        }
        return $data;
    }
    public function update($calendarId, Google_CalendarListEntry $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_CalendarListEntry($data);
        }
        return $data;
    }
    public function patch($calendarId, Google_CalendarListEntry $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_CalendarListEntry($data);
        }
        return $data;
    }
    public function delete($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "calendars" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $calendars = $calendarService->calendars;
 *  </code>
 */
class Google_CalendarsServiceResource extends Google_ServiceResource
{
    public function insert(Google_Calendar $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Calendar($data);
        }
        return $data;
    }
    public function get($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Calendar($data);
        }
        return $data;
    }
    public function clear($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("clear", [$params]);
        return $data;
    }
    public function update($calendarId, Google_Calendar $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Calendar($data);
        }
        return $data;
    }
    public function patch($calendarId, Google_Calendar $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Calendar($data);
        }
        return $data;
    }
    public function delete($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "acl" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $acl = $calendarService->acl;
 *  </code>
 */
class Google_AclServiceResource extends Google_ServiceResource
{
    public function insert($calendarId, Google_AclRule $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_AclRule($data);
        }
        return $data;
    }
    public function get($calendarId, $ruleId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "ruleId" => $ruleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_AclRule($data);
        }
        return $data;
    }
    public function listAcl($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Acl($data);
        }
        return $data;
    }
    public function update($calendarId, $ruleId, Google_AclRule $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "ruleId" => $ruleId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_AclRule($data);
        }
        return $data;
    }
    public function patch($calendarId, $ruleId, Google_AclRule $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "ruleId" => $ruleId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_AclRule($data);
        }
        return $data;
    }
    public function delete($calendarId, $ruleId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "ruleId" => $ruleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * The "colors" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $colors = $calendarService->colors;
 *  </code>
 */
class Google_ColorsServiceResource extends Google_ServiceResource
{
    public function get($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Colors($data);
        }
        return $data;
    }
}
/**
 * The "events" collection of methods.
 * Typical usage is:
 *  <code>
 *   $calendarService = new Google_CalendarService(...);
 *   $events = $calendarService->events;
 *  </code>
 */
class Google_EventsServiceResource extends Google_ServiceResource
{
    public function insert($calendarId, Google_Event $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function get($calendarId, $eventId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function move($calendarId, $eventId, $destination, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId, "destination" => $destination];
        $params = array_merge($params, $optParams);
        $data = $this->__call("move", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function listEvents($calendarId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Events($data);
        }
        return $data;
    }
    public function update($calendarId, $eventId, Google_Event $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function patch($calendarId, $eventId, Google_Event $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function instances($calendarId, $eventId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("instances", [$params]);
        if ($this->useObjects()) {
            return new Google_Events($data);
        }
        return $data;
    }
    public function import($calendarId, Google_Event $postBody, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("import", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function quickAdd($calendarId, $text, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "text" => $text];
        $params = array_merge($params, $optParams);
        $data = $this->__call("quickAdd", [$params]);
        if ($this->useObjects()) {
            return new Google_Event($data);
        }
        return $data;
    }
    public function delete($calendarId, $eventId, $optParams = [])
    {
        $params = ["calendarId" => $calendarId, "eventId" => $eventId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * Service definition for Google_Calendar (v3).
 *
 * <p>
 * Lets you manipulate events and other calendar data.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/calendar/v3/using.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_CalendarService extends Google_Service
{
    public $freebusy = NULL;
    public $settings = NULL;
    public $calendarList = NULL;
    public $calendars = NULL;
    public $acl = NULL;
    public $colors = NULL;
    public $events = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "calendar/v3/";
        $this->version = "v3";
        $this->serviceName = "calendar";
        $client->addService($this->serviceName, $this->version);
        $this->freebusy = new Google_FreebusyServiceResource($this, $this->serviceName, "freebusy", json_decode("{\"methods\": {\"query\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"request\": {\"\$ref\": \"FreeBusyRequest\"}, \"response\": {\"\$ref\": \"FreeBusyResponse\"}, \"httpMethod\": \"POST\", \"path\": \"freeBusy\", \"id\": \"calendar.freebusy.query\"}}}", true));
        $this->settings = new Google_SettingsServiceResource($this, $this->serviceName, "settings", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"path\": \"users/me/settings\", \"response\": {\"\$ref\": \"Settings\"}, \"id\": \"calendar.settings.list\", \"httpMethod\": \"GET\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"setting\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"calendar.settings.get\", \"httpMethod\": \"GET\", \"path\": \"users/me/settings/{setting}\", \"response\": {\"\$ref\": \"Setting\"}}}}", true));
        $this->calendarList = new Google_CalendarListServiceResource($this, $this->serviceName, "calendarList", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"colorRgbFormat\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"CalendarListEntry\"}, \"response\": {\"\$ref\": \"CalendarListEntry\"}, \"httpMethod\": \"POST\", \"path\": \"users/me/calendarList\", \"id\": \"calendar.calendarList.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"calendar.calendarList.get\", \"httpMethod\": \"GET\", \"path\": \"users/me/calendarList/{calendarId}\", \"response\": {\"\$ref\": \"CalendarListEntry\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"showHidden\": {\"type\": \"boolean\", \"location\": \"query\"}, \"maxResults\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"minAccessRole\": {\"enum\": [\"freeBusyReader\", \"owner\", \"reader\", \"writer\"], \"type\": \"string\", \"location\": \"query\"}}, \"response\": {\"\$ref\": \"CalendarList\"}, \"httpMethod\": \"GET\", \"path\": \"users/me/calendarList\", \"id\": \"calendar.calendarList.list\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"colorRgbFormat\": {\"type\": \"boolean\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"CalendarListEntry\"}, \"response\": {\"\$ref\": \"CalendarListEntry\"}, \"httpMethod\": \"PUT\", \"path\": \"users/me/calendarList/{calendarId}\", \"id\": \"calendar.calendarList.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"colorRgbFormat\": {\"type\": \"boolean\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"CalendarListEntry\"}, \"response\": {\"\$ref\": \"CalendarListEntry\"}, \"httpMethod\": \"PATCH\", \"path\": \"users/me/calendarList/{calendarId}\", \"id\": \"calendar.calendarList.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"path\": \"users/me/calendarList/{calendarId}\", \"id\": \"calendar.calendarList.delete\", \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->calendars = new Google_CalendarsServiceResource($this, $this->serviceName, "calendars", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"request\": {\"\$ref\": \"Calendar\"}, \"response\": {\"\$ref\": \"Calendar\"}, \"httpMethod\": \"POST\", \"path\": \"calendars\", \"id\": \"calendar.calendars.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"calendar.calendars.get\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}\", \"response\": {\"\$ref\": \"Calendar\"}}, \"clear\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"path\": \"calendars/{calendarId}/clear\", \"id\": \"calendar.calendars.clear\", \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"POST\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Calendar\"}, \"response\": {\"\$ref\": \"Calendar\"}, \"httpMethod\": \"PUT\", \"path\": \"calendars/{calendarId}\", \"id\": \"calendar.calendars.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Calendar\"}, \"response\": {\"\$ref\": \"Calendar\"}, \"httpMethod\": \"PATCH\", \"path\": \"calendars/{calendarId}\", \"id\": \"calendar.calendars.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"path\": \"calendars/{calendarId}\", \"id\": \"calendar.calendars.delete\", \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->acl = new Google_AclServiceResource($this, $this->serviceName, "acl", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AclRule\"}, \"response\": {\"\$ref\": \"AclRule\"}, \"httpMethod\": \"POST\", \"path\": \"calendars/{calendarId}/acl\", \"id\": \"calendar.acl.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"ruleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"calendar.acl.get\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}/acl/{ruleId}\", \"response\": {\"\$ref\": \"AclRule\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"calendar.acl.list\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}/acl\", \"response\": {\"\$ref\": \"Acl\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"ruleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AclRule\"}, \"response\": {\"\$ref\": \"AclRule\"}, \"httpMethod\": \"PUT\", \"path\": \"calendars/{calendarId}/acl/{ruleId}\", \"id\": \"calendar.acl.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"ruleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AclRule\"}, \"response\": {\"\$ref\": \"AclRule\"}, \"httpMethod\": \"PATCH\", \"path\": \"calendars/{calendarId}/acl/{ruleId}\", \"id\": \"calendar.acl.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"path\": \"calendars/{calendarId}/acl/{ruleId}\", \"id\": \"calendar.acl.delete\", \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"ruleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
        $this->colors = new Google_ColorsServiceResource($this, $this->serviceName, "colors", json_decode("{\"methods\": {\"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"path\": \"colors\", \"response\": {\"\$ref\": \"Colors\"}, \"id\": \"calendar.colors.get\", \"httpMethod\": \"GET\"}}}", true));
        $this->events = new Google_EventsServiceResource($this, $this->serviceName, "events", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"Event\"}, \"response\": {\"\$ref\": \"Event\"}, \"httpMethod\": \"POST\", \"path\": \"calendars/{calendarId}/events\", \"id\": \"calendar.events.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"timeZone\": {\"type\": \"string\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"alwaysIncludeEmail\": {\"type\": \"boolean\", \"location\": \"query\"}, \"maxAttendees\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"id\": \"calendar.events.get\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}/events/{eventId}\", \"response\": {\"\$ref\": \"Event\"}}, \"move\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"destination\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"calendar.events.move\", \"httpMethod\": \"POST\", \"path\": \"calendars/{calendarId}/events/{eventId}/move\", \"response\": {\"\$ref\": \"Event\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"orderBy\": {\"enum\": [\"startTime\", \"updated\"], \"type\": \"string\", \"location\": \"query\"}, \"showHiddenInvitations\": {\"type\": \"boolean\", \"location\": \"query\"}, \"showDeleted\": {\"type\": \"boolean\", \"location\": \"query\"}, \"iCalUID\": {\"type\": \"string\", \"location\": \"query\"}, \"updatedMin\": {\"type\": \"string\", \"location\": \"query\", \"format\": \"date-time\"}, \"singleEvents\": {\"type\": \"boolean\", \"location\": \"query\"}, \"alwaysIncludeEmail\": {\"type\": \"boolean\", \"location\": \"query\"}, \"maxResults\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"timeMin\": {\"type\": \"string\", \"location\": \"query\", \"format\": \"date-time\"}, \"timeZone\": {\"type\": \"string\", \"location\": \"query\"}, \"timeMax\": {\"type\": \"string\", \"location\": \"query\", \"format\": \"date-time\"}, \"maxAttendees\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"id\": \"calendar.events.list\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}/events\", \"response\": {\"\$ref\": \"Events\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"alwaysIncludeEmail\": {\"type\": \"boolean\", \"location\": \"query\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"Event\"}, \"response\": {\"\$ref\": \"Event\"}, \"httpMethod\": \"PUT\", \"path\": \"calendars/{calendarId}/events/{eventId}\", \"id\": \"calendar.events.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"alwaysIncludeEmail\": {\"type\": \"boolean\", \"location\": \"query\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"Event\"}, \"response\": {\"\$ref\": \"Event\"}, \"httpMethod\": \"PATCH\", \"path\": \"calendars/{calendarId}/events/{eventId}\", \"id\": \"calendar.events.patch\"}, \"instances\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\", \"https://www.googleapis.com/auth/calendar.readonly\"], \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"showDeleted\": {\"type\": \"boolean\", \"location\": \"query\"}, \"alwaysIncludeEmail\": {\"type\": \"boolean\", \"location\": \"query\"}, \"maxResults\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"timeZone\": {\"type\": \"string\", \"location\": \"query\"}, \"originalStart\": {\"type\": \"string\", \"location\": \"query\"}, \"maxAttendees\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"id\": \"calendar.events.instances\", \"httpMethod\": \"GET\", \"path\": \"calendars/{calendarId}/events/{eventId}/instances\", \"response\": {\"\$ref\": \"Events\"}}, \"import\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"Event\"}, \"response\": {\"\$ref\": \"Event\"}, \"httpMethod\": \"POST\", \"path\": \"calendars/{calendarId}/events/import\", \"id\": \"calendar.events.import\"}, \"quickAdd\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"parameters\": {\"text\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"calendar.events.quickAdd\", \"httpMethod\": \"POST\", \"path\": \"calendars/{calendarId}/events/quickAdd\", \"response\": {\"\$ref\": \"Event\"}}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/calendar\"], \"path\": \"calendars/{calendarId}/events/{eventId}\", \"id\": \"calendar.events.delete\", \"parameters\": {\"eventId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"calendarId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"sendNotifications\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"httpMethod\": \"DELETE\"}}}", true));
    }
}
class Google_Acl extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_AclRule";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_AclRule", "Google_Acl::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_AclRule extends Google_Model
{
    protected $__scopeType = "Google_AclRuleScope";
    protected $__scopeDataType = "";
    public $scope = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public $role = NULL;
    public $id = NULL;
    public function setScope(Google_AclRuleScope $scope)
    {
        $this->scope = $scope;
    }
    public function getScope()
    {
        return $this->scope;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_AclRuleScope extends Google_Model
{
    public $type = NULL;
    public $value = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}
class Google_Calendar extends Google_Model
{
    public $kind = NULL;
    public $description = NULL;
    public $summary = NULL;
    public $etag = NULL;
    public $location = NULL;
    public $timeZone = NULL;
    public $id = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    public function getSummary()
    {
        return $this->summary;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_CalendarList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_CalendarListEntry";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_CalendarListEntry", "Google_CalendarList::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_CalendarListEntry extends Google_Model
{
    public $kind = NULL;
    public $foregroundColor = NULL;
    protected $__defaultRemindersType = "Google_EventReminder";
    protected $__defaultRemindersDataType = "array";
    public $defaultReminders = NULL;
    public $description = NULL;
    public $colorId = NULL;
    public $selected = NULL;
    public $summary = NULL;
    public $etag = NULL;
    public $location = NULL;
    public $backgroundColor = NULL;
    public $summaryOverride = NULL;
    public $timeZone = NULL;
    public $hidden = NULL;
    public $accessRole = NULL;
    public $id = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;
    }
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }
    public function setDefaultReminders($defaultReminders)
    {
        $this->assertIsArray($defaultReminders, "Google_EventReminder", "Google_CalendarListEntry::setDefaultReminders");
        $this->defaultReminders = $defaultReminders;
    }
    public function getDefaultReminders()
    {
        return $this->defaultReminders;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setColorId($colorId)
    {
        $this->colorId = $colorId;
    }
    public function getColorId()
    {
        return $this->colorId;
    }
    public function setSelected($selected)
    {
        $this->selected = $selected;
    }
    public function getSelected()
    {
        return $this->selected;
    }
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    public function getSummary()
    {
        return $this->summary;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }
    public function setSummaryOverride($summaryOverride)
    {
        $this->summaryOverride = $summaryOverride;
    }
    public function getSummaryOverride()
    {
        return $this->summaryOverride;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
    public function getHidden()
    {
        return $this->hidden;
    }
    public function setAccessRole($accessRole)
    {
        $this->accessRole = $accessRole;
    }
    public function getAccessRole()
    {
        return $this->accessRole;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_ColorDefinition extends Google_Model
{
    public $foreground = NULL;
    public $background = NULL;
    public function setForeground($foreground)
    {
        $this->foreground = $foreground;
    }
    public function getForeground()
    {
        return $this->foreground;
    }
    public function setBackground($background)
    {
        $this->background = $background;
    }
    public function getBackground()
    {
        return $this->background;
    }
}
class Google_Colors extends Google_Model
{
    protected $__calendarType = "Google_ColorDefinition";
    protected $__calendarDataType = "map";
    public $calendar = NULL;
    public $updated = NULL;
    protected $__eventType = "Google_ColorDefinition";
    protected $__eventDataType = "map";
    public $event = NULL;
    public $kind = NULL;
    public function setCalendar(Google_ColorDefinition $calendar)
    {
        $this->calendar = $calendar;
    }
    public function getCalendar()
    {
        return $this->calendar;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setEvent(Google_ColorDefinition $event)
    {
        $this->event = $event;
    }
    public function getEvent()
    {
        return $this->event;
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
class Google_Error extends Google_Model
{
    public $domain = NULL;
    public $reason = NULL;
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
    public function getDomain()
    {
        return $this->domain;
    }
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
    public function getReason()
    {
        return $this->reason;
    }
}
class Google_Event extends Google_Model
{
    protected $__creatorType = "Google_EventCreator";
    protected $__creatorDataType = "";
    public $creator = NULL;
    protected $__organizerType = "Google_EventOrganizer";
    protected $__organizerDataType = "";
    public $organizer = NULL;
    public $summary = NULL;
    public $id = NULL;
    protected $__attendeesType = "Google_EventAttendee";
    protected $__attendeesDataType = "array";
    public $attendees = NULL;
    public $htmlLink = NULL;
    public $recurrence = NULL;
    protected $__startType = "Google_EventDateTime";
    protected $__startDataType = "";
    public $start = NULL;
    public $etag = NULL;
    public $location = NULL;
    public $recurringEventId = NULL;
    protected $__gadgetType = "Google_EventGadget";
    protected $__gadgetDataType = "";
    public $gadget = NULL;
    public $status = NULL;
    public $updated = NULL;
    public $description = NULL;
    public $iCalUID = NULL;
    protected $__extendedPropertiesType = "Google_EventExtendedProperties";
    protected $__extendedPropertiesDataType = "";
    public $extendedProperties = NULL;
    public $endTimeUnspecified = NULL;
    public $sequence = NULL;
    public $visibility = NULL;
    public $guestsCanModify = NULL;
    protected $__endType = "Google_EventDateTime";
    protected $__endDataType = "";
    public $end = NULL;
    public $attendeesOmitted = NULL;
    public $kind = NULL;
    public $locked = NULL;
    public $created = NULL;
    public $colorId = NULL;
    public $anyoneCanAddSelf = NULL;
    protected $__remindersType = "Google_EventReminders";
    protected $__remindersDataType = "";
    public $reminders = NULL;
    public $guestsCanSeeOtherGuests = NULL;
    protected $__originalStartTimeType = "Google_EventDateTime";
    protected $__originalStartTimeDataType = "";
    public $originalStartTime = NULL;
    public $guestsCanInviteOthers = NULL;
    public $transparency = NULL;
    public $privateCopy = NULL;
    public function setCreator(Google_EventCreator $creator)
    {
        $this->creator = $creator;
    }
    public function getCreator()
    {
        return $this->creator;
    }
    public function setOrganizer(Google_EventOrganizer $organizer)
    {
        $this->organizer = $organizer;
    }
    public function getOrganizer()
    {
        return $this->organizer;
    }
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    public function getSummary()
    {
        return $this->summary;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setAttendees($attendees)
    {
        $this->assertIsArray($attendees, "Google_EventAttendee", "Google_Event::setAttendees");
        $this->attendees = $attendees;
    }
    public function getAttendees()
    {
        return $this->attendees;
    }
    public function setHtmlLink($htmlLink)
    {
        $this->htmlLink = $htmlLink;
    }
    public function getHtmlLink()
    {
        return $this->htmlLink;
    }
    public function setRecurrence($recurrence)
    {
        $this->assertIsArray($recurrence, "Google_string", "Google_Event::setRecurrence");
        $this->recurrence = $recurrence;
    }
    public function getRecurrence()
    {
        return $this->recurrence;
    }
    public function setStart(Google_EventDateTime $start)
    {
        $this->start = $start;
    }
    public function getStart()
    {
        return $this->start;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setRecurringEventId($recurringEventId)
    {
        $this->recurringEventId = $recurringEventId;
    }
    public function getRecurringEventId()
    {
        return $this->recurringEventId;
    }
    public function setGadget(Google_EventGadget $gadget)
    {
        $this->gadget = $gadget;
    }
    public function getGadget()
    {
        return $this->gadget;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setICalUID($iCalUID)
    {
        $this->iCalUID = $iCalUID;
    }
    public function getICalUID()
    {
        return $this->iCalUID;
    }
    public function setExtendedProperties(Google_EventExtendedProperties $extendedProperties)
    {
        $this->extendedProperties = $extendedProperties;
    }
    public function getExtendedProperties()
    {
        return $this->extendedProperties;
    }
    public function setEndTimeUnspecified($endTimeUnspecified)
    {
        $this->endTimeUnspecified = $endTimeUnspecified;
    }
    public function getEndTimeUnspecified()
    {
        return $this->endTimeUnspecified;
    }
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }
    public function getSequence()
    {
        return $this->sequence;
    }
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }
    public function getVisibility()
    {
        return $this->visibility;
    }
    public function setGuestsCanModify($guestsCanModify)
    {
        $this->guestsCanModify = $guestsCanModify;
    }
    public function getGuestsCanModify()
    {
        return $this->guestsCanModify;
    }
    public function setEnd(Google_EventDateTime $end)
    {
        $this->end = $end;
    }
    public function getEnd()
    {
        return $this->end;
    }
    public function setAttendeesOmitted($attendeesOmitted)
    {
        $this->attendeesOmitted = $attendeesOmitted;
    }
    public function getAttendeesOmitted()
    {
        return $this->attendeesOmitted;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }
    public function getLocked()
    {
        return $this->locked;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setColorId($colorId)
    {
        $this->colorId = $colorId;
    }
    public function getColorId()
    {
        return $this->colorId;
    }
    public function setAnyoneCanAddSelf($anyoneCanAddSelf)
    {
        $this->anyoneCanAddSelf = $anyoneCanAddSelf;
    }
    public function getAnyoneCanAddSelf()
    {
        return $this->anyoneCanAddSelf;
    }
    public function setReminders(Google_EventReminders $reminders)
    {
        $this->reminders = $reminders;
    }
    public function getReminders()
    {
        return $this->reminders;
    }
    public function setGuestsCanSeeOtherGuests($guestsCanSeeOtherGuests)
    {
        $this->guestsCanSeeOtherGuests = $guestsCanSeeOtherGuests;
    }
    public function getGuestsCanSeeOtherGuests()
    {
        return $this->guestsCanSeeOtherGuests;
    }
    public function setOriginalStartTime(Google_EventDateTime $originalStartTime)
    {
        $this->originalStartTime = $originalStartTime;
    }
    public function getOriginalStartTime()
    {
        return $this->originalStartTime;
    }
    public function setGuestsCanInviteOthers($guestsCanInviteOthers)
    {
        $this->guestsCanInviteOthers = $guestsCanInviteOthers;
    }
    public function getGuestsCanInviteOthers()
    {
        return $this->guestsCanInviteOthers;
    }
    public function setTransparency($transparency)
    {
        $this->transparency = $transparency;
    }
    public function getTransparency()
    {
        return $this->transparency;
    }
    public function setPrivateCopy($privateCopy)
    {
        $this->privateCopy = $privateCopy;
    }
    public function getPrivateCopy()
    {
        return $this->privateCopy;
    }
}
class Google_EventAttendee extends Google_Model
{
    public $comment = NULL;
    public $displayName = NULL;
    public $responseStatus = NULL;
    public $self = NULL;
    public $id = NULL;
    public $additionalGuests = NULL;
    public $resource = NULL;
    public $organizer = NULL;
    public $optional = NULL;
    public $email = NULL;
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setResponseStatus($responseStatus)
    {
        $this->responseStatus = $responseStatus;
    }
    public function getResponseStatus()
    {
        return $this->responseStatus;
    }
    public function setSelf($self)
    {
        $this->self = $self;
    }
    public function getSelf()
    {
        return $this->self;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setAdditionalGuests($additionalGuests)
    {
        $this->additionalGuests = $additionalGuests;
    }
    public function getAdditionalGuests()
    {
        return $this->additionalGuests;
    }
    public function setResource($resource)
    {
        $this->resource = $resource;
    }
    public function getResource()
    {
        return $this->resource;
    }
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;
    }
    public function getOrganizer()
    {
        return $this->organizer;
    }
    public function setOptional($optional)
    {
        $this->optional = $optional;
    }
    public function getOptional()
    {
        return $this->optional;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
}
class Google_EventCreator extends Google_Model
{
    public $self = NULL;
    public $displayName = NULL;
    public $email = NULL;
    public $id = NULL;
    public function setSelf($self)
    {
        $this->self = $self;
    }
    public function getSelf()
    {
        return $this->self;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_EventDateTime extends Google_Model
{
    public $date = NULL;
    public $timeZone = NULL;
    public $dateTime = NULL;
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }
    public function getDateTime()
    {
        return $this->dateTime;
    }
}
class Google_EventExtendedProperties extends Google_Model
{
    public $shared = NULL;
    public $private = NULL;
    public function setShared($shared)
    {
        $this->shared = $shared;
    }
    public function getShared()
    {
        return $this->shared;
    }
    public function setPrivate($private)
    {
        $this->private = $private;
    }
    public function getPrivate()
    {
        return $this->private;
    }
}
class Google_EventGadget extends Google_Model
{
    public $preferences = NULL;
    public $title = NULL;
    public $height = NULL;
    public $width = NULL;
    public $link = NULL;
    public $type = NULL;
    public $display = NULL;
    public $iconLink = NULL;
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
    }
    public function getPreferences()
    {
        return $this->preferences;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setDisplay($display)
    {
        $this->display = $display;
    }
    public function getDisplay()
    {
        return $this->display;
    }
    public function setIconLink($iconLink)
    {
        $this->iconLink = $iconLink;
    }
    public function getIconLink()
    {
        return $this->iconLink;
    }
}
class Google_EventOrganizer extends Google_Model
{
    public $self = NULL;
    public $displayName = NULL;
    public $email = NULL;
    public $id = NULL;
    public function setSelf($self)
    {
        $this->self = $self;
    }
    public function getSelf()
    {
        return $this->self;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_EventReminder extends Google_Model
{
    public $minutes = NULL;
    public $method = NULL;
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;
    }
    public function getMinutes()
    {
        return $this->minutes;
    }
    public function setMethod($method)
    {
        $this->method = $method;
    }
    public function getMethod()
    {
        return $this->method;
    }
}
class Google_EventReminders extends Google_Model
{
    protected $__overridesType = "Google_EventReminder";
    protected $__overridesDataType = "array";
    public $overrides = NULL;
    public $useDefault = NULL;
    public function setOverrides($overrides)
    {
        $this->assertIsArray($overrides, "Google_EventReminder", "Google_EventReminders::setOverrides");
        $this->overrides = $overrides;
    }
    public function getOverrides()
    {
        return $this->overrides;
    }
    public function setUseDefault($useDefault)
    {
        $this->useDefault = $useDefault;
    }
    public function getUseDefault()
    {
        return $this->useDefault;
    }
}
class Google_Events extends Google_Model
{
    public $nextPageToken = NULL;
    public $kind = NULL;
    protected $__defaultRemindersType = "Google_EventReminder";
    protected $__defaultRemindersDataType = "array";
    public $defaultReminders = NULL;
    public $description = NULL;
    protected $__itemsType = "Google_Event";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $updated = NULL;
    public $summary = NULL;
    public $etag = NULL;
    public $timeZone = NULL;
    public $accessRole = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDefaultReminders($defaultReminders)
    {
        $this->assertIsArray($defaultReminders, "Google_EventReminder", "Google_Events::setDefaultReminders");
        $this->defaultReminders = $defaultReminders;
    }
    public function getDefaultReminders()
    {
        return $this->defaultReminders;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Event", "Google_Events::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    public function getSummary()
    {
        return $this->summary;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
    public function setAccessRole($accessRole)
    {
        $this->accessRole = $accessRole;
    }
    public function getAccessRole()
    {
        return $this->accessRole;
    }
}
class Google_FreeBusyCalendar extends Google_Model
{
    protected $__busyType = "Google_TimePeriod";
    protected $__busyDataType = "array";
    public $busy = NULL;
    protected $__errorsType = "Google_Error";
    protected $__errorsDataType = "array";
    public $errors = NULL;
    public function setBusy($busy)
    {
        $this->assertIsArray($busy, "Google_TimePeriod", "Google_FreeBusyCalendar::setBusy");
        $this->busy = $busy;
    }
    public function getBusy()
    {
        return $this->busy;
    }
    public function setErrors($errors)
    {
        $this->assertIsArray($errors, "Google_Error", "Google_FreeBusyCalendar::setErrors");
        $this->errors = $errors;
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
class Google_FreeBusyGroup extends Google_Model
{
    protected $__errorsType = "Google_Error";
    protected $__errorsDataType = "array";
    public $errors = NULL;
    public $calendars = NULL;
    public function setErrors($errors)
    {
        $this->assertIsArray($errors, "Google_Error", "Google_FreeBusyGroup::setErrors");
        $this->errors = $errors;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function setCalendars($calendars)
    {
        $this->assertIsArray($calendars, "Google_string", "Google_FreeBusyGroup::setCalendars");
        $this->calendars = $calendars;
    }
    public function getCalendars()
    {
        return $this->calendars;
    }
}
class Google_FreeBusyRequest extends Google_Model
{
    public $calendarExpansionMax = NULL;
    public $groupExpansionMax = NULL;
    public $timeMax = NULL;
    protected $__itemsType = "Google_FreeBusyRequestItem";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $timeMin = NULL;
    public $timeZone = NULL;
    public function setCalendarExpansionMax($calendarExpansionMax)
    {
        $this->calendarExpansionMax = $calendarExpansionMax;
    }
    public function getCalendarExpansionMax()
    {
        return $this->calendarExpansionMax;
    }
    public function setGroupExpansionMax($groupExpansionMax)
    {
        $this->groupExpansionMax = $groupExpansionMax;
    }
    public function getGroupExpansionMax()
    {
        return $this->groupExpansionMax;
    }
    public function setTimeMax($timeMax)
    {
        $this->timeMax = $timeMax;
    }
    public function getTimeMax()
    {
        return $this->timeMax;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_FreeBusyRequestItem", "Google_FreeBusyRequest::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setTimeMin($timeMin)
    {
        $this->timeMin = $timeMin;
    }
    public function getTimeMin()
    {
        return $this->timeMin;
    }
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }
    public function getTimeZone()
    {
        return $this->timeZone;
    }
}
class Google_FreeBusyRequestItem extends Google_Model
{
    public $id = NULL;
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_FreeBusyResponse extends Google_Model
{
    public $timeMax = NULL;
    public $kind = NULL;
    protected $__calendarsType = "Google_FreeBusyCalendar";
    protected $__calendarsDataType = "map";
    public $calendars = NULL;
    public $timeMin = NULL;
    protected $__groupsType = "Google_FreeBusyGroup";
    protected $__groupsDataType = "map";
    public $groups = NULL;
    public function setTimeMax($timeMax)
    {
        $this->timeMax = $timeMax;
    }
    public function getTimeMax()
    {
        return $this->timeMax;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setCalendars(Google_FreeBusyCalendar $calendars)
    {
        $this->calendars = $calendars;
    }
    public function getCalendars()
    {
        return $this->calendars;
    }
    public function setTimeMin($timeMin)
    {
        $this->timeMin = $timeMin;
    }
    public function getTimeMin()
    {
        return $this->timeMin;
    }
    public function setGroups(Google_FreeBusyGroup $groups)
    {
        $this->groups = $groups;
    }
    public function getGroups()
    {
        return $this->groups;
    }
}
class Google_Setting extends Google_Model
{
    public $kind = NULL;
    public $etag = NULL;
    public $id = NULL;
    public $value = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}
class Google_Settings extends Google_Model
{
    protected $__itemsType = "Google_Setting";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Setting", "Google_Settings::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_TimePeriod extends Google_Model
{
    public $start = NULL;
    public $end = NULL;
    public function setStart($start)
    {
        $this->start = $start;
    }
    public function getStart()
    {
        return $this->start;
    }
    public function setEnd($end)
    {
        $this->end = $end;
    }
    public function getEnd()
    {
        return $this->end;
    }
}

?>