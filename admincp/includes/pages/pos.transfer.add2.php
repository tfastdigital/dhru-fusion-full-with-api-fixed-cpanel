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
$pid = $_POST["val"];
require_once "../../../includes/products.fun.php";
if ($pid) {
    $barcode = $pid / 2 - 497;
    if (mysqli_num_rows(dquery("select DISTINCT pid,serial,(select service_name from tbl_products where id=pid) \n    as service from tbl_serial_list where serial LIKE '" . $pid . "%' and status='0'"))) {
        $dr = mysqli_fetch_assoc(dquery("select DISTINCT pid,serial,wid from tbl_serial_list where serial='" . $pid . "'\n and status='0'"));
        $pid = $dr["pid"];
    } else {
        echo "UNAVL";
    }
}
$md5id = md5($pid);
$prdocutDetails = getProducts("", $md5id);
if ($lastserials) {
    $_SESSION["lastserial"] = $lastserials;
}
if ($warehouset) {
    $_SESSION["WAREHOUSET"] = $idw;
} else {
    if ($warehousef) {
        $_SESSION["WAREHOUSEF"] = $idw;
    } else {
        if ($generate) {
            $msg = "";
            checkDemoMode(false);
            if (isset($_SESSION["TRANS"])) {
                foreach ($_SESSION["TRANS"] as $k => $trans) {
                    $k = explode("-", $k);
                    $k = $k[0];
                    $stock = getWarehouseStock($trans["ware"], $k);
                    if ($trans["qnt"] <= $stock && $msg == "") {
                        $ins["wid"] = $trans["ware"];
                        $ins["pid"] = $k;
                        $ins["stockout"] = 1;
                        $db->insert("tbl_warehousestock", $ins);
                        $ins = NULL;
                        $ins["wid"] = $_SESSION["WAREHOUSET"];
                        $ins["pid"] = $k;
                        $ins["stockin"] = 1;
                        $db->insert("tbl_warehousestock", $ins);
                        $ins = NULL;
                        dquery("UPDATE tbl_serial_list SET wid='" . $_SESSION["WAREHOUSET"] . "' where serial='" . $trans["serial"] . "'");
                    } else {
                        $msg = "Not enough quantity";
                    }
                }
                if (!$msg) {
                    echo "Stock transferred successfully";
                } else {
                    echo $msg;
                }
            }
        } else {
            if ($update) {
                checkDemoMode(false);
                $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $prdocutDetails["id"]);
                $cflag = false;
                if ($q > $stock && !$_SESSION["DESIRED"][$prdocutDetails["id"]] && 1 < $q) {
                    echo "ABS---";
                    $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                    $cflag = true;
                } else {
                    if ($q > $stock && !$_SESSION["DESIRED"][$prdocutDetails["id"]] && 1 < $q) {
                        $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                        echo "NOT---";
                    }
                }
                if (!$cflag) {
                    $_SESSION["TRANS"][$prdocutDetails["id"]]["qnt"] = $q;
                }
            } else {
                if ($remove) {
                    $_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]] = 0;
                    unset($_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]]);
                } else {
                    if ($prdocutDetails["id"] && !isset($_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]]["serial"])) {
                        $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $prdocutDetails["id"]);
                        if ($stock <= 0) {
                            $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                            echo "---ABS";
                        } else {
                            if ($stock <= 0) {
                                $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                                echo "---NOT";
                            }
                        }
                        if ($stock > 0) {
                            $_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]]["qnt"] = 1;
                            $_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]]["ware"] = $dr["wid"];
                            $_SESSION["TRANS"][$prdocutDetails["id"] . "-" . $dr["serial"]]["serial"] = $dr["serial"];
                            echo "             <tr id=\"";
                            echo $prdocutDetails["id"] . "-" . $dr["serial"];
                            echo "\">\n                <td>#";
                            echo $prdocutDetails["id"];
                            echo "</td>\n                <td>";
                            echo $prdocutDetails["service_name"];
                            echo " - [";
                            echo $dr["serial"];
                            echo "] <br /> \n                <a onclick=\"Remove('";
                            echo $prdocutDetails["id"] . "-" . $dr["serial"];
                            echo "')\"><span class=\"textred\">";
                            echo $LNG["delete"];
                            echo "</span></a></td>\n                <td>\n                ";
                            $w = mysqli_fetch_assoc(dquery("select name from tbl_warehouse where id='" . $dr["wid"] . "'"));
                            echo $w["name"];
                            echo "                </td>\n                 <td style=\"text-align: center;\">\n                 1</td>\n              </tr>\n             ";
                        }
                    }
                }
            }
        }
    }
}
$fileverioncheck = "6.1.0";

?>