<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
$codes = explode("\n", $code);
$cnt = 0;
if ($code && $credit && $used && $from && $to) {
    foreach ($codes as $c) {
        $c = trim($c);
        $c = enc($c, "9486");
        if (!mysqli_num_rows(dquery("select * from tbl_voucher where code='" . $c . "'"))) {
            $fix = 0;
            if ($fixcurrency) {
                $fix = 1;
            }
            $cnt++;
            dquery("INSERT INTO `tbl_voucher` (`code` ,`amount` ,`used`, `currency` ,`vali_start`,`vali_end`,`fixcurrency`) VALUES ('" . $c . "','" . $credit . "','" . $used . "','" . $currency . "','" . $from . "','" . $to . "','" . $fix . "')");
        }
    }
    echo "success: " . $cnt . " " . $LNG["rechargevoucher"] . " " . $LNG["created"];
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>