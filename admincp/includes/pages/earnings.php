<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if (!$IsFileOnly) {
    echo "<ul id=\"tabmenu\"> \n<li><a ";
    if (!$loaddefaultpage || $loaddefaultpage == "earningimei.php") {
        echo "class='tabmenu_active'";
    }
    echo " \nhref=\"main2.php?page=earnings&loaddefaultpage=earningimei.php&id=";
    echo $id;
    echo "\"  id=\"tab1\" >";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n<li><a ";
    if ($loaddefaultpage == "earningserver.php") {
        echo "class='tabmenu_active'";
    }
    echo " \nhref=\"main2.php?page=earnings&loaddefaultpage=earningserver.php&id=";
    echo $id;
    echo "\"  id=\"tab3\" >";
    echo $LNG["server"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n<li><a ";
    if ($loaddefaultpage == "earningproduct.php") {
        echo "class='tabmenu_active'";
    }
    echo " \nhref=\"main2.php?page=earnings&loaddefaultpage=earningproduct.php&id=";
    echo $id;
    echo "\"  id=\"tab2\" >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>  \n";
}
echo "    <div id=\"tabcontent\"> ";
if ($loaddefaultpage) {
    include $loaddefaultpage;
    $loaddefaultpage = NULL;
} else {
    include "earningimei.php";
}
echo "  </div>";
$fileverioncheck = "6.1.0";

?>