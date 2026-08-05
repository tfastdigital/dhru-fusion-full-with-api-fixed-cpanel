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
$data["groupname"] = $group;
$data["type"] = $membershiptype;
$data["fee"] = $fee;
$data["days"] = $days;
$data["showon"] = $showon;
$data["maxcredit"] = $maxcredit;
$data["retail"] = $retail;
$data["settings"] = json_encode($settings);
$data["idverification"] = $idverification;
foreach ($charge as $k => $v) {
    $ins = NULL;
    if (mysqli_num_rows(dquery("select * from tbl_membership_fee where cid='" . $k . "' and gid='" . $id . "'"))) {
        $ins["fee"] = $v;
        $db->update("tbl_membership_fee", $ins, "gid='" . $id . "' and cid='" . $k . "'");
    } else {
        $ins["cid"] = $k;
        $ins["gid"] = $id;
        $ins["fee"] = $v;
        $db->insert("tbl_membership_fee", $ins);
    }
}
$data["maxaddfund"] = $maxaddfund;
$data["minaddfund"] = $minaddfund;
if ($db->update("tbl_client_group", $data, "id='" . $id . "'")) {
    if ($retail) {
        $q = dquery("select id,retail_credit from tbl_services_imei where retail=1");
        while ($rs = mysqli_fetch_assoc($q)) {
            setClientGroupRetail($rs["id"], $rs["retail_credit"]);
        }
    }
    echo "success:" . $LNG["savesuccessfully"];
}

?>