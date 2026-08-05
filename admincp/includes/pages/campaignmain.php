<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!licince\checkSupport()) {
    echo "<div id='notification1' class='errorbox' > Support Required for this features</div>";
    exit;
}
echo "<ul id=\"tabmenu\">\r\n    <li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab12','main2.php?page=campaignlist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["campaign"];
echo "s</a></li>\r\n    <li><a ";
if ($laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab','main2.php?page=campaign','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["create"];
echo " ";
echo $LNG["campaign"];
echo "</a></li>\r\n\r\n    <div style=\"clear: both;\"></div>\r\n</ul>\r\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "campaignlist.php";
}
echo "  </div>";

?>