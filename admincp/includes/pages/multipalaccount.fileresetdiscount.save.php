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
if ($group) {
    $WHERE .= " and client_group='" . $group . "'";
}
if ($statuss) {
    $WHERE .= " and userstatus='" . $statuss . "'";
}
if ($reseller) {
    $WHERE .= " and reseller_id='" . $reseller . "'";
}
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where \n   ( usertype=0 or usertype=1 ) " . $WHERE);
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
if ($file_service_id) {
    if ($file_service_id != "ALL") {
        if ($user) {
            if (!is_array($user)) {
                $user = explode(",", $user);
            }
            foreach ($user as $value) {
                $currency = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id=" . $value));
                $cur_id = $currency["default_currency"];
                if ($file_discount[$cur_id]) {
                    $sql = dquery("select * from tbl_discount_file where user_id='" . $value . "' and service_id='" . $file_service_id . "'");
                    if (mysqli_num_rows($sql)) {
                        dquery("update tbl_discount_file set discount=" . $file_hidden_dis[$cur_id] . "-" . $file_discount[$cur_id] . " where user_id=" . $value . " and service_id=" . $file_service_id);
                    } else {
                        $data2["discount"] = $file_hidden_dis[$cur_id] - $file_discount[$cur_id];
                        $data2["user_id"] = $value;
                        $data2["service_id"] = $file_service_id;
                        $db->insert("tbl_discount_file", $data2);
                        $data2 = NULL;
                    }
                }
            }
            echo "success:" . $LNG["discount"] . " " . $LNG["reset"] . " " . $LNG["successfully"] . " ";
        } else {
            echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
        }
    } else {
        echo "error: All Service Custom Price not possible";
    }
} else {
    echo "error:" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}

?>