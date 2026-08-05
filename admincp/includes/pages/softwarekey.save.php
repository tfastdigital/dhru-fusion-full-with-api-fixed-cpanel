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
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($key) {
    $key = explode("\n", $key);
    if (trim($code2)) {
        $code2 = explode("\n", trim($code2));
    } else {
        $code2 = "";
    }
    if (count($key) != count($code2) && $code2 != "") {
        echo "error: Code1 and Code2 not match";
        exit;
    }
    foreach ($key as $c) {
        if (!$ignore) {
            $code = trim($c);
            if (mysqli_num_rows(dquery("select id from tbl_swkey where `key`='" . $code . "' and group_id='" . $group . "'"))) {
                echo "error: Repeat code found " . $code;
                exit;
            }
        }
    }
    foreach ($key as $jk => $c) {
        $data["key"] = trim($c);
        $data["code2"] = trim($code2[$jk]);
        $data["group_id"] = $group;
        $data["qnt"] = $qnt ? $qnt : 1;
        $data["oid"] = "1";
        $data["purchase"] = $purchase;
        $data["addedon"] = date("Y-m-d");
        $data["expiredon"] = $to;
        $db->insert("tbl_swkey", $data);
    }
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["key"] . " " . $LNG["required"];
}

?>