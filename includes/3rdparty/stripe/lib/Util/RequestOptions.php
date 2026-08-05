<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

class RequestOptions
{
    public $headers = NULL;
    public $apiKey = NULL;
    public $apiBase = NULL;
    /**
     * @var array A list of headers that should be persisted across requests.
     */
    public static $HEADERS_TO_PERSIST = ["Stripe-Account", "Stripe-Version"];
    public function __construct($key = NULL, $headers = [], $base = NULL)
    {
        $this->apiKey = $key;
        $this->headers = $headers;
        $this->apiBase = $base;
    }
    public function merge($options)
    {
        $other_options = self::parse($options);
        if ($other_options->apiKey === NULL) {
            $other_options->apiKey = $this->apiKey;
        }
        if ($other_options->apiBase === NULL) {
            $other_options->apiBase = $this->apiBase;
        }
        $other_options->headers = array_merge($this->headers, $other_options->headers);
        return $other_options;
    }
    public function discardNonPersistentHeaders()
    {
        foreach ($this->headers as $k => $v) {
            if (!in_array($k, self::$HEADERS_TO_PERSIST)) {
                unset($this->headers[$k]);
            }
        }
    }
    public static function parse($options)
    {
        if ($options instanceof $this) {
            return $options;
        }
        if (is_null($options)) {
            return new RequestOptions(NULL, [], NULL);
        }
        if (is_string($options)) {
            return new RequestOptions($options, [], NULL);
        }
        if (is_array($options)) {
            $headers = [];
            $key = NULL;
            $base = NULL;
            if (array_key_exists("api_key", $options)) {
                $key = $options["api_key"];
            }
            if (array_key_exists("idempotency_key", $options)) {
                $headers["Idempotency-Key"] = $options["idempotency_key"];
            }
            if (array_key_exists("stripe_account", $options)) {
                $headers["Stripe-Account"] = $options["stripe_account"];
            }
            if (array_key_exists("stripe_version", $options)) {
                $headers["Stripe-Version"] = $options["stripe_version"];
            }
            if (array_key_exists("api_base", $options)) {
                $base = $options["api_base"];
            }
            return new RequestOptions($key, $headers, $base);
        }
        $message = "The second argument to Stripe API method calls is an optional per-request apiKey, which must be a string, or per-request options, which must be an array. (HINT: you can set a global apiKey by \"Stripe::setApiKey(<apiKey>)\")";
        throw new \Stripe\Error\Api($message);
    }
}

?>