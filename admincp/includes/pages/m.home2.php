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
echo " <div class=\"homemenu\">\n\n        <div class='panel'>            \n            <ul class='list'>\n                \n                <li>\n                <a href=\"main4.php?page=clients\" >Clients</a></li>\n\n                <li>\n                <a href='main4.php?page=waiting'>Waiting User</a></li>\n                \n                <li>\n                <a href='main4.php?page=imeiorder'>IMEI Orders</a></li>\n\n                <li>\n                <a href='main4.php?page=serverorder'>Server Orders</a></li>   \n\n                <li>\n                <a href='main4.php?page=settings'>Site Settings</a></li>     \n                                                        \n             </ul>\n        </div>\n        \n </div>";

?>