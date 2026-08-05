<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>Untitled Document</title></head>\n\n";
$pageid = 441;
checkPagePermission($pageid);
if ($innerpage) {
    $type = $innerpage;
} else {
    $type = "global";
}
$result = dquery("SELECT  * FROM `tbl_add_management` where `type`='" . $type . "'");
while ($row = mysqli_fetch_assoc($result)) {
    $rows[$row["p_id"]] = html_entity_decode($row["html_code"]);
}
echo "<style>\n.advertise{border: #ccc dashed 2px;margin: 5px 0;}\n.advertise a{display: block}\n.advertise:hover{border: black dashed 2px;}\nbody{background:none !important;}\n#tabmenu li,#tabmenu li:hover{background: transparent !important;border: none !important; border-right: 1px solid #D4DBE1 !important;padding:2px 10px !important}\n</style>\n<script language=\"JavaScript\">\n</script>\n<ul id=\"tabmenu\">\n<li ><a ";
if (!$innerpage || $innerpage == "global") {
    echo " class=\"tabmenu_active\" ";
}
echo " href=\"javascript: window.location.href='main2.php?page=advertisement&innerpage=global'\">Global</a></li>\n<li ><a ";
if ($innerpage == "index") {
    echo " class=\"tabmenu_active\" ";
}
echo "  href=\"javascript: window.location.href='main2.php?page=advertisement&innerpage=index'\">Index</a></li>\n<li ><a ";
if ($innerpage == "login") {
    echo " class=\"tabmenu_active\" ";
}
echo "  href=\"javascript: window.location.href='main2.php?page=advertisement&innerpage=login'\">Login</a></li>\n<li ><a ";
if ($innerpage == "productdetails") {
    echo " class=\"tabmenu_active\" ";
}
echo "  href=\"javascript: window.location.href='main2.php?page=advertisement&innerpage=productdetails'\">Product Details</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"notification\"></div>\n\n<br/>\n\n<link rel=\"stylesheet\" type=\"text/css\" href=\"../templates/ecommerce/css/style.css\" />  \n\n";
include "includes/pages/advertisement_" . $type . ".php";
echo "\n\n";
$fileverioncheck = "6.1.0";

?>