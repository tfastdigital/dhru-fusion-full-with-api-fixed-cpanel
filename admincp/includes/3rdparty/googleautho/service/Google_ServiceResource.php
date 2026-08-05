<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Implements the actual methods/resources of the discovered Google API using magic function
 * calling overloading (__call()), which on call will see if the method name (plus.activities.list)
 * is available in this service, and if so construct an apiHttpRequest representing it.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_ServiceResource
{
    private $stackParameters = ["alt" => ["type" => "string", "location" => "query"], "boundary" => ["type" => "string", "location" => "query"], "fields" => ["type" => "string", "location" => "query"], "trace" => ["type" => "string", "location" => "query"], "userIp" => ["type" => "string", "location" => "query"], "userip" => ["type" => "string", "location" => "query"], "file" => ["type" => "complex", "location" => "body"], "data" => ["type" => "string", "location" => "body"], "mimeType" => ["type" => "string", "location" => "header"], "uploadType" => ["type" => "string", "location" => "query"], "mediaUpload" => ["type" => "complex", "location" => "query"]];
    /** @var Google_Service $service */
    private $service = NULL;
    /** @var string $serviceName */
    private $serviceName = NULL;
    /** @var string $resourceName */
    private $resourceName = NULL;
    /** @var array $methods */
    private $methods = NULL;
    public function __construct($service, $serviceName, $resourceName, $resource)
    {
        $this->service = $service;
        $this->serviceName = $serviceName;
        $this->resourceName = $resourceName;
        $this->methods = isset($resource["methods"]) ? $resource["methods"] : [$resourceName => $resource];
    }
    public function __call($name, $arguments)
    {
        if (!isset($this->methods[$name])) {
            throw new Google_Exception("Unknown function: " . $this->serviceName . "->" . $this->resourceName . "->" . $name . "()");
        }
        $method = $this->methods[$name];
        $parameters = $arguments[0];
        $postBody = NULL;
        if (isset($parameters["postBody"])) {
            if (is_object($parameters["postBody"])) {
                $this->stripNull($parameters["postBody"]);
            }
            if (is_array($parameters["postBody"]) && "latitude" == $this->serviceName && !isset($parameters["postBody"]["data"])) {
                $rawBody = $parameters["postBody"];
                unset($parameters["postBody"]);
                $parameters["postBody"]["data"] = $rawBody;
            }
            $postBody = is_array($parameters["postBody"]) || is_object($parameters["postBody"]) ? json_encode($parameters["postBody"]) : $parameters["postBody"];
            unset($parameters["postBody"]);
            if (isset($parameters["optParams"])) {
                $optParams = $parameters["optParams"];
                unset($parameters["optParams"]);
                $parameters = array_merge($parameters, $optParams);
            }
        }
        if (!isset($method["parameters"])) {
            $method["parameters"] = [];
        }
        $method["parameters"] = array_merge($method["parameters"], $this->stackParameters);
        foreach ($parameters as $key => $val) {
            if ($key != "postBody" && !isset($method["parameters"][$key])) {
                throw new Google_Exception("(" . $name . ") unknown parameter: '" . $key . "'");
            }
        }
        if (isset($method["parameters"])) {
            foreach ($method["parameters"] as $paramName => $paramSpec) {
                if (isset($paramSpec["required"]) && $paramSpec["required"] && !isset($parameters[$paramName])) {
                    throw new Google_Exception("(" . $name . ") missing required param: '" . $paramName . "'");
                }
                if (isset($parameters[$paramName])) {
                    $value = $parameters[$paramName];
                    $parameters[$paramName] = $paramSpec;
                    $parameters[$paramName]["value"] = $value;
                    unset($parameters[$paramName]["required"]);
                } else {
                    unset($parameters[$paramName]);
                }
            }
        }
        if (!isset($method["id"])) {
            $method["id"] = $method["rpcMethod"];
        }
        if (!isset($method["path"])) {
            $method["path"] = $method["restPath"];
        }
        $servicePath = $this->service->servicePath;
        $contentType = false;
        if (isset($method["mediaUpload"])) {
            $media = Google_MediaFileUpload::process($postBody, $parameters);
            if ($media) {
                $contentType = isset($media["content-type"]) ? $media["content-type"] : NULL;
                $postBody = isset($media["postBody"]) ? $media["postBody"] : NULL;
                $servicePath = $method["mediaUpload"]["protocols"]["simple"]["path"];
                $method["path"] = "";
            }
        }
        $url = Google_REST::createRequestUri($servicePath, $method["path"], $parameters);
        $httpRequest = new Google_HttpRequest($url, $method["httpMethod"], NULL, $postBody);
        if ($postBody) {
            $contentTypeHeader = [];
            if (isset($contentType) && $contentType) {
                $contentTypeHeader["content-type"] = $contentType;
            } else {
                $contentTypeHeader["content-type"] = "application/json; charset=UTF-8";
                $contentTypeHeader["content-length"] = Google_Utils::getStrLen($postBody);
            }
            $httpRequest->setRequestHeaders($contentTypeHeader);
        }
        $httpRequest = Google_Client::$auth->sign($httpRequest);
        if (Google_Client::$useBatch) {
            return $httpRequest;
        }
        if (isset($parameters["uploadType"]["value"]) && "resumable" == $parameters["uploadType"]["value"]) {
            return $httpRequest;
        }
        return Google_REST::execute($httpRequest);
    }
    public function useObjects()
    {
        global $apiConfig;
        return isset($apiConfig["use_objects"]) && $apiConfig["use_objects"];
    }
    protected function stripNull(&$o)
    {
        $o = (array) $o;
        foreach ($o as $k => $v) {
            if ($v === NULL || strstr($k, "\0*\0__")) {
                unset($o[$k]);
            } else {
                if (is_object($v) || is_array($v)) {
                    $this->stripNull($o[$k]);
                }
            }
        }
    }
}

?>