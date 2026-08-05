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
require "../../../comm.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($DEMOMODE) {
    echo "<div id='notification1' class='errorbox'> This function not enabled in demo mode .</div>";
    exit;
}
$filename = $_GET["downloads"];
$filepath = "../backup/" . $filename;
$total = filesize($filepath);
$blocksize = 2097152;
$sent = 0;
$handle = fopen($filepath, "r");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $filename);
while ($sent < $total) {
    echo fread($handle, $blocksize);
    $sent += $blocksize;
}
exit(0);

?>