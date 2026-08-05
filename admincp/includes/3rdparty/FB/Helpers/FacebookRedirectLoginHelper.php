<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Helpers;

/**
 * Class FacebookRedirectLoginHelper
 *
 * @package Facebook
 */
class FacebookRedirectLoginHelper
{
    /**
     * @var OAuth2Client The OAuth 2.0 client service.
     */
    protected $oAuth2Client = NULL;
    /**
     * @var UrlDetectionInterface The URL detection handler.
     */
    protected $urlDetectionHandler = NULL;
    /**
     * @var PersistentDataInterface The persistent data handler.
     */
    protected $persistentDataHandler = NULL;
    /**
     * @var PseudoRandomStringGeneratorInterface The cryptographically secure pseudo-random string generator.
     */
    protected $pseudoRandomStringGenerator = NULL;
    const CSRF_LENGTH = 32;
    public function __construct(\Facebook\Authentication\OAuth2Client $oAuth2Client, \Facebook\PersistentData\PersistentDataInterface $persistentDataHandler = NULL, \Facebook\Url\UrlDetectionInterface $urlHandler = NULL, \Facebook\PseudoRandomString\PseudoRandomStringGeneratorInterface $prsg = NULL)
    {
        $this->oAuth2Client = $oAuth2Client;
        $this->persistentDataHandler = $persistentDataHandler ?: new \Facebook\PersistentData\FacebookSessionPersistentDataHandler();
        $this->urlDetectionHandler = $urlHandler ?: new \Facebook\Url\FacebookUrlDetectionHandler();
        $this->pseudoRandomStringGenerator = $prsg ?: $this->detectPseudoRandomStringGenerator();
    }
    public function getPersistentDataHandler()
    {
        return $this->persistentDataHandler;
    }
    public function getUrlDetectionHandler()
    {
        return $this->urlDetectionHandler;
    }
    public function getPseudoRandomStringGenerator()
    {
        return $this->pseudoRandomStringGenerator;
    }
    public function detectPseudoRandomStringGenerator()
    {
        if (function_exists("mcrypt_create_iv")) {
            return new \Facebook\PseudoRandomString\McryptPseudoRandomStringGenerator();
        }
        if (function_exists("openssl_random_pseudo_bytes")) {
            return new \Facebook\PseudoRandomString\OpenSslPseudoRandomStringGenerator();
        }
        if (!ini_get("open_basedir") && is_readable("/dev/urandom")) {
            return new \Facebook\PseudoRandomString\UrandomPseudoRandomStringGenerator();
        }
        throw new \Facebook\Exceptions\FacebookSDKException("Unable to detect a cryptographically secure pseudo-random string generator.");
    }
    private function makeUrl($redirectUrl, $scope, $params = [], $separator = "&")
    {
        $state = $this->pseudoRandomStringGenerator->getPseudoRandomString(static::CSRF_LENGTH);
        $this->persistentDataHandler->set("state", $state);
        return $this->oAuth2Client->getAuthorizationUrl($redirectUrl, $state, $scope, $params, $separator);
    }
    public function getLoginUrl($redirectUrl, $scope = [], $separator = "&")
    {
        return $this->makeUrl($redirectUrl, $scope, [], $separator);
    }
    public function getLogoutUrl($accessToken, $next, $separator = "&")
    {
        if (!$accessToken instanceof \Facebook\Authentication\AccessToken) {
            $accessToken = new \Facebook\Authentication\AccessToken($accessToken);
        }
        if ($accessToken->isAppAccessToken()) {
            throw new \Facebook\Exceptions\FacebookSDKException("Cannot generate a logout URL with an app access token.", 722);
        }
        $params = ["next" => $next, "access_token" => $accessToken->getValue()];
        return "https://www.facebook.com/logout.php?" . http_build_query($params, NULL, $separator);
    }
    public function getReRequestUrl($redirectUrl, $scope = [], $separator = "&")
    {
        $params = ["auth_type" => "rerequest"];
        return $this->makeUrl($redirectUrl, $scope, $params, $separator);
    }
    public function getReAuthenticationUrl($redirectUrl, $scope = [], $separator = "&")
    {
        $params = ["auth_type" => "reauthenticate"];
        return $this->makeUrl($redirectUrl, $scope, $params, $separator);
    }
    public function getAccessToken($redirectUrl = NULL)
    {
        if (!($code = $this->getCode())) {
            return NULL;
        }
        $this->validateCsrf();
        $redirectUrl = $redirectUrl ?: $this->urlDetectionHandler->getCurrentUrl();
        $redirectUrl = \Facebook\Url\FacebookUrlManipulator::removeParamsFromUrl($redirectUrl, ["state"]);
        return $this->oAuth2Client->getAccessTokenFromCode($code, $redirectUrl);
    }
    protected function validateCsrf()
    {
        $state = $this->getState();
        $savedState = $this->persistentDataHandler->get("state");
        if (!$state || !$savedState) {
            throw new \Facebook\Exceptions\FacebookSDKException("Cross-site request forgery validation failed. Required param \"state\" missing.");
        }
        $savedLen = strlen($savedState);
        $givenLen = strlen($state);
        if ($savedLen !== $givenLen) {
            throw new \Facebook\Exceptions\FacebookSDKException("Cross-site request forgery validation failed. The \"state\" param from the URL and session do not match.");
        }
        $result = 0;
        for ($i = 0; $i < $savedLen; $i++) {
            $result |= ord($state[$i]) ^ ord($savedState[$i]);
        }
        if ($result !== 0) {
            throw new \Facebook\Exceptions\FacebookSDKException("Cross-site request forgery validation failed. The \"state\" param from the URL and session do not match.");
        }
    }
    protected function getCode()
    {
        return $this->getInput("code");
    }
    protected function getState()
    {
        return $this->getInput("state");
    }
    public function getErrorCode()
    {
        return $this->getInput("error_code");
    }
    public function getError()
    {
        return $this->getInput("error");
    }
    public function getErrorReason()
    {
        return $this->getInput("error_reason");
    }
    public function getErrorDescription()
    {
        return $this->getInput("error_description");
    }
    private function getInput($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : NULL;
    }
}

?>