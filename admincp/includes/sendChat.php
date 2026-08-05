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
require_once "../../comm.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$id = md5(preg_replace("/[^0-9a-zA-Z]/i", "", $chatid));
$sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation where md5(id)='" . $id . "'"));
$message = html_entity_decode(nl2br($message));
if (trim($message) && $sql["status"] == "1") {
    $sql["id"] = NULL;
    $sql["message"] = $message;
    $sql["time"] = time();
    $sql["status"] = 2;
    $sql["adminid"] = $_SESSION["adminid"];
    $sql["ip"] = $remote_ip;
    $sql["view"] = 0;
    $id = $db->insert("tbl_livehelp_conversation", $sql);
    $sql = NULL;
    echo "success:";
} else {
    echo "error:";
}

?>