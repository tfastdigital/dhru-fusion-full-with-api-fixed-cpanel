<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$per = $config["passwordsecurity"];
if (1 < strlen($val)) {
    $new = 5;
} else {
    if (2 < strlen($val)) {
        $new = 10;
    } else {
        if (3 < strlen($val)) {
            $new = 15;
        } else {
            if (5 < strlen($val)) {
                $new = 20;
            } else {
                if (7 < strlen($val)) {
                    $new = 25;
                }
            }
        }
    }
}
if (preg_match("#[0-9]#", $val)) {
    $new += 20;
}
if (preg_match("#[a-z]#", $val)) {
    $new += 20;
}
if (preg_match("#[A-Z]#", $val)) {
    $new += 20;
}
if (preg_match("/[^a-zA-Z0-9]+/", $val, $matches)) {
    $new += 20;
}
$newper = $per * 100 / 80;
$veryweak = (int) $newper - 10;
$weak = (int) $newper - 5;
$ok = (int) $newper;
$strong = (int) $newper + 10;
$verystrong = (int) $newper + 20;
$new = (int) $new;
if ($verystrong < $new) {
    echo "verystrong";
} else {
    if ($strong < $new) {
        echo "strong";
    } else {
        if ($ok < $new) {
            echo "ok";
        } else {
            if ($weak < $new) {
                echo "weak";
            } else {
                echo "veryweak";
            }
        }
    }
}

?>