<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class Request
 *
 * @package Facebook
 */
class FacebookRequest
{
    /**
     * @var FacebookApp The Facebook app entity.
     */
    protected $app = NULL;
    /**
     * @var string|null The access token to use for this request.
     */
    protected $accessToken = NULL;
    /**
     * @var string The HTTP method for this request.
     */
    protected $method = NULL;
    /**
     * @var string The Graph endpoint for this request.
     */
    protected $endpoint = NULL;
    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];
    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];
    /**
     * @var array The files to send with this request.
     */
    protected $files = [];
    /**
     * @var string ETag to send with this request.
     */
    protected $eTag = NULL;
    /**
     * @var string Graph version to use for this request.
     */
    protected $graphVersion = NULL;
    public function __construct(FacebookApp $app = NULL, $accessToken = NULL, $method = NULL, $endpoint = NULL, $params = [], $eTag = NULL, $graphVersion = NULL)
    {
        $this->setApp($app);
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->setETag($eTag);
        $this->graphVersion = $graphVersion ?: Facebook::DEFAULT_GRAPH_VERSION;
    }
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        if ($accessToken instanceof Authentication\AccessToken) {
            $this->accessToken = $accessToken->getValue();
        }
        return $this;
    }
    public function setAccessTokenFromParams($accessToken)
    {
        $existingAccessToken = $this->getAccessToken();
        if (!$existingAccessToken) {
            $this->setAccessToken($accessToken);
        } else {
            if ($accessToken !== $existingAccessToken) {
                throw new Exceptions\FacebookSDKException("Access token mismatch. The access token provided in the FacebookRequest and the one provided in the URL or POST params do not match.");
            }
        }
        return $this;
    }
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    public function getAccessTokenEntity()
    {
        return $this->accessToken ? new Authentication\AccessToken($this->accessToken) : NULL;
    }
    public function setApp(FacebookApp $app = NULL)
    {
        $this->app = $app;
    }
    public function getApp()
    {
        return $this->app;
    }
    public function getAppSecretProof()
    {
        if (!($accessTokenEntity = $this->getAccessTokenEntity())) {
            return NULL;
        }
        return $accessTokenEntity->getAppSecretProof($this->app->getSecret());
    }
    public function validateAccessToken()
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            throw new Exceptions\FacebookSDKException("You must provide an access token.");
        }
    }
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function validateMethod()
    {
        if (!$this->method) {
            throw new Exceptions\FacebookSDKException("HTTP method not specified.");
        }
        if (!in_array($this->method, ["GET", "POST", "DELETE"])) {
            throw new Exceptions\FacebookSDKException("Invalid HTTP method specified.");
        }
    }
    public function setEndpoint($endpoint)
    {
        $params = Url\FacebookUrlManipulator::getParamsAsArray($endpoint);
        if (isset($params["access_token"])) {
            $this->setAccessTokenFromParams($params["access_token"]);
        }
        $filterParams = ["access_token", "appsecret_proof"];
        $this->endpoint = Url\FacebookUrlManipulator::removeParamsFromUrl($endpoint, $filterParams);
        return $this;
    }
    public function getEndpoint()
    {
        return $this->endpoint;
    }
    public function getHeaders()
    {
        $headers = static::getDefaultHeaders();
        if ($this->eTag) {
            $headers["If-None-Match"] = $this->eTag;
        }
        return array_merge($this->headers, $headers);
    }
    public function setHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }
    public function setETag($eTag)
    {
        $this->eTag = $eTag;
    }
    public function setParams($params = [])
    {
        if (isset($params["access_token"])) {
            $this->setAccessTokenFromParams($params["access_token"]);
        }
        unset($params["access_token"]);
        unset($params["appsecret_proof"]);
        $params = $this->sanitizeFileParams($params);
        $this->dangerouslySetParams($params);
        return $this;
    }
    public function dangerouslySetParams($params = [])
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }
    public function sanitizeFileParams($params)
    {
        foreach ($params as $key => $value) {
            if ($value instanceof FileUpload\FacebookFile) {
                $this->addFile($key, $value);
                unset($params[$key]);
            }
        }
        return $params;
    }
    public function addFile($key, FileUpload\FacebookFile $file)
    {
        $this->files[$key] = $file;
    }
    public function resetFiles()
    {
        $this->files = [];
    }
    public function getFiles()
    {
        return $this->files;
    }
    public function containsFileUploads()
    {
        return !empty($this->files);
    }
    public function containsVideoUploads()
    {
        foreach ($this->files as $file) {
            if ($file instanceof FileUpload\FacebookVideo) {
                return true;
            }
        }
        return false;
    }
    public function getMultipartBody()
    {
        $params = $this->getPostParams();
        return new Http\RequestBodyMultipart($params, $this->files);
    }
    public function getUrlEncodedBody()
    {
        $params = $this->getPostParams();
        return new Http\RequestBodyUrlEncoded($params);
    }
    public function getParams()
    {
        $params = $this->params;
        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $params["access_token"] = $accessToken;
            $params["appsecret_proof"] = $this->getAppSecretProof();
        }
        return $params;
    }
    public function getPostParams()
    {
        if ($this->getMethod() === "POST") {
            return $this->getParams();
        }
        return [];
    }
    public function getGraphVersion()
    {
        return $this->graphVersion;
    }
    public function getUrl()
    {
        $this->validateMethod();
        $graphVersion = Url\FacebookUrlManipulator::forceSlashPrefix($this->graphVersion);
        $endpoint = Url\FacebookUrlManipulator::forceSlashPrefix($this->getEndpoint());
        $url = $graphVersion . $endpoint;
        if ($this->getMethod() !== "POST") {
            $params = $this->getParams();
            $url = Url\FacebookUrlManipulator::appendParamsToUrl($url, $params);
        }
        return $url;
    }
    public static function getDefaultHeaders()
    {
        return ["User-Agent" => "fb-php-" . Facebook::VERSION, "Accept-Encoding" => "*"];
    }
}

?>