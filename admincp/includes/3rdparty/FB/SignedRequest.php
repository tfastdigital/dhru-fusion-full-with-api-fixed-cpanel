<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class SignedRequest
 *
 * @package Facebook
 */
class SignedRequest
{
    /**
     * @var FacebookApp The FacebookApp entity.
     */
    protected $app = NULL;
    /**
     * @var string The raw encrypted signed request.
     */
    protected $rawSignedRequest = NULL;
    /**
     * @var array The payload from the decrypted signed request.
     */
    protected $payload = NULL;
    public function __construct(FacebookApp $facebookApp, $rawSignedRequest = NULL)
    {
        $this->app = $facebookApp;
        if (!$rawSignedRequest) {
            return NULL;
        }
        $this->rawSignedRequest = $rawSignedRequest;
        $this->parse();
    }
    public function getRawSignedRequest()
    {
        return $this->rawSignedRequest;
    }
    public function getPayload()
    {
        return $this->payload;
    }
    public function get($key, $default = NULL)
    {
        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }
        return $default;
    }
    public function getUserId()
    {
        return $this->get("user_id");
    }
    public function hasOAuthData()
    {
        return $this->get("oauth_token") || $this->get("code");
    }
    public function make($payload)
    {
        $payload["algorithm"] = isset($payload["algorithm"]) ? $payload["algorithm"] : "HMAC-SHA256";
        $payload["issued_at"] = isset($payload["issued_at"]) ? $payload["issued_at"] : time();
        $encodedPayload = $this->base64UrlEncode(json_encode($payload));
        $hashedSig = $this->hashSignature($encodedPayload);
        $encodedSig = $this->base64UrlEncode($hashedSig);
        return $encodedSig . "." . $encodedPayload;
    }
    protected function parse()
    {
        list($encodedSig, $encodedPayload) = $this->explode();
        $sig = $this->decodeSignature($encodedSig);
        $hashedSig = $this->hashSignature($encodedPayload);
        $this->validateSignature($hashedSig, $sig);
        $this->payload = $this->decodePayload($encodedPayload);
        $this->validateAlgorithm();
    }
    protected function explode()
    {
        if (strpos($this->rawSignedRequest, ".") === false) {
            throw new Exceptions\FacebookSDKException("Malformed signed request.", 606);
        }
        return explode(".", $this->rawSignedRequest, 2);
    }
    protected function decodeSignature($encodedSig)
    {
        $sig = $this->base64UrlDecode($encodedSig);
        if (!$sig) {
            throw new Exceptions\FacebookSDKException("Signed request has malformed encoded signature data.", 607);
        }
        return $sig;
    }
    protected function decodePayload($encodedPayload)
    {
        $payload = $this->base64UrlDecode($encodedPayload);
        if ($payload) {
            $payload = json_decode($payload, true);
        }
        if (!is_array($payload)) {
            throw new Exceptions\FacebookSDKException("Signed request has malformed encoded payload data.", 607);
        }
        return $payload;
    }
    protected function validateAlgorithm()
    {
        if ($this->get("algorithm") !== "HMAC-SHA256") {
            throw new Exceptions\FacebookSDKException("Signed request is using the wrong algorithm.", 605);
        }
    }
    protected function hashSignature($encodedData)
    {
        $hashedSig = hash_hmac("sha256", $encodedData, $this->app->getSecret(), $raw_output = true);
        if (!$hashedSig) {
            throw new Exceptions\FacebookSDKException("Unable to hash signature from encoded payload data.", 602);
        }
        return $hashedSig;
    }
    protected function validateSignature($hashedSig, $sig)
    {
        if (mb_strlen($hashedSig) === mb_strlen($sig)) {
            $validate = 0;
            for ($i = 0; $i < mb_strlen($sig); $i++) {
                $validate |= ord($hashedSig[$i]) ^ ord($sig[$i]);
            }
            if ($validate === 0) {
                return NULL;
            }
        }
        throw new Exceptions\FacebookSDKException("Signed request has an invalid signature.", 602);
    }
    public function base64UrlDecode($input)
    {
        $urlDecodedBase64 = strtr($input, "-_", "+/");
        $this->validateBase64($urlDecodedBase64);
        return base64_decode($urlDecodedBase64);
    }
    public function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), "+/", "-_");
    }
    protected function validateBase64($input)
    {
        if (!preg_match("/^[a-zA-Z0-9\\/\\r\\n+]*={0,2}\$/", $input)) {
            throw new Exceptions\FacebookSDKException("Signed request contains malformed base64 encoding.", 608);
        }
    }
}

?>