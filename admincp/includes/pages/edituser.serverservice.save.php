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
    logActivityGlobal("Server Service Disabled", "service", $id, "admin");
}
$RS = dquery("select id,`server_logs`,`username` from tblUsers where `reseller_id` ='" . $id . "'");
while ($rd = mysqli_fetch_assoc($RS)) {
    $buf = NULL;
    $chksrs = explode(",", $rd["server_logs"]);
    $sql = dquery("select id from tbl_server_log where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        foreach ($chksrs as $k => $s) {
            if ($row["id"] == $s) {
                foreach ($server_check as $i) {
                    if (in_array($i, $chksrs)) {
                        $buf[$i] = $i;
                    }
                }
                unset($chksrs[$k]);
            }
        }
    }
    $data = NULL;
    if (is_array($buf)) {
        $service_accrs = implode(",", $buf) . "," . implode(",", $chksrs);
        $data["server_logs"] = trim($service_accrs, ",");
        $data["server_log_access"] = $access;
        $db->update("tblUsers", $data, "id='" . $rd["id"] . "'");
    }
    $data = NULL;
}
$buf = NULL;
if (!$server_check && $access) {
    $user = mysqli_fetch_assoc(dquery("select `server_logs` from tblUsers where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user["server_logs"]);
    $sql = dquery("select id from tbl_server_log where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        foreach ($chksrv as $key => $s) {
            if ($row["id"] == $s) {
                unset($chksrv[$key]);
            }
        }
        dquery("delete from tbl_discount_server_log where `user_id` ='" . $id . "'  AND  `service_id` ='" . $row["id"] . "'");
    }
    $service_acc = trim(implode(",", $chksrv), ",");
    $service_acc = str_replace("ALL,", "", $service_acc);
    $service_acc = str_replace(",ALL", "", $service_acc);
    $service_acc = str_replace("ALL", "", $service_acc);
    $data["server_logs"] = $service_acc;
    $data["pricechange"] = 1;
    $db->update("tblUsers", $data, "id='" . $id . "'");
    echo "success:" . $LNG["datasavesuccessfully"];
    logActivityGlobal("Server service removed for group " . $groupid, "service", $id, "admin");
} else {
    $user = mysqli_fetch_assoc(dquery("select `server_logs` from tblUsers where `id` ='" . $id . "'"));
    $chksrv = explode(",", $user["server_logs"]);
    foreach ($server_check as $i) {
        if (!in_array($i, $chksrv)) {
            $buf .= "," . $i;
        }
    }
    $buf = trim($buf, ",");
    $services = implode(",", $server_check);
    $selected = trim($user["server_logs"] . "," . $buf, ",");
    $selected = explode(",", $selected);
    $sql = dquery("select id from tbl_server_log where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        if (!in_array($row["id"], $server_check)) {
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
    $data["server_logs"] = $service_acc;
    $data["server_log_access"] = $access;
    $data["pricechange"] = 1;
    if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
    $price = "";
    $egs = explode(",", $buf);
    foreach ($server_check as $key => $val) {
        if ($user_credit[$val] >= 0) {
            if ($user_credit[$val] == "") {
                dquery("delete from tbl_discount_server_log where `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
            } else {
                $rows = mysqli_num_rows(dquery("select * from tbl_discount_server_log where `user_id` ='" . $id . "' \n        AND `service_id` ='" . $val . "'"));
                if ($rows != 0) {
                    $discount = $servicecredit[$val] - formatCurrency2($user_credit[$val]);
                    if (in_array($val, $egs)) {
                        $price .= $user_credit[$val] . ",";
                    }
                    dquery("UPDATE `tbl_discount_server_log` SET `discount` = '" . $discount . "' WHERE \n            `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
                } else {
                    $data2["discount"] = $servicecredit[$val] - $user_credit[$val];
                    if (in_array($val, $egs)) {
                        $price .= $user_credit[$val] . ",";
                    }
                    $data2["user_id"] = $id;
                    $data2["service_id"] = $val;
                    $db->insert("tbl_discount_server_log", $data2);
                }
            }
        }
    }
    $price = trim($price, ",");
    logActivityGlobal("Server service  assigned : [" . $buf . "] price: [" . $price . "] ", "service", $id, "admin");
    $price = "";
}
$data = NULL;
if ($allservices) {
    $buf = "";
    $sql = dquery("select id from tbl_server_log");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= "," . $row["id"];
    }
    $service_acc = trim($buf, ",");
    $service_acc = str_replace("ALL,", "", $service_acc);
    $service_acc = str_replace(",ALL", "", $service_acc);
    $service_acc = str_replace("ALL", "", $service_acc);
    $data["server_logs"] = $service_acc;
    $db->update("tblUsers", $data, "id='" . $id . "'");
}
unset($data);
unset($user_credit);

?>