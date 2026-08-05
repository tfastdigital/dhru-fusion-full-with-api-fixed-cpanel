<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class Google2FA
{
    public static $lut = ["A" => 0, "B" => 1, "C" => 2, "D" => 3, "E" => 4, "F" => 5, "G" => 6, "H" => 7, "I" => 8, "J" => 9, "K" => 10, "L" => 11, "M" => 12, "N" => 13, "O" => 14, "P" => 15, "Q" => 16, "R" => 17, "S" => 18, "T" => 19, "U" => 20, "V" => 21, "W" => 22, "X" => 23, "Y" => 24, "Z" => 25, "2" => 26, "3" => 27, "4" => 28, "5" => 29, "6" => 30, "7" => 31];
    const keyRegeneration = 30;
    const otpLength = 6;
    public static function generate_secret_key($length = 16)
    {
        $b32 = "234567QWERTYUIOPASDFGHJKLZXCVBNM";
        $s = "";
        for ($i = 0; $i < $length; $i++) {
            $s .= $b32[rand(0, 31)];
        }
        return $s;
    }
    public static function get_timestamp()
    {
        return floor(microtime(true) / 30);
    }
    public static function base32_decode($b32)
    {
        $b32 = strtoupper($b32);
        if (!preg_match("/^[ABCDEFGHIJKLMNOPQRSTUVWXYZ234567]+\$/", $b32, $match)) {
            throw new Exception("Invalid characters in the base32 string.");
        }
        $l = strlen($b32);
        $n = 0;
        $j = 0;
        $binary = "";
        for ($i = 0; $i < $l; $i++) {
            $n = $n << 5;
            $n = $n + self::$lut[$b32[$i]];
            $j = $j + 5;
            if (8 <= $j) {
                $j = $j - 8;
                $binary .= chr(($n & 255 << $j) >> $j);
            }
        }
        return $binary;
    }
    public static function oath_hotp($key, $counter)
    {
        if (strlen($key) < 8) {
            throw new Exception("Secret key is too short. Must be at least 16 base 32 characters");
        }
        $bin_counter = pack("N*", 0) . pack("N*", $counter);
        $hash = hash_hmac("sha1", $bin_counter, $key, true);
        return str_pad(self::oath_truncate($hash), 6, "0", STR_PAD_LEFT);
    }
    public static function verify_key($b32seed, $key, $window = 4, $useTimeStamp = true)
    {
        $timeStamp = self::get_timestamp();
        if ($useTimeStamp !== true) {
            $timeStamp = (int) $useTimeStamp;
        }
        $binarySeed = self::base32_decode($b32seed);
        for ($ts = $timeStamp - $window; $ts <= $timeStamp + $window; $ts++) {
            if (self::oath_hotp($binarySeed, $ts) == $key) {
                return true;
            }
        }
        return false;
    }
    public static function oath_truncate($hash)
    {
        $offset = ord($hash[19]) & 15;
        return ((ord($hash[$offset + 0]) & 127) << 24 | (ord($hash[$offset + 1]) & 255) << 16 | (ord($hash[$offset + 2]) & 255) << 8 | ord($hash[$offset + 3]) & 255) % pow(10, 6);
    }
}
function secret_key($length = 16)
{
    $b32 = "234567QWERTYUIOPASDFGHJKLZXCVBNM";
    $s = "";
    for ($i = 0; $i < $length; $i++) {
        $s .= $b32[rand(0, 31)];
    }
    return $s;
}

?>