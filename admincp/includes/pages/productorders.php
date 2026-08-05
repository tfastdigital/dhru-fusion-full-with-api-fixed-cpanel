<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

//licince\reqaddon("E-commerce");
include "productsorder.head.php";
echo "    <div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "productsorder.pending.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>