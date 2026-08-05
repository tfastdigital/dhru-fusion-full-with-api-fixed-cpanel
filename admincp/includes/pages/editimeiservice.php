<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"../includes/colorpicker/css/colorpicker.css\" />\n<script type=\"text/javascript\" src=\"../includes/colorpicker/js/colorpicker.js\"></script>\n\n\n";
if (!isset($_SESSION[adminid])) {
    exit;
}
$row = mysqli_fetch_assoc(dquery("select service_name,useasserver from tbl_services_imei where id='" . $id . "'"));
echo "<script>\n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["service_name"];
echo "]');\n</script>\n\n<div class=\"sidemenu-bar\">\n    <ul id=\"tabmenu\">\n    <li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=editimeiservice.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["overview"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=editimeiservice.field','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["field"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab3','main2.php?page=editimeiservice.apiconnection','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["apiconnection"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab11','main2.php?page=editimeiservice.retailpurchase','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
echo $LNG["retail"] . " " . $LNG["purchase"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=editimeiservice.inventory','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["inventory"];
echo "/Purchase Cost</a></li>\n    ";
if (licince\reqaddon("Reward Points System", true)) {
    echo "        <li>\n            <a onclick=\"getContect('#tab13','main2.php?page=editimeiservice.happyhours','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n               id=\"tab13\">";
    echo $LNG["reward"];
    echo " ";
    echo $LNG["points"];
    echo "</a></li>\n        ";
}
echo "    <li><a onclick=\"getContect('#tab15','main2.php?page=editimeiservice.subscribe','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab15\" >";
echo $LNG["subscription"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab18','main2.php?page=editimeiservice.subscribeduser','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab18\" >";
echo $LNG["subscribeduser"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab14','main2.php?page=editimeiservice.resetdiscount','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab14\" >";
echo $LNG["discounted"];
echo " ";
echo $LNG["users"];
echo " </a></li>\n    <li><a onclick=\"getContect('#tab17','main2.php?page=editimeiservice.review','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab17\" >";
echo $LNG["customer"];
echo " ";
echo $LNG["review"];
echo " </a></li>\n    ";
if ($row["useasserver"] == 0) {
    echo "        <li><a onclick=\"getContect('#tab19','main2.php?page=blockimeilist','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab19\" >Blacklisted IMEI </a></li>\n    ";
}
echo "    <div style=\"clear: both;\"></div>\n    ";
if (!$mobilebrowser) {
    echo "        <link   href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/x-main2-new.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\">\n        ";
}
echo "</ul>\n</div>\n<div id=\"tabcontent\">";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "editimeiservice.overview.php";
}
echo "</div>  ";
$fileverioncheck = "6.1.0";

?>