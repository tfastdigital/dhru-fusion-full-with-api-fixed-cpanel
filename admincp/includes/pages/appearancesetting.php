<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n\n<ul id=\"tabmenu\"> \n    <li><a onclick=\"getContect('#tab','main2.php?page=','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["userinterface"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab1','main2.php?page=','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["admininterface"];
echo " </a></li> \n    <li><a onclick=\"getContect('#tab2','main2.php?page=','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["admindashboard"];
echo "</a></li> \n\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">   </div>\n";
$fileverioncheck = "6.1.0";

?>