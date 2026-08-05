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
$posts = explode("_", $xid);
list($xid, $groupid) = $posts;
echo "    <div id=\"notification\"></div>\r\n    <form method=\"post\" name=\"frmapi\" id=\"frmapi\">\r\n        ";
echo generate_token("form");
echo "        <input type=\"hidden\" value=\"";
echo $groupid;
echo "\" name=\"groupid\"/>\r\n        <input type=\"hidden\" value=\"";
echo $xid;
echo "\" name=\"serviceid\"/>\r\n        <table class=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n            <thead>\r\n\r\n            <tr>\r\n                <th>&nbsp;</th>\r\n                <th class=\"left\">";
echo $LNG["user"];
echo "</th>\r\n                <th class=\"right\">";
echo $LNG["price"];
echo "</th>\r\n            </tr>\r\n            </thead>\r\n            <tbody>\r\n            ";
$q = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($q)) {
    $groupprice = mysqli_fetch_assoc(dquery("select discount from \r\ntbl_client_group_price where group_id='" . $groupid . "' and \r\nservice_type='file' and service_id='" . $xid . "' and currency_id='" . $r["id"] . "'"));
    $credit = mysqli_fetch_assoc(dquery("select credit from \r\ntbl_services_file where id='" . $xid . "'"));
    if ($r["id"] == $_SESSION["system_default_currency"]["id"]) {
        $serviceprice = $credit["credit"];
    } else {
        $qcredit = mysqli_fetch_assoc(dquery("select credit from tbl_file_credit\r\n                where currency_id='" . $r["id"] . "' and service_id='" . $xid . "'"));
        $serviceprice = $qcredit["credit"];
        if ($qcredit["credit"] == 0 || !$qcredit["credit"]) {
            $serviceprice = convertCurrency($credit["credit"], $_SESSION["system_default_currency"]["id"], $r["id"]);
        }
    }
    echo "                <tr class=\"credit_";
    echo $r["id"];
    echo "\">\r\n                    <td><i>";
    echo $r["code"];
    echo "</i></td>\r\n                    <td colspan=\"2\"></td>\r\n                </tr>\r\n            ";
    $qu = dquery("select *,(select username from tblUsers \r\n        where id=user_id) as user from tbl_discount_file\r\n        where user_id in (select id from tblUsers where default_currency='" . $r["id"] . "'\r\n        and client_group='" . $groupid . "') and discount!=0 and service_id='" . $xid . "'");
    $cnt = 0;
    while ($row = mysqli_fetch_assoc($qu)) {
        $hisdiscount = $serviceprice - $row["discount"];
        $groupdiscount = $serviceprice - $groupprice["discount"];
        if ($hisdiscount != $groupdiscount) {
            $cnt++;
            echo "                <tr>\r\n                    <td></td>\r\n                    <td >";
            echo $row["user"];
            echo "</td>\r\n                    <td><input type=\"hidden\"\r\n                               name=\"serviceprice[";
            echo $row["user_id"];
            echo "]\"\r\n                               value=\"";
            echo $serviceprice;
            echo "\"\r\n                               style=\"width: 100px\" />\r\n                        <input type=\"text\"\r\n                               name=\"groupuser[";
            echo $row["user_id"];
            echo "]\"\r\n                               value=\"";
            echo $serviceprice - $row["discount"];
            echo "\"\r\n                               style=\"width: 100px\" /></td>\r\n                </tr>\r\n            ";
        }
    }
    if ($cnt == 0) {
        echo "                <script>\r\n                    \$(\".credit_";
        echo $r["id"];
        echo "\").hide();\r\n                </script>\r\n                ";
    }
}
echo "\r\n            </tbody>\r\n        </table>\r\n        <p align=\"center\" class=\"fixedbtn\">\r\n            <input value=\"";
echo $LNG["update"];
echo "\" id=\"btnedituser1\"\r\n class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','clientfilegroupusers','#frmapi','#notification','true','#main_loader');\"/></p>\r\n\r\n    </form>\r\n";
$fileverioncheck = "6.1.0";

?>