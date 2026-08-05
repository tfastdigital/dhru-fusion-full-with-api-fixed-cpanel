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
echo "<ul id=\"tabmenu\"> \n\n<li class=\"tabmenu-header\"><span>Submenu</span></li>\n<span class=\"toggle-tabmenu\"><span>::</span><span style=\"margin-top:-5px;\">::</span></span>\n    <li><a ";
if ($laoddefaultpage == "serverquickaccept.php") {
    echo "class='tabmenu_active'";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverquickaccept.php'  >";
echo $LNG["quickaccept"];
echo "</a></li>\n    <li><a ";
if ($laoddefaultpage == "serverorder.new.php") {
    echo "class='tabmenu_active'";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverorder.new.php'>";
echo $LNG["manualaccept"];
echo "</a></li>\n\n\n\n    <li><a ";
if ($laoddefaultpage == "quickserverreply.php") {
    echo "class='tabmenu_active'";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=quickserverreply.php'>";
echo $LNG["quickreply"];
echo "</a></li>\n    <li><a ";
if ($laoddefaultpage == "serverorder.replied.php") {
    echo "class='tabmenu_active'";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverorder.replied.php'>";
echo $LNG["manualreply"];
echo "</a></li>\n\n<li><a ";
if ($laoddefaultpage == "serverorder.verification.php" || isset($extracts)) {
    echo "class='tabmenu_active'";
} else {
    echo "class=simplelink ";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverorder.verification.php' id=\"tab3\" >";
echo $LNG["verificationorder"];
echo "</a></li>\n<li><a ";
if ($laoddefaultpage == "serverorder.history.php") {
    echo "class='tabmenu_active'";
} else {
    echo "class=simplelink ";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverorder.history.php' id=\"tab4\" >";
echo $LNG["orderhistory"];
echo "</a></li>\n\n<li><a ";
if ($laoddefaultpage == "serverorder.pending.php") {
    echo "class='tabmenu_active'";
} else {
    echo "class=simplelink ";
}
echo "href='main2.php?page=serverorder&laoddefaultpage=serverorder.pending.php' id=\"tab5\" >";
echo $LNG["pending"];
echo " ";
echo $LNG["order"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul> ";
if (isset($_SESSION["once_accepted"]) && $loaddefaultpage) {
    echo "    <div id=\"tabcontent\"> ";
    if ($loaddefaultpage) {
        include $loaddefaultpage;
        $loaddefaultpage = NULL;
    } else {
        include "serverquickaccept.php";
    }
    echo "  </div>\n    ";
    exit;
}
$fileverioncheck = "6.1.0";

?>