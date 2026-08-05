<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../comm.php";
require "../../includes/fun.inc.php";
require "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($_GET["watermark"])) {
    $_SESSION["watermark"] = $_POST["watermark"];
} else {
    if (isset($_GET["setwidth"])) {
        $_SESSION["sizewidth"] = $_POST["width"] . "X";
        $_SESSION["sizeupload"] = $_SESSION["sizewidth"] . $_SESSION["sizeheight"];
    } else {
        if (isset($_GET["setheight"])) {
            $_SESSION["sizeheight"] = $_POST["height"];
            $_SESSION["sizeupload"] = $_SESSION["sizewidth"] . $_SESSION["sizeheight"];
        } else {
            if (isset($_POST["size"])) {
                $_SESSION["sizeupload"] = $_POST["size"];
            }
        }
    }
}

?>