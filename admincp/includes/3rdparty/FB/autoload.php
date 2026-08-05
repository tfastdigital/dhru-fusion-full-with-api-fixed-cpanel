<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (version_compare(PHP_VERSION, "5.4.0", "<")) {
    throw new Exception("The Facebook SDK requires PHP version 5.4 or higher.");
}
spl_autoload_register(function ($class) {
    $prefix = "Facebook\\";
    $customBaseDir = "";
    if (defined("FACEBOOK_SDK_V4_SRC_DIR")) {
        $customBaseDir = FACEBOOK_SDK_V4_SRC_DIR;
    } else {
        if (defined("FACEBOOK_SDK_SRC_DIR")) {
            $customBaseDir = FACEBOOK_SDK_SRC_DIR;
        }
    }
    $baseDir = $customBaseDir ?: __DIR__ . "/";
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return NULL;
    }
    $relativeClass = substr($class, $len);
    $file = rtrim($baseDir, "/") . "/" . str_replace("\\", "/", $relativeClass) . ".php";
    if (file_exists($file)) {
        require $file;
    }
});

?>