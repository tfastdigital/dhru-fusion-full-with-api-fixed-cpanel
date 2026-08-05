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
if (!$imei_check) {
    dquery("UPDATE  tbl_product_group SET active='0' WHERE id='" . $groups . "'");
    dquery("UPDATE  tbl_products SET active='0' WHERE group_id='" . $groups . "'");
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    if ($grp) {
        foreach ($grp as $ids) {
            $data["active"] = 1;
            $db->update("tbl_product_group", $data, "group_name='" . $ids . "'");
            $data = NULL;
        }
    }
    dquery("UPDATE  tbl_products SET active='0'\n     WHERE group_id='" . $groups . "'");
    foreach ($imei_check as $ids) {
        if ($defaultpage == "pos.manage.php") {
            $data["active"] = 1;
            $data["credit"] = $servicecredit[$ids];
            $data["purchase_cost"] = $purchasecost[$ids];
            if ($service[$ids]) {
            }
            $db->update("tbl_products", $data, "id='" . $ids . "'");
        } else {
            $data["active"] = 1;
            $data["credit"] = $servicecredit[$ids];
            $data["affiliate_comission"] = $commission[$ids];
            $db->update("tbl_products", $data, "id='" . $ids . "'");
            $data = NULL;
            $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $d = dquery("SELECT `credit` FROM `tbl_product_credit` WHERE `service_id`='" . $ids . "' AND `currency_id`='" . $row["id"] . "'");
                if (mysqli_num_rows($d)) {
                    $cid = mysqli_fetch_assoc($d);
                    $data["credit"] = ${$row["code"]}[$ids];
                    $data["service_id"] = $ids;
                    $data["currency_id"] = $row["id"];
                    $db->update("tbl_product_credit", $data, "service_id='" . $ids . "' AND currency_id='" . $row["id"] . "'");
                    $data = NULL;
                } else {
                    $data["credit"] = ${$row["code"]}[$ids];
                    $data["service_id"] = $ids;
                    $data["currency_id"] = $row["id"];
                    $db->insert("tbl_product_credit", $data);
                    $data = NULL;
                }
            }
        }
    }
    if ($all_imei) {
        dquery("UPDATE  tbl_product_group SET active='1'");
        dquery("UPDATE  tbl_products SET active='1'");
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($imei_check);

?>