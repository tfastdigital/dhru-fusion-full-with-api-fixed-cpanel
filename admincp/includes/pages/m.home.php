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
echo "  \n    <div class=\"date-fonts\">\n    \t<ul>\n      \t             <li class=\"date\">Today : ";
echo date("M");
echo " ";
echo date("d");
echo ",";
echo date("H:m");
echo "</li>\n        </ul>\n      <div class=\"cb\"></div>\n    </div>\n    \n    \n      \n\n      \n\n    \n      \n      \n     <div class=\"grey-tab\">\n      <a href=\"main3.php?page=clients\">\n        <ul>\n          <li class=\"tab-text\">Clients</li>\n          <li class=\"tab-btn\"><img src=\"templates/mobile/images/grey-tab-btn.gif\" alt=\"Click\" /></li>\n        </ul>\n        <div class=\"cb\"></div>\n      </a>\n    </div>         \n    \n  \n       <div class=\"grey-tab\">\n      <a href=\"main3.php?page=waiting\">\n        <ul>\n          <li class=\"tab-text\">Waiting User</li>\n          <li class=\"tab-btn\"><img src=\"templates/mobile/images/grey-tab-btn.gif\" alt=\"Click\" /></li>\n        </ul>\n        <div class=\"cb\"></div>\n      </a>\n    </div>  \n    \n     <div class=\"grey-tab\">\n      <a href=\"main3.php?page=imeiorder\">\n        <ul>\n          <li class=\"tab-text\">IMEI Orders</li>\n          <li class=\"tab-btn\"><img src=\"templates/mobile/images/grey-tab-btn.gif\" alt=\"Click\" /></li>\n        </ul>\n        <div class=\"cb\"></div>\n      </a>\n    </div>  \n \n     <div class=\"grey-tab\">\n      <a href=\"main3.php?page=serverorder\">\n        <ul>\n          <li class=\"tab-text\">Server Orders</li>\n          <li class=\"tab-btn\"><img src=\"templates/mobile/images/grey-tab-btn.gif\" alt=\"Click\" /></li>\n        </ul>\n        <div class=\"cb\"></div>\n      </a>\n    </div>     \n        \n\n     <div class=\"grey-tab\">\n      <a href=\"main3.php?page=settings\">\n        <ul>\n          <li class=\"tab-text\">Site Settings</li>\n          <li class=\"tab-btn\"><img src=\"templates/mobile/images/grey-tab-btn.gif\" alt=\"Click\" /></li>\n        </ul>\n        <div class=\"cb\"></div>\n      </a>\n    </div>  \n    \n    \n  \n   \n   \n ";

?>