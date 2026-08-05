<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

chdir(dirname(__FILE__));
$autoload = (int) $argv[1];
$returnStatus = NULL;
if (!$autoload) {
    $composer = json_decode(file_get_contents("composer.json"), true);
    unset($composer["autoload"]);
    unset($composer["require-dev"]["squizlabs/php_codesniffer"]);
    file_put_contents("composer.json", json_encode($composer, JSON_PRETTY_PRINT));
}
passthru("composer update", $returnStatus);
if ($returnStatus !== 0) {
    exit(1);
}
if ($autoload) {
    passthru("./vendor/bin/phpcs --standard=PSR2 -n lib tests *.php", $returnStatus);
    if ($returnStatus !== 0) {
        exit(1);
    }
}
$config = $autoload ? "phpunit.xml" : "phpunit.no_autoload.xml";
passthru("./vendor/bin/phpunit -c " . $config, $returnStatus);
if ($returnStatus !== 0) {
    exit(1);
}

?>