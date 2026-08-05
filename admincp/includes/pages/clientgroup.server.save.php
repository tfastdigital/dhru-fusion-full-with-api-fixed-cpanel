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
$COMMONUSERARRAY = [];
if ($imei_check) {
    dquery("DELETE FROM `tbl_client_group_price` \n     WHERE  `service_type` ='imei' AND group_id='" . $id . "'\n     and service_id in (select id from tbl_services_imei\n      where group_id='" . $groupid . "' and useasserver=1)");
    $services = implode(",", $imei_check);
    foreach ($imei_check as $key => $val) {
        $sql1 = dquery("SELECT * from `tbl_currencies`");
        while ($row1 = mysqli_fetch_assoc($sql1)) {
            if (${$row1["code"]}[$val]) {
                $discount = ${$row1["code"] . $row1["id"]}[$val] - ${$row1["code"]}[$val];
            } else {
                $discount = "";
            }
            $pp = ${$row1["code"]}[$val];
            if ($pp >= 0) {
                $rows = mysqli_num_rows(dquery("select * from tbl_client_group_price where \n            `group_id` ='" . $id . "' AND `service_id` ='" . $val . "' AND service_type='imei'\n             AND currency_id='" . $row1["id"] . "'"));
                if ($rows != 0) {
                    dquery("UPDATE `tbl_client_group_price` SET `discount` = '" . $discount . "' \n                WHERE `group_id` ='" . $id . "' AND `service_id` ='" . $val . "' AND `service_type` ='imei' \n                AND currency_id='" . $row1["id"] . "'");
                } else {
                    $data2["discount"] = $discount;
                    $data2["group_id"] = $id;
                    $data2["service_id"] = $val;
                    $data2["service_type"] = "imei";
                    $data2["currency_id"] = $row1["id"];
                    $db->insert("tbl_client_group_price", $data2);
                    unset($data2);
                }
                if ($allprice && (0 < $discount || $discount < 0)) {
                    $clientgroupid = $id;
                    $currencyid = $row1["id"];
                    $quser = dquery("select id from tblUsers where\n                     client_group='" . $clientgroupid . "' \n                and default_currency='" . $currencyid . "' and usertype!='3'");
                    while ($ruser = mysqli_fetch_assoc($quser)) {
                        $COMMONUSERARRAY[] = $ruser["id"];
                        $qdis = dquery("select * from tbl_discount_imei \n                        where user_id='" . $ruser["id"] . "' \n                    and service_id='" . $val . "'");
                        if (mysqli_num_rows($qdis)) {
                            $ddis["discount"] = $discount;
                            $db->update("tbl_discount_imei", $ddis, "user_id='" . $ruser["id"] . "' AND \n                        service_id='" . $val . "'");
                            $ddis = NULL;
                        } else {
                            $ddis["discount"] = $discount;
                            $ddis["user_id"] = $ruser["id"];
                            $ddis["service_id"] = $val;
                            $db->insert("tbl_discount_imei", $ddis);
                            $ddis = NULL;
                        }
                    }
                }
            }
        }
    }
    if ($allprice) {
        $quser = dquery("select id from tblUsers where client_group='" . $id . "' \n                    and usertype!='3'");
        while ($ruser = mysqli_fetch_assoc($quser)) {
            $COMMONUSERARRAY[] = $ruser["id"];
            $imeiacc = "";
            $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n            group_id='" . $id . "' AND service_type='imei'");
            $imeiacc = "";
            while ($r = mysqli_fetch_assoc($grp)) {
                $imeiacc .= $r["service_id"] . ",";
            }
            $iserv = trim($imeiacc, ",");
            dquery("update tblUsers set newserver_services='" . $iserv . "' where id='" . $ruser["id"] . "'");
        }
    }
    $Users = implode(",", $COMMONUSERARRAY);
    dquery("update tblUsers set pricechange=1 \n    where id in (" . $Users . ")");
    echo "success:" . $LNG["datasavesuccessfully"];
    unset($data);
    unset($user_credit);
} else {
    $sql = dquery("select id from tbl_services_imei where group_id='" . $groupid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
        dquery("DELETE FROM `tbl_client_group_price`  WHERE   `service_id` ='" . $row["id"] . "'\n         AND `service_type` ='imei'");
    }
}

?>