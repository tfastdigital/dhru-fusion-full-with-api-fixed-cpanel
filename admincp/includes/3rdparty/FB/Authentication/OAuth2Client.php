<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Authentication;

/**
 * Class OAuth2Client
 *
 * @package Facebook
 */
class OAuth2Client
{
    /**
     * The FacebookApp entity.
     *
     * @var FacebookApp
     */
    protected $app = NULL;
    /**
     * The Facebook client.
     *
     * @var FacebookClient
     */
    protected $client = NULL;
    /**
     * The version of the Graph API to use.
     *
     * @var string
     */
    protected $graphVersion = NULL;
    /**
     * The last request sent to Graph.
     *
     * @var FacebookRequest|null
     */
    protected $lastRequest = NULL;
    const BASE_AUTHORIZATION_URL = "https://www.facebook.com";
    public function __construct(\Facebook\FacebookApp $app, \Facebook\FacebookClient $client, $graphVersion = NULL)
    {
        $this->app = $app;
        $this->client = $client;
        $this->graphVersion = $graphVersion ?: \Facebook\Facebook::DEFAULT_GRAPH_VERSION;
    }
    public function getLastRequest()
    {
        return $this->lastRequest;
    }
    public function debugToken($accessToken)
    {
        $accessToken = $accessToken instanceof AccessToken ? $accessToken->getValue() : $accessToken;
        $params = ["input_token" => $accessToken];
        $this->lastRequest = new \Facebook\FacebookRequest($this->app, $this->app->getAccessToken(), "GET", "/debug_token", $params, NULL, $this->graphVersion);
        $response = $this->client->sendRequest($this->lastRequest);
        $metadata = $response->getDecodedBody();
        return new AccessTokenMetadata($metadata);
    }
    public function getAuthorizationUrl($redirectUrl, $state, $scope = [], $params = [], $separator = "&")
    {
        $params += ["client_id" => $this->app->getId(), "state" => $state, "response_type" => "code", "sdk" => "php-sdk-" . \Facebook\Facebook::VERSION, "redirect_uri" => $redirectUrl, "scope" => implode(",", $scope)];
        return static::BASE_AUTHORIZATION_URL . "/" . $this->graphVersion . "/dialog/oauth?" . http_build_query($params, NULL, $separator);
    }
    public function getAccessTokenFromCode($code, $redirectUri = "")
    {
        $params = ["code" => $code, "redirect_uri" => $redirectUri];
        return $this->requestAnAccessToken($params);
    }
    public function getLongLivedAccessToken($accessToken)
    {
        $accessToken = $accessToken instanceof AccessToken ? $accessToken->getValue() : $accessToken;
        $params = ["grant_type" => "fb_exchange_token", "fb_exchange_token" => $accessToken];
        return $this->requestAnAccessToken($params);
    }
    public function getCodeFromLongLivedAccessToken($accessToken, $redirectUri = "")
    {
        $params = ["redirect_uri" => $redirectUri];
        $response = $this->sendRequestWithClientParams("/oauth/client_code", $params, $accessToken);
        $data = $response->getDecodedBody();
        if (!isset($data["code"])) {
            throw new \Facebook\Exceptions\FacebookSDKException("Code was not returned from Graph.", 401);
        }
        return $data["code"];
    }
    protected function requestAnAccessToken($params)
    {
        $response = $this->sendRequestWithClientParams("/oauth/access_token", $params);
        $data = $response->getDecodedBody();
        if (!isset($data["access_token"])) {
            throw new \Facebook\Exceptions\FacebookSDKException("Access token was not returned from Graph.", 401);
        }
        $expiresAt = 0;
        if (isset($data["expires"])) {
            $expiresAt = time() + $data["expires"];
        } else {
            if (isset($data["expires_in"])) {
                $expiresAt = time() + $data["expires_in"];
            }
        }
        return new AccessToken($data["access_token"], $expiresAt);
    }
    protected function sendRequestWithClientParams($endpoint, $params, $accessToken = NULL)
    {
        $params += $this->getClientParams();
        $accessToken = $accessToken ?: $this->app->getAccessToken();
        $this->lastRequest = new \Facebook\FacebookRequest($this->app, $accessToken, "GET", $endpoint, $params, NULL, $this->graphVersion);
        return $this->client->sendRequest($this->lastRequest);
    }
    protected function getClientParams()
    {
        return ["client_id" => $this->app->getId(), "client_secret" => $this->app->getSecret()];
    }
}

?>