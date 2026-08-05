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
if ($_POST["access"]) {
    $access = 1;
} else {
    $access = 0;
}
$flag = false;
foreach ($imei_check as $k => $sid) {
    $data["purchase_cost"] = formatCurrency2($pcost[$k]);
    $db->update("tbl_server_log", $data, "id=" . $sid);
    $data = NULL;
    $cost = mysqli_fetch_assoc(dquery("SELECT purchase_cost FROM tbl_server_log WHERE id='" . $sid . "'"));
    if ($cost["purchase_cost"] == "") {
        unset($imei_check[$k]);
        $flag = true;
    }
}
$data["server_log_access"] = $access;
if (!$imei_check && $access) {
    $user = mysqli_fetch_assoc(dquery("select `newserver_services` from tbl_supplier where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user["newserver_services"]);
    $sql = dquery("select id from tbl_server_log where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        foreach ($chksrv as $key => $s) {
            if ($row["id"] == $s) {
                unset($chksrv[$key]);
            }
        }
    }
    $service_acc = trim(implode(",", $chksrv), ",");
    $service_acc = str_replace("ALL,", "", $service_acc);
    $service_acc = str_replace(",ALL", "", $service_acc);
    $service_acc = str_replace("ALL", "", $service_acc);
    $data["newserver_services"] = $service_acc;
} else {
    $user = mysqli_fetch_assoc(dquery("select `newserver_services` from tbl_supplier where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user["newserver_services"]);
    foreach ($imei_check as $i) {
        if (!in_array($i, $chksrv)) {
            $buf .= "," . $i;
        }
    }
    $buf = trim($buf, ",");
    $services = implode(",", $imei_check);
    $selected = trim($user["newserver_services"] . "," . $buf, ",");
    $selected = explode(",", $selected);
    $sql = dquery("select id from tbl_server_log where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        if (!in_array($row["id"], $imei_check)) {
            foreach ($selected as $key => $s) {
                if ($s == $row["id"]) {
                    unset($selected[$key]);
                }
            }
        }
    }
    $service_acc = implode($selected, ",");
    $service_acc = str_replace("ALL,", "", $service_acc);
    $service_acc = str_replace(",ALL", "", $service_acc);
    $service_acc = str_replace("ALL", "", $service_acc);
    $data["newserver_services"] = $service_acc;
    $data["server_log_access"] = $access;
    if ($all_imei == "ALL") {
        $buf = "";
        $sql = dquery("select id from tbl_server_log");
        while ($row = mysqli_fetch_assoc($sql)) {
            $buf .= "," . $row["id"];
        }
        $service_acc = trim($buf, ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $data["newserver_services"] = $service_acc;
    }
}
if ($db->update("tbl_supplier", $data, "id=" . $id)) {
    if ($flag) {
        echo "error:" . $LNG["purchasecostnotset"];
    } else {
        echo "success:" . $LNG["datasavesuccessfully"];
    }
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>