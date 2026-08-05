<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!defined("CLIENT")) {
    header("Location: ../main.php");
    exit;
}
$templatefile = "login";
$pagetitle = $lng_languag["login"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"main.php\">" . $lng_languag["login"] . "</a>";
$pageicon = "";
$tempalte_ver["token"] = generate_token("form");
if ($_COOKIE["GSMBACKBASEUID"]) {
    $tempalte_ver["username"] = $_COOKIE["GSMBACKBASEUID"];
}
if ($_COOKIE["GSMBACKBASEPW"]) {
    $tempalte_ver["password"] = $_COOKIE["GSMBACKBASEPW"];
}

?>