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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
global $lng_languag;
$throughReg = false;
$gateway = preg_replace("/[^0-9a-z-_]/i", "", $gateway);
if (isset($_COOKIE["AFFILIATETO"])) {
    $aids = preg_replace("/[^0-9a-z-_]/i", "", dec($_COOKIE["AFFILIATETO"], "9486"));
}
if ($shipping) {
    $_SESSION["CARTOTHER"]["GIFT"] = $gift;
    if ($_POST["shipping"] != "on") {
        if (!trim($sh_email)) {
            echo "error:<li>" . $lng_languag["clientareaerroremail"];
            exit;
        }
        if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $sh_email)) {
            echo "error:<li>" . $lng_languag["clientareaerroremailinvalid"];
            exit;
        }
        if ($sh_contact != "") {
            $phonenumber = $sh_contact;
            if (preg_replace("/[0-9 .\\-()]/", "", $phonenumber)) {
                echo "error:<li>" . $lng_languag["clientareaerrorphonenumber2"];
                exit;
            }
        }
        if ($sh_firstname && $sh_lastname && $sh_address1 && $sh_city && $sh_zip && $sh_state && $country2) {
            $_SESSION["CARTOTHER"]["sh_email"] = $sh_email;
            $_SESSION["CARTOTHER"]["sh_contact"] = $sh_contact;
            $_SESSION["CARTOTHER"]["sh_firstname"] = $sh_firstname;
            $_SESSION["CARTOTHER"]["sh_lastname"] = $sh_lastname;
            $_SESSION["CARTOTHER"]["sh_address1"] = $sh_address1;
            $_SESSION["CARTOTHER"]["sh_address2"] = $sh_address2;
            $_SESSION["CARTOTHER"]["sh_city"] = $sh_city;
            $_SESSION["CARTOTHER"]["sh_zip"] = $sh_zip;
            $_SESSION["CARTOTHER"]["sh_state"] = $sh_state;
            $_SESSION["CARTOTHER"]["sh_country"] = $country2;
            if ($nexts == "cartpayment") {
                echo "redirect: cart.php?action=viewnew&sub=" . $nexts;
            } else {
                echo "success: " . $lng_languag["detailsavesuccess"];
            }
        } else {
            echo "error: " . $lng_languag["filefield"];
            exit;
        }
    } else {
        if ($nexts == "cartpayment") {
            echo "redirect: cart.php?action=viewnew&sub=" . $nexts;
        } else {
            echo "success: " . $lng_languag["detailsavesuccess"];
        }
    }
} else {
    $flag = false;
    if ($_SESSION["CART"]) {
        foreach ($_SESSION["CART"] as $cartdtl) {
            if ($cartdtl["type"] == "product") {
                $slq = mysqli_fetch_assoc(dquery("select virtual from tbl_products where id='" . $cartdtl["id"] . "'"));
                if (!$slq["virtual"]) {
                    $flag = true;
                }
            }
        }
    }
    if ($gateway && ($_SESSION["SHIPPINGID"] || !$flag)) {
        $_SESSION["CARTOTHER"]["GT"] = $gateway;
        if (!$_SESSION["SHIPPINGID"]) {
            $_SESSION["SHIPPINGID"] = "not";
        }
        $u = mysqli_fetch_assoc(dquery("select cardnum,cardtype,startdate,expdate,ccv \n    FROM tblUsers WHERE id='" . $_SESSION["uid"] . "'"));
        if (($u["cardnum"] == "" || $u["cardtype"] == "") && $gateway == "cc") {
            checkCreditCard($cardno, $cardtype, $errornumber, $errortext);
            if ($cardname && $endmonth && $endyear && $ccv) {
                if ($errornumber) {
                    echo "error:" . $errortext;
                    exit;
                }
                $lastfr = substr($cardno, strlen($cardno) - 4, 4);
                $cardname = preg_replace("/[^a-zA-Z\\s]/", "", $cardname);
                $cardno = preg_replace("/[^0-9]/", "", $cardno);
                $ccv = preg_replace("/[^0-9]/", "", $ccv);
                dquery("UPDATE tblUsers \n                SET \n                cardnum= AES_ENCRYPT('" . $cardno . "','" . $ccenckey . "'),\n                cardtype= '" . $cardtype . "',\n                cardname='" . $cardname . "',\n                ccv= AES_ENCRYPT('" . $ccv . "','" . $ccenckey . "'),\n                startdate= AES_ENCRYPT('" . $startmonth . "-" . $startyear . "','" . $ccenckey . "'),\n                expdate= AES_ENCRYPT('" . $endmonth . "-" . $endyear . "','" . $ccenckey . "'),\n                cardlastfour='" . $lastfr . "'\n                WHERE id='" . $_SESSION["uid"] . "'");
            } else {
                echo "error: Credit Card details are compulsary";
                exit;
            }
        }
        if ($nexts == "checkout") {
            $gift = $_SESSION["CARTOTHER"]["GIFT"];
            if ($steps) {
                $gateway = $_SESSION["CARTOTHER"]["GT"];
                $curriers = $_SESSION["SHIPPINGID"];
                $sh_email = $_SESSION["CARTOTHER"]["sh_email"];
                $sh_contact = $_SESSION["CARTOTHER"]["sh_contact"];
                $sh_firstname = $_SESSION["CARTOTHER"]["sh_firstname"];
                $sh_lastname = $_SESSION["CARTOTHER"]["sh_lastname"];
                $sh_address1 = $_SESSION["CARTOTHER"]["sh_address1"];
                $sh_address2 = $_SESSION["CARTOTHER"]["sh_address2"];
                $sh_city = $_SESSION["CARTOTHER"]["sh_city"];
                $sh_zip = $_SESSION["CARTOTHER"]["sh_zip"];
                $sh_state = $_SESSION["CARTOTHER"]["sh_state"];
                $country2 = $_SESSION["CARTOTHER"]["sh_country"];
            }
            if ($_SESSION["uid"]) {
                $flag = false;
                if ($_SESSION["CART"]) {
                    foreach ($_SESSION["CART"] as $cartdtl) {
                        if ($cartdtl["type"] == "product") {
                            $slq = mysqli_fetch_assoc(dquery("select virtual from tbl_products where id='" . $cartdtl["id"] . "'"));
                            if (!$slq["virtual"]) {
                                $flag = true;
                            }
                        }
                    }
                }
                if ($flag) {
                    global $curriers;
                    if (!$curriers) {
                        echo "error: " . $lng_languag["selectshippingservice"];
                        exit;
                    }
                }
                $u = mysqli_fetch_assoc(dquery("select cardnum,cardtype,startdate,expdate,ccv \n                    FROM tblUsers WHERE id='" . $_SESSION["uid"] . "'"));
                if (($u["cardnum"] == "" || $u["cardtype"] == "") && $gateway == "cc") {
                    checkCreditCard($cardno, $cardtype, $errornumber, $errortext);
                    if ($cardname && $endmonth && $endyear && $ccv) {
                        if ($errornumber) {
                            echo "error:" . $errortext;
                            exit;
                        }
                        $lastfr = substr($cardno, strlen($cardno) - 4, 4);
                        $cardname = preg_replace("/[^a-zA-Z\\s]/", "", $cardname);
                        $cardno = preg_replace("/[^0-9]/", "", $cardno);
                        $ccv = preg_replace("/[^0-9]/", "", $ccv);
                        dquery("UPDATE tblUsers \n                            SET cardnum= AES_ENCRYPT('" . $cardno . "','" . $ccenckey . "'),\n                            cardtype= '" . $cardtype . "',\n                            cardname='" . $cardname . "',\n                            ccv= AES_ENCRYPT('" . $ccv . "','" . $ccenckey . "'),\n                            startdate= AES_ENCRYPT('" . $startmonth . "-" . $startyear . "','" . $ccenckey . "'),\n                            expdate= AES_ENCRYPT('" . $endmonth . "-" . $endyear . "','" . $ccenckey . "'),\n                            cardlastfour='" . $lastfr . "'\n                            WHERE id='" . $_SESSION["uid"] . "'");
                    } else {
                        echo "error: Credit Card details are compulsary";
                        exit;
                    }
                }
            }
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            if ($_SESSION["CART"]) {
                foreach ($_SESSION["CART"] as $keyq => $cartdtl) {
                    $serviceDetails = NULL;
                    if (!$gateway) {
                        $paymentmethod = mysqli_fetch_assoc(dquery("select gateway from tbl_paymentgateways limit 1"));
                        $paymentmethod = $paymentmethod["gateway"];
                    } else {
                        $paymentmethod = $gateway;
                    }
                    if ($cartdtl["type"] == "imei") {
                        $data = NULL;
                        require_once ROOTDIR . "/includes/imeiservices.fun.php";
                        $serviceDetails = getIMEIServices("", md5($cartdtl["id"]), "", "", "", "", true);
                        $data["service_id"] = $cartdtl["id"];
                        if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                            $serviceDetails["purchase_cost"] = getPurchaseCost($_SESSION["system_default_currency"]["id"], $serviceDetails["id"], "imei");
                            if (!$serviceDetails["purchase_cost"]) {
                                $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                            }
                        }
                        $data["purchase_cost"] = $cartdtl["orderdetail"]["purchase_cost"];
                        if (0 < $serviceDetails["purchase_cost"]) {
                            $data["profit"] = $serviceDetails["purchase_cost"] - ($serviceDetails["credit"] - $serviceDetails["discount"]);
                        }
                        $data["user_id"] = $_ClientsDetails["id"];
                        $data["imei"] = $cartdtl["orderdetail"]["imei"];
                        $data["date"] = date("Y-m-d");
                        $data["time"] = time();
                        $data["user_can_c"] = 5;
                        $data["pass_key"] = md5(time() . $_ClientsDetails["id"] . time());
                        $data["model_id"] = $cartdtl["orderdetail"]["model_id"];
                        $data["provider_id"] = $cartdtl["orderdetail"]["provider_id"];
                        $data["provider_c_id"] = $cartdtl["orderdetail"]["provider_c_id"];
                        $data["network_id"] = $cartdtl["orderdetail"]["network_id"];
                        $data["mep"] = $cartdtl["orderdetail"]["mep"];
                        $data["KBH"] = $cartdtl["orderdetail"]["KBH"];
                        $data["PIN"] = $cartdtl["orderdetail"]["PIN"];
                        $data["PRD"] = $cartdtl["orderdetail"]["PRD"];
                        $data["Type"] = $cartdtl["orderdetail"]["Type"];
                        $data["Reference"] = $cartdtl["orderdetail"]["Reference"];
                        $data["note"] = $cartdtl["orderdetail"]["note"];
                        $data["comments"] = $cartdtl["orderdetail"]["comments"];
                        $data["Locks"] = $cartdtl["orderdetail"]["Locks"];
                        $data["credit"] = $serviceDetails["credit"];
                        $data["discount"] = $serviceDetails["discount"];
                        $data["retail_shop"] = 1;
                        $data["currency_id"] = $_ClientsDetails["currency_id"];
                        $data["ip"] = $_SERVER["REMOTE_ADDR"];
                        if ($storeowner["id"]) {
                            $data["reseller_id"] = $storeowner["id"];
                            $totcredit = $serviceDetails["credit"] - $serviceDetails["discount"];
                            $resdiscount = $totcredit * $serviceDetails["resellerdisc"] / 100;
                            $data["reseller_discount"] = round($resdiscount, $precision);
                        }
                        if ($aids && $_SESSION["IS_REGISTERED"]) {
                            $data["aid"] = $aids;
                        }
                        $order = $db->insert("tbl_order_imei", $data);
                        $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                        unset($data);
                        if (!function_exists(checkCustomFields)) {
                            require_once ROOTDIR . "/includes/customfield.fun.inc.php";
                        }
                        saveCustomFields($order, $cartdtl["orderdetail"]["customfield"]);
                        if ($cartdtl["orderdetail"]["promotion"] && !$_SESSION["CARTPROMOTION"]) {
                            $promotioncode = $cartdtl["orderdetail"]["promotion"];
                            if (!function_exists(getPromotion)) {
                                include_once ROOTDIR . "/includes/cart.fun.php";
                            }
                            $promotion = getPromotion($promotioncode, $_SESSION["currency"], $serviceDetails["credit"] * $cartdtl["qnt"], $serviceDetails["id"], $cartdtl["type"]);
                        }
                        if ($_SESSION["CARTPROMOTION"]) {
                            $promotion = "";
                            $promotioncode = $_SESSION["CARTPROMOTION"];
                        }
                        insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "IMEI", "relid" => $order, "description" => $cartdtl["name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "promotion" => $promotion, "promotion_code" => $promotioncode]);
                    }
                    if ($cartdtl["type"] == "server") {
                        require_once ROOTDIR . "/includes/serverservices.fun.php";
                        $serviceDetails = getServerServices("", md5($cartdtl["id"]), "", "", "", "", true);
                        $data = NULL;
                        $data["note"] = $cartdtl["orderdetail"]["note"];
                        $data["comments"] = $cartdtl["orderdetail"]["comments"];
                        $data["service_id"] = $cartdtl["id"];
                        if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                            $serviceDetails["purchase_cost"] = getPurchaseCost($_SESSION["system_default_currency"]["id"], $serviceDetails["id"], "server");
                            if (!$serviceDetails["purchase_cost"]) {
                                $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                            }
                        }
                        $data["purchase_cost"] = $serviceDetails["purchase_cost"];
                        if (0 < $serviceDetails["purchase_cost"]) {
                            $data["profit"] = $serviceDetails["purchase_cost"] - ($serviceDetails["credit"] - $serviceDetails["discount"]);
                        }
                        $data["user_id"] = $_ClientsDetails["id"];
                        $data["date"] = date("Y-m-d");
                        $data["time"] = time();
                        $data["user_can_c"] = 5;
                        $data["pass_key"] = md5(time() . $_ClientsDetails["id"] . time());
                        $data["credit"] = $serviceDetails["credit"];
                        $data["discount"] = $serviceDetails["discount"];
                        $data["retail_shop"] = 1;
                        $data["currency_id"] = $_ClientsDetails["currency_id"];
                        $data["ip"] = $_SERVER["REMOTE_ADDR"];
                        if ($storeowner["id"]) {
                            $data["reseller_id"] = $storeowner["id"];
                            $totcredit = $serviceDetails["credit"] - $serviceDetails["discount"];
                            $resdiscount = $totcredit * $serviceDetails["resellerdisc"] / 100;
                            $data["reseller_discount"] = round($resdiscount, $precision);
                        }
                        if ($aids && $_SESSION["IS_REGISTERED"]) {
                            $data["aid"] = $aids;
                        }
                        $order = $db->insert("tbl_order_server", $data);
                        unset($data);
                        $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                        if (!function_exists(checkCustomFields)) {
                            require_once ROOTDIR . "/includes/customfield.fun.inc.php";
                        }
                        saveCustomFields($order, $cartdtl["orderdetail"]["customfield"]);
                        if ($cartdtl["orderdetail"]["promotion"] && !$_SESSION["CARTPROMOTION"]) {
                            $promotioncode = $cartdtl["orderdetail"]["promotion"];
                            if (!function_exists(getPromotion)) {
                                include_once ROOTDIR . "/includes/cart.fun.php";
                            }
                            $promotion = getPromotion($promotioncode, $_SESSION["currency"], $serviceDetails["credit"] * $cartdtl["qnt"], $serviceDetails["id"], $cartdtl["type"]);
                        }
                        if ($_SESSION["CARTPROMOTION"]) {
                            $promotion = "";
                            $promotioncode = $_SESSION["CARTPROMOTION"];
                        }
                        insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "Server", "relid" => $order, "description" => $cartdtl["name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "promotion" => $promotion, "promotion_code" => $promotioncode]);
                    }
                    if ($cartdtl["type"] == "product") {
                        require_once ROOTDIR . "/includes/products.fun.php";
                        $serviceDetails = getProducts("", md5($cartdtl["id"]), "", "", "", "", "", "", "", "", "", "", "", "", "", $cartdtl["qnt"]);
                        $data = NULL;
                        if ($serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3) {
                            $serviceDetails["credit"] = $cartdtl["orderdetail"]["price"];
                            $amount = $serviceDetails["credit"];
                        }
                        $data["note"] = $cartdtl["orderdetail"]["note"];
                        $data["comments"] = $cartdtl["orderdetail"]["comments"];
                        $data["service_id"] = $cartdtl["id"];
                        if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                            $serviceDetails["purchase_cost"] = getPurchaseCost($_SESSION["system_default_currency"]["id"], $serviceDetails["id"], "shop");
                            if (!$serviceDetails["purchase_cost"]) {
                                $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                            }
                        }
                        $data["purchase_cost"] = $serviceDetails["purchase_cost"];
                        $data["user_id"] = $_ClientsDetails["id"];
                        $data["date"] = date("Y-m-d");
                        $data["time"] = time();
                        $data["user_can_c"] = 5;
                        if ($aids && $_SESSION["IS_REGISTERED"]) {
                            $data["aid"] = $aids;
                        }
                        if ($serviceDetails["subscription"]) {
                            $data["subscribe"] = 1;
                            dquery("UPDATE tbl_subscribers set used=used+1 WHERE \n    \t\tservice_id='" . $serviceDetails["id"] . "' AND user_id='" . $_ClientsDetails["id"] . "'\n    \t\tAND type='tbl_products'");
                        }
                        $data["pass_key"] = md5(time() . $_ClientsDetails["id"] . time());
                        $data["credit"] = $serviceDetails["credit"];
                        $data["discount"] = $serviceDetails["discount"];
                        $data["gift"] = $gift;
                        $data["gatway"] = $curriers;
                        if ($storeowner["id"]) {
                            $data["reseller_id"] = $storeowner["id"];
                            $totcredit = $serviceDetails["credit"] - $serviceDetails["discount"];
                            $resdiscount = $totcredit * $serviceDetails["resellerdisc"] / 100;
                            $data["reseller_discount"] = round($resdiscount, $precision);
                        }
                        if (!$shipping && $directlogin) {
                            if ($sh_email && $sh_firstname && $sh_lastname && $sh_address1 && $sh_city && $sh_zip && $country2) {
                                $_SESSION["SH"]["ship"] = [$shipping, true];
                                $_SESSION["SH"]["sh_email"] = [$sh_email, true];
                                $_SESSION["SH"]["sh_contact"] = [$sh_contact, false];
                                $_SESSION["SH"]["sh_firstname"] = [$sh_firstname, true];
                                $_SESSION["SH"]["sh_lastname"] = [$sh_lastname, true];
                                $_SESSION["SH"]["sh_address1"] = [$sh_address1, true];
                                $_SESSION["SH"]["sh_address2"] = [$sh_address2, false];
                                $_SESSION["SH"]["sh_city"] = [$sh_city, true];
                                $_SESSION["SH"]["sh_state"] = [$sh_state, true];
                                $_SESSION["SH"]["sh_zip"] = [$sh_zip, true];
                                $_SESSION["SH"]["sh_country"] = [$country2, true];
                            } else {
                                global $lng_languag;
                                echo "error: " . $lng_languag["blankfield"];
                                exit;
                            }
                        } else {
                            $users = getClientsDetails();
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
                        }
                        if ($_SESSION["SH"]["ship"][1]) {
                            $data["sh_email"] = $_SESSION["SH"]["sh_email"][0];
                            $data["sh_contact"] = $_SESSION["SH"]["sh_contact"][0];
                            $data["sh_firstname"] = $_SESSION["SH"]["sh_firstname"][0];
                            $data["sh_lastname"] = $_SESSION["SH"]["sh_lastname"][0];
                            $data["sh_address1"] = $_SESSION["SH"]["sh_address1"][0];
                            $data["sh_address2"] = $_SESSION["SH"]["sh_address2"][0];
                            $data["sh_city"] = $_SESSION["SH"]["sh_city"][0];
                            $data["sh_zip"] = $_SESSION["SH"]["sh_zip"][0];
                            $data["sh_state"] = $_SESSION["SH"]["sh_state"][0];
                            $data["sh_country"] = $_SESSION["SH"]["sh_country"][0];
                        }
                        if ($serviceDetails["wholesaleprice"]) {
                            $data["wholesale"] = 1;
                        }
                        $date = date("Y-m-d");
                        if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] < 1 && $serviceDetails["outofstock"] == 0 || $date < $serviceDetails["availability_date"] && $serviceDetails["outofstock"] == 0) {
                            $data["buyadvance"] = 1;
                        }
                        $data["ip"] = $_SERVER["REMOTE_ADDR"];
                        $data["currency_id"] = $_ClientsDetails["currency_id"];
                        if (!function_exists(checkCustomFields)) {
                            require_once ROOTDIR . "/includes/customfield.fun.inc.php";
                        }
                        $oids = "";
                        for ($i = 1; $i <= $cartdtl["qnt"]; $i++) {
                            $order = $db->insert("tbl_order_product", $data);
                            $ordarr[] = $order;
                            $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                            if (is_array($cartdtl["orderdetail"]["customfield"])) {
                                foreach ($cartdtl["orderdetail"]["customfield"] as $k => $custom) {
                                    $extraprice = getPriceFromCustomField($k, $custom, $_SESSION["currency"]);
                                    $amount = $amount + $extraprice;
                                }
                            }
                            saveCustomFields($order, $cartdtl["orderdetail"]["customfield"]);
                            if ($cartdtl["orderdetail"]["promotion"] && !$_SESSION["CARTPROMOTION"]) {
                                $promotioncode = $cartdtl["orderdetail"]["promotion"];
                                if (!function_exists(getPromotion)) {
                                    include_once ROOTDIR . "/includes/cart.fun.php";
                                }
                                $promotion = getPromotion($promotioncode, $_SESSION["currency"], $serviceDetails["credit"] * $cartdtl["qnt"], $serviceDetails["id"], $cartdtl["type"]);
                            }
                            if ($_SESSION["CARTPROMOTION"]) {
                                $promotion = "";
                                $promotioncode = $_SESSION["CARTPROMOTION"];
                            }
                            insert_query("tbl_invoiceitems", ["qnt" => $keyq, "userid" => $_SESSION["uid"], "type" => "Product", "relid" => $order, "description" => $cartdtl["name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "shippingtax" => $cartdtl["orderdetail"]["shippingtax"], "promotion" => $promotion, "promotion_code" => $promotioncode, "warehouseid" => $cartdtl["orderdetail"]["shippingtax"]]);
                        }
                        unset($data);
                    }
                }
            }
            unset($_SESSION["SH"]);
            unset($_SESSION["CART"]);
            unset($_SESSION["CARTPROMOTION"]);
            unset($_SESSION["CARTOTHER"]);
            unset($_SESSION["SHIPPINGID"]);
            require_once ROOTDIR . "/includes/invoice.fun.php";
            $invoiceid = generateInvoice($_SESSION["uid"]);
            if (is_array($ordarr)) {
                foreach ($ordarr as $o) {
                    if ($o) {
                        dquery("UPDATE tbl_order_product set invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                        $s = mysqli_fetch_assoc(dquery("select *,(select \n            service_name from tbl_products where id=service_id) as item,\n            (select username from tblUsers where id=user_id) as user,\n            (select email from tblUsers where id=user_id) as email\n            from tbl_order_product where order_id='" . $o . "'"));
                        $itms .= $s["item"] . "<br />";
                        $user = $s["user"] . " [ " . $s["email"] . " ]";
                        $shipper = $s["sh_firstname"] . " " . $s["sh_lastname"] . "<br />";
                        $shipper .= $s["sh_address1"] . "<br />";
                        $shipper .= $s["sh_address2"] . "<br />";
                        $shipper .= $s["sh_city"] . " " . $s["sh_zip"] . "<br />";
                        $shipper .= $s["sh_state"] . "<br />";
                        $shipper .= $s["sh_country"] . "<br />";
                        $shipper .= $s["sh_contact"] . "<br />";
                    }
                }
                require_once ROOTDIR . "/includes/mail.fun.php";
                $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>here</a>";
                $user = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser&id=" . $s["user_id"]) . "&title=" . base64_encode("Edit User") . "'>" . $user . "</a>";
                $adminmessage = " New Shop order Placed <br />\n                      Details are <br /><br />\n                      =============================<br />\n                      Customer : " . $user . " <br />\n                      ---------------<br />\n                      Items : " . $itms . " \n                      ---------------<br />\n                      Shipping Address: <br />\n                      " . $shipper . "\n                      <br /><br />\n                      You can view order details from " . $here . "\n                      ";
                $to[0] = $config["config_admin_mail"];
                sendNotification("system", "New Shopping Order", $adminmessage, $to);
            }
            $sql = mysqli_fetch_assoc(dquery("select paymentmethod,subtotal,shippingtax from tbl_invoices where id='" . $invoiceid . "'"));
            if ($sql["paymentmethod"] == "offlinepayments" || $sql["paymentmethod"] == "offlinepayments1" || $sql["paymentmethod"] == "offlinepayments2" || $sql["paymentmethod"] == "cash" || $sql["paymentmethod"] == "cc" || $sql["paymentmethod"] == "dc" || $sql["paymentmethod"] == "paypal_mass_pay" || $sql["subtotal"] + $sql["shippingtax"] == 0) {
                echo "redirect: viewinvoice.php?id=" . md5($invoiceid);
            } else {
                echo "redirect: viewinvoice.php?id=" . md5($invoiceid) . "&autoredirect=true";
            }
            exit;
        } else {
            echo "success:" . $lng_languag["detailsavesuccess"];
        }
    } else {
        if ($finished) {
            echo "redirect: cart.php?action=viewnew&sub=cartpayment";
        } else {
            echo "error:" . $lng_languag["selectshippingservice"] . "/" . $lng_languag["paymentmethod"];
        }
    }
}

?>