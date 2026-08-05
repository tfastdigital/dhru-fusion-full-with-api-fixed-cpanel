<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "text" collection of methods.
 * Typical usage is:
 *  <code>
 *   $freebaseService = new Google_FreebaseService(...);
 *   $text = $freebaseService->text;
 *  </code>
 */
class Google_TextServiceResource extends Google_ServiceResource
{
    public function get($id, $optParams = [])
    {
        $params = ["id" => $id];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_ContentserviceGet($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Freebase (v1).
 *
 * <p>
 * Lets you access the Freebase repository of open data.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://wiki.freebase.com/wiki/API" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_FreebaseService extends Google_Service
{
    public $text = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "freebase/v1/";
        $this->version = "v1";
        $this->serviceName = "freebase";
        $client->addService($this->serviceName, $this->version);
        $this->text = new Google_TextServiceResource($this, $this->serviceName, "text", json_decode("{\"methods\": {\"get\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"ContentserviceGet\"}, \"id\": \"freebase.text.get\", \"parameters\": {\"maxlength\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"id\": {\"repeated\": true, \"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"format\": {\"default\": \"plain\", \"enum\": [\"html\", \"plain\", \"raw\"], \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"text{/id*}\"}}}", true));
    }
}
class Google_ContentserviceGet extends Google_Model
{
    public $result = NULL;
    public function setResult($result)
    {
        $this->result = $result;
    }
    public function getResult()
    {
        return $this->result;
    }
}

?>