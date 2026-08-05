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
echo "<ul id=\"tabmenu\"> \n    <li><a ";
if ($page == "knowledgebase" || $page == "knowledgebasemain" && !$loaddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab','main2.php?page=knowledgebase','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["listknowledgebase"];
echo "</a></li> \n    <li><a ";
if ($loaddefaultpage == "addknowledgebase.php") {
    echo " class=\"tabmenu_active\" ";
}
echo " href=\"main2.php?page=knowledgebasemain&loaddefaultpage=addknowledgebase.php\" id=\"tab1\" >";
echo $LNG["addknowledgebase"];
echo "</a></li>\n    <li><a ";
if ($page == "quickeditarticle") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab5','main2.php?page=quickeditarticle','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["edit"];
echo " Article</a></li>\n    <li><a ";
if ($page == "knowledgebasecatlist") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=knowledgebasecatlist','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["view"];
echo " ";
echo $LNG["category"];
echo "</a></li> \n    <li><a ";
if ($page == "knowledgebasecatadd") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab3','main2.php?page=knowledgebasecatadd','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n \n<div style=\"clear: both;\"></div>\n</ul> ";
$fileverioncheck = "6.1.0";

?>