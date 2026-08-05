<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 456;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n    <li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=graph.account','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["account"];
echo " ";
echo $LNG["status"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab1','main2.php?page=graph.income','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["monthly"];
echo " ";
echo $LNG["income"];
echo "</a></li>\n    ";
if (!$OnlyEcommerce) {
    echo " \n        <li><a onclick=\"getContect('#tab2','main2.php?page=graph.order','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["monthly"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    ";
} else {
    echo "        <li><a onclick=\"getContect('#tab2','main2.php?page=graph.order.shop','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["monthly"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    ";
}
echo "    <li><a onclick=\"getContect('#tab3','main2.php?page=graph.signup','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["monthly"];
echo " ";
echo $LNG["signup"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n \n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "graph.account.php";
}
echo "  </div>";
$fileverioncheck = "6.1.0";

?>