<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\r\n    <li><a  ";
if ($laoddefaultpage != "popupafter.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab22','main2.php?page=popupbefore','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab22\" >";
echo $LNG["before"];
echo " ";
echo $LNG["login"];
echo "</a></li>\r\n    <li><a  ";
if ($laoddefaultpage == "popupafter.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab','main2.php?page=popupafter','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["after"];
echo " ";
echo $LNG["login"];
echo "</a></li>\r\n</ul>\r\n\r\n<div id=\"tabcontent\" >\r\n\r\n    ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "popupbefore.php";
}
echo "  </div>\r\n";
$fileverioncheck = "6.1.0";

?>