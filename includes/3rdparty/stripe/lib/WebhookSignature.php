<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

class WebhookSignature
{
    const EXPECTED_SCHEME = "v1";
    public static function verifyHeader($payload, $header, $secret, $tolerance = NULL)
    {
        $timestamp = self::getTimestamp($header);
        $signatures = self::getSignatures($header, self::EXPECTED_SCHEME);
        if ($timestamp == -1) {
            throw new Error\SignatureVerification("Unable to extract timestamp and signatures from header", $header, $payload);
        }
        if (empty($signatures)) {
            throw new Error\SignatureVerification("No signatures found with expected scheme", $header, $payload);
        }
        $signedPayload = $timestamp . "." . $payload;
        $expectedSignature = self::computeSignature($signedPayload, $secret);
        $signatureFound = false;
        foreach ($signatures as $signature) {
            if (Util\Util::secureCompare($expectedSignature, $signature)) {
                $signatureFound = true;
                if (!$signatureFound) {
                    throw new Error\SignatureVerification("No signatures found matching the expected signature for payload", $header, $payload);
                }
                if (0 < $tolerance && $tolerance < time() - $timestamp) {
                    throw new Error\SignatureVerification("Timestamp outside the tolerance zone", $header, $payload);
                }
                return true;
            }
        }
    }
    private static function getTimestamp($header)
    {
        $items = explode(",", $header);
        foreach ($items as $item) {
            $itemParts = explode("=", $item, 2);
            if ($itemParts[0] == "t") {
                if (!is_numeric($itemParts[1])) {
                    return -1;
                }
                return intval($itemParts[1]);
            }
        }
        return -1;
    }
    private static function getSignatures($header, $scheme)
    {
        $signatures = [];
        $items = explode(",", $header);
        foreach ($items as $item) {
            $itemParts = explode("=", $item, 2);
            if ($itemParts[0] == $scheme) {
                array_push($signatures, $itemParts[1]);
            }
        }
        return $signatures;
    }
    private static function computeSignature($payload, $secret)
    {
        return hash_hmac("sha256", $payload, $secret);
    }
}

?>