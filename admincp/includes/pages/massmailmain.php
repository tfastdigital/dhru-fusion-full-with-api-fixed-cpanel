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
echo "<ul id=\"tabmenu\">\n <li><a ";
if (!$laoddefaultpage == "mailicontact.php" || $laoddefaultpage == "sendMail.php") {
    echo "class='tabmenu_active'";
}
echo " href=\"main2.php?laoddefaultpage=sendMail.php&page=massmailmain\" id=\"tab1\" >";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo "</a></li>\n <li><a ";
if ($laoddefaultpage == "massmailbatch.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab12','main2.php?page=massmailbatch','','','#tabcontent',true,'#main_loader');\"  id=\"tab12\" >";
echo $LNG["background"];
echo " Queue </a></li>\n <li><a ";
if ($laoddefaultpage == "mailicontact.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=mailicontact','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >iContact</a></li>\n <li><a ";
if ($laoddefaultpage == "mailchimp.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab3','main2.php?page=mailchimp','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >Mail Chimp</a></li>\n <li><a ";
if ($laoddefaultpage == "zoho.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab4','main2.php?page=zoho','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Zoho Campaign</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "sendMail.php";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>