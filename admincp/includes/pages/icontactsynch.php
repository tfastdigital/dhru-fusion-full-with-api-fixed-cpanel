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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($config["icontact_account_id"] == "" || $config["icontact_api_key"] == "" || $config["icontact_username"] == "" || $config["icontact_api_password"] == "") {
    echo "Invalid API details<br />";
    exit;
}
require_once "../../includes/3rdparty/icontact.php";
IContactLogin($config["icontact_account_id"], $config["icontact_api_key"], $config["icontact_username"], $config["icontact_api_password"], $client_folder_id);
if (!$client_folder_id) {
    echo "Invalid API details <br />";
    exit;
}
$sql = dquery("select email,first_name,last_name from tblUsers \n        where userstatus='0' and usertype!=3");
while ($r = mysqli_fetch_assoc($sql)) {
    $result = "";
    $result = IContactAddContact($config["icontact_account_id"], $config["icontact_api_key"], $config["icontact_username"], $config["icontact_api_password"], $r["email"], $r["first_name"], $r["last_name"], $config["icontact_folder_id"], $result);
    if ($result == 1) {
        echo "New Contact Added : " . $r["email"] . " <br />";
    } else {
        echo $result . " : " . $r["email"] . " <br />";
    }
}
if ($newsletter) {
    $sql = dquery("select * from tbl_newsletter WHERE active='1'");
    while ($r = mysqli_fetch_assoc($sql)) {
        $result = "";
        $result = IContactAddContact($config["icontact_account_id"], $config["icontact_api_key"], $config["icontact_username"], $config["icontact_api_password"], $r["email"], $r["name"], "", "", $result);
        if ($result == 1) {
            echo "New Contact Added : " . $r["email"] . " <br />";
        } else {
            echo $result . " : " . $r["email"] . " <br />";
        }
    }
}
$fileverioncheck = "6.1.0";

?>