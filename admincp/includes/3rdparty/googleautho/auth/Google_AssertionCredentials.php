<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Credentials object used for OAuth 2.0 Signed JWT assertion grants.
 *
 * @author Chirag Shah <chirags@google.com>
 */
class Google_AssertionCredentials
{
    public $serviceAccountName = NULL;
    public $scopes = NULL;
    public $privateKey = NULL;
    public $privateKeyPassword = NULL;
    public $assertionType = NULL;
    public $prn = NULL;
    const MAX_TOKEN_LIFETIME_SECS = 3600;
    public function __construct($serviceAccountName, $scopes, $privateKey, $privateKeyPassword = "notasecret", $assertionType = "http://oauth.net/grant_type/jwt/1.0/bearer", $prn = false)
    {
        $this->serviceAccountName = $serviceAccountName;
        $this->scopes = is_string($scopes) ? $scopes : implode(" ", $scopes);
        $this->privateKey = $privateKey;
        $this->privateKeyPassword = $privateKeyPassword;
        $this->assertionType = $assertionType;
        $this->prn = $prn;
    }
    public function generateAssertion()
    {
        $now = time();
        $jwtParams = ["aud" => Google_OAuth2::OAUTH2_TOKEN_URI, "scope" => $this->scopes, "iat" => $now, "exp" => $now + 3600, "iss" => $this->serviceAccountName];
        if ($this->prn !== false) {
            $jwtParams["prn"] = $this->prn;
        }
        return $this->makeSignedJwt($jwtParams);
    }
    private function makeSignedJwt($payload)
    {
        $header = ["typ" => "JWT", "alg" => "RS256"];
        $segments = [Google_Utils::urlSafeB64Encode(json_encode($header)), Google_Utils::urlSafeB64Encode(json_encode($payload))];
        $signingInput = implode(".", $segments);
        $signer = new Google_P12Signer($this->privateKey, $this->privateKeyPassword);
        $signature = $signer->sign($signingInput);
        $segments[] = Google_Utils::urlSafeB64Encode($signature);
        return implode(".", $segments);
    }
}

?>