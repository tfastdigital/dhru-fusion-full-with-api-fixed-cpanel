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
if (($code || $name) && $credit) {
    if ($applydisc == 1) {
        $total = $subtotal;
    }
    if ($applyserv == 1) {
        if (trim($imei) != "") {
            $ptype = "imei";
            $product = $imei;
        } else {
            if (trim($server) != "") {
                $ptype = "server";
                $product = $server;
            } else {
                if (trim($product) != "") {
                    $ptype = "product";
                }
            }
        }
    }
    if ($code) {
        foreach ($codes as $c) {
            if (!$used) {
                $used = 9999999;
            }
            $c = enc($c, "9486");
            dquery("INSERT INTO `tbl_promotion` (`code` ,`amount` ,`used`, `currency` ,`vali_start`,        `vali_end`,`type`,`product`,`product_type`,`total`,`newsignup`)         VALUES ( '" . $c . "','" . $credit . "','" . $used . "','" . $currency . "','" . $from . "','" . $to . "','" . $type . "','" . $product . "','" . $ptype . "','" . $total . "','" . $newsignup . "')");
        }
    } else {
        $name = enc($name, "9486");
        if (!$used) {
            $used = 9999999;
        }
        dquery("INSERT INTO `tbl_promotion` (`code` ,`amount` ,`used`, `currency` ,`vali_start`,     `vali_end`,`type`,`product`,`product_type`,`total`,`newsignup`)         VALUES ( '" . $name . "','" . $credit . "','" . $used . "','" . $currency . "','" . $from . "','" . $to . "','" . $type . "','" . $product . "','" . $ptype . "','" . $total . "','" . $newsignup . "')");
    }
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>