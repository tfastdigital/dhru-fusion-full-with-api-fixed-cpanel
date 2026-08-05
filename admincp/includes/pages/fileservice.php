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
if (!$_ff_onSUBMIT_FILTER && !$p) {
    include "fileservice.head.php";
}
echo "<div id=\"tabcontent\"> ";
if ($defaultpage) {
    include $defaultpage;
} else {
    include "fileservice.list.php";
}
echo "  </div>  ";
$fileverioncheck = "6.1.0";

?>