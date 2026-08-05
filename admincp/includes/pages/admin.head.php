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
echo "<ul id=\"tabmenu\">     \n    <li><a ";
if ($page == "administrator" || $page == "adminlist") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab1','main2.php?page=adminlist','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["adminlist"];
echo "</a></li> \n    <li><a ";
if ($page == "addnewadmin") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab2','main2.php?page=addnewadmin','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["addnewadmin"];
echo "</a></li>\n    <li><a ";
if ($page == "adminroles") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab3','main2.php?page=adminroles','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["accessgroups"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>";
$fileverioncheck = "6.1.0";

?>