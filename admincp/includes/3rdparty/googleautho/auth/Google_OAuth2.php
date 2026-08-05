<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Google_Verifier.php";
require_once "Google_LoginTicket.php";
require_once "service/Google_Utils.php";
/**
 * Authentication class that deals with the OAuth 2 web-server authentication flow
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_OAuth2 extends Google_Auth
{
    public $clientId = NULL;
    public $clientSecret = NULL;
    public $developerKey = NULL;
    public $token = NULL;
    public $redirectUri = NULL;
    public $state = NULL;
    public $accessType = "offline";
    public $approvalPrompt = "force";
    /** @var Google_AssertionCredentials $assertionCredentials */
    public $assertionCredentials = NULL;
    const OAUTH2_REVOKE_URI = "https://accounts.google.com/o/oauth2/revoke";
    const OAUTH2_TOKEN_URI = "https://accounts.google.com/o/oauth2/token";
    const OAUTH2_AUTH_URL = "https://accounts.google.com/o/oauth2/auth";
    const OAUTH2_FEDERATED_SIGNON_CERTS_URL = "https://www.googleapis.com/oauth2/v1/certs";
    const CLOCK_SKEW_SECS = 300;
    const AUTH_TOKEN_LIFETIME_SECS = 300;
    const MAX_TOKEN_LIFETIME_SECS = 86400;
    public function __construct()
    {
        global $apiConfig;
        if (!empty($apiConfig["developer_key"])) {
            $this->developerKey = $apiConfig["developer_key"];
        }
        if (!empty($apiConfig["oauth2_client_id"])) {
            $this->clientId = $apiConfig["oauth2_client_id"];
        }
        if (!empty($apiConfig["oauth2_client_secret"])) {
            $this->clientSecret = $apiConfig["oauth2_client_secret"];
        }
        if (!empty($apiConfig["oauth2_redirect_uri"])) {
            $this->redirectUri = $apiConfig["oauth2_redirect_uri"];
        }
        if (!empty($apiConfig["oauth2_access_type"])) {
            $this->accessType = $apiConfig["oauth2_access_type"];
        }
        if (!empty($apiConfig["oauth2_approval_prompt"])) {
            $this->approvalPrompt = $apiConfig["oauth2_approval_prompt"];
        }
    }
    public function authenticate($service, $code = NULL)
    {
        if (!$code && isset($_GET["code"])) {
            $code = $_GET["code"];
        }
        if ($code) {
            $request = Google_Client::$io->makeRequest(new Google_HttpRequest("https://accounts.google.com/o/oauth2/token", "POST", [], ["code" => $code, "grant_type" => "authorization_code", "redirect_uri" => $this->redirectUri, "client_id" => $this->clientId, "client_secret" => $this->clientSecret]));
            if ($request->getResponseHttpCode() == 200) {
                $this->setAccessToken($request->getResponseBody());
                $this->token["created"] = time();
                return $this->getAccessToken();
            }
            $response = $request->getResponseBody();
            $decodedResponse = json_decode($response, true);
            if ($decodedResponse != NULL && $decodedResponse["error"]) {
                $response = $decodedResponse["error"];
            }
            throw new Google_AuthException("Error fetching OAuth2 access token, message: '" . $response . "'", $request->getResponseHttpCode());
        }
        $authUrl = $this->createAuthUrl($service["scope"]);
        header("Location: " . $authUrl);
        return true;
    }
    public function createAuthUrl($scope)
    {
        $params = ["response_type=code", "redirect_uri=" . urlencode($this->redirectUri), "client_id=" . urlencode($this->clientId), "scope=" . urlencode($scope), "access_type=" . urlencode($this->accessType), "approval_prompt=" . urlencode($this->approvalPrompt)];
        if (isset($this->state)) {
            $params[] = "state=" . urlencode($this->state);
        }
        $params = implode("&", $params);
        return "https://accounts.google.com/o/oauth2/auth" . "?" . $params;
    }
    public function setAccessToken($token)
    {
        $token = json_decode($token, true);
        if ($token == NULL) {
            throw new Google_AuthException("Could not json decode the token");
        }
        if (!isset($token["access_token"])) {
            throw new Google_AuthException("Invalid token format");
        }
        $this->token = $token;
    }
    public function getAccessToken()
    {
        return json_encode($this->token);
    }
    public function setDeveloperKey($developerKey)
    {
        $this->developerKey = $developerKey;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
    public function setAccessType($accessType)
    {
        $this->accessType = $accessType;
    }
    public function setApprovalPrompt($approvalPrompt)
    {
        $this->approvalPrompt = $approvalPrompt;
    }
    public function setAssertionCredentials(Google_AssertionCredentials $creds)
    {
        $this->assertionCredentials = $creds;
    }
    public function sign(Google_HttpRequest $request)
    {
        if ($this->developerKey) {
            $requestUrl = $request->getUrl();
            $requestUrl .= strpos($request->getUrl(), "?") === false ? "?" : "&";
            $requestUrl .= "key=" . urlencode($this->developerKey);
            $request->setUrl($requestUrl);
        }
        if (NULL == $this->token && NULL == $this->assertionCredentials) {
            return $request;
        }
        if ($this->isAccessTokenExpired()) {
            if ($this->assertionCredentials) {
                $this->refreshTokenWithAssertion();
            } else {
                if (!array_key_exists("refresh_token", $this->token)) {
                    throw new Google_AuthException("The OAuth 2.0 access token has expired, and a refresh token is not available. Refresh tokens are not returned for responses that were auto-approved.");
                }
                $this->refreshToken($this->token["refresh_token"]);
            }
        }
        $request->setRequestHeaders(["Authorization" => "Bearer " . $this->token["access_token"]]);
        return $request;
    }
    public function refreshToken($refreshToken)
    {
        $this->refreshTokenRequest(["client_id" => $this->clientId, "client_secret" => $this->clientSecret, "refresh_token" => $refreshToken, "grant_type" => "refresh_token"]);
    }
    public function refreshTokenWithAssertion($assertionCredentials = NULL)
    {
        if (!$assertionCredentials) {
            $assertionCredentials = $this->assertionCredentials;
        }
        $this->refreshTokenRequest(["grant_type" => "assertion", "assertion_type" => $assertionCredentials->assertionType, "assertion" => $assertionCredentials->generateAssertion()]);
    }
    private function refreshTokenRequest($params)
    {
        $http = new Google_HttpRequest("https://accounts.google.com/o/oauth2/token", "POST", [], $params);
        $request = Google_Client::$io->makeRequest($http);
        $code = $request->getResponseHttpCode();
        $body = $request->getResponseBody();
        if (200 == $code) {
            $token = json_decode($body, true);
            if ($token == NULL) {
                throw new Google_AuthException("Could not json decode the access token");
            }
            if (!isset($token["access_token"]) || !isset($token["expires_in"])) {
                throw new Google_AuthException("Invalid token format");
            }
            $this->token["access_token"] = $token["access_token"];
            $this->token["expires_in"] = $token["expires_in"];
            $this->token["created"] = time();
        } else {
            throw new Google_AuthException("Error refreshing the OAuth2 token, message: '" . $body . "'", $code);
        }
    }
    public function revokeToken($token = NULL)
    {
        if (!$token) {
            $token = $this->token["access_token"];
        }
        $request = new Google_HttpRequest("https://accounts.google.com/o/oauth2/revoke", "POST", [], "token=" . $token);
        $response = Google_Client::$io->makeRequest($request);
        $code = $response->getResponseHttpCode();
        if ($code == 200) {
            $this->token = NULL;
            return true;
        }
        return false;
    }
    public function isAccessTokenExpired()
    {
        if (NULL == $this->token) {
            return true;
        }
        $expired = $this->token["created"] + $this->token["expires_in"] - 30 < time();
        return $expired;
    }
    private function getFederatedSignOnCerts()
    {
        $request = Google_Client::$io->makeRequest(new Google_HttpRequest("https://www.googleapis.com/oauth2/v1/certs"));
        if ($request->getResponseHttpCode() == 200) {
            $certs = json_decode($request->getResponseBody(), true);
            if ($certs) {
                return $certs;
            }
        }
        throw new Google_AuthException("Failed to retrieve verification certificates: '" . $request->getResponseBody() . "'.", $request->getResponseHttpCode());
    }
    public function verifyIdToken($id_token = NULL, $audience = NULL)
    {
        if (!$id_token) {
            $id_token = $this->token["id_token"];
        }
        $certs = $this->getFederatedSignonCerts();
        if (!$audience) {
            $audience = $this->clientId;
        }
        return $this->verifySignedJwtWithCerts($id_token, $certs, $audience);
    }
    public function verifySignedJwtWithCerts($jwt, $certs, $required_audience)
    {
        $segments = explode(".", $jwt);
        if (count($segments) != 3) {
            throw new Google_AuthException("Wrong number of segments in token: " . $jwt);
        }
        $signed = $segments[0] . "." . $segments[1];
        $signature = Google_Utils::urlSafeB64Decode($segments[2]);
        $envelope = json_decode(Google_Utils::urlSafeB64Decode($segments[0]), true);
        if (!$envelope) {
            throw new Google_AuthException("Can't parse token envelope: " . $segments[0]);
        }
        $json_body = Google_Utils::urlSafeB64Decode($segments[1]);
        $payload = json_decode($json_body, true);
        if (!$payload) {
            throw new Google_AuthException("Can't parse token payload: " . $segments[1]);
        }
        $verified = false;
        foreach ($certs as $keyName => $pem) {
            $public_key = new Google_PemVerifier($pem);
            if ($public_key->verify($signed, $signature)) {
                $verified = true;
                if (!$verified) {
                    throw new Google_AuthException("Invalid token signature: " . $jwt);
                }
                $iat = 0;
                if (array_key_exists("iat", $payload)) {
                    $iat = $payload["iat"];
                }
                if (!$iat) {
                    throw new Google_AuthException("No issue time in token: " . $json_body);
                }
                $earliest = $iat - 300;
                $now = time();
                $exp = 0;
                if (array_key_exists("exp", $payload)) {
                    $exp = $payload["exp"];
                }
                if (!$exp) {
                    throw new Google_AuthException("No expiration time in token: " . $json_body);
                }
                if ($now + 86400 <= $exp) {
                    throw new Google_AuthException("Expiration time too far in future: " . $json_body);
                }
                $latest = $exp + 300;
                if ($now < $earliest) {
                    throw new Google_AuthException("Token used too early, " . $now . " < " . $earliest . ": " . $json_body);
                }
                if ($latest < $now) {
                    throw new Google_AuthException("Token used too late, " . $now . " > " . $latest . ": " . $json_body);
                }
                $aud = $payload["aud"];
                if ($aud != $required_audience) {
                    throw new Google_AuthException("Wrong recipient, " . $aud . " != " . $required_audience . ": " . $json_body);
                }
                return new Google_LoginTicket($envelope, $payload);
            }
        }
    }
}

?>