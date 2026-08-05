<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
$CGArray = [];
$qc = dquery("select id from tbl_client_group order by displayorder,id asc");
while ($rc = mysqli_fetch_assoc($qc)) {
    $CGArray[] = $rc["id"];
}
foreach ($_POST["_contentTable"] as $k => $v) {
    $findid = explode("row_", $v);
    if ($findid[1] != "") {
        $GroupID = $CGArray[$findid[1]];
        dquery("UPDATE tbl_client_group set displayorder='" . $k . "' WHERE id='" . $GroupID . "'");
    }
}
echo "Order arranged successfully";

?>