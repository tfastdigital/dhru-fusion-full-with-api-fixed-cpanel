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
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n";
if ($tbl) {
    $u = explode(",", $uid);
    foreach ($u as $k) {
        $id = $k;
        foreach ($tbl as $key => $value) {
            deleteUser($id, $key);
        }
        $result = dquery("select id from tblUsers where reseller_id=" . $id);
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($tbl as $key => $value) {
                deleteUser($row["id"], $key);
            }
        }
    }
    echo "<div id=notification1 class=successbox>" . $LNG["data"] . " " . $LNG["deleted"] . " " . $LNG["successfully"] . "</div>";
}
echo "<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"uid\" value=\"";
echo $uid;
echo "\" />\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n  <th>";
echo $LNG["remove"];
echo " ";
echo $LNG["related"];
echo " ";
echo $LNG["items"];
echo "</th><th></th>\n  </tr>\n</thead>\n<tbody>\n";
$parent = [(string) $LNG["order"], (string) $LNG["discount"], (string) $LNG["email"], (string) $LNG["statement"], (string) $LNG["invoice"], (string) $LNG["login"]];
foreach ($parent as $key => $value) {
    echo "<tr><td><input type=\"checkbox\" checked=\"checked\" value=\"1\" name=\"tbl[";
    echo $value;
    echo "]\" id=\"";
    echo $key;
    echo "\"/> <label for=\"";
    echo $key;
    echo "\">";
    echo $value;
    echo "</label></td><td></td></tr>\n";
}
echo "</tbody></table>\n<br /><br />\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["delete"];
echo " ";
echo $LNG["data"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"submit\"/></p>\n\n</form></div></div> ";
$fileverioncheck = "6.1.0";
function deleteUser($id, $key)
{
    dquery("delete from tblUsers where id=" . $id);
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