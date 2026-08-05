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
echo "<ul id=\"tabmenu\"> \n\n<li class=\"tabmenu-header\"><span>Submenu</span></li>\n<span class=\"toggle-tabmenu\"><span>::</span><span style=\"margin-top:-5px;\">::</span></span>\n<li><a ";
if ($laoddefaultpage == "filequickaccept.php") {
    echo "class='tabmenu_active'";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=filequickaccept.php\" id=\"tab33\" >";
echo $LNG["quickaccept"];
echo "</a></li>\n<li><a ";
if ($laoddefaultpage == "fileorder.new.php") {
    echo "class='tabmenu_active'";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=fileorder.new.php\"  id=\"tab\" >";
echo $LNG["manualaccept"];
echo "</a></li>\n\n\n<li><a ";
if ($page == "fileorder.repllied" || $laoddefaultpage == "fileorder.repllied.php") {
    echo "class=tabmenu_active ";
} else {
    echo "class=simplelink ";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=fileorder.repllied.php\" id=\"tab2\" >";
echo $LNG["replyaccepted"];
echo "</a></li>\n\n<li><a ";
if ($laoddefaultpage == "fileorder.quickreply.php") {
    echo "class=tabmenu_active ";
} else {
    echo "class=simplelink ";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=fileorder.quickreply.php\" id=\"tab23\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["reply"];
echo "</a></li>\n\n<li><a ";
if ($page == "fileorder.verification" || $laoddefaultpage == "fileorder.verification.php" || $laoddefaultpage == "viewfileorder.verif.php") {
    echo "class=tabmenu_active ";
} else {
    echo "class=simplelink ";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=fileorder.verification.php\" id=\"tab3\" >";
echo $LNG["verificationorder"];
echo "</a></li>\n<li><a ";
if ($page == "fileorder.history" || $laoddefaultpage == "fileorder.history.php") {
    echo "class=tabmenu_active ";
} else {
    echo "class=simplelink ";
}
echo "href=\"main2.php?page=fileorder&laoddefaultpage=fileorder.history.php\" id=\"tab4\" >";
echo $LNG["orderhistory"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul> ";
if (isset($_SESSION["file_accepted"]) && $laoddefaultpage) {
    echo "    <div id=\"tabcontent\"> ";
    if ($laoddefaultpage) {
        include $laoddefaultpage;
        $laoddefaultpage = NULL;
    } else {
        include "filequickaccept.php";
    }
    echo "  </div>\n    ";
    exit;
}
$fileverioncheck = "6.1.0";

?>