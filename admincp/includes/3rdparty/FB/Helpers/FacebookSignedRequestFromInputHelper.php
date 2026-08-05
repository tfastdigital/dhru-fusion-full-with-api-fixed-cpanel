<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Helpers;

/**
 * Class FacebookSignedRequestFromInputHelper
 *
 * @package Facebook
 */
abstract class FacebookSignedRequestFromInputHelper
{
    /**
     * @var SignedRequest|null The SignedRequest entity.
     */
    protected $signedRequest = NULL;
    /**
     * @var FacebookApp The FacebookApp entity.
     */
    protected $app = NULL;
    /**
     * @var OAuth2Client The OAuth 2.0 client service.
     */
    protected $oAuth2Client = NULL;
    public function __construct(\Facebook\FacebookApp $app, \Facebook\FacebookClient $client, $graphVersion = NULL)
    {
        $this->app = $app;
        $graphVersion = $graphVersion ?: \Facebook\Facebook::DEFAULT_GRAPH_VERSION;
        $this->oAuth2Client = new \Facebook\Authentication\OAuth2Client($this->app, $client, $graphVersion);
        $this->instantiateSignedRequest();
    }
    public function instantiateSignedRequest($rawSignedRequest = NULL)
    {
        $rawSignedRequest = $rawSignedRequest ?: $this->getRawSignedRequest();
        if (!$rawSignedRequest) {
            return NULL;
        }
        $this->signedRequest = new \Facebook\SignedRequest($this->app, $rawSignedRequest);
    }
    public function getAccessToken()
    {
        if ($this->signedRequest && $this->signedRequest->hasOAuthData()) {
            $code = $this->signedRequest->get("code");
            $accessToken = $this->signedRequest->get("oauth_token");
            if ($code && !$accessToken) {
                return $this->oAuth2Client->getAccessTokenFromCode($code);
            }
            $expiresAt = $this->signedRequest->get("expires", 0);
            return new \Facebook\Authentication\AccessToken($accessToken, $expiresAt);
        }
        return NULL;
    }
    public function getSignedRequest()
    {
        return $this->signedRequest;
    }
    public function getUserId()
    {
        return $this->signedRequest ? $this->signedRequest->getUserId() : NULL;
    }
    public abstract function getRawSignedRequest();
    public function getRawSignedRequestFromPost()
    {
        if (isset($_POST["signed_request"])) {
            return $_POST["signed_request"];
        }
        return NULL;
    }
    public function getRawSignedRequestFromCookie()
    {
        if (isset($_COOKIE["fbsr_" . $this->app->getId()])) {
            return $_COOKIE["fbsr_" . $this->app->getId()];
        }
        return NULL;
    }
}

?>