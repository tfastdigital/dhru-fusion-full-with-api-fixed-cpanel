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
if ($group) {
    $WHERE .= " and client_group='" . $group . "'";
}
if ($statuss) {
    $WHERE .= " and userstatus='" . $statuss . "'";
}
if ($reseller) {
    $WHERE .= " and reseller_id='" . $reseller . "'";
}
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where \n   ( usertype=0 or usertype=1 ) " . $WHERE);
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
$groupforce = true;
if ($user) {
    logActivityGlobal("Client group [" . $clientgroup . "] changed to user: [" . $user . "]", "multipleaccount", "", "admin");
    if (!is_array($user)) {
        $user = explode(",", $user);
    }
    $data = NULL;
    foreach ($user as $value) {
        if ($value) {
            $id = $value;
            $U = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $id . "'"));
            $currency = $U["default_currency"];
            $data["client_group"] = $clientgroup;
            if ($groupforce) {
                if ($clientgroup != 0) {
                    dquery("DELETE from tbl_discount_imei where user_id='" . $id . "'");
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n            group_id='" . $clientgroup . "' AND service_type='imei' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        $data2["discount"] = $r["discount"];
                        $data2["user_id"] = $id;
                        $data2["service_id"] = $r["service_id"];
                        $data2 = NULL;
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data["imei_services"] = trim($imeiacc, ",");
                    dquery("DELETE from tbl_discount_file where user_id='" . $id . "'");
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n            group_id='" . $clientgroup . "' AND service_type='file' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $id;
                            $data2["service_id"] = $r["service_id"];
                            $db->insert("tbl_discount_file", $data2);
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data["file_services"] = trim($imeiacc, ",");
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n            group_id='" . $clientgroup . "' AND service_type='server' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $id;
                            $data2["service_id"] = $r["service_id"];
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data["newserver_services"] = trim($imeiacc, ",");
                    dquery("DELETE from tbl_discount_product where user_id='" . $id . "'");
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n            group_id='" . $clientgroup . "' AND service_type='product' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $id;
                            $data2["service_id"] = $r["service_id"];
                            $db->insert("tbl_discount_product", $data2);
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data["products"] = trim($imeiacc, ",");
                } else {
                    $data["imei_service_access"] = 1;
                    $data["file_service_access"] = 1;
                    $data["server_log_access"] = 1;
                    $data["imei_services"] = "ALL";
                    $data["file_services"] = "ALL";
                    $data["server_logs"] = "ALL";
                    $data["newserver_services"] = "ALL";
                    $data["products"] = "ALL";
                    $data["client_group"] = "0";
                    dquery("DELETE FROM tbl_discount_imei where user_id='" . $id . "'");
                    dquery("DELETE FROM tbl_discount_file where user_id='" . $id . "'");
                    dquery("DELETE FROM tbl_discount_server_log where user_id='" . $id . "'");
                    dquery("DELETE FROM tbl_discount_product where user_id='" . $id . "'");
                }
            }
            $db->update("tblUsers", $data, "id='" . $id . "'");
            $data = NULL;
        }
    }
    echo "success:" . $LNG["update"] . " " . $LNG["client"] . "  " . $LNG["group"] . " " . $LNG["successfully"] . " ";
} else {
    echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}

?>