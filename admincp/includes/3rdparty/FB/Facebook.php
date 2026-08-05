<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class Facebook
 *
 * @package Facebook
 */
class Facebook
{
    /**
     * @var FacebookApp The FacebookApp entity.
     */
    protected $app = NULL;
    /**
     * @var FacebookClient The Facebook client service.
     */
    protected $client = NULL;
    /**
     * @var OAuth2Client The OAuth 2.0 client service.
     */
    protected $oAuth2Client = NULL;
    /**
     * @var UrlDetectionInterface|null The URL detection handler.
     */
    protected $urlDetectionHandler = NULL;
    /**
     * @var PseudoRandomStringGeneratorInterface|null The cryptographically secure pseudo-random string generator.
     */
    protected $pseudoRandomStringGenerator = NULL;
    /**
     * @var AccessToken|null The default access token to use with requests.
     */
    protected $defaultAccessToken = NULL;
    /**
     * @var string|null The default Graph version we want to use.
     */
    protected $defaultGraphVersion = NULL;
    /**
     * @var PersistentDataInterface|null The persistent data handler.
     */
    protected $persistentDataHandler = NULL;
    /**
     * @var FacebookResponse|FacebookBatchResponse|null Stores the last request made to Graph.
     */
    protected $lastResponse = NULL;
    const VERSION = "5.0.0";
    const DEFAULT_GRAPH_VERSION = "v2.4";
    const APP_ID_ENV_NAME = "FACEBOOK_APP_ID";
    const APP_SECRET_ENV_NAME = "FACEBOOK_APP_SECRET";
    public function __construct($config = [])
    {
        $appId = isset($config["app_id"]) ? $config["app_id"] : getenv(static::APP_ID_ENV_NAME);
        if (!$appId) {
            throw new Exceptions\FacebookSDKException("Required \"app_id\" key not supplied in config and could not find fallback environment variable \"" . static::APP_ID_ENV_NAME . "\"");
        }
        $appSecret = isset($config["app_secret"]) ? $config["app_secret"] : getenv(static::APP_SECRET_ENV_NAME);
        if (!$appSecret) {
            throw new Exceptions\FacebookSDKException("Required \"app_secret\" key not supplied in config and could not find fallback environment variable \"" . static::APP_SECRET_ENV_NAME . "\"");
        }
        $this->app = new FacebookApp($appId, $appSecret);
        $httpClientHandler = NULL;
        if (isset($config["http_client_handler"])) {
            if ($config["http_client_handler"] instanceof HttpClients\FacebookHttpClientInterface) {
                $httpClientHandler = $config["http_client_handler"];
            } else {
                if ($config["http_client_handler"] === "curl") {
                    $httpClientHandler = new HttpClients\FacebookCurlHttpClient();
                } else {
                    if ($config["http_client_handler"] === "stream") {
                        $httpClientHandler = new HttpClients\FacebookStreamHttpClient();
                    } else {
                        if ($config["http_client_handler"] === "guzzle") {
                            $httpClientHandler = new HttpClients\FacebookGuzzleHttpClient();
                        } else {
                            throw new \InvalidArgumentException("The http_client_handler must be set to \"curl\", \"stream\", \"guzzle\", or be an instance of Facebook\\HttpClients\\FacebookHttpClientInterface");
                        }
                    }
                }
            }
        }
        $enableBeta = isset($config["enable_beta_mode"]) && $config["enable_beta_mode"] === true;
        $this->client = new FacebookClient($httpClientHandler, $enableBeta);
        if (isset($config["url_detection_handler"])) {
            if ($config["url_detection_handler"] instanceof Url\UrlDetectionInterface) {
                $this->urlDetectionHandler = $config["url_detection_handler"];
            } else {
                throw new \InvalidArgumentException("The url_detection_handler must be an instance of Facebook\\Url\\UrlDetectionInterface");
            }
        }
        if (isset($config["pseudo_random_string_generator"])) {
            if ($config["pseudo_random_string_generator"] instanceof PseudoRandomString\PseudoRandomStringGeneratorInterface) {
                $this->pseudoRandomStringGenerator = $config["pseudo_random_string_generator"];
            } else {
                if ($config["pseudo_random_string_generator"] === "mcrypt") {
                    $this->pseudoRandomStringGenerator = new PseudoRandomString\McryptPseudoRandomStringGenerator();
                } else {
                    if ($config["pseudo_random_string_generator"] === "openssl") {
                        $this->pseudoRandomStringGenerator = new PseudoRandomString\OpenSslPseudoRandomStringGenerator();
                    } else {
                        if ($config["pseudo_random_string_generator"] === "urandom") {
                            $this->pseudoRandomStringGenerator = new PseudoRandomString\UrandomPseudoRandomStringGenerator();
                        } else {
                            throw new \InvalidArgumentException("The pseudo_random_string_generator must be set to \"mcrypt\", \"openssl\", or \"urandom\", or be an instance of Facebook\\PseudoRandomString\\PseudoRandomStringGeneratorInterface");
                        }
                    }
                }
            }
        }
        if (isset($config["persistent_data_handler"])) {
            if ($config["persistent_data_handler"] instanceof PersistentData\PersistentDataInterface) {
                $this->persistentDataHandler = $config["persistent_data_handler"];
            } else {
                if ($config["persistent_data_handler"] === "session") {
                    $this->persistentDataHandler = new PersistentData\FacebookSessionPersistentDataHandler();
                } else {
                    if ($config["persistent_data_handler"] === "memory") {
                        $this->persistentDataHandler = new PersistentData\FacebookMemoryPersistentDataHandler();
                    } else {
                        throw new \InvalidArgumentException("The persistent_data_handler must be set to \"session\", \"memory\", or be an instance of Facebook\\PersistentData\\PersistentDataInterface");
                    }
                }
            }
        }
        if (isset($config["default_access_token"])) {
            $this->setDefaultAccessToken($config["default_access_token"]);
        }
        if (isset($config["default_graph_version"])) {
            $this->defaultGraphVersion = $config["default_graph_version"];
        } else {
            $this->defaultGraphVersion = static::DEFAULT_GRAPH_VERSION;
        }
    }
    public function getApp()
    {
        return $this->app;
    }
    public function getClient()
    {
        return $this->client;
    }
    public function getOAuth2Client()
    {
        if (!$this->oAuth2Client instanceof Authentication\OAuth2Client) {
            $app = $this->getApp();
            $client = $this->getClient();
            $this->oAuth2Client = new Authentication\OAuth2Client($app, $client, $this->defaultGraphVersion);
        }
        return $this->oAuth2Client;
    }
    public function getLastResponse()
    {
        return $this->lastResponse;
    }
    public function getUrlDetectionHandler()
    {
        if (!$this->urlDetectionHandler instanceof Url\UrlDetectionInterface) {
            $this->urlDetectionHandler = new Url\FacebookUrlDetectionHandler();
        }
        return $this->urlDetectionHandler;
    }
    public function getDefaultAccessToken()
    {
        return $this->defaultAccessToken;
    }
    public function setDefaultAccessToken($accessToken)
    {
        if (is_string($accessToken)) {
            $this->defaultAccessToken = new Authentication\AccessToken($accessToken);
        } else {
            if ($accessToken instanceof Authentication\AccessToken) {
                $this->defaultAccessToken = $accessToken;
            } else {
                throw new \InvalidArgumentException("The default access token must be of type \"string\" or Facebook\\AccessToken");
            }
        }
    }
    public function getDefaultGraphVersion()
    {
        return $this->defaultGraphVersion;
    }
    public function getRedirectLoginHelper()
    {
        return new Helpers\FacebookRedirectLoginHelper($this->getOAuth2Client(), $this->persistentDataHandler, $this->urlDetectionHandler, $this->pseudoRandomStringGenerator);
    }
    public function getJavaScriptHelper()
    {
        return new Helpers\FacebookJavaScriptHelper($this->app, $this->client, $this->defaultGraphVersion);
    }
    public function getCanvasHelper()
    {
        return new Helpers\FacebookCanvasHelper($this->app, $this->client, $this->defaultGraphVersion);
    }
    public function getPageTabHelper()
    {
        return new Helpers\FacebookPageTabHelper($this->app, $this->client, $this->defaultGraphVersion);
    }
    public function get($endpoint, $accessToken = NULL, $eTag = NULL, $graphVersion = NULL)
    {
        return $this->sendRequest("GET", $endpoint, $params = [], $accessToken, $eTag, $graphVersion);
    }
    public function post($endpoint, $params = [], $accessToken = NULL, $eTag = NULL, $graphVersion = NULL)
    {
        return $this->sendRequest("POST", $endpoint, $params, $accessToken, $eTag, $graphVersion);
    }
    public function delete($endpoint, $params = [], $accessToken = NULL, $eTag = NULL, $graphVersion = NULL)
    {
        return $this->sendRequest("DELETE", $endpoint, $params, $accessToken, $eTag, $graphVersion);
    }
    public function next(GraphNodes\GraphEdge $graphEdge)
    {
        return $this->getPaginationResults($graphEdge, "next");
    }
    public function previous(GraphNodes\GraphEdge $graphEdge)
    {
        return $this->getPaginationResults($graphEdge, "previous");
    }
    public function getPaginationResults(GraphNodes\GraphEdge $graphEdge, $direction)
    {
        $paginationRequest = $graphEdge->getPaginationRequest($direction);
        if (!$paginationRequest) {
            return NULL;
        }
        $this->lastResponse = $this->client->sendRequest($paginationRequest);
        $subClassName = $graphEdge->getSubClassName();
        $graphEdge = $this->lastResponse->getGraphEdge($subClassName, false);
        return 0 < count($graphEdge) ? $graphEdge : NULL;
    }
    public function sendRequest($method, $endpoint, $params = [], $accessToken = NULL, $eTag = NULL, $graphVersion = NULL)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        $request = $this->request($method, $endpoint, $params, $accessToken, $eTag, $graphVersion);
        return $this->lastResponse = $this->client->sendRequest($request);
    }
    public function sendBatchRequest($requests, $accessToken = NULL, $graphVersion = NULL)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        $batchRequest = new FacebookBatchRequest($this->app, $requests, $accessToken, $graphVersion);
        return $this->lastResponse = $this->client->sendBatchRequest($batchRequest);
    }
    public function request($method, $endpoint, $params = [], $accessToken = NULL, $eTag = NULL, $graphVersion = NULL)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        return new FacebookRequest($this->app, $accessToken, $method, $endpoint, $params, $eTag, $graphVersion);
    }
    public function fileToUpload($pathToFile)
    {
        return new FileUpload\FacebookFile($pathToFile);
    }
    public function videoToUpload($pathToFile)
    {
        return new FileUpload\FacebookVideo($pathToFile);
    }
}

?>