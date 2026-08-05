<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getReplyCodeByQnt($gid, $qnt)
{
    global $config;
    global $db;
    $date = date("Y-m-d");
    $UsedKey = [1.0E+19];
    $usedlist = implode(",", $UsedKey);
    $Reply = "";
    for ($i = 1; $i <= $qnt; $i++) {
        $sql = mysqli_fetch_assoc(dquery("select * from tbl_swkey \r\n        where status='0' and group_id='" . $gid . "'\r\n        and (expiredon>'" . $date . "' || expiredon='') and `key`!=''\r\n        id NOT IN (" . $usedlist . ")"));
        if ($sql["id"]) {
            $usedlist[] = $sql["id"];
            $Reply = $Reply . "\n" . $sql["key"];
        }
    }
    $_OUT["reply"] = $Reply;
    $_OUT["usedkey"] = $usedlist;
    return $_OUT;
}
function processKey($gid, $oid, $stype, $qnt = 1, $checkqnt = "")
{
    global $config;
    global $db;
    $date = date("Y-m-d");
    $fromauto = false;
    $autonotfound = false;
    $AvailableQnt = 0;
    $ReplyArr = [];
    $POCOST = 0;
    if (mysqli_num_rows(dquery("select id from tbl_keygroup\r\n    where id='" . $gid . "' and codetable!='' and codeimei!='' and codereply!=''"))) {
        $fromauto = true;
        $keygroup = mysqli_fetch_assoc(dquery("select * from \r\n        tbl_keygroup where id='" . $gid . "'"));
        if ($stype == "imei" || $stype == "server") {
            $imeis = mysqli_fetch_assoc(dquery("select imei from tbl_order_imei\r\n            where order_id='" . $oid . "'"));
        }
        if ($keygroup["exlcludestart"]) {
            $imeis["imei"] = substr($imeis["imei"], $keygroup["exlcludestart"]);
        }
        if ($keygroup["exludeend"]) {
            $imeis["imei"] = substr($imeis["imei"], 0, 0 - $keygroup["exludeend"]);
        }
        $SQLKEY = "";
        if (strpos($keygroup["codereply"], ",") !== false) {
            $PATTERN = str_replace(",", ",'',", $keygroup["codereply"]);
            $keyreply = mysqli_fetch_assoc(dquery("select concat(" . $PATTERN . ") as codereply\r\n            from `" . $keygroup["codetable"] . "` where `" . $keygroup["codeimei"] . "`='" . $imeis["imei"] . "'"));
            $SQLKEY = $keyreply["codereply"];
        } else {
            $keyreply = mysqli_fetch_assoc(dquery("select `" . $keygroup["codereply"] . "`\r\n            from `" . $keygroup["codetable"] . "` where `" . $keygroup["codeimei"] . "`='" . $imeis["imei"] . "'"));
            $SQLKEY = $keyreply[$keygroup["codereply"]];
        }
        $sql["key"] = $SQLKEY;
        $ReplyArr[] = $SQLKEY;
        if ($keygroup["autoreject"] && !trim($sql["key"])) {
            $autonotfound = true;
        }
        $finalreply = "";
        if ($keygroup["replysprintf"] && $sql["key"]) {
            $chararr = str_split($sql["key"]);
            $pattarr = str_split(nl2br($keygroup["replysprintf"]));
            $finalreply = "";
            $star = 0;
            foreach ($pattarr as $k => $p) {
                if ($p == "*") {
                    $p = $chararr[$star];
                    $star++;
                }
                $finalreply .= $p;
            }
        }
        if ($finalreply != "") {
            $sql["key"] = $finalreply;
        }
        $ReplyArr[] = $sql["key"];
        $sql["id"] = 999999999;
        $AvailableQnt = 1;
    } else {
        if (1 < $qnt) {
            $sql = mysqli_fetch_assoc(dquery("SELECT (select `id` from tbl_swkey\r\n             where status='0' and group_id='" . $gid . "' and (expiredon>'" . $date . "' || expiredon='') and `key`!='' limit 1) as id,\r\n             (select `qnt` from tbl_swkey\r\n             where status='0' and group_id='" . $gid . "' and (expiredon>'" . $date . "' || expiredon='') and `key`!='' limit 1) as qnt,             GROUP_CONCAT(`key` SEPARATOR '----') as  `key`              FROM (select `key` from tbl_swkey              where status='0' and group_id='" . $gid . "' and (expiredon>'" . $date . "' || expiredon='') and `key`!='' limit " . $qnt . ") as `key`"));
            $found = explode("----", $sql["key"]);
            $search = implode("','", $found);
            $sql1 = mysqli_fetch_assoc(dquery("select group_concat(`code2` SEPARATOR '----' ) as code2,sum(purchase) as purchase            from tbl_swkey where `key` in ('" . $search . "')"));
            $code2 = explode("----", $sql1["code2"]);
            $POCOST = $sql1["purchase"];
            if ($checkqnt == "" && count($found) != $qnt) {
                $adminmessage = "";
                include_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage = "Order #" . $oid . " not auto process , due to insufficient key in reply group " . $keygroup["group"];
                sendNotification("system", "Auto Key selling order on hold", $adminmessage, $mailto);
                if ($config["slack_notenoughkey"]) {
                    $_cols[0]["titel"] = $keygroup["group"];
                    $_cols[0]["text"] = "ORDER #" . $oid;
                    SlackSendMsg($config["slack_notenoughkey"], strip_tags($adminmessage), "danger", $_cols, false);
                }
                return false;
            }
            $keys = "'" . str_replace("----", "','", $sql["key"]) . "'";
            $vsql = mysqli_fetch_assoc(dquery("select group_concat(id) as gin from \r\n             tbl_swkey where group_id='" . $gid . "' and `key` in (" . $keys . ")"));
            $sql["ids"] = $vsql["gin"];
            $ReplyCode = "";
            $i = 1;
            foreach ($found as $fk => $code) {
                $ReplyArr[] = $code . " " . $code2[$fk];
                $ReplyCode .= $i . ". " . $code . " " . $code2[$fk] . "<br />";
                $i++;
                $AvailableQnt++;
            }
            $sql["key"] = $ReplyCode;
        } else {
            $sql = mysqli_fetch_assoc(dquery("select *,id as ids from tbl_swkey \r\n            where qnt>used and group_id='" . $gid . "'\r\n            and (expiredon>'" . $date . "' || expiredon='') and `key`!=''"));
            if ($sql["id"]) {
                $AvailableQnt = 1;
            }
            $POCOST = $sql["purchase"];
            $sql["key"] = $sql["key"] . " " . $sql["code2"];
        }
    }
    if ($checkqnt != "") {
        if ($AvailableQnt != $qnt) {
            return false;
        }
        return true;
    }
    if ($checkqnt == "" && $sql["id"]) {
        $oid2 = md5($oid);
        if ($stype == "imei" || $stype == "server") {
            $table = "tbl_order_imei";
            if ($autonotfound) {
                $return = rejectIMEI($oid2, "NOT FOUND", 99999);
            } else {
                include_once ROOTDIR . "/includes/imeiservices.fun.php";
                $return = replySuccessIMEI($oid2, $sql["key"], 99999, "", "", "", "", "", $ReplyArr);
                if ($oid) {
                    $OrderDtl = mysqli_fetch_assoc(dquery("select credit,discount,(select default_currency from tblUsers where tblUsers.id=user_id) as currency from \r\n                        tbl_order_imei where order_id='" . $oid . "'"));
                    if ($_SESSION["system_default_currency"]["id"] != $OrderDtl["currency"]) {
                        $POCOST = convertCurrency($POCOST, $_SESSION["system_default_currency"]["id"], $OrderDtl["currency"]);
                    }
                    $Profit = 0;
                    if (0 < $POCOST) {
                        $Profit = round($OrderDtl["credit"] - $OrderDtl["discount"] - $POCOST, 3);
                    }
                    dquery("update tbl_order_imei \r\n                        set purchase_cost='" . $POCOST . "',profit='" . $Profit . "' where order_id='" . $oid . "'");
                }
            }
        } else {
            if ($stype == "file") {
                $table = "tbl_order_file";
                $return = replySuccessFile($oid2, $sql["key"], 99999);
            } else {
                if ($stype == "server") {
                    $table = "tbl_order_server";
                    $return = replySuccessServer($oid2, $sql["key"], 99999);
                } else {
                    if ($stype == "product") {
                        include_once ROOTDIR . "/includes/mail.fun.php";
                        dquery("update tbl_order_product  set reply=concat(reply,' ','" . $sql["key"] . "'),user_can_c='4' \r\n            where order_id='" . $oid . "'");
                        $OrderDtl = mysqli_fetch_assoc(dquery("select *,\r\n            (select template_id1  from tbl_products where id=service_id) as successt\r\n            from tbl_order_product where order_id='" . $oid . "'"));
                        if ($OrderDtl) {
                            $service = mysqli_fetch_assoc(dquery("select `service_name`,bundle,bysupplier,\r\n                `template_id1` from `tbl_products` where `id`='" . $OrderDtl["service_id"] . "'"));
                            $email_merge_fields["servicetype"] = "Product";
                            $email_merge_fields["orderid"] = $OrderDtl["order_id"];
                            $email_merge_fields["service"] .= "<br>\r\n" . $service["service_name"] . " <br>\r\n";
                            $email_merge_fields["reply"] = $sql["key"];
                            $email_merge_fields["comments"] = $OrderDtl["comments"];
                            if ($service["bysupplier"]) {
                                $email_merge_fields["link"] = $config["site_address"] . "feedback.php?id=" . md5($key);
                            }
                            if ($OrderDtl["successt"]) {
                                sendMail($OrderDtl["successt"], $OrderDtl["user_id"], $OrderDtl["order_id"], $email_merge_fields, true);
                            } else {
                                sendMail(49, $OrderDtl["user_id"], $OrderDtl["order_id"], $email_merge_fields, true);
                            }
                        }
                    }
                }
            }
        }
        if ($return[0]) {
            $uid = mysqli_fetch_assoc(dquery("select * from " . $table . " where order_id='" . $oid . "'"));
            if (!$fromauto) {
                dquery("UPDATE tbl_swkey set uid='" . $uid["user_id"] . "',used=used+1,date='" . $date . "',status=1 where id in (" . $sql["ids"] . ")");
                $qk = dquery("select * from tbl_swkey where id in (" . $sql["ids"] . ")");
                while ($rk = mysqli_fetch_assoc($qk)) {
                    $KEY = NULL;
                    $KEY["userid"] = $uid["user_id"];
                    $KEY["keyid"] = $rk["id"];
                    $KEY["orderid"] = $oid;
                    $KEY["type"] = $uid["server"] ? "server" : $stype;
                    $KEY["qnt"] = 1;
                    $KEY["date"] = $date;
                    $db->insert("tbl_used_key", $KEY);
                    $KEY = NULL;
                }
                $used = mysqli_fetch_assoc(dquery("select sum(qnt) as used\r\n                from tbl_used_key where keyid='" . $sql["id"] . "'"));
                if ($used["used"] == $sql["qnt"] || $sql["qnt"] == 1) {
                    dquery("UPDATE tbl_swkey set `status`=1 WHERE  id in (" . $sql["ids"] . ")");
                }
            }
            include_once ROOTDIR . "/includes/mail.fun.php";
            $adminmessage = "Key : " . $sql["key"] . " Used in " . $stype . " order \r\n\r\n                            Order ID: " . $oid;
            $to[0] = $config["config_admin_mail"];
            if ($stype == "imei" || $stype == "server") {
                $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editimeiorder&id=" . $oid) . "&title=" . base64_encode("IMEI Order") . "'>here</a>";
            } else {
                if ($stype == "file") {
                    $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editfileorder&id=" . $oid) . "&title=" . base64_encode("File Order") . "'>here</a>";
                } else {
                    if ($stype == "server") {
                        $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editserverorder&id=" . $oid) . "&title=" . base64_encode("Server Order") . "'>here</a>";
                    }
                }
            }
            $adminmessage .= "<br /> <br />\r\n            You can view order details from " . $here;
            sendNotification("system", "Auto Reply Code Used In " . strtoupper($stype) . " Order", $adminmessage, $to);
            if (1 < $qnt) {
            }
        }
    }
}

?>