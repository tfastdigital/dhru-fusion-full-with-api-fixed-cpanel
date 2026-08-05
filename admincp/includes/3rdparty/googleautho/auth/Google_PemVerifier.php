<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Verifies signatures using PEM encoded certificates.
 *
 * @author Brian Eaton <beaton@google.com>
 */
class Google_PemVerifier extends Google_Verifier
{
    private $publicKey = NULL;
    public function __construct($pem)
    {
        if (!function_exists("openssl_x509_read")) {
            throw new Google_Exception("Google API PHP client needs the openssl PHP extension");
        }
        $this->publicKey = openssl_x509_read($pem);
        if (!$this->publicKey) {
            throw new Google_AuthException("Unable to parse PEM: " . $pem);
        }
    }
    public function __destruct()
    {
        if ($this->publicKey) {
            openssl_x509_free($this->publicKey);
        }
    }
    public function verify($data, $signature)
    {
        $status = openssl_verify($data, $signature, $this->publicKey, "sha256");
        if ($status === -1) {
            throw new Google_AuthException("Signature verification error: " . openssl_error_string());
        }
        return $status === 1;
    }
}

?>