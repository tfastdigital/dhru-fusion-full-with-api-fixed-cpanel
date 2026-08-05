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
if ($id) {
    $sql = mysqli_fetch_assoc(dquery("select relproduct,relaccess from tbl_products where id='" . $id . "'"));
    $relpro = $mid = explode(",", $sql["relproduct"]);
    $relasc = $did = explode(",", $sql["relaccess"]);
    foreach ($hid as $k => $v) {
        foreach ($mid as $c => $s) {
            if ($mid[$c] == $hid[$k]) {
                unset($mid[$c]);
            }
        }
    }
    $relatedpro = implode(",", $mid);
    if ($pro) {
        foreach ($pro as $key => $v) {
            if (!in_array($key, $mid)) {
                $relatedpro .= "," . $key;
            }
        }
        $relatedpro = trim($relatedpro, ",");
    }
    foreach ($hid as $k => $v) {
        foreach ($did as $c => $s) {
            if ($did[$c] == $hid[$k]) {
                unset($did[$c]);
            }
        }
    }
    $relatedac = implode(",", $did);
    if ($ace) {
        foreach ($ace as $key => $v) {
            if (!in_array($key, $did)) {
                $relatedac .= "," . $key;
            }
        }
        $relatedac = trim($relatedac, ",");
    }
    $data["relproduct"] = trim($relatedpro, ",");
    $data["relaccess"] = trim($relatedac, ",");
    if ($db->update("tbl_products", $data, "id='" . $id . "'")) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>