<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["parameter"]);
$q = dquery("SELECT \n         order_id,(select service_name from tbl_server_log where id=service_id) as service\n         ,date,(credit-discount) as total,(select username from tblUsers where id=user_id) as user,reply,time,\n         IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied')) as status,user_can_c,    \n         (select default_currency from tblUsers where id=user_id) as ids from tbl_order_server\n          where order_id='" . $parameter . "'");
while ($e = mysqli_fetch_assoc($q)) {
    $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $e["ids"] . "'"));
    $e["orderon"] = date("Y-m-d H:i:s", $e["time"]);
    $e["code"] = $sql["code"];
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