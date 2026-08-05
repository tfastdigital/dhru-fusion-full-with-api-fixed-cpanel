<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["parameter"]);
if ($parameter == "REJECT") {
    $q = dquery("SELECT \n         order_id,(select service_name from tbl_services_imei where id=service_id) as service,imei\n         ,date,(credit-discount) as total,\n         (select default_currency from tblUsers where id=user_id) as ids,(select username from tblUsers where id=user_id) as user from tbl_order_imei where user_can_c='1' \n         ORDER BY order_id desc\n         limit 10");
    while ($e = mysqli_fetch_assoc($q)) {
        $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $e["ids"] . "'"));
        $e["code"] = $sql["code"];
        $e["users"] = $e["user"];
        $output[] = $e;
    }
} else {
    if ($parameter == "VERIFY") {
        $q = dquery("SELECT          order_id,(select service_name from tbl_services_imei where id=service_id) as service,imei         ,date,(credit-discount) as total,         (select default_currency from tblUsers where id=user_id) as ids,(select username from tblUsers where id=user_id) as user from tbl_order_imei where           (`user_can_c`='4') AND `verified`='1'           ORDER BY order_id desc         limit 10");
        while ($e = mysqli_fetch_assoc($q)) {
            $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $e["ids"] . "'"));
            $e["code"] = $sql["code"];
            $e["users"] = $e["user"];
            $output[] = $e;
        }
    } else {
        $q = dquery("SELECT \n         order_id,(select service_name from tbl_services_imei where id=service_id) as service,imei\n         ,date,(credit-discount) as total,\n         (select default_currency from tblUsers where id=user_id) as ids,\n         (select username from tblUsers where id=user_id) as user from tbl_order_imei where user_can_c='1' \n         ORDER BY order_id desc\n         limit 10");
        while ($e = mysqli_fetch_assoc($q)) {
            $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $e["ids"] . "'"));
            $e["code"] = $sql["code"];
            $e["users"] = $e["user"];
            $output[] = $e;
        }
    }
}
if (count($output) == 0) {
    $reply["STATUS"] = "ERROR";
} else {
    $reply["STATUS"] = "SUCCESS";
}
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>