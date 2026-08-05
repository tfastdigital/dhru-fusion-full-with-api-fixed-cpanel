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
echo "<script src=\"includes/js/jquery-ui.js\"></script>\n<ul id=\"tabmenu\"> \n    <li><a ";
if (($page == "catlog" || $page == "product.list") && $defaultloadpage != "edithomepagegroup.php" && $defaultloadpage != "productquick.edit.php" && $defaultloadpage != "homepagegroup.php" && $defaultloadpage != "product.listgroup.php" && $defaultloadpage != "product.addnew.php" && $defaultloadpage != "product.listgroup3.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=product.list','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["list"];
echo " ";
echo $LNG["product"];
echo "</a></li>\n    <li><a ";
if ($defaultloadpage == "productquick.edit.php") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab22','main2.php?page=productquick.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab22\" >";
echo $LNG["quickedit"];
echo "  ";
echo $LNG["products"];
echo "</a></li> \n    <li><a ";
if ($defaultloadpage == "product.addnew.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab1','main2.php?page=product.addnew','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["product"];
echo "</a></li>    \n    <li><a ";
if ($page == "product.listgroup3" || $defaultloadpage == "product.listgroup3.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab5','main2.php?page=product.listgroup3','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["list"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["group"];
echo "</a></li>\n    <li><a ";
if ($page == "addproductgroup" || $defaultloadpage == "addproductgroup.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab3','main2.php?page=addproductgroup','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["add"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["group"];
echo "</a></li>\n    <li><a  ";
if ($defaultloadpage == "homepagegroup.php" || $defaultloadpage == "edithomepagegroup.php") {
    echo "class=tabmenu_active";
}
echo "  onclick=\"getContect('#tab4','main2.php?page=homepagegroup','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo " ";
echo $LNG["grouping"];
echo "</a></li>\n<div style=\"clear: both;\"></div> \n</ul> ";
$fileverioncheck = "6.1.0";

?>