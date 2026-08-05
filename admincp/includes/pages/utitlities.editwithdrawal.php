<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once ROOTDIR . "/includes/mail.fun.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
$date = date("Y-m-d");
if ($accept && $amount && $id) {
    checkDemoMode(false);
    $s = mysqli_fetch_assoc(dquery("select * from tbl_withdrawal where id='" . $id . "'"));
    if ($s["status"] == 1) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["request"] . " " . $LNG["already"] . " " . $LNG["accepted"] . "</div>";
    } else {
        dquery("update tbl_withdrawal set \n    gateway='" . $gateway . "',\n    note='" . $note . "',transactionid='" . $transactionid . "',accept_date='" . $date . "' where id='" . $id . "'");
        $data["userid"] = $s["uid"];
        $data["gateway"] = $s["gateway"];
        $data["date"] = date("d-m-Y");
        $data["description"] = $note;
        $data["amount"] = $amount;
        $data["transid"] = $transactionid;
        $data["wid"] = $id;
        $db->insert("tbl_withdrawal_transaction", $data);
        $data = NULL;
        dquery("update tblUsers set credit_inprocess= \tcredit_inprocess-" . $amount . " where id='" . $s["uid"] . "'");
        $trans = mysqli_fetch_assoc(dquery("select sum(amount) as total from \n    tbl_withdrawal_transaction where wid='" . $id . "'"));
        if ($s["amount"] <= $trans["total"]) {
            dquery("update tbl_withdrawal set \n                    status='1'\n                     where id='" . $id . "'");
        }
        $s = mysqli_fetch_assoc(dquery("SELECT *,(SELECT username FROM tblUsers WHERE id=uid) AS user\n,(SELECT messengerid FROM tblUsers WHERE id=uid) AS messengerid\n,\nCONCAT(IF(status=0,'Pending',IF(status=1,'Accepted','Rejected'))) as stat,\n(SELECT code FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid)) AS code,\n(SELECT value from tbl_paymentgateways  WHERE setting='name' and tbl_paymentgateways.gateway=tbl_withdrawal.gateway) as gatw FROM tbl_withdrawal where id='" . $id . "'"));
        dquery("update tblUsers set credit_inprocess=credit_inprocess-" . $amount . " where id='" . $s["uid"] . "'");
        $email_merge_fields["user"] = $s["user"];
        $email_merge_fields["amount"] = $s["amount"] . " " . $s["code"];
        $email_merge_fields["transactionid"] = $s["transactionid"];
        $email_merge_fields["gateway"] = $s["gatw"];
        sendMail(67, $s["uid"], "", $email_merge_fields, false);
        $sendmessage = "Your withdrawal request accepted for  " . $s["amount"] . " " . $s["code"] . " with " . $s["gatw"] . " payment method";
        if ($s["messengerid"]) {
            sendTelegramMessage(urlencode($sendmessage), $s["messengerid"]);
        }
        echo "<div id='notification1' class='successbox'>" . $LNG["request"] . " " . $LNG["accepted"] . " " . $LNG["successfully"] . " </div>";
    }
} else {
    if ($accept) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["amount"] . " " . $LNG["fieldblank"] . "</div>";
    }
}
if ($reject && $reason && $id) {
    checkDemoMode(false);
    $s = mysqli_fetch_assoc(dquery("select status from tbl_withdrawal where id='" . $id . "'"));
    if ($s["status"] == 2) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["request"] . " " . $LNG["already"] . " " . $LNG["rejected"] . "</div>";
    } else {
        dquery("update tbl_withdrawal set status=2,reason='" . $reason . "',note='" . $note . "',accept_date='" . $date . "' where id='" . $id . "'");
        $s = mysqli_fetch_assoc(dquery("SELECT *,(SELECT username FROM tblUsers WHERE id=uid) AS user,\nCONCAT(IF(status=0,'Pending',IF(status=1,'Accepted','Rejected'))) as stat,\n(SELECT code FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid)) AS code,\n(SELECT value from tbl_paymentgateways  WHERE setting='name' and tbl_paymentgateways.gateway=tbl_withdrawal.gateway) as gatw FROM tbl_withdrawal where id='" . $id . "'"));
        dquery("update tblUsers set credit_left=credit_left+" . $amount . ",credit_inprocess=credit_inprocess-" . $amount . " where id='" . $s["uid"] . "'");
        addStatementuser($s["uid"], "Credit Added for Withdrawal Rejected", "CR", $s["amount"], $id);
        $email_merge_fields["user"] = $s["user"];
        $email_merge_fields["reason"] = $s["reason"];
        sendMail(66, $s["uid"], "", $email_merge_fields, false);
        echo "<div id='notification1' class='successbox'>" . $LNG["request"] . " " . $LNG["rejected"] . " " . $LNG["successfully"] . " </div>";
    }
} else {
    if ($reject) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["reason"] . " " . $LNG["fieldblank"] . "</div>";
    }
}
$sql = mysqli_fetch_assoc(dquery("select *,\n(SELECT code FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid)) AS code\n from tbl_withdrawal where id='" . $id . "'"));
$trans = mysqli_fetch_assoc(dquery("select sum(amount) as total from tbl_withdrawal_transaction where wid='" . $id . "'"));
echo " \n\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<form  method=\"post\" >\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table id=\"frm\" class=\"form\">\n\n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td><td  class=\"fieldarea\"><input type=\"text\" \n class=\"txt small\"  name=\"amount\" value=\"";
echo $sql["amount"] - $trans["total"];
echo "\" /> ";
echo $sql["code"];
echo "</td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " </td><td  class=\"fieldarea\">\n<select name=\"gateway\">\n";
$s = dquery("select gateway ,value from tbl_paymentgateways  where setting='name'");
while ($r = mysqli_fetch_assoc($s)) {
    echo "            <option value=\"";
    echo $r["gateway"];
    echo "\" \n            ";
    if ($r["gateway"] == $sql["gateway"]) {
        echo "selected";
    }
    echo ">";
    echo $r["value"];
    echo "</option>\n            ";
}
echo "</select>\n</td></tr>\n";
$custom = getCustomFields($sql["gateway"], "", $id, "on");
foreach ($custom as $deta) {
    echo "    <tr><td class=\"fieldlabel\">";
    echo $deta["name"];
    echo " </td><td  class=\"fieldarea\">\n            ";
    echo $deta["value"];
    echo "        </td></tr>\n    ";
}
if ($sql["account"]) {
    echo "<tr><td class=\"fieldlabel\">";
    echo $LNG["account"];
    echo " </td><td  class=\"fieldarea\">\n";
    echo $sql["account"];
    echo "</td></tr>\n";
}
echo "<tr><td class=\"fieldlabel\">";
echo $LNG["invoicestransid"];
echo "</td><td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"transactionid\" value=\"\" /></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["notes"];
echo "</td><td class=\"fieldarea\"><textarea name=\"note\"></textarea></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["rejected"];
echo " ";
echo $LNG["reason"];
echo "</td><td class=\"fieldarea\"><textarea name=\"reason\"></textarea></td></tr>\n<tr>\n<td>&nbsp;</td>\n<td class=\"fieldarea\">\n<input value=\"";
echo $LNG["accept"];
echo "\" name=\"accept\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" />\n<input value=\"";
echo $LNG["reject"];
echo "\" name=\"reject\" id=\"btnedituser\" class=\"submit button_remove\" type=\"submit\" />\n</td>\n</tr>\n</tbody>\n</table>\n\n</form>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>