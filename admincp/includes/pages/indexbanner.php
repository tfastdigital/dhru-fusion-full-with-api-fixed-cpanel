<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 265;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\">\n    <li><a  ";
if ($laoddefaultpage == "addbanner.php" || $laoddefaultpage == "") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab','main2.php?page=addbanner','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["add"];
echo "   ";
echo $LNG["banner"];
echo "</a></li>\n    <!--<li><a  ";
if ($laoddefaultpage != "addbanner.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab22','main2.php?page=bannersetting','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab22\" >";
echo $LNG["banner"];
echo " ";
echo $LNG["settings"];
echo "</a></li>\n    <li><a  ";
if ($laoddefaultpage == "couldbanner.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab3','main2.php?page=cloudbanner','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["from"];
echo " Cloud</a></li>-->\n    <li><a  ";
if ($laoddefaultpage == "listbanner.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab4','main2.php?page=listbanner','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >  List Banners</a></li>\n <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "addbanner.php";
}
echo "</div>\n";
$fileverioncheck = "6.1.0";

?>