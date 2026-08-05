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
dquery("DELETE FROM tbl_disabledemail where uid='" . $uid . "'");
$q = dquery("select id,name from tbl_emailtemplates where \n    (for_reseller='1' or name='Price update notification')\n    AND ( type='imeiorder' or type='fileorder' or type='serverorder' \n    or type='imeiorder' or type='product' )");
while ($r = mysqli_fetch_assoc($q)) {
    if (!in_array($r["id"], $_POST["tid"])) {
        $data["uid"] = $uid;
        $data["tid"] = $r["id"];
        $db->insert("tbl_disabledemail", $data);
    }
}
echo "success:" . $LNG["datasavesuccessfully"];
echo "Œ";

?>