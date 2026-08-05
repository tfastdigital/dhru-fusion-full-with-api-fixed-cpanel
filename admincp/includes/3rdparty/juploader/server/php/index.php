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
require_once "../.././../../../../comm.php";
require_once ROOTDIR . "/includes/comm.inc.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
include "upload.class.php";
$upload_handler = new UploadHandler();
if ($DEMOMODE) {
    header("HTTP/1.1 405 Demomode not allowed");
}
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Disposition: inline; filename=\"files.json\"");
header("X-Content-Type-Options: nosniff");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size");
switch ($_SERVER["REQUEST_METHOD"]) {
    case "OPTIONS":
    case "HEAD":
    case "GET":
    case "POST":
        if (isset($_REQUEST["_method"]) && $_REQUEST["_method"] === "DELETE") {
            $upload_handler->delete();
        } else {
            $upload_handler->post();
        }
        break;
    case "DELETE":
        $upload_handler->delete();
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
}

?>