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
echo "<br />\n<div id=\"notification2\" class=\"alert\"> \n\n&nbsp;&nbsp; ";
echo $reqAddon;
echo " add-on required<br />\n&nbsp;&nbsp; To , Active this addon,<br />\n&nbsp;&nbsp; 1. Login with your dhru account , <a href=\"https://cp.dhru.com/\" target=\"_blank\" >login click here </a><br />\n&nbsp;&nbsp; 2. after login success Go \"My License >> Gsm Portal / Fusion  >> Click on your license >> + Add-on Modules\"  <br />\n&nbsp;&nbsp; 3. Order it !\n<br /><br />\n&nbsp;&nbsp;  if you already purchased this add on so Go \"Help >> License information\" and Forcefully update license information\n</div>\n";
$fileverioncheck = "6.1.0";

?>