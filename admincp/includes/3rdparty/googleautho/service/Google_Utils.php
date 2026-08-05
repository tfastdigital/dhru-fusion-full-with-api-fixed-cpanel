<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Collection of static utility methods used for convenience across
 * the client library.
 *
 * @author Chirag Shah <chirags@google.com>
 */
class Google_Utils
{
    public static function urlSafeB64Encode($data)
    {
        $b64 = base64_encode($data);
        $b64 = str_replace(["+", "/", "\\r", "\\n", "="], ["-", "_"], $b64);
        return $b64;
    }
    public static function urlSafeB64Decode($b64)
    {
        $b64 = str_replace(["-", "_"], ["+", "/"], $b64);
        return base64_decode($b64);
    }
    public static function getStrLen($str)
    {
        $strlenVar = strlen($str);
        $d = $ret = 0;
        for ($count = 0; $count < $strlenVar; $count++) {
            $ordinalValue = ord($str[$ret]);
            if (32 <= $ordinalValue && $ordinalValue <= 127) {
                if (($ordinalValue & 224) == 192) {
                    if (($ordinalValue & 240) == 224) {
                        if (($ordinalValue & 248) == 240) {
                            if (($ordinalValue & 252) == 248) {
                                if (($ordinalValue & 254) == 252) {
                                    $ret++;
                                } else {
                                    $ret += 6;
                                }
                            } else {
                                $ret += 5;
                            }
                        } else {
                            $ret += 4;
                        }
                    } else {
                        $ret += 3;
                    }
                } else {
                    $ret += 2;
                }
            } else {
                $ret++;
            }
        }
        return $ret;
    }
    public static function normalize($arr)
    {
        if (!is_array($arr)) {
            return [];
        }
        $normalized = [];
        foreach ($arr as $key => $val) {
            $normalized[strtolower($key)] = $val;
        }
        return $normalized;
    }
}

?>