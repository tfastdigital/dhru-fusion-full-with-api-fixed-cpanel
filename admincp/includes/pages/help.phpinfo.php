<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 329;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">PHP Information</a></li>\n</ul>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">PHP Information</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n      <div style=\"text-align: center; font-weight: bold;\">\n";
printf("MySQL server version: %s\n", mysqli_get_server_info($db_conn2));
echo "      </div>\n      ";
echo phpinfo();
echo "\n</div></div>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>