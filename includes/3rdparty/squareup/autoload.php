<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

spl_autoload_register(function ($class) {
    $prefix = "SquareConnect\\";
    $base_dir = __DIR__ . "/lib/";
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return NULL;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";
    if (file_exists($file)) {
        require $file;
    }
});

?>