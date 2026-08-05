<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
if ($_POST["parameter"]) {
    $user = $_POST["parameter"];
    $sql = mysqli_fetch_assoc(dquery("select id from tblUsers where username='" . $user . "'"));
    $wher = "and user_id='" . $sql["id"] . "'";
} else {
    $wher = "";
}
$q = dquery("SELECT \n         order_id,(select service_name from tbl_services_imei where id=service_id) as service,imei\n         ,date,(credit-discount) as total,(select username from tblUsers where id=user_id) as user,\n         (select default_currency from tblUsers where id=user_id) as ids from tbl_order_imei where \n         imei LIKE '" . $search . "%' " . $wher . "  and user_can_c!='0' and  user_can_c<5 ORDER BY order_id DESC  limit 20");
while ($e = mysqli_fetch_assoc($q)) {
    $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $e["ids"] . "'"));
    $e["code"] = $sql["code"];
    $e["users"] = $e["user"];
    $output[] = $e;
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