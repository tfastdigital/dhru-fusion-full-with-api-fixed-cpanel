<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class Aes
{
    private static $rCon = [[0, 0, 0, 0], [1, 0, 0, 0], [2, 0, 0, 0], [4, 0, 0, 0], [8, 0, 0, 0], [16, 0, 0, 0], [32, 0, 0, 0], [64, 0, 0, 0], [128, 0, 0, 0], [27, 0, 0, 0], [54, 0, 0, 0]];
    private static $sBox = [99, 124, 119, 123, 242, 107, 111, 197, 48, 1, 103, 43, 254, 215, 171, 118, 202, 130, 201, 125, 250, 89, 71, 240, 173, 212, 162, 175, 156, 164, 114, 192, 183, 253, 147, 38, 54, 63, 247, 204, 52, 165, 229, 241, 113, 216, 49, 21, 4, 199, 35, 195, 24, 150, 5, 154, 7, 18, 128, 226, 235, 39, 178, 117, 9, 131, 44, 26, 27, 110, 90, 160, 82, 59, 214, 179, 41, 227, 47, 132, 83, 209, 0, 237, 32, 252, 177, 91, 106, 203, 190, 57, 74, 76, 88, 207, 208, 239, 170, 251, 67, 77, 51, 133, 69, 249, 2, 127, 80, 60, 159, 168, 81, 163, 64, 143, 146, 157, 56, 245, 188, 182, 218, 33, 16, 255, 243, 210, 205, 12, 19, 236, 95, 151, 68, 23, 196, 167, 126, 61, 100, 93, 25, 115, 96, 129, 79, 220, 34, 42, 144, 136, 70, 238, 184, 20, 222, 94, 11, 219, 224, 50, 58, 10, 73, 6, 36, 92, 194, 211, 172, 98, 145, 149, 228, 121, 231, 200, 55, 109, 141, 213, 78, 169, 108, 86, 244, 234, 101, 122, 174, 8, 186, 120, 37, 46, 28, 166, 180, 198, 232, 221, 116, 31, 75, 189, 139, 138, 112, 62, 181, 102, 72, 3, 246, 14, 97, 53, 87, 185, 134, 193, 29, 158, 225, 248, 152, 17, 105, 217, 142, 148, 155, 30, 135, 233, 206, 85, 40, 223, 140, 161, 137, 13, 191, 230, 66, 104, 65, 153, 45, 15, 176, 84, 187, 22];
    public static function cipher($input, $w)
    {
        $Nb = 4;
        $Nr = count($w) / $Nb - 1;
        $state = [];
        for ($i = 0; $i < 4 * $Nb; $i++) {
            $state[$i % 4][floor($i / 4)] = $input[$i];
        }
        $state = self::addRoundKey($state, $w, 0, $Nb);
        for ($round = 1; $round < $Nr; $round++) {
            $state = self::subBytes($state, $Nb);
            $state = self::shiftRows($state, $Nb);
            $state = self::mixColumns($state, $Nb);
            $state = self::addRoundKey($state, $w, $round, $Nb);
        }
        $state = self::subBytes($state, $Nb);
        $state = self::shiftRows($state, $Nb);
        $state = self::addRoundKey($state, $w, $Nr, $Nb);
        $output = [4 * $Nb];
        for ($i = 0; $i < 4 * $Nb; $i++) {
            $output[$i] = $state[$i % 4][floor($i / 4)];
        }
        return $output;
    }
    private static function addRoundKey($state, $w, $rnd, $Nb)
    {
        for ($r = 0; $r < 4; $r++) {
            for ($c = 0; $c < $Nb; $c++) {
                $state[$r][$c] ^= $w[$rnd * 4 + $c][$r];
            }
        }
        return $state;
    }
    private static function subBytes($s, $Nb)
    {
        for ($r = 0; $r < 4; $r++) {
            for ($c = 0; $c < $Nb; $c++) {
                $s[$r][$c] = self::$sBox[$s[$r][$c]];
            }
        }
        return $s;
    }
    private static function shiftRows($s, $Nb)
    {
        $t = [4];
        for ($r = 1; $r < 4; $r++) {
            for ($c = 0; $c < 4; $c++) {
                $t[$c] = $s[$r][($c + $r) % $Nb];
            }
            for ($c = 0; $c < 4; $c++) {
                $s[$r][$c] = $t[$c];
            }
        }
        return $s;
    }
    private static function mixColumns($s, $Nb)
    {
        for ($c = 0; $c < 4; $c++) {
            $a = [4];
            $b = [4];
            for ($i = 0; $i < 4; $i++) {
                $a[$i] = $s[$i][$c];
                $b[$i] = $s[$i][$c] & 128 ? $s[$i][$c] << 1 ^ 283 : $s[$i][$c] << 1;
            }
            $s[0][$c] = $b[0] ^ $a[1] ^ $b[1] ^ $a[2] ^ $a[3];
            $s[1][$c] = $a[0] ^ $b[1] ^ $a[2] ^ $b[2] ^ $a[3];
            $s[2][$c] = $a[0] ^ $a[1] ^ $b[2] ^ $a[3] ^ $b[3];
            $s[3][$c] = $a[0] ^ $b[0] ^ $a[1] ^ $a[2] ^ $b[3];
        }
        return $s;
    }
    public static function keyExpansion($key)
    {
        $Nb = 4;
        $Nk = count($key) / 4;
        $Nr = $Nk + 6;
        $w = [];
        $temp = [];
        for ($i = 0; $i < $Nk; $i++) {
            $r = [$key[4 * $i], $key[4 * $i + 1], $key[4 * $i + 2], $key[4 * $i + 3]];
            $w[$i] = $r;
        }
        for ($i = $Nk; $i < $Nb * ($Nr + 1); $i++) {
            $w[$i] = [];
            for ($t = 0; $t < 4; $t++) {
                $temp[$t] = $w[$i - 1][$t];
            }
            if ($i % $Nk == 0) {
                $temp = self::subWord(self::rotWord($temp));
                for ($t = 0; $t < 4; $t++) {
                    $temp[$t] ^= self::$rCon[$i / $Nk][$t];
                }
            } else {
                if (6 < $Nk && $i % $Nk == 4) {
                    $temp = self::subWord($temp);
                }
            }
            for ($t = 0; $t < 4; $t++) {
                $w[$i][$t] = $w[$i - $Nk][$t] ^ $temp[$t];
            }
        }
        return $w;
    }
    private static function subWord($w)
    {
        for ($i = 0; $i < 4; $i++) {
            $w[$i] = self::$sBox[$w[$i]];
        }
        return $w;
    }
    private static function rotWord($w)
    {
        $tmp = $w[0];
        for ($i = 0; $i < 3; $i++) {
            $w[$i] = $w[$i + 1];
        }
        $w[3] = $tmp;
        return $w;
    }
}

?>