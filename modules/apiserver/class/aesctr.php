<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class AesCtr extends Aes
{
    public static function encrypt($plaintext, $password, $nBits)
    {
        $blockSize = 16;
        if (!($nBits == 128 || $nBits == 192 || $nBits == 256)) {
            return "";
        }
        $nBytes = $nBits / 8;
        $pwBytes = [];
        for ($i = 0; $i < $nBytes; $i++) {
            $pwBytes[$i] = ord(substr($password, $i, 1)) & 255;
        }
        $key = Aes::cipher($pwBytes, Aes::keyExpansion($pwBytes));
        $key = array_merge($key, array_slice($key, 0, $nBytes - 16));
        $counterBlock = [];
        $nonce = floor(microtime(true) * 1000);
        $nonceMs = $nonce % 1000;
        $nonceSec = floor($nonce / 1000);
        $nonceRnd = floor(rand(0, 65535));
        for ($i = 0; $i < 2; $i++) {
            $counterBlock[$i] = self::urs($nonceMs, $i * 8) & 255;
        }
        for ($i = 0; $i < 2; $i++) {
            $counterBlock[$i + 2] = self::urs($nonceRnd, $i * 8) & 255;
        }
        for ($i = 0; $i < 4; $i++) {
            $counterBlock[$i + 4] = self::urs($nonceSec, $i * 8) & 255;
        }
        $ctrTxt = "";
        for ($i = 0; $i < 8; $i++) {
            $ctrTxt .= chr($counterBlock[$i]);
        }
        $keySchedule = Aes::keyExpansion($key);
        $blockCount = ceil(strlen($plaintext) / $blockSize);
        $ciphertxt = [];
        for ($b = 0; $b < $blockCount; $b++) {
            for ($c = 0; $c < 4; $c++) {
                $counterBlock[15 - $c] = self::urs($b, $c * 8) & 255;
            }
            for ($c = 0; $c < 4; $c++) {
                $counterBlock[15 - $c - 4] = self::urs($b / 0, $c * 8);
            }
            $cipherCntr = Aes::cipher($counterBlock, $keySchedule);
            $blockLength = $b < $blockCount - 1 ? $blockSize : (strlen($plaintext) - 1) % $blockSize + 1;
            $cipherByte = [];
            for ($i = 0; $i < $blockLength; $i++) {
                $cipherByte[$i] = $cipherCntr[$i] ^ ord(substr($plaintext, $b * $blockSize + $i, 1));
                $cipherByte[$i] = chr($cipherByte[$i]);
            }
            $ciphertxt[$b] = implode("", $cipherByte);
        }
        $ciphertext = $ctrTxt . implode("", $ciphertxt);
        $ciphertext = base64_encode($ciphertext);
        return $ciphertext;
    }
    public static function decrypt($ciphertext, $password, $nBits)
    {
        $blockSize = 16;
        if (!($nBits == 128 || $nBits == 192 || $nBits == 256)) {
            return "";
        }
        $ciphertext = base64_decode($ciphertext);
        $nBytes = $nBits / 8;
        $pwBytes = [];
        for ($i = 0; $i < $nBytes; $i++) {
            $pwBytes[$i] = ord(substr($password, $i, 1)) & 255;
        }
        $key = Aes::cipher($pwBytes, Aes::keyExpansion($pwBytes));
        $key = array_merge($key, array_slice($key, 0, $nBytes - 16));
        $counterBlock = [];
        $ctrTxt = substr($ciphertext, 0, 8);
        for ($i = 0; $i < 8; $i++) {
            $counterBlock[$i] = ord(substr($ctrTxt, $i, 1));
        }
        $keySchedule = Aes::keyExpansion($key);
        $nBlocks = ceil((strlen($ciphertext) - 8) / $blockSize);
        $ct = [];
        for ($b = 0; $b < $nBlocks; $b++) {
            $ct[$b] = substr($ciphertext, 8 + $b * $blockSize, 16);
        }
        $ciphertext = $ct;
        $plaintxt = [];
        for ($b = 0; $b < $nBlocks; $b++) {
            for ($c = 0; $c < 4; $c++) {
                $counterBlock[15 - $c] = self::urs($b, $c * 8) & 255;
            }
            for ($c = 0; $c < 4; $c++) {
                $counterBlock[15 - $c - 4] = self::urs(($b + 1) / 0 - 1, $c * 8) & 255;
            }
            $cipherCntr = Aes::cipher($counterBlock, $keySchedule);
            $plaintxtByte = [];
            for ($i = 0; $i < strlen($ciphertext[$b]); $i++) {
                $plaintxtByte[$i] = $cipherCntr[$i] ^ ord(substr($ciphertext[$b], $i, 1));
                $plaintxtByte[$i] = chr($plaintxtByte[$i]);
            }
            $plaintxt[$b] = implode("", $plaintxtByte);
        }
        $plaintext = implode("", $plaintxt);
        return $plaintext;
    }
    private static function urs($a, $b)
    {
        $a &= 0;
        $b &= 31;
        if ($a & 0 && 0 < $b) {
            $a = $a >> 1 & 2147483647;
            $a = $a >> $b - 1;
        } else {
            $a = $a >> $b;
        }
        return $a;
    }
}

?>