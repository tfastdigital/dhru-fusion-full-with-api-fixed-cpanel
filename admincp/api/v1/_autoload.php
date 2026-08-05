<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_include) {
    $apiname = explode(",", $_include);
    foreach ($apiname as $apis) {
        if (is_file("actions/" . $apis . "/function.php")) {
            include_once "actions/" . $apis . "/function.php";
        }
    }
}

?>