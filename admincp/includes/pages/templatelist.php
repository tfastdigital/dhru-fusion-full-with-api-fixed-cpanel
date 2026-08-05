<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (!$innerpage) {
    $innerpage = "default";
    if ($OnlyEcommerce) {
        $innerpage = "ecommerce";
    }
}
echo "<script type=\"text/javascript\" src=\"../includes/js/jtip.js\"></script>\n\n<style>\n.jTip{           \n        padding: 15px;\n        cursor:pointer;\n}\n#JT {\n\tposition: absolute;\n\tz-index:100;\n    width: 100% !important;\n}   \n</style>\n";
$pageid = 432;
checkPagePermission($pageid);
echo "    \n<div id=\"content\">\n<div id=\"content_padded\">\n\n  <select name=\"adver_page\" onchange=\"window.location.href='main2.php?page=templatelist&innerpage='+this.value\">\n  ";
if (!$OnlyEcommerce) {
    echo "\t<option value='default' ";
    if ($innerpage == "default") {
        echo "selected";
    }
    echo " >Default</option>\n    <option value='default2' ";
    if ($innerpage == "default2") {
        echo "selected";
    }
    echo ">Default2</option>\n    <option value='defaultretail' ";
    if ($innerpage == "defaultretail") {
        echo "selected";
    }
    echo ">Default Retail</option>\n    <option value='defaultweb2' ";
    if ($innerpage == "defaultweb2") {
        echo "selected";
    }
    echo ">Default Web</option>\n  ";
}
echo "  \n    <option value='ecommerce' ";
if ($innerpage == "ecommerce") {
    echo "selected";
}
echo ">Ecommerce</option>\n    <option value='mobile' ";
if ($innerpage == "mobile") {
    echo "selected";
}
echo ">Mobile</option>\t  \t    \n</select>\n<br /><br />\n ";
include "includes/pages/templatelist_" . $innerpage . ".php";
echo " ";
$fileverioncheck = "6.1.0";

?>