<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

session_name("DHRUFUSION");
session_set_cookie_params(0, "/", NULL, false, true);
session_start();
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
define("DHRUSOFT", true);
$starting = time();
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (file_exists("../../../configs/config.php")) {
    require "../../../configs/config.php";
}
require "../../../comm.php";
$adms = mysqli_fetch_assoc(dquery("select template from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
if ($adms["template"] == "defaultfile") {
    $IsFileOnly = true;
}
if ($_GET["value"]) {
    $_POST["value"] = $_GET["value"];
}
$input = descape(strip_tags($_POST["value"]));
if ($input) {
    $input = str_replace(":", "", $input);
    $input = trim($input);
    $limit = 10;
    $limit2 = 10;
    $listservicenamelimit = 4;
    $SFLAG = 1;
    if (15 < $input && !$OnlyEcommerce && deregi(",", $input)) {
        $input = str_replace(" ", "", $input);
        $query = "SELECT `order_id`,`imei`,`user_id`,`user_can_c`,encnum FROM `tbl_order_imei`\r\n    WHERE find_in_set(imei,'" . $input . "') \r\n     limit " . $limit2;
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
        }
    }
    if (is_numeric($input) && strlen(trim($input)) == 15 && !$OnlyEcommerce) {
        $query = "SELECT `order_id`,`imei`,`user_id`,`user_can_c`,encnum  FROM `tbl_order_imei`  WHERE (`imei`='" . $input . "')  limit " . $limit2;
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
        }
    } else {
        if (strpos($input, "@") !== false) {
            $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE `username`\r\n  LIKE '" . $input . "%' OR `email` LIKE '" . $input . "%' OR `id` ='" . $input . "' or `first_name`\r\n   like '" . $input . "%' or \r\n  `last_name` like '" . $input . "%' order by username limit " . $limit . " ";
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], $precision) . " " . $noticia["code"]];
            }
        } else {
            $part = explode(":", $input);
            $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n    (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE `username`\r\n    LIKE '" . $input . "%' OR `email` LIKE '" . $input . "%' OR `id` ='" . $input . "' or `first_name` like '" . $input . "%' or \r\n    `last_name` like '" . $input . "%' order by username limit " . $limit . " ";
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], $precision) . " " . $noticia["code"]];
            }
            if (0 < count($uResults)) {
                foreach ($uResults as $us) {
                    if ($us["user"] == $input || $us["email"] == $input) {
                        $uids = $us["id"];
                        $result = dquery("select * from tbl_order_imei\r\n            where user_id='" . $uids . "' order by order_id desc limit 5");
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
                        }
                    }
                }
            }
            if (strtolower($part[0]) == "u" && $part[1] != "") {
                $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n         (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE \r\n         credit_left>" . $part[1] . " order by username limit " . $limit . " ";
                $result = dquery($query);
                while ($noticia = mysqli_fetch_assoc($result)) {
                    $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], $precision) . " " . $noticia["code"]];
                }
            } else {
                if (strtolower($input) == "inactive") {
                    $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n     (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE \r\n     userstatus='2' order by username limit " . $limit . " ";
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], $precision) . " " . $noticia["code"]];
                    }
                }
            }
            $query = "SELECT `id`,`username`,`firstname`,`lastname`,`email` \r\nFROM `tbl_admin` WHERE `username` LIKE '" . $input . "%' OR `email`\r\n LIKE '" . $input . "%' OR `id` ='" . $input . "' order by username limit " . $limit . " ";
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $admnResults[] = ["id" => $noticia["id"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["firstname"]), "last" => htmlspecialchars($noticia["lastname"]), "email" => htmlspecialchars($noticia["email"])];
            }
            if ($SFLAG) {
                $query = "SELECT * FROM `tbl_return_request` WHERE `uid` LIKE '" . $input . "%' limit " . $limit . " ";
                $result = dquery($query);
                while ($noticia = mysqli_fetch_assoc($result)) {
                    if ($noticia["status"] == 0) {
                        $status = "Requested";
                    } else {
                        if ($noticia["status"] == 1) {
                            $status = "Authorized";
                        } else {
                            if ($noticia["status"] == 2) {
                                $status = "Declined";
                            } else {
                                if ($noticia["status"] == 3) {
                                    $status = "Completed";
                                } else {
                                    if ($noticia["status"] == 3) {
                                        $status = "Canceled";
                                    }
                                }
                            }
                        }
                    }
                    $Returns[] = ["uid" => $noticia["uid"], "date" => $noticia["date"], "status" => $status];
                }
                $parts = explode("edit", $_POST["value"]);
                if (is_numeric($parts[1]) && strlen($parts[1]) < 15) {
                    echo "      <script>\r\nload_page('edituser.editimeiorder&id=";
                    echo $parts[1];
                    echo "','IMEI Order ";
                    echo $parts[1];
                    echo "','";
                    echo $token;
                    echo "');\r\n      </script>\r\n      ";
                    exit;
                }
                if (is_numeric($parts[1])) {
                    $oid = mysqli_fetch_assoc(dquery("select order_id from tbl_order_imei\r\n    where imei='" . $parts[1] . "'\r\n    order by order_id desc limit 1"));
                    echo "      <script>\r\nload_page('edituser.editimeiorder&id=";
                    echo $oid["order_id"];
                    echo "','IMEI Order ";
                    echo $oid["order_id"];
                    echo "','";
                    echo $token;
                    echo "');\r\n      </script>\r\n      ";
                    exit;
                }
                if (strpos($_POST["value"], "edit") === 0 && $parts[1]) {
                    $un = mysqli_fetch_assoc(dquery("select id from tblUsers\r\n    where email='" . $parts[1] . "' or username='" . $parts[1] . "'"));
                    if ($un["id"]) {
                        echo "        <script>\r\nload_page('edituser&id=";
                        echo $un["id"];
                        echo "','";
                        echo $parts[1];
                        echo "','";
                        echo $token;
                        echo "')\r\n        </script>\r\n        ";
                        exit;
                    }
                }
                $parts = explode("stat", $_POST["value"]);
                if ($parts[1]) {
                    $un = mysqli_fetch_assoc(dquery("select id from tblUsers\r\n    where email='" . $parts[1] . "' or username='" . $parts[1] . "'"));
                    if ($un["id"]) {
                        echo "        <script>\r\nload_page('edituser&laoddefaultpage=edituser.statement.php&id=";
                        echo $un["id"];
                        echo "','";
                        echo $parts[1];
                        echo "','";
                        echo $token;
                        echo "')\r\n        </script>\r\n        ";
                        exit;
                    }
                }
                $parts = explode("credit", $_POST["value"]);
                if ($parts[1]) {
                    $un = mysqli_fetch_assoc(dquery("select id from tblUsers\r\n    where email='" . $parts[1] . "' or username='" . $parts[1] . "'"));
                    if ($un["id"]) {
                        echo "        <script>\r\nload_page('edituser&laoddefaultpage=edituser.accountfinancial.php&id=";
                        echo $un["id"];
                        echo "','";
                        echo $parts[1];
                        echo "','";
                        echo $token;
                        echo "')\r\n        </script>\r\n        ";
                        exit;
                    }
                }
                $parts = explode("inv", $_POST["value"]);
                if (is_numeric($parts[1])) {
                    echo "        <script>\r\nload_page('edituser.editinvoice&id=";
                    echo $parts[1];
                    echo "','";
                    echo $parts[1];
                    echo "','";
                    echo $token;
                    echo "')\r\n        </script>\r\n        ";
                    exit;
                }
                $parts = explode("order", $_POST["value"]);
                if ($parts[1]) {
                    $un = mysqli_fetch_assoc(dquery("select id from tblUsers\r\n    where email='" . $parts[1] . "' or username='" . $parts[1] . "'"));
                    if ($un["id"]) {
                        echo "        <script>\r\nload_page('edituser&laoddefaultpage=edituser.imeiorder.php&id=";
                        echo $un["id"];
                        echo "','";
                        echo $parts[1];
                        echo "','";
                        echo $token;
                        echo "')\r\n        </script>\r\n        ";
                        exit;
                    }
                }
                $parts = explode("reply", $_POST["value"]);
                if (is_numeric($parts[1])) {
                    $order = mysqli_fetch_assoc(dquery("select order_id,(select\r\n    service_name from tbl_services_imei where id=service_id) as service,\r\n    (select username from tblUsers where id=user_id) as user,imei,date\r\n    from tbl_order_imei where order_id='" . $parts[1] . "'\r\n    and ( user_can_c=0 or user_can_c=1)"));
                    if ($order["order_id"]) {
                        echo "   <div class=\"sidearrow\"></div>\r\n<div class=\"resultcontent notclick\">\r\n<h1>IMEI : ";
                        echo $order["order_id"];
                        echo "</h1>\r\n<input type=\"hidden\" name=\"save_token\" id=\"save_token\"\r\nvalue=\"";
                        echo sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2");
                        echo "\" />\r\n<div class=\"search-box-result\">\r\n    <div class=\"src-content\">\r\n          <div class=\"scr_result\">\r\n\r\n<span style=\"padding:7px 5px;\">Service : ";
                        echo $order["service"];
                        echo "</span>\r\n<span style=\"padding:7px 5px;\">Date : ";
                        echo $order["date"];
                        echo "</span>\r\n<span style=\"padding:7px 5px;\">User : ";
                        echo $order["user"];
                        echo " </span>\r\n<span style=\"padding:7px 5px;\">Reply:\r\n<input type=\"text\" name=\"reply\" class=\"quickreply\" id=\"fastreply\"\r\nstyle=\"padding: 5px;\" value=\"\" />\r\n<input value=\"Reply\" id=\"btnedituser\" class=\"button quickreply\"\r\ntype=\"button\" onclick=\"ReplyIMEI(";
                        echo $order["order_id"];
                        echo ",'";
                        echo md5($order["order_id"]);
                        echo "');\" />\r\n</span>\r\n          </div>\r\n    </div>\r\n</div>\r\n</div>\r\n\r\n   ";
                    }
                    exit;
                }
                if (!$OnlyEcommerce && count($uResults) == 0) {
                    if (!$part[1]) {
                        $part[1] = "9999999999999999999999";
                    }
                    if (!$IsFileOnly) {
                        if (is_numeric($input)) {
                            $qpart = " `order_id`='" . $input . "'";
                        } else {
                            $qpart = " `encnum`='" . $input . "'";
                        }
                        if (10 < strlen($input)) {
                            $MERGE = " OR (`imei` LIKE '%" . $input . "%')";
                        }
                        if ($part[0] == "imei") {
                            $MERGE2 = "  OR ('" . $part[0] . "'='imei'\r\n             AND ( order_id=" . $part[1] . " or encnum=" . $part[1] . " ) )";
                        }
                        $query = "SELECT `order_id`,`imei`,`user_can_c`,`user_id`,encnum \r\n        FROM `tbl_order_imei` WHERE \r\n        (" . $qpart . " " . $MERGE . ") " . $MERGE2 . "\r\n        AND `user_can_c`<'5' order by order_id desc limit " . $limit2;
                        $result = dquery($query);
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
                        }
                    }
                    $query = "SELECT `order_id`,substring_index(file,',',1) AS files,`user_id`     FROM `tbl_order_file` WHERE (`order_id`='" . $input . "' OR substring_index(file,',',1) LIKE '%" . $input . "%'\r\n    OR ('" . $part[0] . "'='file' AND order_id=" . $part[1] . "))  limit " . $limit2;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $fResults[$noticia["order_id"]] = ["id" => $noticia["order_id"], "file" => $noticia["files"], "user_id" => $noticia["user_id"]];
                    }
                    if (!$IsFileOnly) {
                        $query = "SELECT `order_id`,`user_id`,(select service_name from tbl_server_log WHERE id=service_id) as service FROM `tbl_order_server` WHERE (`order_id`='" . $input . "' OR ('" . $part[0] . "'='server' AND order_id=" . $part[1] . ")) \r\n        limit " . $limit2;
                        $result = dquery($query);
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $sResults[] = ["id" => $noticia["order_id"], "user_id" => $noticia["user_id"], "service" => $noticia["service"]];
                        }
                    }
                }
                if (!$IsFileOnly && count($uResults) == 0) {
                    $query = "SELECT `order_id`,`user_id`,    (select service_name from tbl_products WHERE id=service_id) item FROM `tbl_order_product` WHERE     (`order_id`='" . $input . "' OR ('" . $part[0] . "'='shop' AND order_id='" . $part[1] . "'))\r\n    AND `user_can_c`<'5' limit " . $limit2;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $pResults[] = ["id" => $noticia["order_id"], "user_id" => $noticia["user_id"], "item" => $noticia["item"]];
                    }
                }
                $uid = mysqli_fetch_assoc(dquery("SELECT `id` FROM `tblUsers`\r\n WHERE `username` LIKE '%" . $input . "%'"));
                $uid = $uid["id"];
                if (!$part[1]) {
                    $part[1] = "9999999999999999999999";
                }
                if (count($uResults) == 0) {
                    $query = "SELECT `id`,`userid`,date,total FROM `tbl_invoices` WHERE  (`id`='" . $input . "' OR ('" . $part[0] . "'='inv' AND id=" . $part[1] . ") ) \r\n or (id in (select invoiceid from tbl_transaction where transid='" . $input . "'))\r\n limit " . $limit;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $uid = mysqli_fetch_assoc(dquery("SELECT `username`,\r\n     (SELECT code FROM tbl_currencies WHERE id=default_currency) as code\r\n      FROM `tblUsers` WHERE `id`='" . $noticia["userid"] . "'"));
                        $invResults[] = ["id" => $noticia["id"], "userid" => $noticia["user_id"], "user" => $uid["username"], "date" => $noticia["date"], "total" => $noticia["total"] . " " . $uid["code"]];
                    }
                }
                if (strtolower($input) == "unpaid") {
                    $query = "SELECT `id`,`userid`,date,total FROM `tbl_invoices` WHERE\r\n    `status`='Unpaid' limit " . $limit;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $uid = mysqli_fetch_assoc(dquery("SELECT `username`,\r\n        (SELECT code FROM tbl_currencies WHERE id=default_currency) as code\r\n        FROM `tblUsers` WHERE `id`='" . $noticia["userid"] . "'"));
                        $invResults[] = ["id" => $noticia["id"], "userid" => $noticia["user_id"], "user" => $uid["username"], "date" => $noticia["date"], "total" => $noticia["total"] . " " . $uid["code"]];
                    }
                } else {
                    if (strtolower($input) == "cancel") {
                        $query = "SELECT `id`,`userid`,date,total FROM `tbl_invoices` WHERE `status`='Cancel' limit " . $limit;
                        $result = dquery($query);
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $uid = mysqli_fetch_assoc(dquery("SELECT `username`,\r\n        (SELECT code FROM tbl_currencies WHERE id=default_currency) as code \r\n        FROM `tblUsers`\r\n        WHERE `id`='" . $noticia["userid"] . "'"));
                            $invResults[] = ["id" => $noticia["id"], "userid" => $noticia["user_id"], "user" => $uid["username"], "date" => $noticia["date"], "total" => $noticia["total"] . " " . $uid["code"]];
                        }
                    } else {
                        if (strtolower($part[0]) == "inv" && $part[1] != "") {
                            $query = "SELECT `id`,`userid`,date,total FROM `tbl_invoices` WHERE \r\n    id=" . $part[1] . " limit " . $limit;
                            $result = dquery($query);
                            while ($noticia = mysqli_fetch_assoc($result)) {
                                $uid = mysqli_fetch_assoc(dquery("SELECT `username`,\r\n        (SELECT code FROM tbl_currencies WHERE id=default_currency) as code FROM `tblUsers`\r\n        WHERE `id`='" . $noticia["userid"] . "'"));
                                $invResults[] = ["id" => $noticia["id"], "userid" => $noticia["user_id"], "user" => $uid["username"], "date" => $noticia["date"], "total" => $noticia["total"] . " " . $uid["code"]];
                            }
                        }
                    }
                }
                if (!is_numeric($input) || 2 < strlen($input) && strlen($input) < 15) {
                    if (!$OnlyEcommerce) {
                        if (!$IsFileOnly) {
                            if (strtolower($part[0]) == "imei" && $part[1] != "") {
                                $query = "SELECT `order_id`,`imei`,`user_can_c`,`user_id`,                encnum FROM `tbl_order_imei` WHERE                 (`order_id`='" . $part[1] . "'  OR `imei` LIKE '%" . $part[1] . "%' \r\n                or encnum='" . $part[1] . "')  limit " . $limit2;
                                $result = dquery($query);
                                while ($noticia = mysqli_fetch_assoc($result)) {
                                    $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
                                }
                            }
                            $query = "SELECT `id`,`service_name`,`credit`,`active`,`time` FROM             `tbl_services_imei` WHERE             (`service_name` LIKE  '%" . $input . "%' or sku='" . $input . "') \r\n            limit " . $limit2 . " ";
                            $result = dquery($query);
                            while ($noticia = mysqli_fetch_assoc($result)) {
                                $serResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
                            }
                            $iso = dquery("select * from tbl_services_imei\r\n            where service_name like '" . $input . "'");
                            if (mysqli_num_rows($iso)) {
                                foreach ($serResults as $s) {
                                    if ($input == $s["service"]) {
                                        $result = dquery("select * from tbl_order_imei\r\n    where service_id='" . $s["id"] . "' order by order_id desc limit 5");
                                        while ($noticia = mysqli_fetch_assoc($result)) {
                                            $oResults[] = ["id" => $noticia["order_id"], "imei" => $noticia["imei"], "encnum" => $noticia["encnum"], "user_id" => $noticia["user_id"], "user_can_c" => $noticia["user_can_c"]];
                                        }
                                    }
                                }
                            }
                        }
                        if (strtolower($part[0]) == "file" && $part[1] != "") {
                            $query = "SELECT `order_id`,substring_index(file,',',1) AS files,\r\n            `user_id` FROM `tbl_order_file` WHERE `order_id`='" . $part[1] . "' \r\n            limit " . $limit2;
                            $result = dquery($query);
                            while ($noticia = mysqli_fetch_assoc($result)) {
                                $fResults[] = ["id" => $noticia["order_id"], "file" => $noticia["files"], "user_id" => $noticia["user_id"]];
                            }
                        }
                        $query = "SELECT `id`,`service_name`,`credit`,`active`,`time`\r\n         FROM `tbl_services_file` WHERE `service_name` LIKE  '%" . $input . "%'\r\n          limit " . $listservicenamelimit . " ";
                        $result = dquery($query);
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $fileResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
                        }
                        if (!$IsFileOnly) {
                            if (strtolower($part[0]) == "server" && $part[1] != "") {
                                $query = "SELECT `order_id`,`user_id`,\r\n                (select service_name from tbl_server_log \r\n                WHERE id=service_id) as service \r\n                FROM `tbl_order_server`  WHERE `order_id`='" . $part[1] . "'\r\n                  limit " . $limit2;
                                $result = dquery($query);
                                while ($noticia = mysqli_fetch_assoc($result)) {
                                    $sResults[] = ["id" => $noticia["order_id"], "user_id" => $noticia["user_id"], "service" => $noticia["service"]];
                                }
                            }
                            $query = "SELECT `id`,`service_name`,`credit`,`active`,`time` \r\n            FROM `tbl_server_log` WHERE `service_name` LIKE  '%" . $input . "%'  \r\n            limit " . $listservicenamelimit;
                            $result = dquery($query);
                            while ($noticia = mysqli_fetch_assoc($result)) {
                                $logResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
                            }
                        }
                    }
                    if (!$IsFileOnly) {
                        $query = "SELECT `id`,`service_name`,`active`,`credit`,`time`             FROM `tbl_products` WHERE             (`service_name` LIKE  '%" . $input . "%'  or sku='" . $input . "') \r\n              limit " . $listservicenamelimit;
                        $result = dquery($query);
                        while ($noticia = mysqli_fetch_assoc($result)) {
                            $cartResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
                        }
                    }
                }
                if (is_numeric($input)) {
                    $query = "select DISTINCT pid,serial,\r\n        (select service_name from tbl_products where id=pid)\r\n        as service from tbl_serial_list where serial LIKE '" . $input . "' \r\n        limit " . $listservicenamelimit;
                    $result = dquery($query);
                    while ($no = mysqli_fetch_assoc($result)) {
                        $noticia = mysqli_fetch_assoc(dquery("SELECT `id`,`service_name`,`active`,`credit`,`time` \r\n            FROM `tbl_products` WHERE id='" . $no["pid"] . "'"));
                        $cartResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
                    }
                }
                if (2 < strlen($input)) {
                    $query = "SELECT `id`,`pagetitle`,`pagename` FROM `tbl_recent_pages` WHERE `pagetitle` LIKE  '%" . $input . "%'  limit " . $limit;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        $pageResults[] = ["id" => $noticia["id"], "pagename" => $noticia["pagename"], "title" => $noticia["pagetitle"]];
                    }
                }
                if (4 < strlen($input)) {
                    $query = "SELECT `tid`,MIN(id) as id,\r\n     (SELECT username FROM tblUsers WHERE id=uid) as user,subject  FROM `tbl_support_tickets` WHERE `tid`='" . $input . "'  limit " . $limit;
                    $result = dquery($query);
                    while ($noticia = mysqli_fetch_assoc($result)) {
                        if ($noticia["id"]) {
                            $ticitResults[] = ["id" => $noticia["id"], "ticket" => $noticia["tid"], "user" => $noticia["user"], "subject" => $noticia["subject"]];
                        }
                    }
                }
            }
        }
    }
    $FLAG = true;
    echo "<div class=\"sidearrow\"></div>\r\n<div class=\"resultcontent\">\r\n<div style=\"cursor: pointer;line-height: 15px;position: absolute;right: 15px;top: 0;\" id=\"closesubpage\" class=\"close-subpage\" onclick=\"\$('#scr_results').hide();\">x</div>\r\n<h1>Search Result</h1>\r\n\r\n\r\n<div class=\"find-result-box\">\r\n\r\n";
    if (0 < count($invResults)) {
        $FLAG = false;
        echo "    <div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #def5f5;\"><span style=\"background:white;padding:7px 5px;\">Invoices</span> <span class=\"counter\">";
        echo count($invResults);
        echo "</span> </div>\r\n    <div class=\"src-content\">\r\n        ";
        foreach ($invResults as $U) {
            echo "          <div class=\"scr_result\">\r\n              <a href=\"javascript:load_page('edituser.editinvoice&id=";
            echo $U["id"];
            echo "','Invoice [";
            echo $U["id"];
            echo "]','";
            echo $token;
            echo "')\" >Invoice ID: #";
            echo $U["id"];
            echo "                  <span>User: ";
            echo $U["user"];
            echo "</span>\r\n                  <span>Amount: ";
            echo $U["total"];
            echo "</span>\r\n                  <span>Date: ";
            echo $U["date"];
            echo "</span>\r\n              </a>\r\n          </div>\r\n         ";
        }
        echo "    </div>\r\n    </div>\r\n    ";
    }
    if (0 < count($ticitResults)) {
        $FLAG = false;
        echo "    <div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #6eb2b6;\"><span style=\"background:white;padding:7px 5px;\">Support Ticket</span> <span class=\"counter\">";
        echo count($ticitResults);
        echo "</span></div>\r\n    <div class=\"src-content\">\r\n        ";
        foreach ($ticitResults as $U) {
            echo "          <div class=\"scr_result\">\r\n              <a href=\"javascript:load_page('support.open&edit=";
            echo $U["id"];
            echo "','Ticket ";
            echo $U["ticket"];
            echo "','";
            echo $token;
            echo "')\" >\r\n        \t  <span>Ticket ID: #";
            echo $U["ticket"];
            echo " [";
            if (25 < strlen($U["subject"])) {
                echo substr($U["subject"], 0, 25) . "...";
            } else {
                echo $U["subject"];
            }
            echo "] </span>\r\n                <span>User : ";
            echo $U["user"];
            echo "</span>\r\n            </a>\r\n          </div>\r\n            ";
        }
        echo "    </div>\r\n    </div>\r\n    ";
    }
    if (0 < count($Returns)) {
        $FLAG = false;
        echo "<div class=\"search-box-result\">\r\n<div class=\"scr_resultheader\" style=\"background: #6eb2b6;\">\r\n<span style=\"background:white;padding:7px 5px;\">Return Request</span> <span class=\"counter\">";
        echo count($Returns);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($Returns as $U) {
            echo "  <div class=\"scr_result\">\r\n      <a href=\"javascript:load_page('editreturn.request&id=";
            echo $U["uid"];
            echo "','Request ";
            echo $U["uid"];
            echo "','";
            echo $token;
            echo "')\" >\r\n\t  <span>Request ID: #";
            echo $U["uid"];
            echo "  </span>\r\n           <span>Date : ";
            echo $U["date"];
            echo "</span>\r\n    </a>\r\n  </div>\r\n    ";
        }
        echo "</div>\r\n</div>\r\n";
    }
    echo "\r\n";
    if (0 < count($uResults)) {
        $FLAG = false;
        echo "<div class=\"search-box-result\">\r\n<div class=\"scr_resultheader\" style=\"background: gray;\"><span style=\"background:white;padding:7px 5px;\">Clients</span> <span class=\"counter\">";
        echo count($uResults);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($uResults as $U) {
            echo "        <div class=\"scr_result\">\r\n     <a href=\"javascript:load_page('edituser&id=";
            echo $U["id"];
            echo "','";
            echo $U["user"];
            echo "','";
            echo $token;
            echo "')\" >\r\n<table cellpadding=\"0\" cellspacing=\"3\" border=\"0\" width=\"100%\"><tr><td>";
            echo $U["first"];
            echo " ";
            echo $U["last"];
            echo " ( ";
            echo $U["user"];
            echo " ) #";
            echo $U["id"];
            echo "<br />\r\n        <span>";
            echo $U["email"];
            echo " [";
            echo $U["credit"];
            echo "]</span></td>\r\n\r\n        <td align=\"right\" valign=\"top\">\r\n        ";
            if ($U["status"] == 1) {
                echo "<div class='textred'><span>Blocked</span></div>";
            } else {
                if ($U["status"] == 2) {
                    echo "<div class='textyellow'><span>Inactive</span></div>";
                } else {
                    echo "<div class='textgreen'><span>Active</span></div>";
                }
            }
            echo "</td></tr></table></a></div>";
        }
        echo "</div></div>\r\n";
    }
    echo "\r\n";
    if (!$OnlyEcommerce) {
        if (0 < count($serResults)) {
            $FLAG = false;
            echo "<div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #7cb5ec;\"><span style=\"background:white;padding:7px 5px;\">IMEI Services</span> <span class=\"counter\">";
            echo count($serResults);
            echo "</span></div>\r\n    <div class=\"src-content\">\r\n    ";
            foreach ($serResults as $F) {
                echo "            <div class=\"scr_result\">\r\n            <table cellpadding=\"0\" cellspacing=\"3\" border=\"0\" width=\"100%\"><tr><td>\r\n            <a href=\"javascript:load_page('editimeiservice&id=";
                echo $F["id"];
                echo "','";
                if (20 < strlen($F["service"])) {
                    echo substr($F["service"], 0, 20) . "..";
                } else {
                    echo $F["service"];
                }
                echo "','";
                echo $token;
                echo "')\" title=\"";
                echo $F["service"];
                echo "\" >\r\n            ";
                echo $F["service"];
                echo "            <span><small>Credit: ";
                echo $F["credit"];
                echo "  |  Time: ";
                echo $F["time"];
                echo "</small></span></a></td><td valign=\"top\" align=\"right\">\r\n            ";
                if ($F["active"] == 1) {
                    echo "<div class='textgreen'><span>Active</span></div>";
                } else {
                    echo "<div class='textyellow'><span>Inactive</span></div>";
                }
                echo "            </td></tr></table>\r\n            </div>\r\n            ";
            }
            echo "    </div></div>\r\n";
        }
        if (0 < count($oResults)) {
            $FLAG = false;
            echo "<div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #7cb5ec;\"><span style=\"background:white;padding:7px 5px;\">Imei Orders</span> <span class=\"counter\">";
            echo count($oResults);
            echo "</span></div>\r\n    <div class=\"src-content\">\r\n        ";
            foreach ($oResults as $O) {
                if ($O["user_can_c"] == 0) {
                    $BG = "#bcbcbc";
                } else {
                    if ($O["user_can_c"] == 1) {
                        $BG = "#ef7f3a";
                    } else {
                        if ($O["user_can_c"] == 4) {
                            $BG = "#62bb43";
                        } else {
                            if ($O["user_can_c"] == 3) {
                                $BG = "#d04621";
                            }
                        }
                    }
                }
                $username = mysqli_fetch_assoc(dquery("SELECT `username` FROM `tblUsers` WHERE `id`='" . $O["user_id"] . "'"));
                echo "                 <div class=\"scr_result\"  >\r\n\r\n\r\n                 <a style=\"background-color: white; \" href=\"javascript:load_page('edituser.editimeiorder&id=";
                echo $O["id"];
                echo "','IMEI Order ";
                echo $O["id"];
                echo "','";
                echo $token;
                echo "')\" >\r\n                 Order ID : ";
                echo $O["id"];
                echo "                 ";
                if ($O["encnum"]) {
                    echo " / " . $O["encnum"];
                }
                echo "                 <span> Orders by : ";
                echo $username["username"];
                echo "                 <br />  <span style=\"color: ";
                echo $BG;
                echo ";\">IMEI :";
                echo $O["imei"];
                echo "</span></span></a>\r\n                </div>\r\n                 ";
            }
            echo "    </div></div>\r\n";
        }
        echo "    ";
        if (0 < count($fResults)) {
            $FLAG = false;
            echo "<div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #434348;\">\r\n    <span style=\"background:white;padding:7px 5px;\">File Orders</span> <span class=\"counter\">";
            echo count($fResults);
            echo "</span></div>\r\n    <div class=\"src-content\">\r\n    ";
            foreach ($fResults as $F) {
                $username = mysqli_fetch_assoc(dquery("SELECT `username` FROM `tblUsers` WHERE `id`='" . $F["user_id"] . "'"));
                echo "        <div class=\"scr_result\">\r\n            <a href=\"javascript:load_page('edituser.editfileorder&id=";
                echo $F["id"];
                echo "','File Order ";
                echo $F["id"];
                echo "','";
                echo $token;
                echo "')\" >\r\n            Order ID : ";
                echo $F["id"];
                echo " <span> Orders by : ";
                echo $username["username"];
                echo " <br /> File : ";
                echo $F["file"];
                echo "</span></a>\r\n        </div>\r\n    ";
            }
            echo "    </div></div>\r\n    ";
        }
    }
    if (0 < count($pResults)) {
        $FLAG = false;
        echo "    <div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #f7a35c;\"><span style=\"background:white;padding:7px 5px;\">Shop Orders</span> <span class=\"counter\">";
        echo count($pResults);
        echo "</span></div>\r\n    <div class=\"src-content\">\r\n          ";
        foreach ($pResults as $P) {
            $username = mysqli_fetch_assoc(dquery("SELECT `username` FROM `tblUsers` WHERE `id`='" . $P["user_id"] . "'"));
            echo "            <div class=\"scr_result\">\r\n                <a href=\"javascript:load_page('edituser.editproductorder&id=";
            echo $P["id"];
            echo "','Shopping Order ";
            echo $P["id"];
            echo "','";
            echo $token;
            echo "')\" >\r\n                Order ID : ";
            echo $P["id"];
            echo " <span> Orders by : ";
            echo $username["username"];
            echo "</span>\r\n                <span> Item : ";
            echo $P["item"];
            echo "</span></a>\r\n            </div>\r\n            ";
        }
        echo "    </div></div>\r\n    ";
    }
    if (!$OnlyEcommerce) {
        if (0 < count($fileResults)) {
            $FLAG = false;
            echo "        <div class=\"search-box-result\">\r\n            <div class=\"scr_resultheader\" style=\"background: #f7a35c;\"><span style=\"background:white;padding:7px 5px;\">Edit File Services</span> <span class=\"counter\">";
            echo count($fileResults);
            echo "</span></div>\r\n          <div class=\"src-content\">\r\n            ";
            foreach ($fileResults as $F) {
                echo "                <div class=\"scr_result\">\r\n                    <a href=\"javascript:load_page('editfileservice&id=";
                echo $F["id"];
                echo "','";
                echo 20 < strlen($F["service"]) ? substr($F["service"], 0, 20) . ".." : $F["service"];
                echo "','";
                echo $token;
                echo "')\" title=\"";
                echo $F["service"];
                echo "\" >";
                echo $F["service"];
                echo "                       <span><small>Credit: ";
                echo $F["credit"];
                echo "  |  Time: ";
                echo $F["time"];
                echo "</span> </small>\r\n                        ";
                if ($F["active"] == 1) {
                    echo "<div class='textgreen'><span>Active</span></div>";
                } else {
                    echo "<div class='textyellow'><span>Inactive</span></div>";
                }
                echo "                    </a>\r\n                </div>\r\n                ";
            }
            echo "        </div></div>\r\n        ";
        }
        if (0 < count($logResults)) {
            $FLAG = false;
            echo "        <div class=\"search-box-result\">\r\n       <div class=\"scr_resultheader\" style=\"background: #90ed7d;\"><span style=\"background:white;padding:7px 5px;\">Edit Server Services</span> <span class=\"counter\">";
            echo count($logResults);
            echo "</span></div>\r\n          <div class=\"src-content\">\r\n                ";
            foreach ($logResults as $F) {
                echo "                    <div class=\"scr_result\">\r\n                        <a href=\"javascript:load_page('editserverservice&id=";
                echo $F["id"];
                echo "','";
                echo 20 < strlen($F["service"]) ? substr($F["service"], 0, 20) . ".." : $F["service"];
                echo "','";
                echo $token;
                echo "')\" title=\"";
                echo $F["service"];
                echo "\" >Edit : ";
                echo $F["service"];
                echo "                           <span> <small>Credit: ";
                echo $F["credit"];
                echo "  |  Time: ";
                echo $F["time"];
                echo "</span></small>\r\n                           ";
                if ($F["active"] == 1) {
                    echo "<div class='textgreen'><span>Active</span></div>";
                } else {
                    echo "<div class='textyellow'><span>Inactive</span></div>";
                }
                echo "                        </a>\r\n                    </div>\r\n                    ";
            }
            echo "            </div></div>\r\n        ";
        }
    }
    if (0 < count($cartResults)) {
        $FLAG = false;
        echo "<div class=\"search-box-result\">\r\n<div class=\"scr_resultheader\" style=\"background: #90ed7d;\"><span style=\"background:white;padding:7px 5px;\">Edit Catalog</span> <span class=\"counter\">";
        echo count($cartResults);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($cartResults as $F) {
            echo "    <div class=\"scr_result\">\r\n        <a href=\"javascript:load_page('editproduct&id=";
            echo $F["id"];
            echo "','";
            echo 20 < strlen($F["service"]) ? substr($F["service"], 0, 20) . ".." : $F["service"];
            echo "','";
            echo $token;
            echo "')\" title=\"";
            echo $F["service"];
            echo "\" >Edit : ";
            echo $F["service"];
            echo "            <span><small>Credit: ";
            echo $F["credit"];
            echo "  |  Time: ";
            echo $F["time"];
            echo "</span></small>\r\n            ";
            if ($F["active"] == 1) {
                echo "<div class='textgreen'><span>Active</span></div>";
            } else {
                echo "<div class='textyellow'><span>Inactive</span></div>";
            }
            echo "        </a>\r\n    </div>\r\n    ";
        }
        echo "</div></div>\r\n";
    }
    if (!$OnlyEcommerce && 0 < count($sResults)) {
        $FLAG = false;
        echo "<div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\" style=\"background: #90ed7d;\"><span style=\"background:white;padding:7px 5px;\">Server Orders</span> <span class=\"counter\">";
        echo count($sResults);
        echo "</span></div>\r\n    <div class=\"src-content\">\r\n    ";
        foreach ($sResults as $S) {
            $username = mysqli_fetch_assoc(dquery("SELECT `username` FROM `tblUsers` WHERE `id`='" . $S["user_id"] . "'"));
            echo "             <div class=\"scr_result\">\r\n                  <a href=\"javascript:load_page('edituser.editserverorder&id=";
            echo $S["id"];
            echo "','Server Order ";
            echo $S["id"];
            echo "','";
            echo $token;
            echo "')\" >\r\n                      Order ID : ";
            echo $S["id"];
            echo "                      <span> Orders by : ";
            echo $username["username"];
            echo "</span>\r\n                      <span> Service : ";
            echo $S["service"];
            echo "</span>\r\n                  </a>\r\n              </div>\r\n            ";
        }
        echo "    </div></div>\r\n";
    }
    if (0 < count($pageResults)) {
        $FLAG = false;
        if (!$IsFileOnly) {
            echo "    <div class=\"search-box-result\">\r\n    <div class=\"scr_resultheader\"><span style=\"background:white;padding:7px 5px;\">Jump To</span> <span class=\"counter\">";
            echo count($pageResults);
            echo "</span></div>\r\n        <div class=\"src-content\">\r\n            ";
            foreach ($pageResults as $P) {
                echo "                <div class=\"scr_result\">\r\n                    <a href=\"javascript:load_page('";
                echo $P["pagename"];
                echo "','";
                echo $P["title"];
                echo "','";
                echo $token;
                echo "')\" > ";
                echo $P["title"];
                echo " </a>\r\n                </div>\r\n            ";
            }
            echo "        </div>\r\n   </div>\r\n        ";
        }
    }
    if ($FLAG) {
        echo "<div align=center>No result Found</div>";
    }
}
echo "</div>\r\n<div class=\"clear\" style=\"clear: both;\"></div>\r\n</div>";

?>