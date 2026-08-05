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
echo "<ul id=\"tabmenu\">\n";
if (!$OnlyEcommerce) {
    echo "<li><a ";
    if ($laoddefaultpage == "" || $laoddefaultpage == "utilities.review_imei.php") {
        echo "class=tabmenu_active ";
    }
    echo " href=\"main2.php?page=utilities.review&laoddefaultpage=utilities.review_imei.php\" id=\"tab4\" >IMEI Service Review</a></li>\n<li><a ";
    if ($laoddefaultpage == "utilities.review_server.php") {
        echo "class=tabmenu_active ";
    }
    echo "href=\"main2.php?page=utilities.review&laoddefaultpage=utilities.review_server.php\" id=\"tab4\" >Server Service Review</a></li>\n";
}
echo "\n<li><a ";
if ($laoddefaultpage == "utilities.review_shop.php") {
    echo "class=tabmenu_active ";
}
echo "href=\"main2.php?page=utilities.review&laoddefaultpage=utilities.review_shop.php\" id=\"tab4\" >Shop Service Review</a></li>\n</ul>\n\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    if ($OnlyEcommerce) {
        include "utilities.review_shop.php";
    } else {
        include "utilities.review_imei.php";
    }
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>