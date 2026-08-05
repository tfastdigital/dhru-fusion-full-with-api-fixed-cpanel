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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
global $lng_languag;
global $config;
$throughReg = false;
$gateway = preg_replace("/[^0-9a-z-_]/i", "", $gateway);
if (isset($_COOKIE["AFFILIATETO"])) {
    $aids = preg_replace("/[^0-9a-z-_]/i", "", dec($_COOKIE["AFFILIATETO"], "9486"));
}
if ($steps) {
    $gateway = $_SESSION["CARTOTHER"]["GT"];
    $curriers = $_SESSION["SHIPPINGID"];
    $gift = $_SESSION["CARTOTHER"]["GIFT"];
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
foreach ($_SESSION["CART"] as $cartdtl) {
    if ($cartdtl["type"] == "product") {
        unset($config["minregistration"]);
    }
}
if ($_SESSION["uid"]) {
    $flag = false;
    if ($_SESSION["CART"]) {
        foreach ($_SESSION["CART"] as $cartdtl) {
            if ($cartdtl["type"] == "product") {
                unset($config["minregistration"]);
                $slq = mysqli_fetch_assoc(dquery("select `virtual` from tbl_products \n                                                        where id='" . $cartdtl["id"] . "'"));
                if (!$slq["virtual"]) {
                    $flag = true;
                }
            }
        }
    }
    global $gateway;
    if (!$gateway) {
        echo "error: " . $lng_languag["paymentgatewayreq"];
        exit;
    }
    if ($flag) {
        global $curriers;
        if (!$curriers) {
            echo "error: " . $lng_languag["selectshippingservice"];
            exit;
        }
    }
    $u = mysqli_fetch_assoc(dquery("select cardnum,credit_left,cardtype,startdate,expdate,ccv \n        FROM tblUsers WHERE id='" . $_SESSION["uid"] . "'"));
    if (isset($_SESSION["carttotal"]) && 0 < $_SESSION["carttotal"] && $gateway == "applycredit" && $u["credit_left"] < $_SESSION["carttotal"]) {
        echo "error: " . $lng_languag["notenoughbalance"];
        exit;
    }
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
            dquery("UPDATE tblUsers \n                SET cardnum= AES_ENCRYPT('" . $cardno . "','" . $ccenckey . "'),\n                cardtype= '" . $cardtype . "',\n                cardname='" . $cardname . "',\n                ccv= AES_ENCRYPT('" . $ccv . "','" . $ccenckey . "'),\n                startdate= AES_ENCRYPT('" . $startmonth . "-" . $startyear . "','" . $ccenckey . "'),\n                expdate= AES_ENCRYPT('" . $endmonth . "-" . $endyear . "','" . $ccenckey . "'),\n                cardlastfour='" . $lastfr . "'\n                WHERE id='" . $_SESSION["uid"] . "'");
        } else {
            echo "error: Credit Card details are compulsary";
            exit;
        }
    }
}
if (!$_SESSION["uid"]) {
    $validator = NULL;
    if ($config["minregistration"] || $type == 3) {
        $validator["email"] = [$email, true];
        $u = explode("@", $email);
        if ($email) {
            $validator["username"] = [$u[0], true];
        }
        if ($type == 3) {
            $validator["password"] = [$password, true];
            $validator["confirmation"] = [$confirmation, true];
            $validator["first_name"] = [$first_name, true];
            $validator["last_name"] = [$last_name, true];
            global $address1;
            global $address2;
            global $city;
            global $state;
            global $zip;
            global $country;
            global $phonenumber;
            global $phonenumber1;
            $validator["phonenumber"] = [$phonenumber1 . $phonenumber, true];
            $validator["address1"] = [$address1, true];
            $validator["address2"] = [$address2, false];
            $validator["city"] = [$city, true];
            $validator["state"] = [$state, true];
            $validator["zip"] = [$zip, true];
            $validator["country"] = [$country, true];
        } else {
            if ($password) {
                $validator["password"] = [$password, true];
                $validator["confirmation"] = [$confirmation, true];
            }
            if ($first_name) {
                $validator["first_name"] = [$first_name, true];
            }
            if ($last_name) {
                $validator["last_name"] = [$last_name, true];
            }
        }
        if ($config["captcha_registration"]) {
            $validator["captcha"] = [strtoupper($captcha), true];
        }
        $flag = false;
        if ($_SESSION["CART"]) {
            foreach ($_SESSION["CART"] as $cartdtl) {
                if ($cartdtl["type"] == "product") {
                    $slq = mysqli_fetch_assoc(dquery("select `virtual` from tbl_products where id='" . $cartdtl["id"] . "'"));
                    if (!$slq["virtual"]) {
                        $flag = true;
                    }
                }
            }
        }
    } else {
        if (!mysqli_num_rows(dquery("select id from \n        tbl_currencies where id='" . $currency . "'")) && $currency) {
            echo "error: Something Wrong #4586";
            exit;
        }
        if (!$guestcheck) {
            $validator["username"] = [$username, true];
            $validator["password"] = [$password, true];
            $validator["confirmation"] = [$confirmation, true];
            $validator["currency"] = [$currency, true];
        } else {
            $validator["guestcheck"] = [$guestcheck, true];
        }
        if ($guestcheck) {
            $validator["guest"] = [true, true];
        }
        $validator["email"] = [$email, true];
        $validator["phonenumber"] = [$phonenumber1 . $phonenumber, true];
        $validator["first_name"] = [$first_name, true];
        $validator["last_name"] = [$last_name, true];
        $validator["address1"] = [$address1, true];
        $validator["address2"] = [$address2, false];
        $validator["city"] = [$city, true];
        $validator["state"] = [$state, true];
        $validator["zip"] = [$zip, true];
        $validator["country"] = [$country, true];
        $validator["language"] = [$language, false];
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
    }
    if (!$shipping && $flag) {
        $_SESSION["SH"]["ship"] = [$shipping, true];
        $validator["ship"] = $_SESSION["SH"]["ship"];
        $_SESSION["SH"]["sh_email"] = [$sh_email, true];
        $validator["sh_email"] = $_SESSION["SH"]["sh_email"];
        $_SESSION["SH"]["sh_contact"] = [$sh_contact, false];
        $validator["sh_contact"] = $_SESSION["SH"]["sh_contact"];
        $_SESSION["SH"]["sh_firstname"] = [$sh_firstname, true];
        $validator["sh_firstname"] = $_SESSION["SH"]["sh_firstname"];
        $_SESSION["SH"]["sh_lastname"] = [$sh_lastname, true];
        $validator["sh_lastname"] = $_SESSION["SH"]["sh_lastname"];
        $_SESSION["SH"]["sh_address1"] = [$sh_address1, true];
        $validator["sh_address1"] = $_SESSION["SH"]["sh_address1"];
        $_SESSION["SH"]["sh_address2"] = [$sh_address2, false];
        $validator["sh_address2"] = $_SESSION["SH"]["sh_address2"];
        $_SESSION["SH"]["sh_city"] = [$sh_city, true];
        $validator["sh_city"] = $_SESSION["SH"]["sh_city"];
        $_SESSION["SH"]["sh_state"] = [$sh_state, true];
        $validator["sh_state"] = $_SESSION["SH"]["sh_state"];
        $_SESSION["SH"]["sh_zip"] = [$sh_zip, true];
        $validator["sh_zip"] = $_SESSION["SH"]["sh_zip"];
        $_SESSION["SH"]["sh_country"] = [$country2, true];
        $validator["sh_country"] = $_SESSION["SH"]["sh_country"];
    }
    if (!$guestcheck) {
        if ($config["registration_terms"]) {
            $validator["terms"] = [$terms, true];
        }
        if ($config["captcha_registration"]) {
            $validator["captcha"] = [strtoupper($captcha), true];
        }
    }
    if ($error = validateProfiles($validator)) {
        echo "error: " . $error;
        exit;
    }
    if ($error = addNewUser($validator, "", "", "", "", "", "", "", true)) {
        echo "error: " . $error;
        exit;
    }
    $result = dquery("SELECT * FROM `tblUsers` WHERE `id`='" . $_SESSION["tmp_usersid"] . "'");
    $data = mysqli_fetch_assoc($result);
    $lastlogin = time();
    $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
    $session = session_id();
    $time = time();
    dquery("UPDATE `tblUsers` SET ``= '" . $encdata . "',``='" . $lastlogin . "',\n    `last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\n    `current_login_time`='" . $time . "',`online_status`='1' \n    WHERE `id`= '" . $data["id"] . "' ");
    $_SESSION["uid"] = $data["id"];
    $_SESSION["username"] = $data["username"];
    $_SESSION["WLANG"] = $data["default_lang"];
    $_SESSION["currency"] = $data["default_currency"];
    if ($data["default_theme"]) {
        $_SESSION["template"] = $data["default_theme"];
    }
    $_SESSION["encdata"] = $encdata;
    $_SESSION["last_login"] = $data["last_login"] . "," . $data["last_login_ip"];
    $_SESSION["shippingzip"] = $data["zip"];
    $_SESSION["shippingstate"] = $data["state"];
    $_SESSION["shippingcountry"] = $data["country"];
    $_SESSION["issignupfromcart"] = true;
    unset($_SESSION["tmp_usersid"]);
    unset($data);
    unset($lastlogin);
    unset($encdata);
    unset($session);
    unset($time);
    if ($type == 3) {
        echo "redirect: " . _url("cart/checkout");
    } else {
        if ($type) {
            echo "redirect: " . _url("cart/view/1/sub/cartshipping");
        } else {
            echo "redirect:" . _url("cart/checkout");
        }
    }
    exit;
} else {
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
                $serviceDetails = getIMEIServices("", md5($cartdtl["id"]), "", "", "", "", true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $cartdtl["qnt"]);
                $data["service_id"] = $cartdtl["id"];
                if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                    $serviceDetails["purchase_cost"] = getPurchaseCost($_ClientsDetails["currency_id"], $serviceDetails["id"], "imei");
                    if (!$serviceDetails["purchase_cost"]) {
                        $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                    }
                }
                $data["purchase_cost"] = $cartdtl["orderdetail"]["purchase_cost"];
                if ($serviceDetails["useasserver"] == 2) {
                    $data["server"] = 2;
                }
                if ($serviceDetails["useasserver"] == 1) {
                    $data["server"] = 1;
                }
                if (0 < $serviceDetails["purchase_cost"]) {
                    $data["profit"] = $serviceDetails["purchase_cost"] - ($serviceDetails["credit"] - $serviceDetails["discount"]);
                }
                $data["user_id"] = $_ClientsDetails["id"];
                $data["imei"] = $cartdtl["orderdetail"]["imei"];
                $data["qnt"] = 0 < $cartdtl["qnt"] ? $cartdtl["qnt"] : 1;
                $data["date"] = date("Y-m-d");
                $data["time"] = time();
                $data["user_can_c"] = 5;
                if ($storeowner["id"]) {
                    $data["reseller_id"] = $storeowner["id"];
                    $totcredit = $serviceDetails["credit"] - $serviceDetails["discount"];
                    $resdiscount = $totcredit * $serviceDetails["resellerdisc"] / 100;
                    $data["reseller_discount"] = round($resdiscount, $precision);
                }
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
                if ($aids && $_SESSION["IS_REGISTERED"]) {
                    $data["aid"] = $aids;
                }
                if ($serviceDetails["manualverification"]) {
                    $data["autosend"] = 1;
                }
                $data["pricefrom"] = "Retail";
                $data["status"] = "new";
                $order = $db->insert("tbl_order_imei", $data);
                alphanumeric($order);
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
                    if (0 < $promotion) {
                        dquery("update tbl_order_imei \n               set discount='" . $promotion . "' where order_id='" . $order . "'");
                    }
                }
                if ($_SESSION["CARTPROMOTION"]) {
                    $promotion = "";
                    $promotioncode = $_SESSION["CARTPROMOTION"];
                }
                insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "IMEI", "relid" => $order, "description" => $cartdtl["name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "promotion" => $promotion, "promotion_code" => $promotioncode, "qnt" => 0 < $cartdtl["qnt"] ? $cartdtl["qnt"] : 1]);
            }
            if ($cartdtl["type"] == "server") {
                require_once ROOTDIR . "/includes/serverservices.fun.php";
                $serviceDetails = getServerServices("", md5($cartdtl["id"]), "", "", "", "", true);
                $data = NULL;
                $data["note"] = $cartdtl["orderdetail"]["note"];
                $data["comments"] = $cartdtl["orderdetail"]["comments"];
                $data["service_id"] = $cartdtl["id"];
                if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                    $serviceDetails["purchase_cost"] = getPurchaseCost($_ClientsDetails["currency_id"], $serviceDetails["id"], "server");
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
                if ($storeowner["id"]) {
                    $data["reseller_id"] = $storeowner["id"];
                    $totcredit = $serviceDetails["credit"] - $serviceDetails["discount"];
                    $resdiscount = $totcredit * $serviceDetails["resellerdisc"] / 100;
                    $data["reseller_discount"] = round($resdiscount, $precision);
                }
                $data["currency_id"] = $_ClientsDetails["currency_id"];
                $data["ip"] = $_SERVER["REMOTE_ADDR"];
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
                if ($cartdtl["orderdata"]) {
                    $data["data"] = json_encode($cartdtl["orderdata"]);
                }
                $data["comments"] = $cartdtl["orderdetail"]["comments"];
                $data["service_id"] = $cartdtl["id"];
                if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                    $serviceDetails["purchase_cost"] = getPurchaseCost($_ClientsDetails["currency_id"], $serviceDetails["id"], "shop");
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
                if ($serviceDetails["producttype"] == "physical") {
                    if ($sh_firstname && $sh_address1 && $sh_city && $sh_zip && $sh_country) {
                        $_SESSION["SH"]["ship"] = [1, true];
                        $_SESSION["SH"]["sh_email"] = [$sh_email, true];
                        $_SESSION["SH"]["sh_contact"] = [$sh_contact, false];
                        $_SESSION["SH"]["sh_firstname"] = [$sh_firstname, true];
                        $_SESSION["SH"]["sh_lastname"] = [$sh_lastname, true];
                        $_SESSION["SH"]["sh_address1"] = [$sh_address1, true];
                        $_SESSION["SH"]["sh_address2"] = [$sh_address2, false];
                        $_SESSION["SH"]["sh_city"] = [$sh_city, true];
                        $_SESSION["SH"]["sh_state"] = [$sh_state, true];
                        $_SESSION["SH"]["sh_zip"] = [$sh_zip, true];
                        $_SESSION["SH"]["sh_country"] = [$sh_country, true];
                        $_SESSION["SH"]["sh_landmark"] = [$sh_landmark, true];
                        $_SESSION["SH"]["sh_preference"] = [$sh_preference, true];
                    } else {
                        echo "error: " . $lng_languag["shippingrequired"];
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
                if ($serviceDetails["producttype"] == "physical") {
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
                    $data["sh_landmark"] = $_SESSION["SH"]["sh_landmark"][0];
                    $data["sh_preference"] = $_SESSION["SH"]["sh_preference"][0];
                    $data["data"] = json_encode($_SESSION["SH"]);
                }
                if ($serviceDetails["wholesaleprice"]) {
                    $data["wholesale"] = 1;
                }
                $date = date("Y-m-d");
                if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] < 1 && $serviceDetails["outofstock"] == 0 || $date < $serviceDetails["availability_date"] && $serviceDetails["outofstock"] == 0) {
                    $data["buyadvance"] = 1;
                }
                $data["ip"] = $_SERVER["REMOTE_ADDR"];
                $data["status"] = "new";
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
    global $seller_instruction;
    require_once ROOTDIR . "/includes/invoice.fun.php";
    $invoiceid = generateInvoice($_SESSION["uid"], "", "", "", $seller_instruction, true);
    if (is_array($ordarr)) {
        foreach ($ordarr as $o) {
            if ($o) {
                dquery("UPDATE tbl_order_product set invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
            }
        }
    }
    orderNotification($invoiceid);
    $sql = mysqli_fetch_assoc(dquery("select paymentmethod,subtotal,shippingtax from tbl_invoices where id='" . $invoiceid . "'"));
    if ($sql["paymentmethod"] == "offlinepayments" || $sql["paymentmethod"] == "offlinepayments1" || $sql["paymentmethod"] == "offlinepayments2" || $sql["paymentmethod"] == "offlinepayments3" || $sql["paymentmethod"] == "offlinepayments5" || $sql["paymentmethod"] == "offlinepayments6" || $sql["paymentmethod"] == "offlinepayments7" || $sql["paymentmethod"] == "offlinepayments8" || $sql["paymentmethod"] == "offlinepayments9" || $sql["paymentmethod"] == "offlinepayments10" || $sql["paymentmethod"] == "offlinepayments11" || $sql["paymentmethod"] == "offlinepayments12" || $sql["paymentmethod"] == "offlinepayments13" || $sql["paymentmethod"] == "offlinepayments14" || $sql["paymentmethod"] == "offlinepayments15" || $sql["paymentmethod"] == "offlinepayments16" || $sql["paymentmethod"] == "offlinepayments16" || $sql["paymentmethod"] == "offlinepayments17" || $sql["paymentmethod"] == "offlinepayments18" || $sql["paymentmethod"] == "offlinepayments19" || $sql["paymentmethod"] == "offlinepayments20" || $sql["paymentmethod"] == "offlinepayments4" || $sql["paymentmethod"] == "cash" || $sql["paymentmethod"] == "cc" || $sql["paymentmethod"] == "razorpay" || $sql["paymentmethod"] == "dc" || $sql["paymentmethod"] == "applycredit" || $sql["paymentmethod"] == "paypal_mass_pay" || $sql["subtotal"] + $sql["shippingtax"] == 0) {
        echo "redirect: " . _url("viewinvoice/id/" . md5($invoiceid));
    } else {
        echo "redirect: " . _url("viewinvoice/id/" . md5($invoiceid) . "/autoredirect/true");
    }
    exit;
}

?>