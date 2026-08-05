<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($tbl) {
    foreach ($tbl as $key => $value) {
        logActivityGlobal("Client Remove #" . $id, "profile", $id, "admin");
        deleteUser($id, $key);
    }
    $result = dquery("select id ,username from tblUsers where reseller_id=" . $id);
    while ($row = mysqli_fetch_assoc($result)) {
        logActivityGlobal("Client Remove " . $row["username"], "profile", $id, "admin");
        foreach ($tbl as $key => $value) {
            deleteUser($row["id"], $key);
        }
    }
    echo "<div id=notification1 class=successbox>" . $LNG["data"] . " " . $LNG["deleted"] . " " . $LNG["successfully"] . "</div>";
}
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n  <th>";
echo $LNG["remove"];
echo " ";
echo $LNG["related"];
echo " ";
echo $LNG["items"];
echo "</th>\n  <th></th>\n  </tr>\n</thead>\n<tbody>\n";
$parent = [(string) $LNG["order"], (string) $LNG["discount"], (string) $LNG["email"], (string) $LNG["statement"], (string) $LNG["invoice"], (string) $LNG["login"]];
foreach ($parent as $key => $value) {
    echo "<tr><td>\n<input type=\"checkbox\" checked=\"checked\" value=\"1\"\n name=\"tbl[";
    echo $value;
    echo "]\" id=\"";
    echo $key;
    echo "\"/> \n<label for=\"";
    echo $key;
    echo "\">";
    echo $value;
    echo "</label></td>\n<td></td>\n</tr>\n";
}
echo "</tbody></table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["delete"];
echo " ";
echo $LNG["data"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"submit\"/></p>\n\n</form></div></div> ";
$fileverioncheck = "6.1.0";
function deleteUser($id, $key)
{
    dquery("delete from tblUsers where id=" . $id);
    $cq = dquery("select id from tbl_customfields where `type`='regis'");
    while ($rcq = mysqli_fetch_assoc($cq)) {
        dquery("DELETE FROM tbl_customfieldsvalues\n                where relid='" . $id . "' and fieldid='" . $rcq["id"] . "'");
    }
    if ($key == "Order") {
        dquery("delete from tbl_order_imei where user_id=" . $id);
        dquery("delete from tbl_order_file where user_id=" . $id);
        dquery("delete from tbl_order_server where user_id=" . $id);
        dquery("delete from tbl_order_product where user_id=" . $id);
    }
    if ($key == "Discount") {
        dquery("delete from tbl_discount_imei where user_id=" . $id);
        dquery("delete from tbl_discount_file where user_id=" . $id);
        dquery("delete from tbl_discount_server_log where user_id=" . $id);
        dquery("delete from tbl_discount_product where user_id=" . $id);
    }
    if ($key == "Email") {
        dquery("delete from tbl_email_history where userid=" . $id);
    }
    if ($key == "Invoice") {
        dquery("delete from tbl_invoiceitems where userid=" . $id);
        dquery("delete from tbl_invoices where userid=" . $id);
    }
    if ($key == "Login") {
        dquery("delete from tbl_online_user where userid=" . $id);
        dquery("delete from tbl_loginlog_user where userid=" . $id);
    }
    if ($key == "Statement") {
        dquery("delete from tbl_statement_user where uid=" . $id);
    }
    return true;
}

?>