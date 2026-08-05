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
echo "<ul id=\"tabmenu\"> \n    \n  <li><a ";
if (($page == "fileservice" || $page == "fileservice.list") && !$defaultpage) {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=fileservice.list','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["list"];
echo " ";
echo $LNG["all"];
echo " ";
echo $LNG["file"];
echo " ";
echo $LNG["services"];
echo "</a></li>\n  <li><a ";
if ($defaultpage == "filequick.edit.php") {
    echo "class=tabmenu_active";
}
echo "   onclick=\"getContect('#tab22','main2.php?page=filequick.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab22\" >";
echo $LNG["quickedit"];
echo "  ";
echo $LNG["file"];
echo " ";
echo $LNG["services"];
echo "</a></li> \n  <li><a onclick=\"getContect('#tab1','main2.php?page=fileservice.addnew','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["services"];
echo "</a></li> \n  <li><a ";
if ($defaultpage == "fileservice.viewgroup.php" || $defaultpage == "fileservice.viewgroup.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab2','main2.php?page=fileservice.viewgroup','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["list"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["group"];
echo "</a></li>\n  <li><a onclick=\"getContect('#tab3','main2.php?page=addfilegroup','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["add"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["group"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>";
$fileverioncheck = "6.1.0";

?>