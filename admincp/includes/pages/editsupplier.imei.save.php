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
if ($newserver == 2) {
    $ServiceField = "remote_services";
} else {
    if ($newserver == 1) {
        $ServiceField = "server_logs";
    } else {
        $ServiceField = "imei_services";
    }
}
$flag = false;
foreach ($imei_check as $k => $sid) {
    $data["purchase_cost"] = formatCurrency2($pcost[$k]);
    $db->update("tbl_services_imei", $data, "id=" . $sid);
    $data = NULL;
    $cost = mysqli_fetch_assoc(dquery("SELECT purchase_cost FROM tbl_services_imei WHERE id='" . $sid . "'"));
    if ($cost["purchase_cost"] == "") {
        unset($imei_check[$k]);
        $flag = true;
    }
}
if ($newserver == 2) {
    $data["remote_service_access"] = $access;
} else {
    if ($newserver == 1) {
        $data["server_log_access"] = $access;
    } else {
        $data["imei_service_access"] = $access;
    }
}
if (!$imei_check && $access) {
    $user = mysqli_fetch_assoc(dquery("select `" . $ServiceField . "` from tbl_supplier where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user[$ServiceField]);
    $sql = dquery("select id from tbl_services_imei where group_id='" . $groupid . "'");
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
    $data[$ServiceField] = $service_acc;
} else {
    $user = mysqli_fetch_assoc(dquery("select `" . $ServiceField . "` from tbl_supplier where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user[$ServiceField]);
    foreach ($imei_check as $i) {
        if (!in_array($i, $chksrv)) {
            $buf .= "," . $i;
        }
    }
    $buf = trim($buf, ",");
    $services = implode(",", $imei_check);
    $selected = trim($user[$ServiceField] . "," . $buf, ",");
    $selected = explode(",", $selected);
    $sql = dquery("select id from tbl_services_imei where group_id='" . $groupid . "'");
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
    $data[$ServiceField] = $service_acc;
    if ($newserver == 2) {
        $data["remote_service_access"] = $access;
    } else {
        if ($newserver == 1) {
            $data["server_log_access"] = $access;
        } else {
            $data["imei_service_access"] = $access;
        }
    }
    if ($all_imei == "ALL") {
        $buf = "";
        $sql = dquery("select id from tbl_services_imei");
        while ($row = mysqli_fetch_assoc($sql)) {
            $buf .= "," . $row["id"];
        }
        $service_acc = trim($buf, ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $data[$ServiceField] = $service_acc;
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