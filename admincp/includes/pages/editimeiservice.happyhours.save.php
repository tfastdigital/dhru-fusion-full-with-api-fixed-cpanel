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
if (!$promotional) {
    $promotional = 0;
}
if ($_POST["status"]) {
    $status = 1;
} else {
    $status = 0;
}
$data["reward"] = $reward;
$data["point"] = $point;
$data["purchasepoint"] = $purchasepoint;
if ($days && $happyhoursch == "day" && $status) {
    $days = implode(",", $days);
    $data["happy_hours_weekdays"] = $days;
    $data["happy_hours_start"] = "";
    $data["happy_hours_end"] = "";
    $data["promotiondis"] = $promotional;
    $data["happy_hours_repetation"] = $repetation;
} else {
    if ($happyhourstart && $happyhourend && $happyhoursch == "date" && $status) {
        $data["happy_hours_start"] = $happyhourstart . " " . $timefrom;
        $data["happy_hours_end"] = $happyhourend . " " . $timeto;
        $data["happy_hours_weekdays"] = "";
        $data["promotiondis"] = $promotional;
        $data["happy_hours_repetation"] = $repetation;
    } else {
        if ($happyhoursch == "nocrt" && $status) {
            $data["happy_hours_weekdays"] = "sun,mon,tue,wed,thu,fri,sat";
            $data["happy_hours_start"] = "";
            $data["happy_hours_end"] = "";
            $data["promotiondis"] = $promotional;
            $data["happy_hours_repetation"] = $repetation;
        } else {
            $data["happy_hours_weekdays"] = "";
            $data["happy_hours_start"] = "";
            $data["happy_hours_end"] = "";
            $data["promotiondis"] = $promotional = "0";
            $data["happy_hours_repetation"] = "";
        }
    }
}
if (!$id) {
    $id = $sid;
}
$data["promotiondis"] = formatCurrency2($data["promotiondis"]);
if ($db->update("tbl_services_imei", $data, "id=" . $id . " and credit>=" . $promotional)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>