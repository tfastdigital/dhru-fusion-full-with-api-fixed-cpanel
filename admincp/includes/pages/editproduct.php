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
$active = "class='tabmenu_active'";
$row = mysqli_fetch_assoc(dquery("select service_name,bundle from tbl_products where id=" . $id));
echo "    \n <script>  \n    subheader2_txt('[";
echo $LNG["edit"];
echo " : ";
echo $row["service_name"];
echo "]');\n </script>  \n<div id=\"tab_div\">\n<ul id=\"tabmenu\">     \n    <li><a ";
if (!$defaultloadpage) {
    echo $active;
}
echo " onclick=\"getContect('#tab','main2.php?page=editproduct.overview','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["product"];
echo " ";
echo $LNG["information"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=editproduct.field','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["field"];
echo "</a></li>         \n    <li><a onclick=\"getContect('#tab21','main2.php?page=editproduct.api','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab21\" >";
echo $LNG["apiconnection"];
echo "</a></li>\n    <li><a  ";
if ($defaultloadpage == "editproduct.features.php") {
    echo $active;
}
echo " onclick=\"getContect('#tab16','main2.php?page=editproduct.features','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab16\" >";
echo $LNG["features"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=editproduct.inventory','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["stock"];
echo "</a></li>\n  \n    <li><a onclick=\"getContect('#tab15','main2.php?page=editproduct.subscribe','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab15\" >";
echo $LNG["subscription"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab116','main2.php?page=editproduct.subscribeduser','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab116\" >";
echo $LNG["subscribeduser"];
echo "</a></li>\n         \n    <li><a onclick=\"getContect('#tab13','main2.php?page=editproduct.happyhours','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab13\" >";
echo $LNG["promotional"];
echo "</a></li>\n";
if (!$OnlyEcommerce) {
    echo "        \n    <li><a onclick=\"getContect('#tab18','main2.php?page=editproduct.store','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab18\" > Partner Site</a></li>\n";
}
echo "    \n    <li><a ";
if ($defaultloadpage == "editproduct.review.php") {
    echo $active;
}
echo "  onclick=\"getContect('#tab20','main2.php?page=editproduct.review','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab20\" > ";
echo $LNG["customer"];
echo " ";
echo $LNG["review"];
echo "</a></li>\n";
if ($row["bundle"]) {
    echo "  <li><a  ";
    if ($defaultloadpage == "editproduct.bundle.php") {
        echo $active;
    }
    echo " onclick=\"getContect('#tab19','main2.php?page=editproduct.bundle','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab19\" >";
    echo $LNG["bundle"];
    echo "</a></li>\n";
}
echo "  <div style=\"clear: both;\"></div>\n</ul>\n</div>\n\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "editproduct.overview.php";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>