<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include_once "../../../comm.php";
if ($_POST["plain"] == "true") {
    $plain = "1";
} else {
    $plain = "0";
}
dquery("UPDATE tbl_emailtemplates SET plaintext='" . $plain . "' WHERE id='" . $_POST["id"] . "'");
echo "  ";

?>