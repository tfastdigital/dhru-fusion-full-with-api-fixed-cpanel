<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Signs data.
 *
 * Only used for testing.
 *
 * @author Brian Eaton <beaton@google.com>
 */
class Google_P12Signer extends Google_Signer
{
    private $privateKey = NULL;
    public function __construct($p12, $password)
    {
        if (!function_exists("openssl_x509_read")) {
            throw new Exception("The Google PHP API library needs the openssl PHP extension");
        }
        $certs = [];
        if (!openssl_pkcs12_read($p12, $certs, $password)) {
            throw new Google_AuthException("Unable to parse the p12 file.  Is this a .p12 file?  Is the password correct?  OpenSSL error: " . openssl_error_string());
        }
        if (!array_key_exists("pkey", $certs) || !$certs["pkey"]) {
            throw new Google_AuthException("No private key found in p12 file.");
        }
        $this->privateKey = openssl_pkey_get_private($certs["pkey"]);
        if (!$this->privateKey) {
            throw new Google_AuthException("Unable to load private key in ");
        }
    }
    public function __destruct()
    {
        if ($this->privateKey) {
            openssl_pkey_free($this->privateKey);
        }
    }
    public function sign($data)
    {
        if (version_compare(PHP_VERSION, "5.3.0") < 0) {
            throw new Google_AuthException("PHP 5.3.0 or higher is required to use service accounts.");
        }
        if (!openssl_sign($data, $signature, $this->privateKey, "sha256")) {
            throw new Google_AuthException("Unable to sign data");
        }
        return $signature;
    }
}

?>