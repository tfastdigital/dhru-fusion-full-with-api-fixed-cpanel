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
    if (strpos($input, "@") !== false) {
        $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE `username`\r\n  LIKE '" . $input . "%' OR `email` LIKE '" . $input . "%' OR `id` ='" . $input . "' or `first_name`\r\n   like '" . $input . "%' or \r\n  `last_name` like '" . $input . "%' order by username limit " . $limit . " ";
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], 2) . " " . $noticia["code"]];
        }
    } else {
        $part = explode(":", $input);
        $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE `username`\r\n  LIKE '" . $input . "%' OR `email` LIKE '" . $input . "%' OR `id` ='" . $input . "' or `first_name` like '" . $input . "%' or \r\n  `last_name` like '" . $input . "%' order by username limit " . $limit . " ";
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], 2) . " " . $noticia["code"]];
        }
        if (strtolower($part[0]) == "u" && $part[1] != "") {
            $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n         (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE \r\n         credit_left>" . $part[1] . " order by username limit " . $limit . " ";
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], 2) . " " . $noticia["code"]];
            }
        } else {
            if (strtolower($input) == "inactive") {
                $query = "SELECT `id`,`username`,`first_name`,`last_name`,`email`,`userstatus`,credit_left,\r\n     (select code from tbl_currencies where id=default_currency) as code FROM `tblUsers` WHERE \r\n     userstatus='2' order by username limit " . $limit . " ";
                $result = dquery($query);
                while ($noticia = mysqli_fetch_assoc($result)) {
                    $uResults[] = ["id" => $noticia["id"], "status" => $noticia["userstatus"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["first_name"]), "last" => htmlspecialchars($noticia["last_name"]), "email" => htmlspecialchars($noticia["email"]), "credit" => round($noticia["credit_left"], 2) . " " . $noticia["code"]];
                }
            }
        }
        $query = "SELECT `id`,`username`,`firstname`,`lastname`,`email`\r\n FROM `tbl_admin` WHERE `username` LIKE '" . $input . "%' OR `email` LIKE '" . $input . "%' OR `id` ='" . $input . "' order by username limit " . $limit . " ";
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            $admnResults[] = ["id" => $noticia["id"], "user" => htmlspecialchars($noticia["username"]), "first" => htmlspecialchars($noticia["firstname"]), "last" => htmlspecialchars($noticia["lastname"]), "email" => htmlspecialchars($noticia["email"])];
        }
        if (!$IsFileOnly) {
            $query = "SELECT `order_id`,`user_id`,  (select service_name from tbl_products WHERE id=service_id) item FROM `tbl_order_product` WHERE   (`order_id`='" . $input . "'\r\n    OR ('" . $part[0] . "'='shop' AND order_id='" . $part[1] . "'))\r\n  AND `user_can_c`<'5' limit " . $limit2;
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $pResults[] = ["id" => $noticia["order_id"], "user_id" => $noticia["user_id"], "item" => $noticia["item"]];
            }
        }
        $uid = mysqli_fetch_assoc(dquery("SELECT `id` FROM `tblUsers` WHERE `username` LIKE '%" . $input . "%'"));
        $uid = $uid["id"];
        if (!$part[1]) {
            $part[1] = "9999999999999999999999";
        }
        if (!is_numeric($input)) {
            $query = "SELECT `id`,`service_name`,`active`,`credit`,`time` \r\n        FROM `tbl_products` WHERE `service_name` LIKE  '%" . $input . "%'\r\n          limit " . $listservicenamelimit;
            $result = dquery($query);
            while ($noticia = mysqli_fetch_assoc($result)) {
                $cartResults[] = ["id" => $noticia["id"], "service" => $noticia["service_name"], "credit" => $noticia["credit"], "time" => $noticia["time"], "active" => $noticia["active"]];
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
    }
    $FLAG = true;
    echo "<div class=\"sidearrow\"></div>\r\n<div class=\"resultcontent\">\r\n<div style=\"cursor: pointer;line-height: 15px;position: absolute;right: 15px;top: 0;\" id=\"closesubpage\" class=\"close-subpage\">x</div>\r\n<h1>Search Result</h1>\r\n";
    if (0 < count($invResults)) {
        $FLAG = false;
        echo "    <div class=\"scr_resultheader\" style=\"background: #def5f5;\"><span style=\"background:white;padding:7px 5px;\">Invoices</span> <span class=\"counter\">";
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
        echo "    </div>\r\n    ";
    }
    if (0 < count($ticitResults)) {
        $FLAG = false;
        echo "\t\r\n    <div class=\"scr_resultheader\" style=\"background: #6eb2b6;\"><span style=\"background:white;padding:7px 5px;\">Support Ticket</span> <span class=\"counter\">";
        echo count($ticitResults);
        echo "</span></div>\r\n    <div class=\"src-content\">\r\n        ";
        foreach ($ticitResults as $U) {
            echo "          <div class=\"scr_result\">\r\n              <a href=\"javascript:load_page('support.open&edit=";
            echo $U["id"];
            echo "','Ticket ";
            echo $U["ticket"];
            echo "','";
            echo $token;
            echo "')\" >  \r\n        \t  <span>Ticket ID: #";
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
        echo "    </div>\r\n    ";
    }
    if (0 < count($Returns)) {
        $FLAG = false;
        echo "\t\r\n<div class=\"scr_resultheader\" style=\"background: #6eb2b6;\">\r\n<span style=\"background:white;padding:7px 5px;\">Return Request</span> <span class=\"counter\">";
        echo count($Returns);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($Returns as $U) {
            echo "  <div class=\"scr_result\">\r\n      <a href=\"javascript:load_page('editreturn.request&id=";
            echo $U["uid"];
            echo "','Request ";
            echo $U["uid"];
            echo "','";
            echo $token;
            echo "')\" >  \r\n\t  <span>Request ID: #";
            echo $U["uid"];
            echo "  </span>\r\n           <span>Date : ";
            echo $U["date"];
            echo "</span>\r\n    </a>\r\n  </div>\r\n    ";
        }
        echo "</div>\r\n";
    }
    if (0 < count($uResults)) {
        $FLAG = false;
        echo "\t\r\n<div class=\"scr_resultheader\" style=\"background: gray;\"><span style=\"background:white;padding:7px 5px;\">Clients</span> <span class=\"counter\">";
        echo count($uResults);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($uResults as $U) {
            echo "        <div class=\"scr_result\">\r\n      \r\n<table cellpadding=\"0\" cellspacing=\"3\" border=\"0\" width=\"100%\">\r\n<tr><td>\r\n<a href=\"javascript:load_page('pos.edituser&id=";
            echo $U["id"];
            echo "','";
            echo $U["user"];
            echo "','";
            echo $token;
            echo "')\" >\r\n";
            echo $U["first"];
            echo " ";
            echo $U["last"];
            echo " ( ";
            echo $U["user"];
            echo " ) #";
            echo $U["id"];
            echo "<br />\r\n\r\n        <span>";
            echo $U["email"];
            echo " [";
            echo $U["credit"];
            echo "]</span>\r\n        </a>\r\n        </td>\r\n        <td align=\"right\" valign=\"top\">\r\n\r\n        ";
            if ($U["status"] == 1) {
                echo "<div class='textred'><span>Blocked</span></div>";
            } else {
                if ($U["status"] == 2) {
                    echo "<div class='textyellow'><span>Inactive</span></div>";
                } else {
                    echo "<div class='textgreen'><span>Active</span></div>";
                }
            }
            echo "</td></tr>        \r\n        </table>\r\n        <a href=\"javascript:load_page('edituser.invoice&id=";
            echo $U["id"];
            echo "','Admin Invoice','";
            echo $token;
            echo "')\">View Invoice</a> \r\n        </div>\r\n        ";
        }
        echo "\r\n</div>\r\n";
    }
    if (0 < count($pResults)) {
        $FLAG = false;
        echo "\t\r\n    <div class=\"scr_resultheader\" style=\"background: #a4cc8a;\">\r\n    <span style=\"background:white;padding:7px 5px;\">Shop Orders</span> <span class=\"counter\">";
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
            echo "')\" > \r\n                Order ID : ";
            echo $P["id"];
            echo " <span> Orders by : ";
            echo $username["username"];
            echo "</span>\r\n                <span> Item : ";
            echo $P["item"];
            echo "</span></a>\r\n            </div>\r\n            ";
        }
        echo "    </div>\r\n    ";
    }
    if (0 < count($cartResults)) {
        $FLAG = false;
        echo "\t\r\n<div class=\"scr_resultheader\" style=\"background: #a4cc8a;\"><span style=\"background:white;padding:7px 5px;\">Edit Catalog</span> <span class=\"counter\">";
        echo count($cartResults);
        echo "</span></div>\r\n<div class=\"src-content\">\r\n";
        foreach ($cartResults as $F) {
            echo "    <div class=\"scr_result\">\r\n        <a href=\"javascript:load_page('pos.editproduct&id=";
            echo $F["id"];
            echo "','";
            echo $F["service"];
            echo "','";
            echo $token;
            echo "')\" title=\"";
            echo $F["service"];
            echo "\" >Edit : ";
            echo $F["service"];
            echo "  \r\n            <span><small>Credit: ";
            echo $F["credit"];
            echo "  |  Time: ";
            echo $F["time"];
            echo "</span></small>\r\n            ";
            if ($F["active"] == 1) {
                echo "<div class='textgreen'><span>Active</span></div>";
            } else {
                echo "<div class='textyellow'><span>Inactive</span></div>";
            }
            echo "    \r\n        </a> \r\n        <a href=\"javascript:load_page('editproduct.inventory&id=";
            echo $F["id"];
            echo "','Add Stock','";
            echo $token;
            echo "')\">Add Stock</a>  \r\n    </div>\r\n    ";
        }
        echo "</div>\r\n";
    }
    if ($FLAG) {
        echo "<div align=center>No result Found</div>";
    }
}
echo "</div>";

?>