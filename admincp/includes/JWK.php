<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Firebase\JWT;

/**
 * JSON Web Key implementation, based on this spec:
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-key-41
 *
 * PHP version 5
 *
 * @category Authentication
 * @package  Authentication_JWT
 * @author   Bui Sy Nguyen <nguyenbs@gmail.com>
 * @license  http://opensource.org/licenses/BSD-3-Clause 3-clause BSD
 * @link     https://github.com/firebase/php-jwt
 */
class JWK
{
    public static function parseKeySet($jwks)
    {
        $keys = [];
      
        return $keys;
    }
    public static function parseKey($jwk)
    {
        if (empty($jwk)) {
            throw new \InvalidArgumentException("JWK must not be empty");
        }
        if (!isset($jwk["kty"])) {
            throw new \UnexpectedValueException("JWK must contain a \"kty\" parameter");
        }
        switch ($jwk["kty"]) {
            case "RSA":
                if (!empty($jwk["d"])) {
                    throw new \UnexpectedValueException("RSA private keys are not supported");
                }
                if (!isset($jwk["n"]) || !isset($jwk["e"])) {
                    throw new \UnexpectedValueException("RSA keys must contain values for both \"n\" and \"e\"");
                }
                $pem = self::createPemFromModulusAndExponent($jwk["n"], $jwk["e"]);
                $publicKey = openssl_pkey_get_public($pem);
                if (false === $publicKey) {
                    throw new \DomainException("OpenSSL error: " . openssl_error_string());
                }
                return $publicKey;
                break;
        }
    }
    private static function createPemFromModulusAndExponent($n, $e)
    {
        $modulus = JWT::urlsafeB64Decode($n);
        $publicExponent = JWT::urlsafeB64Decode($e);
        $components = ["modulus" => pack("Ca*a*", 2, self::encodeLength(strlen($modulus)), $modulus), "publicExponent" => pack("Ca*a*", 2, self::encodeLength(strlen($publicExponent)), $publicExponent)];
        $rsaPublicKey = pack("Ca*a*a*", 48, self::encodeLength(strlen($components["modulus"]) + strlen($components["publicExponent"])), $components["modulus"], $components["publicExponent"]);
        $rsaOID = pack("H*", "300d06092a864886f70d0101010500");
        $rsaPublicKey = chr(0) . $rsaPublicKey;
        $rsaPublicKey = chr(3) . self::encodeLength(strlen($rsaPublicKey)) . $rsaPublicKey;
        $rsaPublicKey = pack("Ca*a*", 48, self::encodeLength(strlen($rsaOID . $rsaPublicKey)), $rsaOID . $rsaPublicKey);
        $rsaPublicKey = "-----BEGIN PUBLIC KEY-----\r\n" . chunk_split(base64_encode($rsaPublicKey), 64) . "-----END PUBLIC KEY-----";
        return $rsaPublicKey;
    }
    private static function encodeLength($length)
    {
        if ($length <= 127) {
            return chr($length);
        }
        $temp = ltrim(pack("N", $length), chr(0));
        return pack("Ca*", 128 | strlen($temp), $temp);
    }
}

?>