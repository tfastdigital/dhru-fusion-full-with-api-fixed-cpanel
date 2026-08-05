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
    if (mysqli_num_rows(dquery("select id from tbl_products\n      where id='" . $barcode . "'"))) {
        $pid = $barcode;
    }
}
$md5id = md5($pid);
$prdocutDetails = getProducts("", $md5id);
if ($shipping) {
    $_SESSION["SHIP"] = $shipping;
    exit;
}
if ($total) {
    $total = 0;
    $_SESSION["TOTALS"] = 0;
    if (isset($_SESSION["SALES"])) {
        foreach ($_SESSION["SALES"] as $k => $sales) {
            if (1 < count($sales["serial"])) {
                $sales["qnt"] = count($sales["serial"]);
            }
            if ($_SESSION["DTYPE"]) {
                $disc = $sales["price"] * $sales["qnt"] * $sales["disc"] / 100;
            } else {
                $disc = $sales["disc"];
            }
            $total = $total + $sales["price"] * $sales["qnt"] - $disc;
        }
        $_SESSION["TOTALS"] = $total;
    }
    echo "Subtotal: " . round($_SESSION["TOTALS"], 2) . " " . $config["base_currency"];
} else {
    if ($discount) {
        $_SESSION["DISCOUNTED"] = $discount;
        echo round($_SESSION["TOTALS"] - $_SESSION["DISCOUNTED"], 2);
    } else {
        if ($warehouse) {
            $_SESSION["WAREHOUSE"] = $idw;
        } else {
            if ($suspend) {
                if (isset($_SESSION["SALES"])) {
                    foreach ($_SESSION["SALES"] as $k => $sales) {
                        $pid = $pid . "," . $k;
                        $disc = $disc . "," . $sales["disc"];
                        $qnt = $qnt . "," . $sales["qnt"];
                        $price = $price . "," . $sales["price"];
                    }
                    $data["date"] = date("d-m-Y");
                    $data["cid"] = $_SESSION["CUSTOMER"];
                    $data["pid"] = trim($pid, ",");
                    $data["qnt"] = trim($qnt, ",");
                    $data["disc"] = trim($disc, ",");
                    $data["price"] = trim($price, ",");
                    $data["dtype"] = $_SESSION["DTYPE"];
                    $db->insert("tbl_suspended_sale", $data);
                } else {
                    echo "NOT";
                }
            } else {
                if ($setsuspended) {
                    $sql = mysqli_fetch_assoc(dquery("select * from \n        tbl_suspended_sale where id='" . $id . "'"));
                    if ($sql["cid"] && $step != "next") {
                        $_SESSION["CUSTOMER"] = $sql["cid"];
                        echo $_SESSION["CUSTOMER"];
                    }
                    if ($step == "next" && $sql["id"]) {
                        unset($_SESSION["SALES"]);
                        unset($_SESSION["CUSTOMER"]);
                        unset($_SESSION["AMOUNT"]);
                        unset($_SESSION["NOTES"]);
                        unset($_SESSION["GATEWAYS"]);
                        $_SESSION["DTYPE"] = $sql["dtype"];
                        $_SESSION["TOTALS"] = 0;
                        if ($sql["cid"]) {
                            $_SESSION["CUSTOMER"] = $sql["cid"];
                        }
                        $pro = explode(",", $sql["pid"]);
                        $disc = explode(",", $sql["disc"]);
                        $qnt = explode(",", $sql["qnt"]);
                        $price = explode(",", $sql["price"]);
                        foreach ($pro as $k => $p) {
                            $_SESSION["SALES"][$p]["price"] = $price[$k];
                            $_SESSION["SALES"][$p]["qnt"] = $qnt[$k];
                            $_SESSION["SALES"][$p]["disc"] = $disc[$k];
                            $prodt = mysqli_fetch_assoc(dquery("select service_name from \n                tbl_products where id='" . $p . "'"));
                            if ($_SESSION["DTYPE"]) {
                                $d = $price[$k] * $qnt[$k] * $disc[$k] / 100;
                            } else {
                                $d = $disc[$k];
                            }
                            $total = $price[$k] * $qnt[$k] - $d;
                            echo "             <tr id=\"";
                            echo $p;
                            echo "\">\n                <td>#";
                            echo $p;
                            echo "</td>\n                <td>";
                            echo $prodt["service_name"];
                            echo " <br /> \n                <a onclick=\"Remove(";
                            echo $p;
                            echo ")\"><span class=\"textred\">";
                            echo $LNG["delete"];
                            echo "</span></a></td>\n                <td style=\"text-align: center;\"><input style=\"text-align: right;width: 50px;\" type=\"text\" onkeypress=\"setTo(\$(this))\" onkeyup=\"updateData('";
                            echo $p;
                            echo "');\" class=\"prices\"  id=\"price[";
                            echo $p;
                            echo "]\" name=\"price[";
                            echo $p;
                            echo "]\" value=\"";
                            echo $price[$k];
                            echo "\" /></td>\n                <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\" onkeyup=\"updateData('";
                            echo $p;
                            echo "');\" class=\"qnts\" id=\"qnt[";
                            echo $p;
                            echo "]\" name='qnt[";
                            echo $p;
                            echo "]' value=\"";
                            echo $qnt[$k];
                            echo "\" /></td>\n                <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 20px;\" onkeypress=\"setTo(\$(this))\" onkeyup=\"updateData('";
                            echo $p;
                            echo "');\" class=\"discs\" id=\"disc[";
                            echo $p;
                            echo "]\"  name='disc[";
                            echo $p;
                            echo "]' value=\"";
                            echo $disc[$k];
                            echo "\" /></td>\n                <td style=\"text-align: right;\" id=\"tot_";
                            echo $p;
                            echo "\">";
                            echo $total;
                            echo "</td>\n              </tr>\n            ";
                        }
                        echo "--" . $_SESSION["DTYPE"];
                        dquery("delete from tbl_suspended_sale where id='" . $id . "'");
                    }
                } else {
                    if ($tax) {
                        $_SESSION["TAXS"] = 0;
                        $tax = $_SESSION["TAXS"];
                        $_SESSION["DISCOUNTED"] = 0;
                        require "../../../includes/invoice.fun.php";
                        if ($config["taxenabled"]) {
                            $g = mysqli_fetch_assoc(dquery("select gateway  from tbl_paymentgateways where setting='name'\n        and value='" . $gateway . "'"));
                            $taxrate = getTaxRate(1, "", "", $gateway);
                            $taxrate2 = getTaxRate(2, "", "", $gateway);
                            if ($_SESSION["SALES"]) {
                                foreach ($_SESSION["SALES"] as $k => $sales) {
                                    $p = mysqli_fetch_assoc(dquery("select taxed from \n                tbl_products where id='" . $k . "'"));
                                    if ($p["taxed"]) {
                                        if ($_SESSION["DTYPE"]) {
                                            $disc = $sales["price"] * $sales["qnt"] * $sales["disc"] / 100;
                                        } else {
                                            $disc = $sales["disc"];
                                        }
                                        $tot = $sales["price"] * $sales["qnt"] - $disc;
                                        $tax = $tot * $taxrate["rate"] / 100;
                                        $tax2 = $tot * $taxrate2["rate"] / 100;
                                        $tax = round($tax, 2);
                                        $tax2 = round($tax2, 2);
                                        $TOTTAX = $tax + $tax2;
                                    }
                                }
                            }
                            $_SESSION["GATEWAYS"] = $gateway;
                            $_SESSION["TAXS"] = $TOTTAX;
                        }
                        if ($taxrate["name"] && $tax) {
                            echo "<tr>\n<td style=\"width:25%;\" id=\"tax\">";
                            echo $taxrate["name"];
                            echo ": ";
                            echo round($tax, 2);
                            echo " ";
                            echo $config["base_currency"];
                            echo "</td>\n</tr>\n";
                        }
                        if ($taxrate2["name"] && $tax2) {
                            echo "<tr>\n<td style=\"width:25%;\" id=\"tax\">";
                            echo $taxrate2["name"];
                            echo ": ";
                            echo round($tax2, 2);
                            echo " ";
                            echo $config["base_currency"];
                            echo "</td>\n</tr>\n";
                        }
                        echo "<tr id=\"ships\" style=\"display: none;\">\n<td style=\"width:25%;\" >Shipping Cost: <span id=\"spice\">0</span> ";
                        echo $config["base_currency"];
                        echo "</td>\n</tr>\n<tr>\n<td style=\"width:25%;\" id=\"gross\">Total: ";
                        echo round($_SESSION["TOTALS"] + $TOTTAX, 2);
                        echo " ";
                        echo $config["base_currency"];
                        echo "</td>\n</tr>\n";
                    } else {
                        if ($type) {
                            $_SESSION["DTYPE"] = $pid;
                        } else {
                            if ($generate2) {
                                require_once ROOTDIR . "/includes/fun.inc.php";
                                require_once ROOTDIR . "/includes/invoice.fun.php";
                                require_once ROOTDIR . "/includes/clients.fun.inc.php";
                                require_once ROOTDIR . "/includes/mail.fun.php";
                                global $adminAddPayment;
                                $adminAddPayment = true;
                                $_SESSION["AMOUNT"] = $amount;
                                $_SESSION["NOTES"] = $note;
                                $_SESSION["STYPE"] = $stype;
                                $_SESSION["SHIP"] = $ship;
                                $_SESSION["WAREHOUSE"] = $wr;
                                $_SESSION["FIRST"] = $fn;
                                $_SESSION["LAST"] = $ln;
                                $_SESSION["EMAIL"] = $em;
                                $_SESSION["PHONE"] = $ph;
                                $_SESSION["GATEWAYS"] = $gt;
                                if ($_SESSION["STYPE"] == 2) {
                                    $list = "";
                                    foreach ($_SESSION["SALES"] as $k => $s) {
                                        if ($s["serial"]) {
                                            $g = mysqli_fetch_assoc(dquery("select pid from \n        tbl_serial_list where serial='" . $s["serial"] . "' and status='0'"));
                                            $k = $g["pid"];
                                            $sql = dquery("select (select service_name from tbl_products\n        where id=service_id)\n        as service from tbl_order_product \n        where service_id='" . $k . "' and user_id='" . $_SESSION["CUSTOMER"] . "'");
                                            if ($s["serial"]) {
                                                dquery("update `tbl_serial_list` set status='0'\n              ,refund='1' where serial='" . $s["serial"] . "' and \n              wid='" . $_SESSION["WAREHOUSE"] . "' limit 1");
                                            }
                                            if (mysqli_num_rows($sql)) {
                                                if (mysqli_num_rows($sql) < $s["qnt"]) {
                                                    $OUT["STATUS"] = "error";
                                                    $OUT["MSG"] = "Not enough quantity";
                                                } else {
                                                    dquery("update tbl_order_product set user_can_c='3'\n             where service_id='" . $k . "' and user_id='" . $_SESSION["CUSTOMER"] . "'\n              AND pos='1'");
                                                    dquery("update tbl_products set stock=stock+" . $s["qnt"] . "\n             where id='" . $k . "'");
                                                    $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                    $ins["pid"] = $k;
                                                    $ins["stockin"] = $s["qnt"];
                                                    $db->insert("tbl_warehousestock", $ins);
                                                    $ins = NULL;
                                                    $ins["qnt"] = $s["qnt"];
                                                    $ins["date"] = date("Y-m-d");
                                                    $ins["time"] = time();
                                                    $ins["pid"] = $k;
                                                    $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                    $ins["aid"] = $_SESSION["adminid"];
                                                    $ins["status"] = "IN";
                                                    $db->insert("tbl_stock_history", $ins);
                                                    $ins = NULL;
                                                    $sql = mysqli_fetch_assoc($sql);
                                                    $list = $list . $sql["service"] . ",";
                                                    $prod = mysqli_fetch_assoc(dquery("select bundle,bundle_list \n            from tbl_products where id='" . $k . "'"));
                                                    if ($prod["bundle"]) {
                                                        $ex = explode(",", $prod["bundle_list"]);
                                                        foreach ($ex as $e) {
                                                            dquery("update tbl_products set stock=stock+1\n                     where id='" . $e . "'");
                                                            $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                            $ins["pid"] = $e;
                                                            $ins["stockin"] = 1;
                                                            $db->insert("tbl_warehousestock", $ins);
                                                            $ins = NULL;
                                                            $ins["qnt"] = 1;
                                                            $ins["date"] = date("Y-m-d");
                                                            $ins["time"] = time();
                                                            $ins["pid"] = $e;
                                                            $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                            $ins["aid"] = $_SESSION["adminid"];
                                                            $ins["status"] = "IN";
                                                            $db->insert("tbl_stock_history", $ins);
                                                            $ins = NULL;
                                                        }
                                                    }
                                                    $OUT["STATUS"] = "success";
                                                    $OUT["MSG"] = "Order Rejected: " . $list;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $flag = 1;
                                    $canv = 0;
                                    if (isset($_SESSION["SALES"])) {
                                        foreach ($_SESSION["SALES"] as $k => $v) {
                                            if ($v["serial"]) {
                                                if (!mysqli_num_rows(dquery("select count(id) as cnt \n                from tbl_serial_list where serial='" . $v["serial"] . "' and status='0' \n                and wid='" . $_SESSION["WAREHOUSE"] . "' having cnt>=" . $v["qnt"]))) {
                                                    $flag = 0;
                                                } else {
                                                    $canv = 1;
                                                }
                                            }
                                        }
                                        if ($canv == 0) {
                                            $flag = 1;
                                        }
                                        if ($flag == 1) {
                                            if (!isset($_SESSION["CUSTOMER"])) {
                                                if ($_SESSION["FIRST"] && $_SESSION["LAST"] && $_SESSION["EMAIL"] && $_SESSION["PHONE"]) {
                                                    $u = explode("@", $_SESSION["EMAIL"]);
                                                    $username = $u[0];
                                                    $validator["username"] = [$u[0], true];
                                                    $password = generatePassword();
                                                    $admn = mysqli_fetch_assoc(dquery("select credit \n                    from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
                                                    $flager = false;
                                                    $validator["password"] = [$password, true];
                                                    $validator["email"] = [$_SESSION["EMAIL"], true];
                                                    $validator["first_name"] = [$_SESSION["FIRST"], false];
                                                    $validator["last_name"] = [$_SESSION["LAST"], false];
                                                    $validator["phonenumber"] = [$_SESSION["PHONE"], false];
                                                    $validator["default_theme"] = [$template, false];
                                                    $validator["admin_id"] = [$_SESSION["adminid"], false];
                                                    $validator["is_registered"] = ["1", false];
                                                    if ($error = validateProfiles($validator)) {
                                                        $OUT["STATUS"] = "error";
                                                        $OUT["MSG"] = $error;
                                                    }
                                                    if ($error = addNewUser($validator, "", "ADMIN")) {
                                                        $OUT["STATUS"] = "error";
                                                        $OUT["MSG"] = $error;
                                                    } else {
                                                        $u = mysqli_fetch_assoc(dquery("select id from \n                        tblUsers order by id desc limit 1"));
                                                        $_SESSION["CUSTOMER"] = $u["id"];
                                                    }
                                                } else {
                                                    $OUT["STATUS"] = "error";
                                                    $OUT["MSG"] = "Select Client or add new client";
                                                }
                                            }
                                            if ($config["lowstockalert"]) {
                                                foreach ($_SESSION["SALES"] as $k => $s) {
                                                    if ($s["serial"]) {
                                                        $g = mysqli_fetch_assoc(dquery("select pid from \n             tbl_serial_list where serial='" . $s["serial"] . "' and status='0'"));
                                                        $k = $g["pid"];
                                                        $sql = dquery("SELECT id,service_name,reorder_level,\n                reorder_notify,stock FROM tbl_products\n                where stock<=reorder_level and id='" . $k . "'");
                                                        $today = time();
                                                        while ($row = mysqli_fetch_assoc($sql)) {
                                                            $remind = ($today - $row["reorder_notify"]) / 86400;
                                                            if ($row["stock"] <= $row["reorder_level"] && $config["reorderlevel"] < $remind) {
                                                                dquery("update tbl_products set reorder_notify='" . $today . "' where id='" . $row["id"] . "'");
                                                                $pro = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editproduct&id=" . $row["id"]) . "&title=" . base64_encode("Edit Product") . "'>" . $row["service_name"] . "</a>";
                                                                $buff .= " " . $pro . " - Current Stock : " . $row["stock"] . " <br />";
                                                            }
                                                        }
                                                        if ($buff) {
                                                            $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("catlog") . "&title=" . base64_encode("List Products") . "'>here</a>";
                                                            $buff .= "<br /><br /> Click " . $here . " to view Product List";
                                                            sendNotification("system", "[URGENT] Low quantity", $buff, "", (string) $config["config_admin_mail"]);
                                                        }
                                                    }
                                                }
                                            }
                                            if ($OUT["STATUS"] != "error") {
                                                $users = getClientsDetails($_SESSION["CUSTOMER"]);
                                                if ($users["currency"]["id"] != $_SESSION["system_default_currency"]["id"]) {
                                                    foreach ($_SESSION["SALES"] as $k => $s) {
                                                        if ($s["serial"]) {
                                                            $currencyid = $_ClientsDetails["currency"]["id"];
                                                            $_SESSION["SALES"][$k]["price"] = convertCurrency($s["price"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                                                            $_SESSION["SALES"][$k]["disc"] = convertCurrency($s["disc"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                                                            $curid = $users["currency"]["id"];
                                                            $_SESSION["AMOUNT"] = convertCurrency($_SESSION["AMOUNT"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                                                            $data = mysqli_fetch_assoc(dquery("SELECT * FROM \n                        `tbl_currencies` WHERE id='" . $curid . "'"));
                                                            $_SESSION["currency"] = $data;
                                                        }
                                                    }
                                                }
                                                $totaled = 0;
                                                foreach ($_SESSION["SALES"] as $k => $s) {
                                                    if ($s["serial"]) {
                                                        $g = mysqli_fetch_assoc(dquery("select pid from \n         tbl_serial_list where serial='" . $s["serial"] . "' and status='0'"));
                                                        $k = $g["pid"];
                                                        $pro = mysqli_fetch_assoc(dquery("select purchase_cost,service_name,taxed \n        from tbl_products where id='" . $k . "'"));
                                                        if ($s["serial"]) {
                                                            dquery("update `tbl_serial_list` set status='1'\n           where serial='" . $s["serial"] . "' and status='0' limit " . $s["qnt"]);
                                                        }
                                                        $data = NULL;
                                                        $data["note"] = $_SESSION["NOTES"];
                                                        $data["service_id"] = $k;
                                                        $data["purchase_cost"] = $pro["purchase_cost"];
                                                        $data["user_id"] = $_SESSION["CUSTOMER"];
                                                        $data["date"] = date("Y-m-d");
                                                        $data["time"] = time();
                                                        $data["reply_time"] = time();
                                                        $data["reply_date"] = date("Y-m-d");
                                                        $data["user_can_c"] = 4;
                                                        $data["pass_key"] = md5(time() . $_SESSION["CUSTOMER"] . time());
                                                        $data["credit"] = $s["price"];
                                                        $disc = $s["price"] * $s["disc"] / 100;
                                                        $data["discount"] = $disc;
                                                        $data["sh_email"] = $users["email"];
                                                        $data["sh_contact"] = $users["phonenumber"];
                                                        $data["sh_firstname"] = $users["firstname"];
                                                        $data["sh_lastname"] = $users["lastname"];
                                                        $data["sh_address1"] = $users["address1"];
                                                        $data["sh_address2"] = $users["address2"];
                                                        $data["sh_city"] = $users["city"];
                                                        $data["sh_zip"] = $users["zip"];
                                                        $data["sh_state"] = $users["state"];
                                                        $data["sh_country"] = $users["country"];
                                                        $data["pos"] = 1;
                                                        $data["warehouse"] = $_SESSION["WAREHOUSE"];
                                                        $date = date("Y-m-d");
                                                        $data["ip"] = $_SERVER["REMOTE_ADDR"];
                                                        $data["currency_id"] = $users["currency_id"];
                                                        $oids = "";
                                                        $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                        $ins["pid"] = $k;
                                                        $ins["stockout"] = $s["qnt"];
                                                        $db->insert("tbl_warehousestock", $ins);
                                                        $ins = NULL;
                                                        $ins["qnt"] = $s["qnt"];
                                                        $ins["date"] = date("Y-m-d");
                                                        $ins["time"] = time();
                                                        $ins["pid"] = $k;
                                                        $ins["wid"] = $_SESSION["WAREHOUSE"];
                                                        $ins["aid"] = $_SESSION["adminid"];
                                                        $ins["status"] = "OUT";
                                                        $sth[] = $db->insert("tbl_stock_history", $ins);
                                                        $ins = NULL;
                                                        $m = 0;
                                                        for ($i = 1; $i <= $s["qnt"]; $i++) {
                                                            $data["serial"] = $s["serial"];
                                                            $order = $db->insert("tbl_order_product", $data);
                                                            $ordarr[] = $order;
                                                            $totaled = $totaled + $s["price"] - $disc;
                                                            insert_query("tbl_invoiceitems", ["qnt" => "p_" . $k, "userid" => $_SESSION["CUSTOMER"], "type" => "Product", "serial" => $data["serial"], "relid" => $order, "shippingtax" => round($_SESSION["SHIP"], 2), "description" => $pro["service_name"], "amount" => $s["price"] - $disc, "taxed" => $pro["taxed"], "duedate" => "now()", "pos" => "1", "paymentmethod" => $_SESSION["GATEWAYS"], "bundleid" => $s["bundleid"], "warehouse" => $_SESSION["WAREHOUSE"]]);
                                                            $_SESSION["SHIP"] = 0;
                                                            $m++;
                                                        }
                                                    }
                                                }
                                                $invoiceid = generateInvoice($_SESSION["CUSTOMER"], false);
                                                if (is_array($sth)) {
                                                    foreach ($sth as $s) {
                                                        if ($s) {
                                                            dquery("UPDATE tbl_stock_history set \n                    relid='" . $invoiceid . "' where id='" . $s . "'");
                                                        }
                                                    }
                                                }
                                                if (is_array($ordarr)) {
                                                    foreach ($ordarr as $o) {
                                                        if ($o) {
                                                            dquery("UPDATE tbl_order_product set \n                    invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                                                        }
                                                    }
                                                }
                                                if ($_SESSION["AMOUNT"]) {
                                                    addPayment($invoiceid, "", $_SESSION["AMOUNT"], "", $_SESSION["GATEWAYS"]);
                                                }
                                                update_query("tbl_invoices", ["paymentmethod" => $_SESSION["GATEWAYS"]], ["md5(id)" => md5($invoiceid), "userid" => $_SESSION["CUSTOMER"]]);
                                                if ($config["taxenabled"]) {
                                                    $taxrate = getTaxRate(1, "", "", $_SESSION["GATEWAYS"]);
                                                    $taxrate2 = getTaxRate(2, "", "", $_SESSION["GATEWAYS"]);
                                                    $taxrate = $taxrate["rate"];
                                                    $taxrate2 = $taxrate2["rate"];
                                                    $tax = $totaled * $taxrate["rate"] / 100;
                                                    $tax2 = $totaled * $taxrate2["rate"] / 100;
                                                    $tax = round($tax, 2);
                                                    $tax2 = round($tax2, 2);
                                                    $sql = dquery("UPDATE tbl_invoices SET `taxrate`='" . $taxrate . "',\n                `taxrate2`='" . $taxrate2 . "'\n                WHERE  id='" . $invoiceid . "' AND userid='" . $_SESSION["CUSTOMER"] . "'");
                                                    $sql = dquery("UPDATE tbl_invoices SET `tax`=" . $tax . ",`tax2`=" . $tax2 . "\n                WHERE  id='" . $invoiceid . "' AND userid='" . $_SESSION["CUSTOMER"] . "'");
                                                    updateInvoiceTotal($invoiceid);
                                                }
                                                if ($gateway) {
                                                    update_query("tbl_invoices", ["paymentmethod" => $_SESSION["GATEWAYS"]], ["id" => $invoiceid, "userid" => $_SESSION["CUSTOMER"]]);
                                                }
                                                require_once ROOTDIR . "/includes/gateway.fun.php";
                                                $gatewaysarray = getGatewaysArray();
                                                if ($_SESSION["adminid"]) {
                                                    $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
                                                }
                                                updateInvoiceTotal($invoiceid);
                                                $OUT["STATUS"] = "success";
                                                $OUT["MSG"] = $invoiceid;
                                            }
                                        } else {
                                            $OUT["STATUS"] = "error";
                                            $OUT["MSG"] = "This much of Qnt not avaialble";
                                        }
                                    } else {
                                        $OUT["STATUS"] = "error";
                                        $OUT["MSG"] = "Please add products";
                                    }
                                }
                                echo json_encode($OUT);
                                exit;
                            } else {
                                if ($generate) {
                                    $_SESSION["AMOUNT"] = $amount;
                                    $_SESSION["NOTES"] = $note;
                                    $_SESSION["STYPE"] = $stype;
                                    $_SESSION["SHIP"] = $ship;
                                    $_SESSION["WAREHOUSE"] = $wr;
                                    $_SESSION["FIRST"] = $fn;
                                    $_SESSION["LAST"] = $ln;
                                    $_SESSION["EMAIL"] = $em;
                                    $_SESSION["PHONE"] = $ph;
                                } else {
                                    if ($customer) {
                                        $sql = mysqli_fetch_assoc(dquery("select id,username,email,credit_left,address,address2,state,city,zip,country,phonenumber\n    ,(select code from tbl_currencies where id=default_currency) as code from tblUsers where \n    id='" . $pid . "'"));
                                        $_SESSION["CUSTOMER"] = $pid;
                                        echo "<table>\n<tbody>\n<tr>\n    <td>        \n        <strong>";
                                        echo $sql["username"];
                                        echo "</strong><br />\n        Email : ";
                                        echo $sql["email"];
                                        echo "<br />            \n        Mobile : ";
                                        echo $sql["phonenumber"];
                                        echo "          <br /> \n        ";
                                        echo $sql["address"];
                                        echo ",";
                                        echo $sql["address2"];
                                        echo ",<br />\n        ";
                                        echo $sql["city"];
                                        echo " - ";
                                        echo $sql["zip"];
                                        echo " <br />\n        ";
                                        echo $sql["state"];
                                        echo ",";
                                        echo $sql["country"];
                                        echo " \n    </td>    \n</tr>\n</tbody>\n</table>\n<br />\n<p style=\"text-align: right;\">\n<input type=\"button\" class=\"btn\" name=\"removeUser\" onclick=\"detach()\" value=\"Detach\" />\n</p>  \n<hr />\n    ";
                                    } else {
                                        if ($detach) {
                                            unset($_SESSION["CUSTOMER"]);
                                            echo "<script>\n\$('#cid').keyup(function(e) {\n      var vls=\$(this).val();\n      if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57)  || (e.which>=96 && e.which<=105)){ \n           \$.post(\"includes/pages/pos.sales.product.php?client=true\", \n           { val: vls},function(data) {\n                 \$('#client').show();\n                 \$('#client').html(data);\n           });\n       }\n       else if(e.which==40 || e.which==38 || e.which==13){\n           gener2(e);\n       }\n});    \n</script>\n <input type=\"text\" name=\"customer\" id=\"cid\"  \n  value=\"\" placeholder=\"Username\" />\n<a onclick=\"javascript: \$('.clients').toggle();\" href=\"#\">+";
                                            echo $LNG["add"];
                                            echo " ";
                                            echo $LNG["client"];
                                            echo " </a>\n<div id=\"client\" style=\"display: none;\"></div>       \n<div style=\"display: none;\" class=\"clients\" >\n<input type=\"text\" name=\"firstname\" id=\"firstname\" value=\"\" placeholder=\"First Name\" /> <br />\n<input type=\"text\" name=\"lastname\" id=\"lastname\" value=\"\" placeholder=\"Last Name\" /> <br />\n<input type=\"text\" name=\"email\" id=\"email\" value=\"\" placeholder=\"Email\" /> <br />\n<input type=\"text\" name=\"phone\" id=\"phone\" value=\"\" placeholder=\"Phone\" /> <br />\n</div>               \n                           \n                           \n";
                                        } else {
                                            if ($update) {
                                                $stock = getWarehouseStock($_SESSION["WAREHOUSE"], $prdocutDetails["id"]);
                                                $cflag = false;
                                                if ($config["followstock"] && $q > $stock && !$_SESSION["DESIRED"][$prdocutDetails["id"]] && 1 < $q) {
                                                    echo "ABS---";
                                                    $cflag = true;
                                                } else {
                                                    if ($q > $stock && !$_SESSION["DESIRED"][$prdocutDetails["id"]] && 1 < $q) {
                                                        $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                                                        echo "NOT---";
                                                    }
                                                }
                                                if (!$cflag) {
                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["price"] = $p;
                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] = $q;
                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["disc"] = $d;
                                                    $tot = $p * $q;
                                                    if ($_SESSION["DTYPE"]) {
                                                        $disc = $tot * $d / 100;
                                                        echo round($tot - $disc, 2);
                                                    } else {
                                                        echo round($tot - $d, 2);
                                                    }
                                                }
                                            } else {
                                                if ($remove) {
                                                    foreach ($_SESSION["SALES"] as $k => $sales) {
                                                        foreach ($sales["serial"] as $sk => $s) {
                                                            if ($s == $val) {
                                                                unset($_SESSION["SALES"][$k]["serial"][$sk]);
                                                            }
                                                        }
                                                    }
                                                    exit;
                                                } else {
                                                    if ($prdocutDetails["id"] && (!isset($_SESSION["SALES"][$prdocutDetails["id"]]) || $_SESSION["SALES"][$prdocutDetails["id"]]["serial"] != $serial && $serial != "")) {
                                                        if ($prdocutDetails["bundle"] && $prdocutDetails["bundle_list"]) {
                                                            $flag = false;
                                                            $sflag = false;
                                                            $bundleprice = $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                            $bid = $prdocutDetails["id"];
                                                            $ex = explode(",", $prdocutDetails["bundle_list"]);
                                                            $bt = 0;
                                                            foreach ($ex as $e) {
                                                                $md5id = md5($e);
                                                                $prdocutDetails = getProducts("", $md5id);
                                                                $stock = getWarehouseStock($_SESSION["WAREHOUSE"], $prdocutDetails["id"]);
                                                                if ($config["followstock"] && $stock <= 0) {
                                                                    $sflag = true;
                                                                } else {
                                                                    if ($stock <= 0) {
                                                                        $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                                                                        $flag = true;
                                                                    }
                                                                }
                                                                if (!($config["followstock"] && $stock <= 0)) {
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["price"] = $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] = 1;
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["disc"] = 0;
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["bundle"] = $bid;
                                                                    $bt = $bt + $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                    echo "                 <tr id=\"";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "\">\n                    <td>#";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "</td>\n                    <td>";
                                                                    echo $prdocutDetails["service_name"];
                                                                    echo " <br /> \n                    <a onclick=\"Remove(";
                                                                    echo $prdocutDetails["id"];
                                                                    echo ")\"><span class=\"textred\">";
                                                                    echo $LNG["delete"];
                                                                    echo "</span></a></td>\n                    <td style=\"text-align: center;\"><input style=\"text-align: right;width: 50px;\" type=\"text\" onkeypress=\"setTo(\$(this))\"  class=\"prices\"  id=\"price[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]\" name=\"price[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]\" value=\"";
                                                                    echo round($prdocutDetails["credit"] - $prdocutDetails["discount"], 2);
                                                                    echo "\" /></td>\n                    <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\"  class=\"qnts\" id=\"qnt[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]\" name='qnt[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]' value=\"1\" /></td>\n                    <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 20px;\" onkeypress=\"setTo(\$(this))\"  class=\"discs\" id=\"disc[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]\"  name='disc[";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "]' value=\"0\" /></td>                    \n                    <td style=\"text-align: right;\" id=\"tot_";
                                                                    echo $prdocutDetails["id"];
                                                                    echo "\">";
                                                                    echo $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                    echo "</td>\n                  </tr>\n                 ";
                                                                }
                                                            }
                                                            if ($sflag && $stype != 2) {
                                                                foreach ($_SESSION["SALES"] as $k => $sales) {
                                                                    if ($sales["bundle"] == $bid) {
                                                                        unset($_SESSION["SALES"][$k]);
                                                                    }
                                                                }
                                                                echo "---ABS";
                                                            } else {
                                                                if ($flag && $stype != 2) {
                                                                    echo "---NOT";
                                                                }
                                                            }
                                                        } else {
                                                            if ($prdocutDetails["id"]) {
                                                                if ($serial) {
                                                                    $sto = mysqli_num_rows(dquery("select id from tbl_serial_list\n                 where serial like '" . $serial . "' and status=0 and wid='" . $_SESSION["WAREHOUSE"] . "'"));
                                                                    $stock = $sto;
                                                                } else {
                                                                    $stock = getWarehouseStock($_SESSION["WAREHOUSE"], $prdocutDetails["id"]);
                                                                }
                                                                if (0 < $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"]) {
                                                                    $jaguar = 0;
                                                                    foreach ($_SESSION["SALES"][$prdocutDetails["id"]]["serial"] as $srs) {
                                                                        if ($srs == $serial) {
                                                                            $jaguar = 1;
                                                                        }
                                                                    }
                                                                    if ($jaguar == 1) {
                                                                        $stock = $stock - $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"];
                                                                    }
                                                                }
                                                                if (!($config["followstock"] && $stock <= 0)) {
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["price"] = $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                    if ($_SESSION["SALES"][$prdocutDetails["id"]] && in_array($serial, $_SESSION["SALES"][$prdocutDetails["id"]]["serial"])) {
                                                                        if ($_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] < mysqli_num_rows(dquery("select id from tbl_serial_list\n            where serial='" . $serial . "' and status=0"))) {
                                                                            $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] = 1;
                                                                        } else {
                                                                            exit;
                                                                        }
                                                                    } else {
                                                                        $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] = 1;
                                                                    }
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["disc"] = 0;
                                                                    $_SESSION["SALES"][$prdocutDetails["id"]]["serial"][] = $serial;
                                                                    if ($serial) {
                                                                        echo "             <tr id=\"";
                                                                        echo $serial;
                                                                        echo "\">\n               <!-- <td>#";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "</td>-->\n                <td>\n                 ";
                                                                        if (0 < $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"]) {
                                                                            echo "                <script>\n                \$(\"#";
                                                                            echo $prdocutDetails["id"] . ($_SESSION["SALES"][$prdocutDetails["id"]]["qnt"] - 1);
                                                                            echo "\").remove();\n                </script>\n                ";
                                                                        }
                                                                        echo "                ";
                                                                        echo $prdocutDetails["service_name"];
                                                                        echo " [<strong>";
                                                                        echo $serial;
                                                                        echo "</strong>] <br /> \n                <a onclick=\"Remove(";
                                                                        echo $serial;
                                                                        echo ")\"><span class=\"textred\">";
                                                                        echo $LNG["delete"];
                                                                        echo "</span></a></td>\n                <td style=\"text-align: center;\"><input onkeyup=\"updateData('";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "');\"  style=\"text-align: right;width: 50px;\" type=\"text\" onkeypress=\"setTo(\$(this))\"  class=\"prices\"  id=\"price[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" name=\"price[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" value=\"";
                                                                        echo round($prdocutDetails["credit"] - $prdocutDetails["discount"], 2);
                                                                        echo "\" /></td>\n                <td style=\"text-align: center;\">1<input type=\"hidden\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\"  class=\"qnts\" id=\"qnt[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" name='qnt[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]' value=\"";
                                                                        echo $_SESSION["SALES"][$prdocutDetails["id"]]["qnt"];
                                                                        echo "\" /></td>\n                <td style=\"text-align: center;\"><input onkeyup=\"updateData('";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "');\" type=\"text\" style=\"text-align: right;width: 20px;\" onkeypress=\"setTo(\$(this))\"  class=\"discs\" id=\"disc[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\"  name='disc[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]' value=\"0\" /></td>\n                <td style=\"text-align: right;\" id=\"tot_";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "\">";
                                                                        echo $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                        echo "</td>\n            </tr>\n             ";
                                                                    } else {
                                                                        echo "             <tr id=\"";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "\">\n               <!-- <td>#";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "</td>-->\n                <td>";
                                                                        echo $prdocutDetails["service_name"];
                                                                        echo "<br /> \n                <a onclick=\"Remove(";
                                                                        echo $prdocutDetails["id"];
                                                                        echo ")\"><span class=\"textred\">";
                                                                        echo $LNG["delete"];
                                                                        echo "</span></a></td>\n                <td style=\"text-align: center;\"><input style=\"text-align: right;width: 50px;\" type=\"text\" onkeypress=\"setTo(\$(this))\"  class=\"prices\"  id=\"price[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" name=\"price[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" value=\"";
                                                                        echo round($prdocutDetails["credit"] - $prdocutDetails["discount"], 2);
                                                                        echo "\" /></td>\n                <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 30px;\" onkeypress=\"setTo(\$(this))\"  class=\"qnts\" id=\"qnt[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\" name='qnt[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]' value=\"1\" /></td>\n                <td style=\"text-align: center;\"><input type=\"text\" style=\"text-align: right;width: 20px;\" onkeypress=\"setTo(\$(this))\"  class=\"discs\" id=\"disc[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]\"  name='disc[";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "]' value=\"0\" /></td>\n                <td style=\"text-align: right;\" id=\"tot_";
                                                                        echo $prdocutDetails["id"];
                                                                        echo "\">";
                                                                        echo $prdocutDetails["credit"] - $prdocutDetails["discount"];
                                                                        echo "</td>\n            </tr>\n             ";
                                                                    }
                                                                }
                                                                if ($config["followstock"] && $stock <= 0 && $stype != 2) {
                                                                    echo "---ABS";
                                                                } else {
                                                                    if ($stock <= 0 && $stype != 2) {
                                                                        $_SESSION["DESIRED"][$prdocutDetails["id"]] = true;
                                                                        echo "---NOT";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
$fileverioncheck = "6.1.0";
function generatePassword($length = 8)
{
    $password = "";
    $possible = "12346789ABCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($maxlength < $length) {
        $length = $maxlength;
    }
    $i = 0;
    while ($i < $length) {
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;
}

?>