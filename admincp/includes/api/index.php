<?php
/*
 *after.com
 * @ Release: 13/06/2023
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
include "api.fun.php";
checkDemoMode();
$username = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $username);
$action = preg_replace("/[^a-zA-Z]/i", "", $action);
$aid = preg_replace("/[^0-9]/i", "", $aid);
$credit = preg_replace("/[^0-9.]/i", "", $credit);
if ($aid) {
    $admin = mysqli_fetch_assoc(dquery("select * from tbl_admin \r\n    where id='" . $aid . "'"));
}
$password = md5(md5($pass) . "9486");
if ($password && !mysqli_num_rows(dquery("select * from tbl_admin where password='" . $password . "'"))) {
    exit;
}
if ($action == "dashboard") {
    $_OUT["imeinew"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_imei` \r\n    where user_can_c='0'"));
    $_OUT["imeipending"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_imei` \r\n    where user_can_c='1'"));
    $_OUT["filenew"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_file` \r\n    where user_can_c='0'"));
    $_OUT["filepending"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_file` \r\n    where user_can_c='1'"));
    $_OUT["servernew"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_server` \r\n    where user_can_c='0'"));
    $_OUT["serverpending"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_server` \r\n    where user_can_c='1'"));
    $_OUT["shopnew"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_product` \r\n    where user_can_c='0'"));
    $_OUT["shoppending"] = mysqli_num_rows(dquery("SELECT order_id FROM `tbl_order_product` \r\n    where user_can_c='1'"));
    if (!$admin["support_department"]) {
        $admin["support_department"] = 0;
    }
    $_OUT["IMEIVER"] = mysqli_num_rows(dquery("select * from tbl_order_imei\r\n   WHERE  (user_can_c =3 or user_can_c=4) and verified=1"));
    $_OUT["FILEVER"] = mysqli_num_rows(dquery("select * from tbl_order_file\r\n   WHERE  (user_can_c =3 or user_can_c=4) and verified=1"));
    $_OUT["SERVERVER"] = mysqli_num_rows(dquery("select * from tbl_order_server\r\n   WHERE  (user_can_c =3 or user_can_c=4) and verified=1"));
} else {
    if ($action == "clientlist") {
        $q = dquery("select id,username,email,credit_left,(select code from \r\n   tbl_currencies where id=default_currency) as code  from tblUsers where userstatus=0");
        while ($r = mysqli_fetch_assoc($q)) {
            $_OUT[] = $r;
        }
    } else {
        if ($action == "clientsearch") {
            $q = dquery("select id,username,email,credit_left,(select code from \r\n   tbl_currencies where id=default_currency) as code  from tblUsers where userstatus=0\r\n   and  username like '" . $filter . "%' or email like '" . $filter . "%'\r\n    limit 20");
            while ($r = mysqli_fetch_assoc($q)) {
                $_OUT[] = $r;
            }
        } else {
            if ($action == "adminunlimited") {
                if ($id) {
                    dquery("update tbl_admin set credit=''\r\n        where id='" . $id . "'");
                    $data["amount"] = $credit;
                    $data["aid"] = $id;
                    $data["date"] = date("Y-m-d");
                    $data["type"] = "Unlimited";
                    $data["desc"] = "Set From App";
                    $db->insert("tbl_admin_fund_log", $data);
                    $data = NULL;
                    echo "DONE";
                    exit;
                }
            } else {
                if ($action == "adminrebate") {
                    if ($id && $credit) {
                        $ad = mysqli_fetch_assoc(dquery("select credit from tbl_admin\r\n        where id='" . $id . "'"));
                        if ($credit <= $ad["credit"]) {
                            dquery("update tbl_admin set credit=credit-" . $credit . "\r\n            where id='" . $id . "'");
                            $data["amount"] = $credit;
                            $data["aid"] = $id;
                            $data["date"] = date("Y-m-d");
                            $data["type"] = "Rebate";
                            $data["desc"] = "Rebated From App";
                            $db->insert("tbl_admin_fund_log", $data);
                            $data = NULL;
                            echo "DONE";
                        } else {
                            echo "NOT";
                        }
                        exit;
                    }
                } else {
                    if ($action == "adminaddc") {
                        if ($id && $credit) {
                            dquery("update tbl_admin set credit=credit+" . $credit . "\r\n        where id='" . $id . "'");
                            $data["amount"] = $credit;
                            $data["aid"] = $id;
                            $data["date"] = date("Y-m-d");
                            $data["type"] = "Add";
                            $data["desc"] = "Added From App";
                            $db->insert("tbl_admin_fund_log", $data);
                            $data = NULL;
                            echo "DONE";
                            exit;
                        }
                    } else {
                        if ($action == "acceptimei") {
                            if ($oid) {
                                dquery("update tbl_order_imei set user_can_c=1\r\n        where order_id in (" . $oid . ")");
                                echo "DONE";
                                exit;
                            }
                        } else {
                            if ($action == "acceptserver") {
                                if ($oid) {
                                    dquery("update tbl_order_server set user_can_c=1\r\n        where order_id in (" . $oid . ")");
                                    echo "DONE";
                                    exit;
                                }
                            } else {
                                if ($action == "acceptfile") {
                                    if ($oid) {
                                        dquery("update tbl_order_file set user_can_c=1\r\n        where order_id in (" . $oid . ")");
                                        echo "DONE";
                                        exit;
                                    }
                                } else {
                                    if ($action == "department") {
                                        $q = mysqli_fetch_assoc(dquery("select support_department from tbl_admin\r\n    where id='" . $aid . "'"));
                                        $de = explode(",", $q["support_department"]);
                                        foreach ($de as $d) {
                                            $qa = mysqli_fetch_assoc(dquery("select id,department from tbl_support_department\r\n        where id='" . $d . "'"));
                                            $_OUT[] = $qa;
                                        }
                                    } else {
                                        if ($action == "filesearch") {
                                            $q = dquery("select order_id,(select username from tblUsers\r\n   where id=user_id) as username,file,user_can_c,(select service_name from tbl_services_file\r\n   where id=service_id) as service  from tbl_order_file where file like '" . $filter . "%'\r\n   or order_id='" . $filter . "'  limit 20");
                                            while ($r = mysqli_fetch_assoc($q)) {
                                                $_OUT[] = $r;
                                            }
                                        } else {
                                            if ($action == "serversearch") {
                                                $q = dquery("select order_id,(select username from tblUsers\r\n   where id=user_id) as username,user_can_c,server,\r\n   (select service_name from tbl_server_log\r\n   where id=service_id) as service \r\n    from tbl_order_server where order_id='" . $filter . "' limit 20");
                                                while ($r = mysqli_fetch_assoc($q)) {
                                                    $_OUT[] = $r;
                                                }
                                            } else {
                                                if ($action == "getadmin") {
                                                    $q = dquery("select id,username from tbl_admin where id!=1");
                                                    while ($r = mysqli_fetch_assoc($q)) {
                                                        $_OUT[] = $r;
                                                    }
                                                } else {
                                                    if ($action == "imeisearch") {
                                                        $q = dquery("select order_id,(select username from tblUsers\r\n   where id=user_id) as username,user_can_c,imei,(select service_name from tbl_services_imei\r\n   where id=service_id) as service  from tbl_order_imei \r\n   where imei like '" . $filter . "%'\r\n   or order_id='" . $filter . "' limit 20");
                                                        while ($r = mysqli_fetch_assoc($q)) {
                                                            $_OUT[] = $r;
                                                        }
                                                    } else {
                                                        if ($action == "acceptedserver") {
                                                            $_OUT = getAcceptedServer($limit);
                                                        } else {
                                                            if ($action == "newserver") {
                                                                $_OUT = getNewServer($limit);
                                                            } else {
                                                                if ($action == "acceptedfile") {
                                                                    $_OUT = getAcceptedFile($limit);
                                                                } else {
                                                                    if ($action == "newfile") {
                                                                        $_OUT = getNewFile($limit);
                                                                    } else {
                                                                        if ($action == "acceptedimei") {
                                                                            $_OUT = getAcceptedIMEI($limit);
                                                                        } else {
                                                                            if ($action == "imeidetail") {
                                                                                if ($oid) {
                                                                                    $_OUT = mysqli_fetch_assoc(dquery("select order_id,imei,(select service_name\r\n        from tbl_services_imei where id=service_id) as service,(select username from\r\n        tblUsers where id=user_id) as user,concat(credit-discount) as credit,reply,date,\r\n        (select code from tbl_currencies where id=(select default_currency from tblUsers\r\n        where id=user_id)) as code,user_can_c\r\n        from tbl_order_imei where order_id='" . $oid . "'"));
                                                                                }
                                                                            } else {
                                                                                if ($action == "filedetail") {
                                                                                    if ($oid) {
                                                                                        $_OUT = mysqli_fetch_assoc(dquery("select order_id,user_can_c,file,(select service_name\r\n        from tbl_services_file where id=service_id) as service,(select reply_type\r\n        from tbl_services_file where id=service_id) as type,(select username from\r\n        tblUsers where id=user_id) as user,concat(credit-discount) as credit,reply,date,\r\n        (select code from tbl_currencies where id=(select default_currency from tblUsers\r\n        where id=user_id)) as code\r\n        from tbl_order_file where order_id='" . $oid . "'"));
                                                                                    }
                                                                                } else {
                                                                                    if ($action == "serverdetail") {
                                                                                        if ($oid) {
                                                                                            $_OUT = mysqli_fetch_assoc(dquery("select order_id,server,(select service_name\r\n        from tbl_server_log where id=service_id) as service,\r\n        (select username from\r\n        tblUsers where id=user_id) as user,concat(credit-discount) as credit,reply,date,\r\n        (select code from tbl_currencies where id=(select default_currency from tblUsers\r\n        where id=user_id)) as code\r\n        from tbl_order_server where order_id='" . $oid . "'"));
                                                                                        }
                                                                                    } else {
                                                                                        if ($action == "replyserver") {
                                                                                            include ROOTDIR . "/includes/serverservices.fun.php";
                                                                                            $_OUT = replySuccessServer(md5($oid), $reply, $aid);
                                                                                        } else {
                                                                                            if ($action == "rejectserver") {
                                                                                                include ROOTDIR . "/includes/serverservices.fun.php";
                                                                                                $_OUT = rejectServer(md5($oid), $reply, $aid);
                                                                                            } else {
                                                                                                if ($action == "rejectserverb") {
                                                                                                    include ROOTDIR . "/includes/serverservices.fun.php";
                                                                                                    $is = explode(",", $oid);
                                                                                                    foreach ($is as $if) {
                                                                                                        $_OUT = rejectServer(md5($if), $reply, $aid);
                                                                                                    }
                                                                                                    echo "DONE";
                                                                                                    exit;
                                                                                                } else {
                                                                                                    if ($action == "replyimei") {
                                                                                                        include ROOTDIR . "/includes/imeiservices.fun.php";
                                                                                                        $_OUT = replySuccessIMEI(md5($oid), $reply, $aid);
                                                                                                    } else {
                                                                                                        if ($action == "rejectimei") {
                                                                                                            include ROOTDIR . "/includes/imeiservices.fun.php";
                                                                                                            $_OUT = rejectIMEI(md5($oid), $reply, $aid);
                                                                                                        } else {
                                                                                                            if ($action == "rejectimeib") {
                                                                                                                include ROOTDIR . "/includes/imeiservices.fun.php";
                                                                                                                $is = explode(",", $oid);
                                                                                                                foreach ($is as $if) {
                                                                                                                    $_OUT = rejectIMEI(md5($if), $reply, $aid);
                                                                                                                }
                                                                                                                echo "DONE";
                                                                                                                exit;
                                                                                                            } else {
                                                                                                                if ($action == "rejectfileb") {
                                                                                                                    include ROOTDIR . "/includes/fileservices.fun.php";
                                                                                                                    $is = explode(",", $oid);
                                                                                                                    foreach ($is as $if) {
                                                                                                                        $_OUT = rejectFile(md5($if), $reply, $aid);
                                                                                                                    }
                                                                                                                    echo "DONE";
                                                                                                                    exit;
                                                                                                                } else {
                                                                                                                    if ($action == "rejectfile") {
                                                                                                                        include ROOTDIR . "/includes/fileservices.fun.php";
                                                                                                                        $_OUT = rejectFile(md5($oid), $reply, $aid);
                                                                                                                    } else {
                                                                                                                        if ($action == "replyfile") {
                                                                                                                            include ROOTDIR . "/includes/fileservices.fun.php";
                                                                                                                            $_OUT = replySuccessFile(md5($oid), $reply, $aid);
                                                                                                                        } else {
                                                                                                                            if ($action == "newimei") {
                                                                                                                                $_OUT = getNewIMEI($limit);
                                                                                                                            } else {
                                                                                                                                if ($action == "rebatecredit") {
                                                                                                                                    $_SESSION["adminid"] = $aid;
                                                                                                                                    $adminAddPayment = true;
                                                                                                                                    global $adminAddPayment;
                                                                                                                                    $_OUT = rebateAdminCredit($uid, $credit, $sell);
                                                                                                                                } else {
                                                                                                                                    if ($action == "admins") {
                                                                                                                                        $u = mysqli_fetch_assoc(dquery("select id,credit as credit_left,\r\n    username\r\n    from tbl_admin where id='" . $uid . "'"));
                                                                                                                                        $u["code"] = $config["base_currency"];
                                                                                                                                        $_OUT = $u;
                                                                                                                                    } else {
                                                                                                                                        if ($action == "clients") {
                                                                                                                                            $u = mysqli_fetch_assoc(dquery("select id,credit_left,\r\n    usertype,email,sell_credit_limit,(select code\r\n    from tbl_currencies where id=default_currency) as code,username\r\n    from tblUsers where id='" . $uid . "'"));
                                                                                                                                            $_OUT = $u;
                                                                                                                                        } else {
                                                                                                                                            if ($action == "addcredit") {
                                                                                                                                                $_SESSION["adminid"] = $aid;
                                                                                                                                                $adminAddPayment = true;
                                                                                                                                                global $adminAddPayment;
                                                                                                                                                $_OUT = addAdminCredit($uid, $credit, $sell, $generate == "true" ? 1 : 0, $paid == "true" ? 1 : 0);
                                                                                                                                            } else {
                                                                                                                                                if ($action == "search") {
                                                                                                                                                    $io = dquery("select order_id,imei,(select service_name from\r\n   tbl_services_imei where id=service_id) as service,CONCAT('imei') as searchtype\r\n   from tbl_order_imei where ( `imei` LIKE '%" . $search . "%' AND LENGTH('" . $search . "')>10 ) \r\n   or order_id='" . $search . "' limit 5");
                                                                                                                                                    while ($rio = mysqli_fetch_assoc($io)) {
                                                                                                                                                        $_OUT[] = $rio;
                                                                                                                                                    }
                                                                                                                                                    $io = dquery("select order_id,file,(select service_name from\r\n   tbl_services_file where id=service_id) as service,CONCAT('file') as searchtype\r\n     from tbl_order_file where  order_id='" . $search . "' limit 5");
                                                                                                                                                    while ($rio = mysqli_fetch_assoc($io)) {
                                                                                                                                                        $_OUT[] = $rio;
                                                                                                                                                    }
                                                                                                                                                    $io = dquery("select order_id,(select service_name from\r\n   tbl_server_log where id=service_id) as service,CONCAT('server') as searchtype\r\n     from tbl_order_server where  order_id='" . $search . "' limit 5");
                                                                                                                                                    while ($rio = mysqli_fetch_assoc($io)) {
                                                                                                                                                        $_OUT[] = $rio;
                                                                                                                                                    }
                                                                                                                                                    $io = dquery("select id,username,email,CONCAT('client') as searchtype from tblUsers \r\n   where username like '" . $search . "%' or email like '" . $search . "%' limit 5");
                                                                                                                                                    while ($rio = mysqli_fetch_assoc($io)) {
                                                                                                                                                        $_OUT[] = $rio;
                                                                                                                                                    }
                                                                                                                                                    $io = dquery("select *,CONCAT('ticket') as searchtype from\r\n    tbl_support_tickets where tid='" . $search . "' ORDER BY id ASC limit 5");
                                                                                                                                                    while ($rio = mysqli_fetch_assoc($io)) {
                                                                                                                                                        $_OUT[] = $rio;
                                                                                                                                                    }
                                                                                                                                                } else {
                                                                                                                                                    if ($action == "ticket") {
                                                                                                                                                        $sql = dquery("select * from tbl_support_tickets where tid='" . $tid . "' ORDER BY id ASC");
                                                                                                                                                        while ($r = mysqli_fetch_assoc($sql)) {
                                                                                                                                                            $_OUT[] = $r;
                                                                                                                                                        }
                                                                                                                                                    } else {
                                                                                                                                                        if ($action == "ticketanswer") {
                                                                                                                                                            include_once ROOTDIR . "/includes/support.fun.php";
                                                                                                                                                            $TIC = mysqli_fetch_assoc(dquery("select * from tbl_support_tickets\r\n    where tid='" . $tid . "'"));
                                                                                                                                                            $ticket["message"] = $reply;
                                                                                                                                                            $ticket["subject"] = $TIC["subject"];
                                                                                                                                                            ticket($TIC["tid"], $TIC["uid"], $aid, $TIC["name"], $TIC["email"], $TIC["did"], "", $ticket);
                                                                                                                                                        } else {
                                                                                                                                                            if ($action == "addcredit") {
                                                                                                                                                                $_SESSION["adminid"] = $aid;
                                                                                                                                                                $adminAddPayment = true;
                                                                                                                                                                global $adminAddPayment;
                                                                                                                                                                $_OUT = addAdminCredit($uid, $credit, $sell, $generate == "true" ? 1 : 0, $paid == "true" ? 1 : 0);
                                                                                                                                                            } else {
                                                                                                                                                                if ($action == "waitingticket") {
                                                                                                                                                                    if ($d) {
                                                                                                                                                                        $admin["support_department"] = $d;
                                                                                                                                                                    } else {
                                                                                                                                                                        if (!$admin["support_department"]) {
                                                                                                                                                                            $admin["support_department"] = 0;
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                    $sql = dquery("SELECT *\r\nFROM tbl_support_tickets \r\nwhere (sid=1 or sid=4 ) AND did IN (" . $admin["support_department"] . ")\r\nGROUP BY tid");
                                                                                                                                                                    while ($r = mysqli_fetch_assoc($sql)) {
                                                                                                                                                                        $_OUT[] = $r;
                                                                                                                                                                    }
                                                                                                                                                                } else {
                                                                                                                                                                    if ($action == "openticket") {
                                                                                                                                                                        if ($d) {
                                                                                                                                                                            $admin["support_department"] = $d;
                                                                                                                                                                        } else {
                                                                                                                                                                            if (!$admin["support_department"]) {
                                                                                                                                                                                $admin["support_department"] = 0;
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                        $sql = dquery("SELECT *\r\nFROM tbl_support_tickets \r\nwhere sid=1  AND did IN (" . $admin["support_department"] . ") GROUP BY tid");
                                                                                                                                                                        while ($r = mysqli_fetch_assoc($sql)) {
                                                                                                                                                                            $_OUT[] = $r;
                                                                                                                                                                        }
                                                                                                                                                                    } else {
                                                                                                                                                                        if ($action == "getcurrency") {
                                                                                                                                                                            $c = dquery("select id,code,`default` from tbl_currencies");
                                                                                                                                                                            while ($r = mysqli_fetch_assoc($c)) {
                                                                                                                                                                                $_OUT[] = $r["id"] . "___" . $r["code"] . "___" . $r["default"];
                                                                                                                                                                            }
                                                                                                                                                                        } else {
                                                                                                                                                                            if ($action == "addclient") {
                                                                                                                                                                                include ROOTDIR . "/includes/clients.fun.inc.php";
                                                                                                                                                                                $flager = false;
                                                                                                                                                                                if ($_SESSION["system_default_currency"]["id"] != $currency) {
                                                                                                                                                                                    $convtrtc = convertCurrency($creditleft, $currency, $_SESSION["system_default_currency"]["id"]);
                                                                                                                                                                                } else {
                                                                                                                                                                                    $convtrtc = $creditleft;
                                                                                                                                                                                }
                                                                                                                                                                                if (0 < $convtrtc && $admin["credit"] != "") {
                                                                                                                                                                                    if ($admin["credit"] < $convtrtc) {
                                                                                                                                                                                        $_OUT["STATUS"] = "ERROR";
                                                                                                                                                                                        $_OUT["MSG"] = $LNG["notengouthcredit"];
                                                                                                                                                                                    } else {
                                                                                                                                                                                        $flager = true;
                                                                                                                                                                                    }
                                                                                                                                                                                }
                                                                                                                                                                                $status = 0;
                                                                                                                                                                                $validator["username"] = [$username, true];
                                                                                                                                                                                $validator["password"] = [$password, true];
                                                                                                                                                                                $validator["email"] = [$email, true];
                                                                                                                                                                                $validator["first_name"] = [$firstname, false];
                                                                                                                                                                                $validator["last_name"] = [$lastname, false];
                                                                                                                                                                                $validator["usertype"] = [$type, false];
                                                                                                                                                                                $validator["userstatus"] = [$status, false];
                                                                                                                                                                                $validator["imei_service_access"] = [$imei, false];
                                                                                                                                                                                $validator["file_service_access"] = [$file, false];
                                                                                                                                                                                $validator["server_log_access"] = [$server, false];
                                                                                                                                                                                if ($error = validateProfiles($validator)) {
                                                                                                                                                                                    $_OUT["STATUS"] = "ERROR";
                                                                                                                                                                                    $_OUT["MSG"] = $error;
                                                                                                                                                                                }
                                                                                                                                                                                if ($error = addNewUser($validator, "", "ADMIN")) {
                                                                                                                                                                                    $_OUT["STATUS"] = "ERROR";
                                                                                                                                                                                    $_OUT["MSG"] = $error;
                                                                                                                                                                                }
                                                                                                                                                                                if (!$error) {
                                                                                                                                                                                    $_OUT["STATUS"] = "SUCCESS";
                                                                                                                                                                                    $_OUT["MSG"] = "User created successfully";
                                                                                                                                                                                    $result = dquery("select id from tblUsers where username='" . $username . "'");
                                                                                                                                                                                    $row = mysqli_fetch_assoc($result);
                                                                                                                                                                                    if ($creditleft != "0") {
                                                                                                                                                                                        if ($flager) {
                                                                                                                                                                                            dquery("update tbl_admin set credit=credit-" . $convtrtc . " \r\n                where id='" . $aid . "'");
                                                                                                                                                                                        }
                                                                                                                                                                                        if (addCredit($row["id"], $creditleft, $sendmail)) {
                                                                                                                                                                                            $_OUT["MSG"] .= "<li>" . $LNG["creditsuccessfullyadded"] . "</li>";
                                                                                                                                                                                        }
                                                                                                                                                                                        if ($type == "1" && addSellCredit($row["id"], $creditleft, $sendmail)) {
                                                                                                                                                                                            $_OUT["MSG"] .= "<li>" . $LNG["creditsuccessfullyadded"] . "</li>";
                                                                                                                                                                                        }
                                                                                                                                                                                    }
                                                                                                                                                                                }
                                                                                                                                                                            } else {
                                                                                                                                                                                if ($username && $password) {
                                                                                                                                                                                    if ($reply = getLogin($username, $password)) {
                                                                                                                                                                                        $_OUT = $reply;
                                                                                                                                                                                    }
                                                                                                                                                                                } else {
                                                                                                                                                                                    $_OUT["STATUS"] = "ERROR";
                                                                                                                                                                                    $_OUT["MSG"] = "Username and Password required";
                                                                                                                                                                                }
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($_OUT);

?>