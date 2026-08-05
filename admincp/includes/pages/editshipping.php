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
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($key) {
    dquery("UPDATE tbl_swkey SET `key`='" . $value . "' WHERE id='" . $id . "'");
    echo $value;
} else {
    if ($keygroup) {
        foreach ($id as $key => $value1) {
            dquery("UPDATE tbl_keygroup SET `group`='" . $value[$key] . "' WHERE id='" . $value1 . "'");
        }
    } else {
        if ($reject) {
            dquery("UPDATE tbl_order_product SET \tremove='1',user_can_c='3' WHERE order_id='" . $id . "'");
            $sql = mysqli_fetch_assoc(dquery("select invoiceid,service_id,subscribe,service_id,user_id,(SELECT default_currency from tblUsers where id=user_id) as cur,credit,discount,\tsh_state,sh_country,sh_zip from tbl_order_product where order_id='" . $id . "'"));
            $tax = mysqli_fetch_assoc(dquery("select shippingtax from \n     tbl_invoiceitems where invoiceid='" . $sql["invoiceid"] . "' and relid='" . $id . "'"));
            $price = $sql["credit"] - $sql["discount"] + $tax["shippingtax"];
            dquery("UPDATE tblUsers SET credit_left=(credit_left+'" . $price . "')\n      WHERE id='" . $sql["user_id"] . "'");
            addStatementuser($sql["user_id"], "Credit Refunded #" . $sql["invoiceid"], "CR", $price, $sql["invoiceid"]);
            $pr = mysqli_fetch_assoc(dquery("select reseller_id,reseller_discount from \n                                            tbl_order_product where order_id='" . $id . "'"));
            if ($pr["reseller_id"]) {
                dquery("UPDATE tblUsers SET credit_left=(credit_left-" . $pr["reseller_discount"] . ") \n                                            WHERE id='" . $pr["reseller_id"] . "'");
                addStatementuser($pr["reseller_id"], "Reseller Store Commision Rebate (invoice #" . $sql["invoiceid"] . ")", "DR", $pr["reseller_discount"], $sql["invoiceid"]);
            }
            if ($sql["subscribe"]) {
                dquery("UPDATE tbl_subscribers set used=used-1 WHERE \n    \t\tservice_id='" . $sql["service_id"] . "' AND user_id='" . $sql["user_id"] . "'\n    \t\tAND type='tbl_products'");
            }
            $prod = mysqli_fetch_assoc(dquery("select bundle,bundle_list,stock_allow from tbl_products \n            where id='" . $sql["service_id"] . "'"));
            if ($prod["stock_allow"] && $prod["bundle"]) {
                $ex = explode(",", $prod["bundle_list"]);
                foreach ($ex as $e) {
                }
            }
        } else {
            if ($status) {
                dquery("UPDATE tbl_order_product SET `user_can_c`='" . $value . "' WHERE order_id='" . $id . "'");
                if ($value == 0) {
                    echo $LNG["new"];
                } else {
                    if ($value == 1) {
                        echo $LNG["inprocess"];
                    } else {
                        if ($value == 3) {
                            echo $LNG["rejected"];
                        } else {
                            if ($value == 4) {
                                echo $LNG["sent"];
                                $time = time();
                                $date = date("Y-m-d");
                                dquery("UPDATE tbl_order_product SET `reply_time`='" . $time . "',\n             `reply_date`='" . $date . "' WHERE order_id='" . $id . "'");
                            } else {
                                if ($value == 6) {
                                    echo $LNG["onhold"];
                                } else {
                                    if ($value == 7) {
                                        echo $LNG["received"];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $val = explode("|", $id);
                if ($val[0]) {
                    dquery("UPDATE tbl_order_product SET `" . $val[0] . "`='" . $value . "' WHERE order_id='" . $val[1] . "'");
                    echo $value;
                }
            }
        }
    }
}
$fileverioncheck = "6.1.0";

?>