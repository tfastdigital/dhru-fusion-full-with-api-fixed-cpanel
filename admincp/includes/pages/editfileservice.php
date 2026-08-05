<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"../includes/colorpicker/css/colorpicker.css\" />\n<script type=\"text/javascript\"\n        src=\"../includes/colorpicker/js/colorpicker.js\"></script>\n\n";
if (!isset($_SESSION[adminid])) {
    exit;
}
$row = mysqli_fetch_assoc(dquery("select service_name from tbl_services_file where id='" . $id . "'"));
echo "<script>\n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["service_name"];
echo "]');\n</script>\n<ul id=\"tabmenu\">\n    <li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=editfileservice.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["overview"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=editfileservice.field','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["field"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab3','main2.php?page=editfileservice.apiconnection','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["apiconnection"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=editfileservice.inventory','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["inventory"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab15','main2.php?page=editfileservice.subscribe','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab15\" >";
echo $LNG["subscription"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab16','main2.php?page=editfileservice.subscribeduser','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab16\" >";
echo $LNG["subscribeduser"];
echo "</a></li>\n<!--    <li><a onclick=\"getContect('#tab13','main2.php?page=editfileservice.happyhours','','','#tabcontent',true,'#main_loader');\" id=\"tab13\" ></a></li>\n-->    <li><a onclick=\"getContect('#tab14','main2.php?page=editfileservice.resetdiscount','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab14\" >";
echo $LNG["discounted"];
echo " ";
echo $LNG["users"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "editfileservice.overview.php";
}
echo "  </div> ";
$fileverioncheck = "6.1.0";

?>