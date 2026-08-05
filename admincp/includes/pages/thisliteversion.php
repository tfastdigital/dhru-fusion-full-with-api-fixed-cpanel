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
echo "<br />\n<div id=\"notification2\" class=\"alert\"> \n\n&nbsp;&nbsp; The lite version have limited access. you do not have permission to access this page .<br />\n&nbsp;&nbsp; To , Active full version,<br />\n&nbsp;&nbsp; 1. Login at Customer Hub <br />\n&nbsp;&nbsp; 2. after login success Go \"My service >> Gsm Portal / Fusion  >> Click on your license >> Upgrade/Downgrade\" <br />\n&nbsp;&nbsp; 3. Order it !\n<br /><br />\n&nbsp;&nbsp;  if you already purchased this so Go \"Help >> License information\" and Forcefull update license information.\n</div>";
$fileverioncheck = "6.1.0";

?>