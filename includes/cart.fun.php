<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function getPromotion($code, $currency, $amount, $product = "", $type = "", $total = "", $cartarr = "")
{
    $date = date("Y-m-d");
    $code = enc($code, "9486");
    $sql = dquery("select * from tbl_promotion where code='" . $code . "'  and (\n\t('" . $date . "' between vali_start and vali_end)\n\tor (vali_start='' or vali_end='') ) and used>0");
    if (mysqli_num_rows($sql)) {
        $detail = mysqli_fetch_assoc($sql);
        if ($cartarr) {
            foreach ($cartarr as $k => $v) {
                if ($v["orderdetail"]["promotion"] != "") {
                    return false;
                }
            }
        }
        if ($detail["product_type"] != "" && $detail["total"] != "") {
            if ($cartarr) {
                foreach ($cartarr as $k => $v) {
                    if ($type == $detail["product_type"]) {
                        $prodarr = explode(",", $detail["product"]);
                        $proids = str_replace("p_", "", $k);
                        if (in_array($proids, $prodarr) && in_array($product, $prodarr)) {
                            $totals = $totals + $v["orderdetail"]["credit"];
                        }
                    }
                }
                if ($detail["total"] > $totals) {
                    return false;
                }
            }
        } else {
            if ($detail["product_type"] != "") {
                if ($type == $detail["product_type"]) {
                    $prodarr = explode(",", $detail["product"]);
                    if (in_array($product, $prodarr)) {
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                if ($detail["total"] != "") {
                    if ($detail["total"] > $total) {
                        return false;
                    }
                }
            }
        }
        if ($detail["type"]) {
            $discount = round($amount * $detail["amount"] / 100, 2);
            return $discount;
        }
        if ($detail["currency"] == $currency["id"]) {
            return $detail["amount"];
        }
        return convertCurrency($detail["amount"], $detail["currency"], $currency["id"]);
    } else {
        return false;
    }
}

?>