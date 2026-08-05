<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

class OAuth
{
    public static function authorizeUrl($params = NULL, $opts = NULL)
    {
        $params = $params ?: [];
        $base = $opts && array_key_exists("connect_base", $opts) ? $opts["connect_base"] : Stripe::$connectBase;
        $params["client_id"] = self::_getClientId($params);
        if (!array_key_exists("response_type", $params)) {
            $params["response_type"] = "code";
        }
        $query = Util\Util::encodeParameters($params);
        return $base . "/oauth/authorize?" . $query;
    }
    public static function token($params = NULL, $opts = NULL)
    {
        $base = $opts && array_key_exists("connect_base", $opts) ? $opts["connect_base"] : Stripe::$connectBase;
        $requestor = new ApiRequestor(NULL, $base);
        list($response, $apiKey) = $requestor->request("post", "/oauth/token", $params, NULL);
        return Util\Util::convertToStripeObject($response->json, $opts);
    }
    public static function deauthorize($params = NULL, $opts = NULL)
    {
        $params = $params ?: [];
        $base = $opts && array_key_exists("connect_base", $opts) ? $opts["connect_base"] : Stripe::$connectBase;
        $requestor = new ApiRequestor(NULL, $base);
        $params["client_id"] = self::_getClientId($params);
        list($response, $apiKey) = $requestor->request("post", "/oauth/deauthorize", $params, NULL);
        return Util\Util::convertToStripeObject($response->json, $opts);
    }
    private static function _getClientId($params = NULL)
    {
        $clientId = $params && array_key_exists("client_id", $params) ? $params["client_id"] : NULL;
        if ($clientId === NULL) {
            $clientId = Stripe::getClientId();
        }
        if ($clientId === NULL) {
            $msg = "No client_id provided.  (HINT: set your client_id using \"Stripe::setClientId(<CLIENT-ID>)\".  You can find your client_ids in your Stripe dashboard at https://dashboard.stripe.com/account/applications/settings, after registering your account as a platform. See https://stripe.com/docs/connect/standard-accounts for details, or email support@stripe.com if you have any questions.";
            throw new Error\Authentication($msg);
        }
        return $clientId;
    }
}

?>