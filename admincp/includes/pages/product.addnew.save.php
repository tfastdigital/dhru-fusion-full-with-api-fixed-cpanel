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
if ($productname) {
    if ($hidd) {
        $check = mysqli_num_rows(dquery("select * from tbl_products where service_name='" . $productname . "'"));
        if ($check != 0) {
            echo "error:" . $LNG["productname"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        $row = mysqli_fetch_assoc(dquery("select * from tbl_products where id='" . $hidd . "'"));
        $row["id"] = NULL;
        $row["service_name"] = $productname;
        if ($pos) {
            $row["pos"] = $pos;
        }
        $newsid = $db->insert("tbl_products", $row);
        $row = NULL;
        if ($newsid) {
            if ($pos) {
                echo "success: Product added successfully";
            } else {
                echo "callfunction:editproduct:" . $newsid;
            }
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        $data["service_name"] = $productname;
        $service_name = mysqli_fetch_assoc(dquery("SELECT service_name FROM tbl_products where id='" . $id . "'"));
        if ($servicename != $service_name["service_name"]) {
            $check = mysqli_num_rows(dquery("select * from tbl_products where service_name='" . $servicename . "'"));
        }
        if ($check != 0) {
            echo "error:" . $LNG["servicename"] . " " . $LNG["already"] . " " . $LNG["exists"];
            exit;
        }
        if (!$groupname) {
            echo "error:" . $LNG["group"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
            exit;
        }
        if ($pos) {
            $data["pos"] = $pos;
        }
        $data["group_id"] = $groupname;
        $data["time"] = $time1 . " " . $timeref;
        $data["credit"] = $credit;
        $data["availability_date"] = $availability_date;
        $data["active"] = $status;
        $data["bundle"] = $bundle;
        $newsid = $db->insert("tbl_products", $data);
        if ($newsid) {
            if ($pos) {
                echo "success: Product added successfully";
            } else {
                echo "callfunction:editproduct:" . $newsid;
            }
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    }
} else {
    echo "error:" . $LNG["product"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
}

?>