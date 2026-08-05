<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($tbl) {
    $success = "";
    foreach ($tbl as $key => $value) {
        $cl = mysqli_fetch_assoc(dquery("select username from tblUsers where id='" . $id . "'"));
        logActivityGlobal("Client Remove " . $cl["username"], "profile", $id, "admin");
        deleteUser($id, $key);
    }
    $result = dquery("select id from tblUsers where reseller_id=" . $id);
    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($tbl as $key => $value) {
            deleteUser($row["id"], $key);
        }
    }
    if (!$mobile) {
        echo "redirect: main2.php?page=clientlist";
    } else {
        echo "redirect: main4.php?page=clients";
    }
}
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