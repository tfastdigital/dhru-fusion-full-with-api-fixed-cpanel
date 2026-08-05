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
include ROOTDIR . "/includes/fileservices.fun.php";
if (isset($_POST["select"])) {
    foreach ($_POST["select"] as $oid) {
        if (isset($_POST["reject"][$oid])) {
            $data["reason"] = $_POST["reason"][$oid];
            $db->update("tbl_order_file", "order_id=" . $oid);
            $data = NULL;
            rejectFile(md5($oid), $_POST["reply"][$oid], $_SESSION["adminid"]);
        } else {
            if ($_FILES["reply"][$oid]["error"] <= 0) {
                $REPLY = $_FILES["reply"][$oid]["name"];
                move_uploaded_file($_FILES["reply"][$oid]["tmp_name"], "../" . $donloaddirpath . "/" . $_FILES["reply"][$oid]["name"]);
                replySuccessFile(md5($oid), $REPLY, $_SESSION["adminid"]);
            }
        }
    }
    echo "success: " . $LNG["datasavesuccessfully"];
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>