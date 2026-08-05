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
if ($template == 3) {
    $myFile = "../templates/" . $_SESSION["admin_template"] . "/billing.tpl";
    $fh = fopen($myFile, "w");
    fwrite($fh, html_entity_decode($_POST["coder"]));
    fclose($fh);
} else {
    if ($template == 2) {
        $myFile = "../templates/" . $_SESSION["admin_template"] . "/landscape.tpl";
        $fh = fopen($myFile, "w");
        fwrite($fh, html_entity_decode($_POST["coder"]));
        fclose($fh);
    } else {
        if ($template == 1) {
            $myFile = "../templates/" . $_SESSION["admin_template"] . "/invoice.tpl";
            $fh = fopen($myFile, "w");
            fwrite($fh, html_entity_decode($_POST["coder"]));
            fclose($fh);
        }
    }
}
$data["papertype"] = $papertype;
$data["template"] = $template;
$db->update("tbl_pos_setting", $data, "id=1");
echo "success: Setting save successully";

?>