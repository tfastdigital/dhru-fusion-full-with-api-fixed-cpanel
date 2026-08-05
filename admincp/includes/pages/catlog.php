<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\reqaddon("E-commerce");
if (!$_ff_onSUBMIT_FILTER && !$p) {
    include "catlog.head.php";
}
dquery("ALTER TABLE `tbl_products` ADD `pos` INT(1) NOT NULL");
echo "<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "product.list.php";
}
echo "  </div>  \n";
$fileverioncheck = "6.1.0";

?>