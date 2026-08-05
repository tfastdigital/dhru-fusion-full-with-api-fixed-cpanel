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
if ($email) {
    if ($password) {
        $data["password"] = md5(md5($password) . "9486");
    }
    $data["first_name"] = $firstname;
    $data["last_name"] = $lastname;
    $data["email"] = $email;
    $data["phone"] = $phone;
    $data["address"] = $address;
    $data["userstatus"] = $status;
    $data["mywarehouse"] = $mywarehouse;
    $data["country"] = $country;
    if (is_array($days)) {
        $days = implode(",", $days);
    }
    $data["logindays"] = $days;
    if ($starthrs && $endhrs) {
        $data["start_time"] = $starthrs . " " . $startsec;
        $data["end_time"] = $endhrs . " " . $endsec;
    } else {
        $data["start_time"] = "";
        $data["end_time"] = "";
    }
    if ($db->update("tbl_supplier", $data, "id=" . $id)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["email"] . " " . $LNG["required"];
}

?>