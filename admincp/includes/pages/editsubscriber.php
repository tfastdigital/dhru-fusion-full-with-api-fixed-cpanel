<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$subscription = mysqli_fetch_assoc(dquery("SELECT type from tbl_subscribers WHERE id='" . $id . "'"));
$table = $subscription["type"];
if (isset($_POST["renew"])) {
    $row = mysqli_fetch_assoc(dquery("SELECT id,user_id,subscribe_start,subscribe_end,(SELECT subscribe_days FROM " . $table . " \n                WHERE id=service_id) as days from tbl_subscribers WHERE id='" . $id . "'"));
    $dif = 86400 * $row["days"];
    if ($account) {
        $cur = mysqli_fetch_assoc(dquery("select credit_left from tblUsers where id='" . $row["user_id"] . "'"));
        if ($cur["credit_left"] < $credit) {
            echo "<div id=notification1 class=errorbox>" . $LNG["notengouthcredit"] . "</div>";
            exit;
        }
        dquery("UPDATE tblUsers SET credit_left=credit_left-" . $credit . " WHERE id='" . $row["user_id"] . "'");
        include_once ROOTDIR . "/includes/mail.fun.php";
        addStatementuser($row["user_id"], "Renew Subscription for : " . $serv["service_name"] . " ", "DR", $credit, "", $name, 1);
    } else {
        if ($geninvoice && $credit) {
            insert_query("tbl_invoiceitems", ["userid" => $userid, "type" => "Subscription", "relid" => "", "description" => $LNG["subscription"] . " renew for Service : " . $service, "amount" => $credit, "taxed" => "0", "duedate" => "now()", "paymentmethod" => ""]);
            require ROOTDIR . "/includes/invoice.fun.php";
            $invoiceid = generateInvoice($userid);
            if ($paid) {
                processInvoicetoPaid($invoiceid);
            }
        }
    }
    dquery("UPDATE `tbl_subscribers` SET `subscribe_end`=(`subscribe_end`+'" . $dif . "'),count=count+1 where `id`='" . $id . "'");
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
if (isset($_POST["save"])) {
    $row = mysqli_fetch_assoc(dquery("SELECT id,subscribe_start,subscribe_end,(SELECT subscribe_days FROM " . $table . " \n                WHERE id=service_id) as days from tbl_subscribers WHERE id='" . $id . "'"));
    $dif = 86400 * $row["days"];
    dquery("UPDATE `tbl_subscribers` SET `status`='" . $status . "' where `id`='" . $id . "'");
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
$row = mysqli_fetch_assoc(dquery("SELECT id,(SELECT service_name FROM " . $table . " WHERE id=service_id) as service ,\n(select username from tblUsers where id=user_id) as username ,service_id,user_id,status,\nsubscribe_start, subscribe_end from tbl_subscribers WHERE id='" . $id . "'"));
$currency = mysqli_fetch_assoc(dquery("SELECT default_currency from tblUsers where id='" . $row["user_id"] . "'"));
$clientDetails = getClientsDetails($row["user_id"]);
$credit = mysqli_fetch_assoc(dquery("select credit_subscribe from tbl_imei_credit where service_id='" . $row["service_id"] . "' and `currency_id`='" . $currency["default_currency"] . "'"));
$credit["credit_subscribe"] = subscribeCurrency($row["service_id"], $table, $clientDetails["currency"]["id"]);
echo "<script>\nfunction hiden(val){\n    \n    if(val){\n        document.getElementById('hide').style.display='none';\n    }else{\n        document.getElementById('hide').style.display='';\n    }\n}\n</script>\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n\n<script type=\"text/javascript\" src=\"../js/jquery.js\"></script>\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"content\">\n<div id=\"content_padded\" style=\"padding: 30px 40px;\">\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" name=\"userid\" value=\"";
echo $row["user_id"];
echo "\" />\n";
echo generate_token("form");
echo "<table id=\"\"  class=\"form\"  style=\"display: table;\">\n       <tbody>\n           <tr>\n            <td align=\"left\" class=\"fieldlabel\" >";
echo $LNG["service"];
echo "</td><td class=\"fieldarea\">";
echo $row["service"];
echo "            <input type=\"hidden\" name=\"service\" value=\"";
echo $row["service"];
echo "\" />\n            </td>\n          </tr>\n          <tr>\n            <td align=\"left\"  class=\"fieldlabel\" >";
echo $LNG["user"];
echo "</td><td class=\"fieldarea\">";
echo $row["username"];
echo "</td>\n          </tr>  \n        \n          <tr>\n            <td align=\"left\"  class=\"fieldlabel\" >";
echo $LNG["credit"];
echo "</td><td class=\"fieldarea\">";
echo $credit["credit_subscribe"];
echo "&nbsp;[ ";
echo $clientDetails["currency"]["code"];
echo " ]</td>\n          </tr>        <input type=\"hidden\" name=\"credit\" value=\"";
echo $credit["credit_subscribe"];
echo "\" />\n        \n          <tr>\n            <td align=\"left\"  class=\"fieldlabel\" >";
echo $LNG["subscription"];
echo " ";
echo $LNG["date"];
echo "</td><td class=\"fieldarea\">";
echo date("d-m-Y", $row["subscribe_start"]);
echo "</td>\n          </tr> \n          \n          <tr>\n            <td align=\"left\"  class=\"fieldlabel\" >";
echo $LNG["subscription"];
echo " ";
echo $LNG["end"];
echo "</td><td class=\"fieldarea\">";
echo date("d-m-Y", $row["subscribe_end"]);
echo "</td>\n          </tr>     \n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"account\" id=\"account\" value=\"1\" onclick=\"hiden(this.checked)\" /><label for=\"account\">";
echo $LNG["payfromaccount"];
echo "&nbsp;&nbsp; \n     ( ";
echo $LNG["creditleft"] . "&nbsp;&nbsp;" . $clientDetails["credit"]["credit"] . "&nbsp;&nbsp;" . $clientDetails["currency"]["code"];
echo " )</label> </td>\n</tr>                        \n<tr id=\"hide\" > \n    <td class=\"fieldlabel\" align=\"left\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" checked=\"checked\" id=\"geninvoice\" name=\"geninvoice\"/>\n        <label for=\"geninvoice\">";
echo $LNG["geninvoice"];
echo "</label> \n        <input type=\"checkbox\" checked=\"checked\" id=\"paid\" name=\"paid\"/>\n        <label for=\"paid\">";
echo $LNG["paid"];
echo "</label></td>\n</tr>     \n     <tr>\n     \n     <td></td><td class=\"fieldarea\"><input  id=\"btnedituser\" name=\"renew\" class=\"btn save\" type=\"submit\" value=\"Renew\" /></td>\n     </tr>\n      \n          <tr> \n            <td align=\"left\"  class=\"fieldlabel\" >";
echo $LNG["status"];
echo "</td><td class=\"fieldarea\">  \n            <select name=\"status\">\n            <option ";
if ($row["status"] == "active") {
    echo "selected";
}
echo " value=\"active\">";
echo $LNG["active"];
echo "</option>\n            <option ";
if ($row["status"] == "inactive") {
    echo "selected";
}
echo " value=\"inactive\">";
echo $LNG["inactive"];
echo "</option>\n            <option ";
if ($row["status"] == "cancel") {
    echo "selected";
}
echo " value=\"cancel\">";
echo $LNG["cancel"];
echo "</option>\n            <option ";
if ($row["status"] == "expired") {
    echo "selected";
}
echo " value=\"expired\">";
echo $LNG["expires"];
echo "</option>\n            </select>  \n            </td>\n          </tr> \n        </tbody>\n\n</table>\n\n<div class=\"fixedbtn\">\n    <input  id=\"btnedituser\" name=\"save\" class=\"btn save\" type=\"submit\" value=\"Save\" />\n</div>\n\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>