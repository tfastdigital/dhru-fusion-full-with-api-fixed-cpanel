<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

session_name("DHRUFUSION");
session_set_cookie_params(0, "/", NULL, false, true);
session_start();
if (isset($_SESSION["adminid"]) && $_GET["template"] && $_GET["file"]) {
    if (deregi("css/", $_GET["file"])) {
        include "../../templates/" . $_GET["template"] . "/" . $_GET["file"];
    } else {
        include "../../templates/" . $_GET["template"] . "/" . $_GET["file"] . ".tpl";
    }
}
$fileverioncheck = "6.1.0";

?>