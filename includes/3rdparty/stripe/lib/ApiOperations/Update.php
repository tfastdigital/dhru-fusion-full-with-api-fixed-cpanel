<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\ApiOperations;

/**
 * Trait for updatable resources. Adds an `update()` static method and a
 * `save()` method to the class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Update
{
    public static function update($id, $params = NULL, $opts = NULL)
    {
        self::_validateParams($params);
        $url = static::resourceUrl($id);
        list($response, $opts) = static::_staticRequest("post", $url, $params, $opts);
        $obj = \Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
    public function save($opts = NULL)
    {
        $params = $this->serializeParameters();
        if (0 < count($params)) {
            $url = $this->instanceUrl();
            list($response, $opts) = $this->_request("post", $url, $params, $opts);
            $this->refreshFrom($response, $opts);
        }
        return $this;
    }
}

?>