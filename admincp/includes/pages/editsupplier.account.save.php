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
if ($credit && $id) {
    $data["amount"] = formatCurrency2($credit);
    $data["supplier_id"] = $id;
    $data["type"] = "CR";
    $data["date"] = date("Y-m-d");
    $data["time"] = time();
    $data["note"] = $note;
    $data["ptype"] = $ptype;
    $data["tid"] = $tid;
    $data["description"] = "Payout by Admin";
    $data["ip"] = $_SERVER["REMOTE_ADDR"];
    if ($ptype == "addtocredit") {
        $sql = dquery("select * from tblUsers where id='" . $uid . "'");
        if (mysqli_num_rows($sql)) {
            include_once ROOTDIR . "/includes/clients.fun.inc.php";
            addCredit($uid, $credit, true, "", $note);
            if ($db->insert("tbl_statement_supplier", $data)) {
                echo "success:" . $LNG["datasavesuccessfully"];
            } else {
                echo "error:" . $LNG["datanotsave"];
            }
        } else {
            echo "error: Wrong User ID";
            exit;
        }
    } else {
        if ($db->insert("tbl_statement_supplier", $data)) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    }
} else {
    echo "error:" . $LNG["amount"] . " " . $LNG["required"];
}

?>