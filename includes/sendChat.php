<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "../comm.php";
$id = preg_replace("/[^0-9a-zA-Z]/i", "", $chatid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_livehelp_conversation where md5(id)='" . $id . "'"));
$message = html_entity_decode(nl2br($message));
checkDemoMode();
if (trim($message) && $sql["status"] == "1") {
    $sql["id"] = NULL;
    $sql["message"] = $message;
    $sql["time"] = time();
    $sql["status"] = 2;
    $sql["adminid"] = 0;
    $sql["ip"] = $remote_ip;
    $sql["view"] = 0;
    $id = $db->insert("tbl_livehelp_conversation", $sql);
    $sql = NULL;
    echo "success:";
} else {
    echo "error:";
}

?>