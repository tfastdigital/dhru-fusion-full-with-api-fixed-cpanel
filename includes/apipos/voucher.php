<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$checkParameter[] = "code";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $code = $parameters["code"];
    $uid = $UserDetails["id"];
    $code = descape(htmlspecialchars(strip_tags($code)));
    if (strlen($code) != 20) {
        $apiresults["ERROR"][] = ["message" => "Voucher Code is not valid"];
    } else {
        $code = enc((string) $code, "9486");
        $date = date("Y-m-d");
        $sql = dquery("SELECT id,reseller from tbl_voucher\n         where code='" . $code . "' and used>0 and (\n         ('" . $date . "' between vali_start and vali_end) ) ");
        if (mysqli_num_rows($sql)) {
            $date = date("Y-m-d");
            if (rechargeVoucher($uid, $code)) {
                $apiresults["SUCCESS"][] = ["message" => "Recharge successful"];
            } else {
                $apiresults["ERROR"][] = ["message" => "Voucher Code is not available"];
            }
        } else {
            $apiresults["ERROR"][] = ["message" => "Voucher is not available"];
        }
    }
}

?>