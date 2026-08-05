<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (licince\reqaddon("Payment Aggregation", true)) {
    if (!isset($_SESSION[adminid])) {
        exit;
    }
    echo "<ul id=\"tabmenu\">\n    <li><a ";
    if (!$laoddefaultpage == "addnewaggeragation.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab1','main2.php?page=addnewaggeragation','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["addnew"];
    echo "</a></li>\n    <li><a ";
    if ($laoddefaultpage == "aggregationlist.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab2','main2.php?page=aggregationlist','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["payment"];
    echo " ";
    echo $LNG["aggregation"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n    <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n    ";
    if ($laoddefaultpage) {
        include $laoddefaultpage;
    } else {
        include "addnewaggeragation.php";
    }
    echo "</div>\n";
    $fileverioncheck = "6.1.0";
} else {
    exit("You are not allowed");
}

?>