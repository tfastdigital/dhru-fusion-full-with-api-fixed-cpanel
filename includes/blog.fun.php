<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DHRUSOFT") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function friendlyURL($string)
{
    $string = preg_replace("`\\[.*\\]`U", "", $string);
    $string = preg_replace("`&(amp;)?#?[a-z0-9]+;`i", "-", $string);
    $string = htmlentities($string, ENT_COMPAT, "utf-8");
    $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
    $string = preg_replace(["`[^a-z0-9]`i", "`[-]+`"], "-", $string);
    $string = trim($string, "-");
    if (!$string) {
        $string = "Unrecognized";
    }
    return $string;
}
function validEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

?>