<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$row = mysqli_fetch_assoc(dquery("select service_name from tbl_server_log where id='" . $id . "'"));
echo "    \n <script>  \n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["service_name"];
echo "]');\n </script>\n<ul id=\"tabmenu\"> \n    <li><a ";
if (!$defaultloadpage) {
    echo "class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab','main2.php?page=editserverservice.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["overview"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=editserverservice.field','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["field"];
echo "</a></li>      \n    <li><a onclick=\"getContect('#tab3','main2.php?page=editserverservice.apiconnection','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["apiconnection"];
echo "</a></li>    \n    <li><a onclick=\"getContect('#tab11','main2.php?page=editserverservice.retailpurchase','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
echo $LNG["retail"] . " " . $LNG["purchase"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=editserverservice.inventory','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["inventory"];
echo "</a></li>    \n   \n            <li><a onclick=\"getContect('#tab15','main2.php?page=editserverservice.subscribe','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab15\" >";
echo $LNG["subscription"];
echo "</a></li>\n            <li><a onclick=\"getContect('#tab16','main2.php?page=editserverservice.subscribeduser','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab16\" >";
echo $LNG["subscribeduser"];
echo "</a></li>\n         \n    <li><a onclick=\"getContect('#tab13','main2.php?page=editserverservice.happyhours','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab13\" >";
echo $LNG["promotional"];
echo "</a></li>        \n    <!--\n<li><a onclick=\"getContect('#tab18','main2.php?page=editserverservice.store','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab18\" > ";
echo $LNG["reseller"];
echo " ";
echo $LNG["store"];
echo "</a></li>\n-->\n    <li><a onclick=\"getContect('#tab14','main2.php?page=editserverservice.resetdiscount','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab14\" >";
echo $LNG["discounted"];
echo " ";
echo $LNG["users"];
echo "</a></li>\n  <li><a ";
if ($defaultloadpage == "editserverservice.review.php") {
    echo "class='tabmenu_active' ";
}
echo "  onclick=\"getContect('#tab17','main2.php?page=editserverservice.review','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab17\" >";
echo $LNG["customer"];
echo " ";
echo $LNG["review"];
echo " </a></li>         \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "editserverservice.overview.php";
}
echo "  </div> ";
$fileverioncheck = "6.1.0";

?>