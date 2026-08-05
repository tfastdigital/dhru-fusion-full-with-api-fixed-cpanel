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
echo "<ul id=\"tabmenu\"> \n<li><a ";
if ($defaultloadpage != "smsgateway.settings.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=smsgateway.settings','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >SMS Gateway Settings</a></li> \n<li><a onclick=\"getContect('#tab2','main2.php?page=smsgateway.clickatell','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >Clickatell Settings</a></li> \n<li><a onclick=\"getContect('#tab1','main2.php?page=smsgateway.customapi','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Custom  api settings</a></li> \n<li><a onclick=\"getContect('#tab3','main2.php?page=smsgateway.messages','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >Messages</a></li> \n <div style=\"clear: both;\"></div>  \n</ul>\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "smsgateway.settings.php";
}
echo "  </div>  ";
$fileverioncheck = "6.1.0";

?>