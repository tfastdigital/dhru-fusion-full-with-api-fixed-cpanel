<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "autosuggest.fun.php";
if (!$_SESSION["adminid"]) {
    exit;
}
autoSuggestoutput("SELECT `id`,`service_name` as username FROM `tbl_products`\n WHERE `service_name` LIKE '" . $input . "%'");

?>