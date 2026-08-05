<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
if ($action == "tax") {
    $tx = dquery("select id,`name`,taxrate from tbl_tax");
    while ($rt = mysqli_fetch_assoc($tx)) {
        $OUT[] = $rt;
    }
    echo json_encode($OUT);
    exit;
}
if ($action == "remove") {
    unset($_SESSION["SALES"][$rid]);
}
if ($action == "update" && $id) {
    $_SESSION["SALES"][$id]["qnt"] = $qnt;
    $_SESSION["SALES"][$id]["price"] = $price;
    $_SESSION["SALES"][$id]["disc"] = $discount;
}
if ($action == "add" && $serial && $wid) {
    $current = 0;
    if (mysqli_num_rows(dquery("select * from tbl_serial_list\n    where serial='" . $serial . "' and status='0' and wid='" . $wid . "' and transist=''"))) {
        $slist = mysqli_fetch_assoc(dquery("select * from tbl_serial_list\n        where serial='" . $serial . "' and status='0' and wid='" . $wid . "' and transist=''"));
        $stock = mysqli_num_rows(dquery("select id from tbl_serial_list\n        where  serial='" . $serial . "' and status='0' and wid='" . $wid . "' and transist=''"));
        foreach ($_SESSION["SALES"] as $k => $sales) {
            if ($sales["serial"] == $serial) {
                $current += $_SESSION["SALES"][$k]["qnt"];
                $_SESSION["unique"] = $k;
            }
        }
        if ($current < $stock) {
            if (!$current) {
                if (!$_SESSION["unique"]) {
                    $_SESSION["unique"] = 1;
                } else {
                    $_SESSION["unique"]++;
                }
            }
            $product = mysqli_fetch_assoc(dquery("select id,pos,\n            service_name,credit from \n            tbl_products where id='" . $slist["pid"] . "'"));
            if (trim($serial)) {
                $_SESSION["SALES"][$_SESSION["unique"]]["serial"] = $serial;
                if (!$current) {
                    $_SESSION["SALES"][$_SESSION["unique"]]["qnt"] = 1;
                } else {
                    $_SESSION["SALES"][$_SESSION["unique"]]["qnt"] = $current + 1;
                }
                $_SESSION["SALES"][$_SESSION["unique"]]["price"] = $product["credit"];
                $OUT["status"] = "success";
                $OUT["data"] = ["id" => $_SESSION["unique"], "serial" => $serial, "item" => $product["service_name"], "price" => $product["credit"], "qnt" => $_SESSION["SALES"][$_SESSION["unique"]]["qnt"], "discount" => 0];
            }
        } else {
            $OUT["status"] = "error";
            $OUT["data"] = ["Out of Stock!"];
        }
        echo json_encode($OUT);
    }
}
$fileverioncheck = "6.1.0";

?>