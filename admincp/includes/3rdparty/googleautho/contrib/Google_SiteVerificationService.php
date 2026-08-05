<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "webResource" collection of methods.
 * Typical usage is:
 *  <code>
 *   $siteVerificationService = new Google_SiteVerificationService(...);
 *   $webResource = $siteVerificationService->webResource;
 *  </code>
 */
class Google_WebResourceServiceResource extends Google_ServiceResource
{
    public function insert($verificationMethod, Google_SiteVerificationWebResourceResource $postBody, $optParams = [])
    {
        $params = ["verificationMethod" => $verificationMethod, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceResource($data);
        }
        return $data;
    }
    public function get($id, $optParams = [])
    {
        $params = ["id" => $id];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceResource($data);
        }
        return $data;
    }
    public function listWebResource($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceListResponse($data);
        }
        return $data;
    }
    public function update($id, Google_SiteVerificationWebResourceResource $postBody, $optParams = [])
    {
        $params = ["id" => $id, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceResource($data);
        }
        return $data;
    }
    public function patch($id, Google_SiteVerificationWebResourceResource $postBody, $optParams = [])
    {
        $params = ["id" => $id, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceResource($data);
        }
        return $data;
    }
    public function getToken(Google_SiteVerificationWebResourceGettokenRequest $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("getToken", [$params]);
        if ($this->useObjects()) {
            return new Google_SiteVerificationWebResourceGettokenResponse($data);
        }
        return $data;
    }
    public function delete($id, $optParams = [])
    {
        $params = ["id" => $id];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        return $data;
    }
}
/**
 * Service definition for Google_SiteVerification (v1).
 *
 * <p>
 * Lets you programatically verify ownership of websites or domains with Google.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/siteverification/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_SiteVerificationService extends Google_Service
{
    public $webResource = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "siteVerification/v1/";
        $this->version = "v1";
        $this->serviceName = "siteVerification";
        $client->addService($this->serviceName, $this->version);
        $this->webResource = new Google_WebResourceServiceResource($this, $this->serviceName, "webResource", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\", \"https://www.googleapis.com/auth/siteverification.verify_only\"], \"parameters\": {\"verificationMethod\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"request\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"response\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"httpMethod\": \"POST\", \"path\": \"webResource\", \"id\": \"siteVerification.webResource.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"siteVerification.webResource.get\", \"httpMethod\": \"GET\", \"path\": \"webResource/{id}\", \"response\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\"], \"path\": \"webResource\", \"response\": {\"\$ref\": \"SiteVerificationWebResourceListResponse\"}, \"id\": \"siteVerification.webResource.list\", \"httpMethod\": \"GET\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"response\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"httpMethod\": \"PUT\", \"path\": \"webResource/{id}\", \"id\": \"siteVerification.webResource.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"response\": {\"\$ref\": \"SiteVerificationWebResourceResource\"}, \"httpMethod\": \"PATCH\", \"path\": \"webResource/{id}\", \"id\": \"siteVerification.webResource.patch\"}, \"getToken\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\", \"https://www.googleapis.com/auth/siteverification.verify_only\"], \"request\": {\"\$ref\": \"SiteVerificationWebResourceGettokenRequest\"}, \"response\": {\"\$ref\": \"SiteVerificationWebResourceGettokenResponse\"}, \"httpMethod\": \"POST\", \"path\": \"token\", \"id\": \"siteVerification.webResource.getToken\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/siteverification\"], \"path\": \"webResource/{id}\", \"id\": \"siteVerification.webResource.delete\", \"parameters\": {\"id\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"httpMethod\": \"DELETE\"}}}", true));
    }
}
class Google_SiteVerificationWebResourceGettokenRequest extends Google_Model
{
    public $verificationMethod = NULL;
    protected $__siteType = "Google_SiteVerificationWebResourceGettokenRequestSite";
    protected $__siteDataType = "";
    public $site = NULL;
    public function setVerificationMethod($verificationMethod)
    {
        $this->verificationMethod = $verificationMethod;
    }
    public function getVerificationMethod()
    {
        return $this->verificationMethod;
    }
    public function setSite(Google_SiteVerificationWebResourceGettokenRequestSite $site)
    {
        $this->site = $site;
    }
    public function getSite()
    {
        return $this->site;
    }
}
class Google_SiteVerificationWebResourceGettokenRequestSite extends Google_Model
{
    public $identifier = NULL;
    public $type = NULL;
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
    public function getIdentifier()
    {
        return $this->identifier;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
}
class Google_SiteVerificationWebResourceGettokenResponse extends Google_Model
{
    public $token = NULL;
    public $method = NULL;
    public function setToken($token)
    {
        $this->token = $token;
    }
    public function getToken()
    {
        return $this->token;
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
class Google_SiteVerificationWebResourceListResponse extends Google_Model
{
    protected $__itemsType = "Google_SiteVerificationWebResourceResource";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_SiteVerificationWebResourceResource", "Google_SiteVerificationWebResourceListResponse::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
}
class Google_SiteVerificationWebResourceResource extends Google_Model
{
    public $owners = NULL;
    public $id = NULL;
    protected $__siteType = "Google_SiteVerificationWebResourceResourceSite";
    protected $__siteDataType = "";
    public $site = NULL;
    public function setOwners($owners)
    {
        $this->assertIsArray($owners, "Google_string", "Google_SiteVerificationWebResourceResource::setOwners");
        $this->owners = $owners;
    }
    public function getOwners()
    {
        return $this->owners;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSite(Google_SiteVerificationWebResourceResourceSite $site)
    {
        $this->site = $site;
    }
    public function getSite()
    {
        return $this->site;
    }
}
class Google_SiteVerificationWebResourceResourceSite extends Google_Model
{
    public $identifier = NULL;
    public $type = NULL;
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
    public function getIdentifier()
    {
        return $this->identifier;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
}

?>