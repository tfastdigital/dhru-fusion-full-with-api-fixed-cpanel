<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\ApiOperations;

/**
 * Trait for resources that have nested resources.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait NestedResource
{
    protected static function _nestedResourceOperation($method, $url, $params = NULL, $options = NULL)
    {
        self::_validateParams($params);
        list($response, $opts) = static::_staticRequest($method, $url, $params, $options);
        $obj = \Stripe\Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
    protected static function _nestedResourceUrl($id, $nestedPath, $nestedId = NULL)
    {
        $url = static::resourceUrl($id) . $nestedPath;
        if ($nestedId !== NULL) {
            $url .= "/" . $nestedId;
        }
        return $url;
    }
    protected static function _createNestedResource($id, $nestedPath, $params = NULL, $options = NULL)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);
        return self::_nestedResourceOperation("post", $url, $params, $options);
    }
    protected static function _retrieveNestedResource($id, $nestedPath, $nestedId, $params = NULL, $options = NULL)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);
        return self::_nestedResourceOperation("get", $url, $params, $options);
    }
    protected static function _updateNestedResource($id, $nestedPath, $nestedId, $params = NULL, $options = NULL)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);
        return self::_nestedResourceOperation("post", $url, $params, $options);
    }
    protected static function _deleteNestedResource($id, $nestedPath, $nestedId, $params = NULL, $options = NULL)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);
        return self::_nestedResourceOperation("delete", $url, $params, $options);
    }
    protected static function _allNestedResources($id, $nestedPath, $params = NULL, $options = NULL)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);
        return self::_nestedResourceOperation("get", $url, $params, $options);
    }
}

?>