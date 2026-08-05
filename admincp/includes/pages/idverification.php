<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\r\n    <li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab12','main2.php?page=idverificationpending','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["pending"];
echo "</a></li>\r\n    <li><a ";
if ($laoddefaultpage == "idverificationcompleted") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab','main2.php?page=idverificationcompleted','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["completed"];
echo "</a></li>\r\n    <li><a ";
if ($laoddefaultpage == "idverificationrejected") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=idverificationcompleted&reject=1','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["rejected"];
echo "</a></li>\r\n\r\n    <div style=\"clear: both;\"></div>\r\n</ul>\r\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "idverificationpending.php";
}

?>