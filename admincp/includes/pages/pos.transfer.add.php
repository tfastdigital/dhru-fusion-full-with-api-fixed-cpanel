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
    if (mysqli_num_rows(dquery("select id from tbl_products \n     where id='" . $barcode . "'"))) {
        $pid = $barcode;
    }
}
$md5id = md5($pid);
$prdocutDetails = getProducts("", $md5id);
if ($warehouset) {
    $_SESSION["WAREHOUSET"] = $idw;
} else {
    if ($warehousef) {
        $_SESSION["WAREHOUSEF"] = $idw;
    } else {
        if ($generate) {
            $msg = "";
            checkDemoMode(false);
            if ($_SESSION["WAREHOUSEF"] != $_SESSION["WAREHOUSET"]) {
                if (isset($_SESSION["TRANS"])) {
                    foreach ($_SESSION["TRANS"] as $k => $trans) {
                        $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $k);
                        $is = 0;
                        $time = time();
                        foreach ($trans["serial"] as $serial) {
                            if (trim($serial)) {
                                dquery("update tbl_serial_list set wid='" . $_SESSION["WAREHOUSET"] . "',transist='" . $time . "'\n                        where serial='" . $serial . "' and wid='" . $_SESSION["WAREHOUSEF"] . "' and status='0' limit 1");
                                $ins = NULL;
                                $is++;
                            }
                        }
                        if ($is) {
                            $trans["qnt"] = $is;
                        }
                        if ($trans["qnt"] <= $stock && $msg == "") {
                            $ins["wid"] = $_SESSION["WAREHOUSEF"];
                            $ins["pid"] = $k;
                            $ins["stockout"] = $trans["qnt"];
                            $ins["notes"] = $notes;
                            $ins["time"] = $time;
                            $ins["transferby"] = $tranby == 1 ? "Instant" : "Transport";
                            $ins["days"] = $delt;
                            $ins["date"] = $deld;
                            $ins["transferto"] = $_SESSION["WAREHOUSET"];
                            if ($tranby == 1) {
                                $ins["status"] = 1;
                            }
                            $db->insert("tbl_warehousestock", $ins);
                            $ins = NULL;
                            if ($tranby == 1) {
                                $ins["wid"] = $_SESSION["WAREHOUSET"];
                                $ins["pid"] = $k;
                                $ins["stockin"] = $trans["qnt"];
                                $ins["notes"] = $notes;
                                $ins["time"] = $time;
                                $db->insert("tbl_warehousestock", $ins);
                                $ins = NULL;
                            }
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
                echo "Both warehouse should not same !";
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
                    $_SESSION["TRANS"][$prdocutDetails["id"]] = 0;
                    unset($_SESSION["TRANS"][$prdocutDetails["id"]]);
                } else {
                    if ($prdocutDetails["id"] && (!isset($_SESSION["TRANS"][$prdocutDetails["id"]]) || $_SESSION["TRANS"][$prdocutDetails["id"]]["serial"] != $serial && $serial != "")) {
                        $stock = getWarehouseStock($_SESSION["WAREHOUSEF"], $prdocutDetails["id"], $serial);
                        if ($_SESSION["TRANS"][$prdocutDetails["id"]]["serial"]) {
                            $stock = $stock - count($_SESSION["TRANS"][$prdocutDetails["id"]]["serial"]);
                        }
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
                            $_SESSION["TRANS"][$prdocutDetails["id"]]["qnt"] = 1;
                            $_SESSION["TRANS"][$prdocutDetails["id"]]["serial"][] = $serial;
                            if ($serial != "") {
                                echo "              <tr id=\"";
                                echo $prdocutDetails["id"];
                                echo "\">\n                <td>#";
                                echo $prdocutDetails["id"];
                                echo "</td>\n                <td>";
                                echo $prdocutDetails["service_name"];
                                echo " [";
                                echo $serial;
                                echo "] <br /> \n                <a onclick=\"Remove(";
                                echo $prdocutDetails["id"];
                                echo ")\"><span class=\"textred\">";
                                echo $LNG["delete"];
                                echo "</span></a></td>\n                 <td style=\"text-align: center;\"><input type=\"hidden\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\"  class=\"qnts\" id=\"qnt[";
                                echo $prdocutDetails["id"];
                                echo "]\" name='qnt[";
                                echo $prdocutDetails["id"];
                                echo "]' value=\"1\" />1</td>\n              </tr>\n             ";
                            } else {
                                echo "              <tr id=\"";
                                echo $prdocutDetails["id"];
                                echo "\">\n                <td>#";
                                echo $prdocutDetails["id"];
                                echo "</td>\n                <td>";
                                echo $prdocutDetails["service_name"];
                                echo " <br /> \n                <a onclick=\"Remove(";
                                echo $prdocutDetails["id"];
                                echo ")\"><span class=\"textred\">";
                                echo $LNG["delete"];
                                echo "</span></a></td>\n                 <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\"  class=\"qnts\" id=\"qnt[";
                                echo $prdocutDetails["id"];
                                echo "]\" name='qnt[";
                                echo $prdocutDetails["id"];
                                echo "]' value=\"1\" /></td>\n              </tr>\n             ";
                            }
                        }
                    }
                }
            }
        }
    }
}
$fileverioncheck = "6.1.0";

?>