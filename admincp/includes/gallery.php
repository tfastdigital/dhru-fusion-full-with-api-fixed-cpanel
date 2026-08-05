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
$pageid = 537;
checkPagePermission($pageid);
if (isset($id)) {
    $_SESSION["opid"] = $id;
}
unset($_SESSION["tabd"]);
unset($_SESSION["gallary"]);
echo "<script src=\"js/jquery.js\" type=\"text/javascript\"></script>\n<script>\n    \$(document).ready(function(){       \n       window.resizeTo(1135,720); \n       \$(\".block\").hover(\n          function () {                       \n                \$('.block_text',this).fadeIn('fast');\n          }, \n          function () {                        \n                \$('.block_text',this).fadeOut('fast');\n       });   \n    });    \n</script>\n\n<frameset frameborder=0 framespacing=0 cols=\"250px,*\">\n      <frame name=\"menus\" src=\"gallerymenu.php?id=";
echo $id;
echo "\" />\n      <frame name=\"mains\" src=\"gallerymn.php?id=";
echo $id;
echo "&tab=";
echo $tab;
echo "\" />\n</frameset>\n\n";

?>