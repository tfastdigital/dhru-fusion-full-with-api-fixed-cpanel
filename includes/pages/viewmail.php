<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$mid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $mid);
$id = preg_replace("/[^0-9a-zA-Z]/i", "", $id);
if ($_SESSION["uid"] || $_SESSION["adminid"]) {
    $uid = $_SESSION["uid"];
    $mid = descape($id);
    if (!isset($_SESSION["adminid"])) {
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_email_history where  md5(id)='" . $mid . "' AND userid='" . $uid . "'"));
    } else {
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_email_history where  md5(id)='" . $mid . "'"));
    }
    echo "<html>\n<head></head>\n<body style=\"text-align: center;\">\n<h2 style=\"color: #666666; font-family: arial;\">";
    echo $sql["subject"];
    echo "</h2>\n \n";
    echo $sql["message"];
    echo " \n";
    chkMd5sumsubpage();
    echo "</body>\n</html>";
} else {
    header("Location: index.php");
    exit;
}
class no
{
}

?>