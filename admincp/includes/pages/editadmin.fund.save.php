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
if ($admni) {
    $data["credit"] = "";
    $db->update("tbl_admin", $data, "id=" . $admni);
    $data = NULL;
} else {
    $admns = mysqli_fetch_assoc(dquery("select credit from tbl_admin where id='" . $id . "'"));
    if ($creditleft) {
        $data["credit"] = $admns["credit"] + $creditleft;
        $db->update("tbl_admin", $data, "id=" . $id);
        $data = NULL;
        $data["amount"] = $creditleft;
        $data["aid"] = $id;
        $data["desc"] = $admin_notea;
        $data["date"] = date("Y-m-d");
        $data["type"] = "Add";
        $db->insert("tbl_admin_fund_log", $data);
        $data = NULL;
        echo "success: Fund Increased";
    }
    if ($rebatecredit) {
        if ($rebatecredit <= $admns["credit"]) {
            $data["credit"] = $admns["credit"] - $rebatecredit;
            $db->update("tbl_admin", $data, "id=" . $id);
            $data = NULL;
            $data["amount"] = -1 * abs($rebatecredit);
            $data["aid"] = $id;
            $data["desc"] = $admin_noter;
            $data["date"] = date("Y-m-d");
            $data["type"] = "Rebate";
            $db->insert("tbl_admin_fund_log", $data);
            $data = NULL;
            echo "success: Fund Descreased";
        } else {
            echo "error: Rebate fund exceed than available fund";
        }
    }
}

?>