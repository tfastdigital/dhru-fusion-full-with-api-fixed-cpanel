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
echo "<div class=\"sidemenu-bar\">\n<ul id=\"tabmenu\">\n    <li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab2','main2.php?page=mailsettings.basic','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["basic"] . " " . $LNG["mailsettings"];
echo "</a></li>\n    <!--<li><a onclick=\"getContect('#tab3','main2.php?page=mailsettings.send','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["sendingperformance"];
echo "</a></li>-->\n    <li><a ";
if ($laoddefaultpage == "emailtemplate.list.php") {
    echo "class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab','main2.php?page=emailtemplate.list','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["emailtemplate"];
echo "</a></li>\n    <li><a ";
if ($laoddefaultpage == "emailtemplate.layout.php") {
    echo "class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab4','main2.php?page=emailtemplate.layout','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["email"];
echo " Layout</a></li>\n    <li><a ";
if ($laoddefaultpage == "emailtemplate.add.php") {
    echo " class=\"tabmenu_active\" ";
}
echo " href=\"main2.php?page=mailsetting&laoddefaultpage=emailtemplate.add.php\" id=\"tab1\" > ";
echo $LNG["addemailtemplate"];
echo " </a></li>\n    <li><a onclick=\"getContect('#tab3','main2.php?page=emailtemplate.notification','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["system"];
echo " ";
echo $LNG["notification"];
echo "</a></li>\n";
if ($config["mail_sending_type"] == 1) {
    $cnt = mysqli_num_rows(dquery("select id from tbl_sheduledmail"));
    echo "<li><a ";
    if ($laoddefaultpage == "emailtemplate.sheduled.php") {
        echo " class=\"tabmenu_active\" ";
    }
    echo "  onclick=\"getContect('#tab44','main2.php?page=emailtemplate.sheduled','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab44\" >";
    echo $LNG["sheduled"];
    echo " ";
    echo $LNG["mail"];
    echo $cnt ? " <b>[" . $cnt . "]</b>" : "";
    echo "</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n";
if (!$mobilebrowser) {
    echo "    <link   href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/x-main2-new.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\">\n    ";
}
echo "</ul>\n</div>\n\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "mailsettings.basic.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>