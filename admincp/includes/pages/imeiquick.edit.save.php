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
if ($server) {
    $wherecond = " and `server`=1";
    $whereservicecond = " and `useasserver`=1";
} else {
    $wherecond = " and `server`=0";
    $whereservicecond = " and `useasserver`=0";
}
if (!$imei_check) {
    dquery("UPDATE  tbl_imei_group SET active='0' WHERE id='" . $groups . "' " . $wherecond);
    dquery("UPDATE  tbl_services_imei SET active='0' WHERE group_id='" . $groups . "'");
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    if ($grp) {
        foreach ($grp as $ids) {
            if ($showall) {
                $data["active"] = 1;
                $db->update("tbl_imei_group", $data, "group_name='" . $ids . "'");
            }
            $data = NULL;
        }
    }
    dquery("UPDATE  tbl_services_imei SET active='0' WHERE group_id='" . $groups . "'");
    if ($imei_check) {
        foreach ($imei_check as $ids) {
            $servicerow = mysqli_fetch_assoc(dquery("select * from tbl_services_imei\n        where id='" . $ids . "'"));
            $data["active"] = 1;
            $data["credit"] = $servicecredit[$ids];
            $data["time"] = $times[$ids];
            $data["purchase_cost"] = $purchase_cost[$ids];
            $data["service_name"] = $servicename[$ids];
            $db->update("tbl_services_imei", $data, "id='" . $ids . "'");
            $data = NULL;
            if ($servicerow["API"] && $servicerow["API_ID"]) {
                dquery("update tbl_apiserversservices  set flagprice=0\n            where gateway='" . $servicerow["API"] . "' and id='" . $servicerow["API_ID"] . "'");
            }
            if ($servicerow["credit"] != $servicecredit[$ids] && $annoucements) {
                addAnnoucement("Price changed for " . $servicerow["service_name"] . " : <span class='badge badge-warning'>" . $servicecredit[$ids] . "</span>", date("Y-m-d"), "", $ids, $_SESSION["currency"]["id"], "", $servicecredit[$ids], $servicerow["credit"]);
            }
            $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $d = dquery("SELECT `credit` FROM `tbl_imei_credit` WHERE `service_id`='" . $ids . "' AND `currency_id`='" . $row["id"] . "'");
                if (mysqli_num_rows($d)) {
                    $cid = mysqli_fetch_assoc($d);
                    if (${$row["code"]}[$ids] != "") {
                        $data["credit"] = ${$row["code"]}[$ids];
                        $data["service_id"] = $ids;
                        $data["currency_id"] = $row["id"];
                        $db->update("tbl_imei_credit", $data, "service_id='" . $ids . "' AND currency_id='" . $row["id"] . "'");
                        $data = NULL;
                    } else {
                        dquery("DELETE FROM tbl_imei_credit where service_id='" . $ids . "'\n                    and currency_id='" . $row["id"] . "'");
                    }
                    $ddata = mysqli_fetch_assoc($d);
                    if (($ddata["credit"] != ${$row["code"]}[$ids] || ${$row["code"]}[$ids] == 0) && $annoucements) {
                        if (${$row["code"]}[$ids] == 0) {
                            ${$row["code"]}[$ids] = convertCurrency($servicecredit[$ids], $_SESSION["system_default_currency"]["id"], $row["id"]);
                        }
                        addAnnoucement("Price changed for " . $servicerow["service_name"] . " : <span class='badge badge-warning'>" . ${$row["code"]}[$ids] . "</span>", date("Y-m-d"), "", $ids, $row["id"], "", ${$row["code"]}[$ids], $ddata["credit"]);
                    }
                } else {
                    if (${$row["code"]}[$ids] != "") {
                        $data["credit"] = ${$row["code"]}[$ids];
                        $data["service_id"] = $ids;
                        $data["currency_id"] = $row["id"];
                        $db->insert("tbl_imei_credit", $data);
                        $data = NULL;
                    }
                    if ($annoucements) {
                        if (${$row["code"]}[$ids] == 0) {
                            ${$row["code"]}[$ids] = convertCurrency($servicecredit[$ids], $_SESSION["system_default_currency"]["id"], $row["id"]);
                        }
                        addAnnoucement("Price changed for " . $servicerow["service_name"] . " : <span class='badge badge-warning'>" . ${$row["code"]}[$ids] . "</span>", date("Y-m-d"), "", $ids, $row["id"], "", ${$row["code"]}[$ids], $servicerow["credit"]);
                    }
                }
            }
        }
    }
    if ($all_imei) {
        dquery("UPDATE  tbl_imei_group SET active='1' where 1=1 " . $wherecond);
        dquery("UPDATE  tbl_services_imei SET active='1' where 1=1 " . $whereservicecond);
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($imei_check);

?>