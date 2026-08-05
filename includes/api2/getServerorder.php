<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$q = dquery("SELECT \n         order_id,(select service_name from tbl_server_log where id=service_id) as service\n         ,date,(tbl_order_server.credit-discount) as total,\n         (select default_currency from tblUsers where id=user_id) as ids,(select username from tblUsers where id=user_id) as user from tbl_order_server \n LEFT OUTER JOIN tbl_server_log ON `tbl_order_server`.service_id = tbl_server_log.id  where service_name LIKE '" . $search . "%' \n  and user_can_c!='0' and  user_can_c<5 ORDER BY order_id DESC   limit 20");
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