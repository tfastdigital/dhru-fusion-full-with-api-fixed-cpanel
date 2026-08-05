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
if ($newserver) {
    if ($_POST["access"]) {
        $access = 1;
    } else {
        $access = 0;
        logActivityGlobal("Server Service Disabled", "service", $id, "admin");
    }
    $RS = dquery("select id,`newserver_services`,`username`\n    from tblUsers where `reseller_id` ='" . $id . "'");
    while ($rd = mysqli_fetch_assoc($RS)) {
        $buf = NULL;
        $chksrs = explode(",", $rd["newserver_services"]);
        $sql = dquery("select id from tbl_services_imei\n        where group_id='" . $groupid . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            foreach ($chksrs as $k => $s) {
                if ($row["id"] == $s) {
                    if ($imei_check) {
                        foreach ($imei_check as $i) {
                            if (in_array($i, $chksrs)) {
                                $buf[$i] = $i;
                            }
                        }
                    }
                    unset($chksrs[$k]);
                }
            }
        }
        $data = NULL;
        if (is_array($buf)) {
            $service_accrs = implode(",", $buf) . "," . implode(",", $chksrs);
            $data["newserver_services"] = trim($service_accrs, ",");
            $data["server_log_access"] = $access;
            $data["pricechange"] = 1;
            $db->update("tblUsers", $data, "id='" . $rd["id"] . "'");
        }
        $data = NULL;
    }
    $buf = NULL;
    if (!$imei_check && $access) {
        $user = mysqli_fetch_assoc(dquery("select `newserver_services`\n    from tblUsers where `id` ='" . $id . "'"));
        $chksrv = explode(",", $user["newserver_services"]);
        $sql = dquery("select id from tbl_services_imei where\n    group_id='" . $groupid . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            foreach ($chksrv as $key => $s) {
                if ($row["id"] == $s) {
                    unset($chksrv[$key]);
                }
            }
            dquery("delete from tbl_discount_imei where `user_id` ='" . $id . "'\n          AND  `service_id` ='" . $row["id"] . "'");
        }
        $service_acc = trim(implode(",", $chksrv), ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $data["newserver_services"] = $service_acc;
        $data["pricechange"] = 1;
        $db->update("tblUsers", $data, "id='" . $id . "'");
        echo "success:" . $LNG["datasavesuccessfully"];
        logActivityGlobal("Server service removed for group " . $groupid, "service", $id, "admin");
    } else {
        $user = mysqli_fetch_assoc(dquery("select `newserver_services`\n     from tblUsers where `id` ='" . $id . "'"));
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
        $sql = dquery("select id from tbl_services_imei \n    where group_id='" . $groupid . "'");
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
        $data["pricechange"] = 1;
        if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
        $price = "";
        $egs = explode(",", $buf);
        foreach ($imei_check as $key => $val) {
            if ($user_credit[$val] >= 0) {
                if ($user_credit[$val] == "") {
                    dquery("delete from tbl_discount_imei where `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
                } else {
                    $rows = mysqli_num_rows(dquery("select * from tbl_discount_imei where \n        `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'"));
                    if ($rows != 0) {
                        $discount = round($servicecredit[$val] - formatCurrency2($user_credit[$val]), 2);
                        $disc = mysqli_fetch_assoc(dquery("select * from tbl_discount_imei where \n        `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'"));
                        if (in_array($val, $egs)) {
                            $price .= $user_credit[$val] . ",";
                        }
                        dquery("UPDATE `tbl_discount_imei` SET `discount` = '" . $discount . "',price='" . $user_credit[$val] . "'\n             WHERE `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
                        $serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei\n            where id='" . $val . "'"));
                        if ($disc["discount"] != $discount) {
                            addAnnoucement("Price changed for " . $serv["service_name"] . " : <span class='badge badge-warning'>" . $user_credit[$val] . "</span>", date("Y-m-d"), "", $val, "", $id, $user_credit[$val], $servicecredit[$val]);
                        }
                    } else {
                        $data2["discount"] = round($servicecredit[$val] - $user_credit[$val], 2);
                        if (in_array($val, $egs)) {
                            $price .= $user_credit[$val] . ",";
                        }
                        $data2["user_id"] = $id;
                        $data2["service_id"] = $val;
                        $data2["price"] = round($user_credit[$val], 2);
                        $db->insert("tbl_discount_imei", $data2);
                        $serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei\n            where id='" . $val . "'"));
                        addAnnoucement("Price changed for " . $serv["service_name"] . " : <span class='badge badge-warning'>" . $user_credit[$val] . "</span>", date("Y-m-d"), "", $val, "", $id, $user_credit[$val], $servicecredit[$val]);
                    }
                }
            }
        }
        $price = trim($price, ",");
        logActivityGlobal("Server service assigned : [" . $buf . "] price: [" . $price . "] ", "service", $id, "admin");
        $price = "";
    }
    $data = NULL;
    if ($allservices) {
        $buf = "";
        $sql = dquery("select id from tbl_services_imei where useasserver=1");
        while ($row = mysqli_fetch_assoc($sql)) {
            $buf .= "," . $row["id"];
        }
        $service_acc = trim($buf, ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $user = mysqli_fetch_assoc(dquery("select `newserver_services`\n     from tblUsers where `id` ='" . $id . "'"));
        if ($user["newserver_services"]) {
            $assignedserv = $user["newserver_services"] . "," . $service_acc;
        } else {
            $assignedserv = $service_acc;
        }
        $data["newserver_services"] = $assignedserv;
        $data["pricechange"] = 1;
        $db->update("tblUsers", $data, "id='" . $id . "'");
    }
    unset($data);
    unset($user_credit);
} else {
    if ($_POST["access"]) {
        $access = 1;
    } else {
        $access = 0;
        logActivityGlobal("IMEI Service Disabled", "service", $id, "admin");
    }
    $RS = dquery("select id,`imei_services`,`username`\n    from tblUsers where `reseller_id` ='" . $id . "'");
    while ($rd = mysqli_fetch_assoc($RS)) {
        $buf = NULL;
        $chksrs = explode(",", $rd["imei_services"]);
        $sql = dquery("select id from tbl_services_imei\n        where group_id='" . $groupid . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            foreach ($chksrs as $k => $s) {
                if ($row["id"] == $s) {
                    if ($imei_check) {
                        foreach ($imei_check as $i) {
                            if (in_array($i, $chksrs)) {
                                $buf[$i] = $i;
                            }
                        }
                    }
                    unset($chksrs[$k]);
                }
            }
        }
        $data = NULL;
        if (is_array($buf)) {
            $service_accrs = implode(",", $buf) . "," . implode(",", $chksrs);
            $data["imei_services"] = trim($service_accrs, ",");
            $data["imei_service_access"] = $access;
            $data["pricechange"] = 1;
            $db->update("tblUsers", $data, "id='" . $rd["id"] . "'");
        }
        $data = NULL;
    }
    $buf = NULL;
    if (!$imei_check && $access) {
        $user = mysqli_fetch_assoc(dquery("select `imei_services`\n    from tblUsers where `id` ='" . $id . "'"));
        $chksrv = explode(",", $user["imei_services"]);
        $sql = dquery("select id from tbl_services_imei where\n    group_id='" . $groupid . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            foreach ($chksrv as $key => $s) {
                if ($row["id"] == $s) {
                    unset($chksrv[$key]);
                }
            }
            dquery("delete from tbl_discount_imei where `user_id` ='" . $id . "'\n          AND  `service_id` ='" . $row["id"] . "'");
        }
        $service_acc = trim(implode(",", $chksrv), ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $data["imei_services"] = $service_acc;
        $data["pricechange"] = 1;
        $db->update("tblUsers", $data, "id='" . $id . "'");
        echo "success:" . $LNG["datasavesuccessfully"];
        logActivityGlobal("IMEI service removed for group " . $groupid, "service", $id, "admin");
    } else {
        $user = mysqli_fetch_assoc(dquery("select `imei_services`\n     from tblUsers where `id` ='" . $id . "'"));
        $chksrv = explode(",", $user["imei_services"]);
        foreach ($imei_check as $i) {
            if (!in_array($i, $chksrv)) {
                $buf .= "," . $i;
            }
        }
        $buf = trim($buf, ",");
        $services = implode(",", $imei_check);
        $selected = trim($user["imei_services"] . "," . $buf, ",");
        $selected = explode(",", $selected);
        $sql = dquery("select id from tbl_services_imei \n    where group_id='" . $groupid . "'");
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
        $data["imei_services"] = $service_acc;
        $data["imei_service_access"] = $access;
        $data["pricechange"] = 1;
        if ($db->update("tblUsers", $data, "id='" . $id . "'")) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
        $price = "";
        $egs = explode(",", $buf);
        foreach ($imei_check as $key => $val) {
            if ($user_credit[$val] >= 0) {
                if ($user_credit[$val] == "") {
                    dquery("delete from tbl_discount_imei where `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
                } else {
                    $rows = mysqli_num_rows(dquery("select * from tbl_discount_imei where \n        `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'"));
                    if ($rows != 0) {
                        $discount = round($servicecredit[$val] - formatCurrency2($user_credit[$val]), 2);
                        $disc = mysqli_fetch_assoc(dquery("select * from tbl_discount_imei where \n            `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'"));
                        if (in_array($val, $egs)) {
                            $price .= $user_credit[$val] . ",";
                        }
                        dquery("UPDATE `tbl_discount_imei`\n SET `discount` = '" . $discount . "',price='" . $user_credit[$val] . "'\n             WHERE `user_id` ='" . $id . "' AND `service_id` ='" . $val . "'");
                        $serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei\n            where id='" . $val . "'"));
                        if ($disc["discount"] != $discount) {
                            addAnnoucement("Price changed for " . $serv["service_name"] . " : <span class='badge badge-warning'>" . $user_credit[$val] . "</span>", date("Y-m-d"), "", $val, "", $id, $user_credit[$val], $servicecredit[$val]);
                        }
                    } else {
                        $data2["discount"] = round($servicecredit[$val] - $user_credit[$val], 2);
                        if (in_array($val, $egs)) {
                            $price .= $user_credit[$val] . ",";
                        }
                        $data2["user_id"] = $id;
                        $data2["service_id"] = $val;
                        $data2["price"] = $user_credit[$val];
                        $db->insert("tbl_discount_imei", $data2);
                        $serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei\n            where id='" . $val . "'"));
                        addAnnoucement("Price changed for " . $serv["service_name"] . " : <span class='badge badge-warning'>" . $user_credit[$val] . "</span>", date("Y-m-d"), "", $val, "", $id, $user_credit[$val], $servicecredit[$val]);
                    }
                }
            }
        }
        $price = trim($price, ",");
        logActivityGlobal("IMEI service assigned : [" . $buf . "] price: [" . $price . "] ", "service", $id, "admin");
        $price = "";
    }
    $data = NULL;
    if ($allservices) {
        $buf = "";
        $sql = dquery("select id from tbl_services_imei where useasserver=0");
        while ($row = mysqli_fetch_assoc($sql)) {
            $buf .= "," . $row["id"];
        }
        $service_acc = trim($buf, ",");
        $service_acc = str_replace("ALL,", "", $service_acc);
        $service_acc = str_replace(",ALL", "", $service_acc);
        $service_acc = str_replace("ALL", "", $service_acc);
        $data["imei_services"] = $service_acc;
        $data["pricechange"] = 1;
        $db->update("tblUsers", $data, "id='" . $id . "'");
    }
    unset($data);
    unset($user_credit);
}

?>