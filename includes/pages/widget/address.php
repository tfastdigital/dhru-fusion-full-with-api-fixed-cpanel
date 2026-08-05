<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
if ($addresskey != "") {
    $User = mysqli_fetch_assoc(dquery("select `data` from tblUsers where id='" . $_SESSION["uid"] . "'"));
    if ($User["data"]) {
        $Data = json_decode($User["data"], true);
        echo json_encode($Data["address"][$addresskey]);
    }
} else {
    if ($deleteid == "") {
        if (!$firstname || !$country || !$address1 || !$zip || !$city || !$state) {
            $OUT["status"] = "error";
            $OUT["message"] = "Field required";
            echo _josnOUT($OUT);
            exit;
        }
    }
    $UPDATE = [];
    $UPDATE["country"] = $country;
    $UPDATE["firstname"] = $firstname;
    $UPDATE["phonenumber"] = $phonenumber;
    $UPDATE["address1"] = $address1;
    $UPDATE["address2"] = $address2;
    $UPDATE["landmark"] = $landmark;
    $UPDATE["zip"] = $zip;
    $UPDATE["city"] = $city;
    $UPDATE["state"] = $state;
    $UPDATE["preference"] = $preference;
    $UPDATE["phone_code"] = $phone_code;
    $UPDATE["country_code"] = $country_code;
    $UPDATE["state_code"] = $state_code;
    $UPDATE["city_code"] = $city_code;
    $UPDATE["latitude"] = $latitude;
    $UPDATE["longitude"] = $longitude;
    $where["id"] = $_SESSION["uid"];
    $index = "";
    if ($id != "") {
        $index = $id;
    }
    if ($deleteid != "") {
        $Data = [];
        $User = mysqli_fetch_assoc(dquery("select `data` from tblUsers where id='" . $_SESSION["uid"] . "'"));
        if ($User["data"]) {
            $Data = json_decode($User["data"], true);
        }
        unset($Data["address"][$deleteid]);
        $UpdatedValue = json_encode($Data);
        dquery("update tblUsers set `data`='" . $UpdatedValue . "' where id='" . $_SESSION["uid"] . "'");
        $RETURN = $UpdatedValue;
    } else {
        $RETURN = jsonUpdateToTable("tblUsers", "data", "address", $index, $UPDATE, $where);
    }
    $OUT["data"] = $RETURN;
    $OUT["status"] = "success";
    $OUT["message"] = "Data save successfully";
    echo _josnOUT($OUT);
}

?>