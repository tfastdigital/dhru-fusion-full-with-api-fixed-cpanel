<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class ApiResource
 *
 * @package Stripe
 */
class ApiResource extends StripeObject
{
    use ApiOperations\Request;
    /**
     * @var boolean A flag that can be set a behavior that will cause this
     * resource to be encoded and sent up along with an update of its parent
     * resource. This is usually not desirable because resources are updated
     * individually on their own endpoints, but there are certain cases,
     * replacing a customer's source for example, where this is allowed.
     */
    public $saveWithParent = false;
    public static function getSavedNestedResources()
    {
        static $savedNestedResources = NULL;
        if ($savedNestedResources === NULL) {
            $savedNestedResources = new Util\Set();
        }
        return $savedNestedResources;
    }
    public function __set($k, $v)
    {
        parent::__set($k, $v);
        $v = $this->{$k};
        if (static::getSavedNestedResources()->includes($k) && $v instanceof ApiResource) {
            $v->saveWithParent = true;
        }
        return $v;
    }
    public function refresh()
    {
        $requestor = new ApiRequestor($this->_opts->apiKey, static::baseUrl());
        $url = $this->instanceUrl();
        list($response, $this->_opts->apiKey) = $requestor->request("get", $url, $this->_retrieveOptions, $this->_opts->headers);
        $this->setLastResponse($response);
        $this->refreshFrom($response->json, $this->_opts);
        return $this;
    }
    public static function baseUrl()
    {
        return Stripe::$apiBase;
    }
    public static function classUrl()
    {
        $base = str_replace(".", "/", static::OBJECT_NAME);
        return "/v1/" . $base . "s";
    }
    public static function resourceUrl($id)
    {
        if ($id === NULL) {
            $class = get_called_class();
            $message = "Could not determine which URL to request: " . $class . " instance has invalid ID: " . $id;
            throw new Error\InvalidRequest($message, NULL);
        }
        $id = Util\Util::utf8($id);
        $base = static::classUrl();
        $extn = urlencode($id);
        return $base . "/" . $extn;
    }
    public function instanceUrl()
    {
        return static::resourceUrl($this["id"]);
    }
}

?>