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
require "../comm.php";
require_once "../includes/fun.inc.php";
require_once "../" . $admindirpath . "/includes/fun.inc.php";
define("DATAGRID_DIR", "includes/3rdparty/datagrid/");
define("PEAR_DIR", "includes/3rdparty/datagrid/pear/");
require_once "../" . $admindirpath . "/includes/comm.inc.php";
unset($_SESSION["supplier_afterlogin_re"]);
if (!$_SESSION["supid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["supplier_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$licinfo = licince\getLicenseDetails();
if ($laoddefaultpage) {
    $laoddefaultpage = str_replace("..", "", $laoddefaultpage);
    $laoddefaultpage = str_replace("/", "", $laoddefaultpage);
}
if (!isset($page)) {
    $page = "dashboard";
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n    <title>Dhru Fusion</title>\n    <link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\">\n    <link rel=\"stylesheet\" href=\"includes/css/main2.css\" />\n    <script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/main2.fun.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/jquery.fileupload.extend.js\" type=\"text/javascript\"></script>\n    <script src=\"templates/default/js/custom.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/main.fun.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/search.js\" type=\"text/javascript\"></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg.js'></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/languages/js/dg-en.js'></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/scripts/highlight.js'></script>\n    <style type='text/css'>@import url(includes/3rdparty/datagrid/modules/jscalendar/skins/aqua/theme.css);</style>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar.js'></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/lang/calendar-en.js'></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar-setup.js'></script>\n    <script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg_ajax.js'></script>\n</head>\n<body>\n\n<div id=\"main_loader\" style=\"display: none;\">\n    <div  id=\"main_loader_sub\">\n        <table summary=\"Loader Layout\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n            <tbody><tr>\n                <td>\n                    <svg class=\"spinner\" viewBox=\"0 0 50 50\"><circle class=\"path\" cx=\"25\" cy=\"25\" r=\"20\" fill=\"none\" stroke-width=\"5\"></circle></svg>\n                </td>\n                <td>\n                    <strong>Loading...</strong>\n                    <div style=\"font-size: 12px\"> Please wait until this completely loaded.</div></td>\n            </tr>\n            </tbody>\n        </table>\n    </div>\n</div>\n\n";
licince\reqaddon("Supplier panel");
include "includes/pages/" . $page . ".php";
echo "\n<!--<div style=\" position: fixed; bottom: 10px; right: 10px; font-size: 10px; color: #ccc;\" align=\"center\">Powerd by <a href=\"http://dhru.com\" target=\"_blank\">Dhru Fusion</a></div>-->\n</body>\n</html>\n";

?>