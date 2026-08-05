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
if ($formats) {
    if ($format == "Other") {
        $data["format"] = $otherformat;
    } else {
        $data["format"] = $format;
    }
    $data["isbn"] = $isbn;
    if ($audio_format == "Other") {
        $data["audio_format"] = $otheraudio_format;
    } else {
        $data["audio_format"] = $audio_format;
    }
    $db->update("tbl_products", $data, "id=" . $id);
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
    $data = NULL;
} else {
    if ($customfield) {
        include_once ROOTDIR . "/includes/features.fun.php";
        saveFeatures($id, $customfield);
        echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
    } else {
        $data["weight"] = $weight;
        if ($height) {
            $data["height"] = $height . " " . $unit;
        } else {
            $data["height"] = "";
        }
        if ($width) {
            $data["width"] = $width . " " . $unit2;
        } else {
            $data["width"] = "";
        }
        if ($depth) {
            $data["depth"] = $depth . " " . $unit1;
        } else {
            $data["depth"] = "";
        }
        if ($db->update("tbl_products", $data, "id=" . $id)) {
            echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    }
}

?>