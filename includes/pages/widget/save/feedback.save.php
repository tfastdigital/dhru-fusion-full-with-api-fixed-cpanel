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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
if ($type && $order) {
    if ($feedback) {
        if ($type == "imei") {
            $table = "tbl_order_imei";
        } else {
            if ($type == "file") {
                $table = "tbl_order_file";
            } else {
                if ($type == "server") {
                    $table = "tbl_order_server";
                } else {
                    if ($type == "shop") {
                        $table = "tbl_order_product";
                    }
                }
            }
        }
        $order = mysqli_fetch_assoc(dquery("SELECT order_id from " . $table . " where md5(order_id)='" . $order . "'"));
        $data["email"] = $email;
        if ($type == "imei") {
            $data["lid"] = $order["order_id"];
        } else {
            if ($type == "server") {
                $data["sid"] = $order["order_id"];
            } else {
                if ($type == "shop") {
                    $data["pid"] = $order["order_id"];
                }
            }
        }
        $data["rate"] = $estart;
        $data["date"] = date("d-m-Y");
        $data["comment"] = nl2br($feedback);
        $db->insert("tbl_review", $data);
        echo "success: " . $lng_languag["thankscomments"];
    } else {
        echo "error: " . $lng_languag["feedback"] . " " . $lng_languag["blankfield"];
    }
} else {
    if ($comment && $id) {
        $order = mysqli_fetch_assoc(dquery("select service_id,user_id from tbl_order_product\n    where md5(order_id)='" . $id . "' and feedback='0'"));
        if ($order["service_id"]) {
            $sql = mysqli_fetch_assoc(dquery("select bysupplier,id from tbl_products where id='" . $order["service_id"] . "'"));
            if ($feedtype == 1) {
                dquery("update tbl_supplier set success=success+1 where id='" . $sql["bysupplier"] . "'");
            } else {
                dquery("update tbl_supplier set reject=reject+1 where id='" . $sql["bysupplier"] . "'");
            }
            $_ClientsDetails = getClientsDetails($order["user_id"]);
            $name = $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"];
            $email = $_ClientsDetails["email"];
            $data["name"] = $name;
            $data["email"] = $email;
            $data["comment"] = nl2br($comment);
            $data["rate"] = $estart;
            $data["date"] = date("d-m-Y");
            $data["pid"] = $order["service_id"];
            $data["supplier"] = $sql["bysupplier"];
            if ($db->insert("tbl_review", $data)) {
                dquery("update tbl_order_product set feedback=1 where  md5(order_id)='" . $id . "'");
            }
            echo "success: " . $lng_languag["thankscomments"];
        }
    } else {
        echo "error: " . $lng_languag["review"] . " " . $lng_languag["blankfield"];
    }
}

?>