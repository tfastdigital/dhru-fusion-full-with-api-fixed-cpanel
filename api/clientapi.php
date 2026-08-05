<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
define("SSLON", true);
require "../comm.php";
require "../includes/fun.inc.php";
require "../includes/client.area.inc.php";
if ($action) {
    $_OUT["STATUS"] = "success";
    $_OUT["DISPLAY_MSG"] = $msg;
    $_OUT["REDIRECT"] = $redirect;
    if ($action == "menu") {
        $m = getMenuGroupArray(0, 1);
        $_OUT["ARRAY"] = $m;
    }
    if ($action == "login" && $username && $password) {
        if (!$passenc) {
            $passenc = "9486";
        }
        $password = md5(md5($password) . $passenc);
        if (mysqli_num_rows(dquery("select id from tblUsers where \r\n            (username='" . $username . "' or email='" . $username . "')\r\n            and password='" . $password . "' and userstatus=0"))) {
            $u = mysqli_fetch_assoc(dquery("select id,credit_left,email,credit_used,first_name,\r\n                    (select code from tbl_currencies where id=default_currency) as code\r\n                     from tblUsers where (username='" . $username . "' or email='" . $username . "')\r\n                    and password='" . $password . "'"));
            if ($registration) {
                dquery("ALTER TABLE  `tblUsers` ADD `gcmid` VARCHAR(555) NOT NULL");
                dquery("update tblUsers set gcmid='" . $registration . "' where\r\n                    id='" . $u["id"] . "'");
                if ($config["googlesenderid"]) {
                    $_OUT["GCM"] = $config["googlesenderid"];
                }
            }
            if ($action == "login") {
                $_OUT["CREDIT"] = round($u["credit_left"], $precision);
                $_OUT["EMAIL"] = md5(strtolower(trim($u["email"])));
                $_OUT["CREDITU"] = $u["credit_used"] ? $u["credit_used"] : 0;
                $_OUT["FIRST"] = $u["first_name"] ? $u["first_name"] : "";
                $_OUT["LAST"] = $u["last_name"] ? $u["last_name"] : "";
                $_OUT["UID"] = $u["id"];
                $_OUT["version"] = 1;
                $_OUT["EMAILT"] = $u["email"];
                $_OUT["CURRENCY"] = $u["code"];
            }
            $_OUT["STATUS"] = "success";
        } else {
            dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 \r\n                                                        WHERE (username='" . $username . "' or email='" . $username . "')");
            if (mysqli_num_rows(dquery("SELECT `login_failed_atoms` FROM \r\n                `tblUsers` WHERE username='" . $username . "'\r\n                AND `login_failed_atoms` > " . $config["MaxLoginFailedAttempts"]))) {
                $mail_ver["blockreson"] = "Automatically block (" . $config["MaxLoginFailedAttempts"] . " failed login attempts) from Apps";
                dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,\r\n                    `userstatus`='1',`login_failed_atoms`='0' WHERE (username='" . $username . "' or email='" . $username . "') ");
                require_once ROOTDIR . "/includes/mail.fun.php";
                sendMail(5, $data["id"], "", $mail_ver);
            }
            $_OUT["STATUS"] = "error";
            $_OUT["DISPLAY_MSG"] = "Wrong Username or Password";
        }
    }
    if ($action == "imeiservices") {
        $u = mysqli_fetch_assoc(dquery("select usertype,reseller_id,\r\n        default_currency,\r\n        (select rate from tbl_currencies where id=default_currency) cur_rate,\r\n        imei_service_access,imei_services\r\n        from tblUsers where id=" . $uid));
        if ($u["imei_service_access"]) {
            if ($u["imei_services"] != "ALL") {
                $where_service = " AND `id` IN (" . $u["imei_services"] . ") \r\n               and active=1";
            }
            $q = dquery("select id,service_name,credit from \r\n            tbl_services_imei where\r\n            active='1' " . $where_service);
            while ($r = mysqli_fetch_assoc($q)) {
                $r["service_name"] = html_entity_decode($r["service_name"]);
                $_OUT["ARRAY"][] = $r;
            }
        }
    }
    if ($action == "imeigroup") {
        $u = mysqli_fetch_assoc(dquery("select imei_service_access,imei_services\r\n    from tblUsers where id='" . $uid . "'"));
        if ($u["imei_service_access"]) {
            if ($u["imei_services"] == "ALL") {
                $g = dquery("select id,group_name from tbl_imei_group\r\n             where active='1'");
                while ($rg = mysqli_fetch_assoc($g)) {
                    if (mysqli_num_rows(dquery("select id \r\n                from tbl_services_imei where group_id='" . $rg["id"] . "'\r\n                 and active='1'"))) {
                        $_OUT["ARRAY"][] = $rg;
                    }
                }
            } else {
                $g = dquery("select group_id as id,(select group_name from tbl_imei_group\r\n            where id=group_id) as group_name from tbl_services_imei,\r\n            tbl_imei_group where tbl_services_imei.group_id=tbl_imei_group.id and \r\n            tbl_imei_group.active='1' and tbl_services_imei.id in \r\n            (" . $u["imei_services"] . ") group by group_id");
                while ($rg = mysqli_fetch_assoc($g)) {
                    if (mysqli_num_rows(dquery("select id \r\n                from tbl_services_imei where group_id='" . $rg["id"] . "' and active='1'\r\n                 and id in (" . $u["imei_services"] . ")"))) {
                        $_OUT["ARRAY"][] = $rg;
                    }
                }
            }
        }
    }
    if ($action == "placeorder") {
        require ROOTDIR . "/includes/clients.fun.inc.php";
        global $_ClientsDetails;
        $_SESSION["uid"] = $user;
        $_ClientsDetails = getClientsDetails($user);
        if ($custom) {
            $custom = explode("__", $custom);
            foreach ($custom as $k => $vs) {
                $csk = explode("_", $vs);
                $customfield[$csk[0]] = $csk[1];
            }
        }
        require_once ROOTDIR . "/includes/imeiservices.fun.php";
        $serviceDetails = getIMEIServices("", md5($service), $user, true);
        $order = explode("&amp;", $order);
        foreach ($order as $k => $v) {
            $data = explode("=", $v);
            ${$data[0]} = $data[1];
        }
        $imei_mobile = str_replace("%0D%0A", "\n", $imei_mobile);
        $id = md5($service);
        $imei = explode("\n", $imei_mobile);
        if ($config["duplicateimei"]) {
            foreach ($imei as $i) {
                if (checkRepeatIMEI($_SESSION["uid"], $i)) {
                    $error = $lng_languag["duplicateimeientry"];
                    $_OUT[] = $error;
                }
            }
        }
        if (!$_OUT) {
            if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], false, false)) {
                $error = str_replace("</li>", ",", $error);
                $error = str_replace("<li>", "", $error);
                $error = str_replace("error:", "", $error);
                $_OUT = explode(",", $error);
            } else {
                if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails)) {
                    $error = str_replace("</li>", ",", $error);
                    $error = str_replace("<li>", "", $error);
                    if (deregi("success", $error)) {
                        foreach ($imei as $i) {
                            dquery("update tbl_order_imei set tmp_status='9' where imei='" . $i . "'\r\n                    and user_id='" . $user . "' and service_id='" . $service . "' and user_can_c=0");
                        }
                        $error = str_replace("success:", "Success:", $error);
                        if ($format) {
                            $_OUT["status"] = 1;
                        }
                    }
                    $error = str_replace("error:", "", $error);
                    $_OUT = explode(",", $error);
                }
            }
        }
    }
    $OUT["REPLY"] = $_OUT;
    echo json_encode($OUT["REPLY"]);
}

?>