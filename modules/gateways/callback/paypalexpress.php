<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
include ROOTDIR . "/includes/clients.fun.inc.php";
$GATEWAY = loadGatewayModule("paypalexpress");
$_client_id = $GATEWAY["clientid"];
$_secret = $GATEWAY["secretkey"];
if ($GATEWAY["testmode"]) {
    $_url = "https://api.sandbox.paypal.com";
} else {
    $_url = "https://api.paypal.com";
}
$json = file_get_contents("php://input");
logTransaction("paypalexpress", $json, "Received", "", "");
$_req_data = json_decode($json, true)["details"];
if ($_req_data["id"]) {
    $_id = $_req_data["id"];
    $_token = base64_encode($_client_id . ":" . $_secret);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url . "/v2/checkout/orders/" . $_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type: application/json"];
    curl_setopt($ch, CURLOPT_USERPWD, $_client_id . ":" . $_secret);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($server_output, true);
    $_req_data = $data;
    logTransaction("paypalexpress", json_encode($data), "Get Order Detail", "", "");
    $intent = $data["intent"];
    if ($intent === "CAPTURE") {
        $transactonid = $data["purchase_units"][0]["payments"]["captures"][0]["id"];
    }
    if ($intent === "AUTHORIZE") {
        $transactonid = $data["purchase_units"][0]["payments"]["authorizations"][0]["id"];
        $_SESSION["paypal_authorization_id"][$data["id"]] = $data["purchase_units"][0]["payments"]["authorizations"][0]["id"];
    }
    if ($data["id"] && $transactonid) {
        $purchase_units = $_req_data["purchase_units"];
        $payer = $_req_data["payer"];
        $originaltranactionid = $_req_data["id"];
        $payerdet = $_req_data["purchase_units"][0]["shipping"];
        $currency = $_req_data["purchase_units"][0]["amount"]["currency_code"];
        $paypal_capture_id = $_req_data["purchase_units"][0]["payments"]["captures"][0]["id"];
        $totalamount = $_req_data["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"];
        $currencycode = $_req_data["purchase_units"][0]["payments"]["captures"][0]["amount"]["currency_code"];
        $tmpid = $purchase_units[0]["custom_id"];
        if ($data["status"] == "COMPLETED") {
            if (isset($_SESSION["uid"])) {
                $uid = mysqli_fetch_assoc(dquery("select * from tblUsers\r\n            where id='" . $_SESSION["uid"] . "'"));
            } else {
                $uid = mysqli_fetch_assoc(dquery("select * from tblUsers\r\n            where email='" . $payer["email_address"] . "'"));
            }
            $name = $purchase_units[0]["shipping"]["name"]["full_name"];
            $add1 = $purchase_units[0]["shipping"]["address"]["address_line_1"];
            $add2 = $purchase_units[0]["shipping"]["address"]["address_line_2"];
            $state = $purchase_units[0]["shipping"]["address"]["admin_area_1"];
            $city = $purchase_units[0]["shipping"]["address"]["admin_area_2"];
            $zip = $purchase_units[0]["shipping"]["address"]["postal_code"];
            $country = $purchase_units[0]["shipping"]["address"]["country_code"];
            $clientfound = false;
            if (!$uid["id"]) {
                $validator = NULL;
                if ($payer["email_address"]) {
                    $username = explode("@", $payer["email_address"]);
                    $username = $username[0];
                    while (mysqli_num_rows(dquery("select id from tblUsers\r\n                where username='" . $username . "'"))) {
                        $username .= rand(1, 9);
                    }
                }
                $password = GeneRate(8);
                $validator["email"] = [$payer["email_address"], true];
                $validator["first_name"] = [$purchase_units[0]["shipping"]["name"]["full_name"], true];
                $validator["address1"] = [$purchase_units[0]["shipping"]["address"]["address_line_1"], true];
                $validator["address2"] = [$purchase_units[0]["shipping"]["address"]["address_line_2"], false];
                $validator["state"] = [$purchase_units[0]["shipping"]["address"]["admin_area_1"], false];
                $validator["city"] = [$purchase_units[0]["shipping"]["address"]["admin_area_2"], false];
                $validator["zip"] = [$purchase_units[0]["shipping"]["address"]["postal_code"], true];
                $validator["country"] = [$purchase_units[0]["shipping"]["address"]["country_code"], true];
                $validator["currency"] = [$_SESSION["currency"]["id"], true];
                addNewUser($validator, true, "", true);
                $ID = mysqli_fetch_assoc(dquery("select id from tblUsers order by id desc limit 1"));
                dquery("update tblUsers set userstatus=0 where id='" . $ID["id"] . "'");
                $uid = mysqli_fetch_assoc(dquery("select * from tblUsers\r\n            where email='" . $payer["email_address"] . "'"));
            } else {
                $clientfound = true;
                $_SESSION["clientexists"] = true;
                $lastlogin = time();
                $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
                $session = session_id();
                $time = time();
                dquery("UPDATE `tblUsers` SET `enc_login`= '" . $encdata . "',\r\n            `last_login`='" . $lastlogin . "',\r\n    \t\t`last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\r\n\t\t    `current_login_time`='" . $time . "',`online_status`='1' " . $_addd_to_update . ",\r\n\t\t    `login_failed_atoms`='0'\r\n\t\t     WHERE `id`= '" . $uid["id"] . "' ");
                $ins = NULL;
                $ins["username"] = $username;
                $ins["userid"] = $uid["id"];
                $ins["ip"] = $remote_ip;
                $ins["time"] = time();
                $db->insert("tbl_loginlog_user", $ins);
                $ins = NULL;
            }
            $Part = explode("_", $tmpid);
            if ($Part[0] == "INV") {
                $invoiceid = $Part[1];
                $Invoices = mysqli_fetch_assoc(dquery("select total from tbl_invoices\r\nwhere id='" . $invoiceid . "'"));
                $User = mysqli_fetch_assoc(dquery("select (select code from tbl_currencies \r\nwhere id=default_currency) as code from tblUsers where id='" . $_SESSION["uid"] . "'"));
                if ($User["code"] != $currencycode) {
                    $totalamount = convertCurrency($totalamount, $currencycode, $User["code"], "", "code");
                    if ($totalamount <= $Invoices["total"] + 0 && $Invoices["total"] - 0 <= $totalamount) {
                        $totalamount = $Invoices["total"];
                    }
                }
                dquery("update tbl_invoices set exorderid='" . $originaltranactionid . "' where id='" . $invoiceid . "'");
                addPayment($invoiceid, $transactonid, $totalamount, 0, "paypalexpress", true, "", "", $payer["email_address"], json_encode($payer));
            } else {
                $_SESSION["uid"] = $uid["id"];
                $_SESSION["username"] = $uid["username"];
                $_SESSION["fullname"] = $name;
                $_SESSION["USERLANG"] = $uid["language"];
                $_SESSION["currency"] = $uid["default_currency"];
                $_SESSION["shippingzip"] = $zip;
                $_SESSION["shippingstate"] = $state;
                $_SESSION["shippingcountry"] = $country;
                $_SESSION["encdata"] = $encdata;
                $_ClientsDetails = $uid;
                $UserID = $uid["id"];
                $tmpdata = mysqli_fetch_assoc(dquery("select data from tbl_tmp where id='" . $tmpid . "'"));
                $_CART = json_decode($tmpdata["data"], true);
                $cartcurrency = $_CART["cartcurrency"];
                loginUser($UserID);
                foreach ($_CART as $keyq => $cartdtl) {
                    $serviceDetails = NULL;
                    $paymentmethod = "paypalexpress";
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
                                dquery("update tbl_order_imei \r\n               set discount='" . $promotion . "' where order_id='" . $order . "'");
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
                        $serviceDetails = getProducts("", md5($cartdtl["id"]), $UserID, true, "", "", "", "", "", "", "", "", "", "", "", $cartdtl["qnt"]);
                        $data = NULL;
                        if ($serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3) {
                            $serviceDetails["credit"] = $serviceDetails["discount"];
                            $amount = $serviceDetails["credit"];
                        }
                        $data["note"] = $cartdtl["orderdetail"]["note"];
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
                            dquery("UPDATE tbl_subscribers set used=used+1 WHERE \r\n    \t\tservice_id='" . $serviceDetails["id"] . "' AND user_id='" . $_ClientsDetails["id"] . "'\r\n    \t\tAND type='tbl_products'");
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
                        $data["sh_email"] = $_ClientsDetails["email"];
                        $data["sh_contact"] = $_ClientsDetails["phonenumber"];
                        $data["sh_firstname"] = $name;
                        $data["sh_lastname"] = $_ClientsDetails["lastname"];
                        $data["sh_address1"] = $add1;
                        $data["sh_address2"] = $add2;
                        $data["sh_city"] = $city;
                        $data["sh_zip"] = $zip;
                        $data["sh_state"] = $state;
                        $data["sh_country"] = $country;
                        $Datas["name"] = $name;
                        $Datas["address1"] = $add1;
                        $Datas["address2"] = $add2;
                        $Datas["city"] = $city;
                        $Datas["zip"] = $zip;
                        $Datas["state"] = $state;
                        $data["data"] = json_encode($Datas);
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
                unset($_SESSION["SH"]);
                unset($_SESSION["CART"]);
                unset($_SESSION["CARTPROMOTION"]);
                unset($_SESSION["CARTOTHER"]);
                unset($_SESSION["SHIPPINGID"]);
                require_once ROOTDIR . "/includes/invoice.fun.php";
                $invoiceid = generateInvoice($_SESSION["uid"], "", "", "", "", true);
                if (is_array($ordarr)) {
                    foreach ($ordarr as $o) {
                        if ($o) {
                            dquery("UPDATE tbl_order_product set invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                        }
                    }
                }
                dquery("update tbl_invoices set exorderid='" . $originaltranactionid . "' where id='" . $invoiceid . "'");
                addPayment($invoiceid, $transactonid, $totalamount, 0, "paypalexpress", true, "", "", $payer["email_address"], json_encode($payer));
                orderNotification($invoiceid);
            }
            $_OUT["status"] = "success";
            $_OUT["invoiceid"] = md5($invoiceid);
            $_OUT["message"] = "Payment success.";
        } else {
            $_OUT["status"] = "error";
            $_OUT["message"] = "Payment failed.";
        }
    } else {
        $_OUT["status"] = "error";
        $_OUT["message"] = "Error #9539, Please contact us.";
    }
    $_OUT["data"] = $data;
} else {
    $_OUT["status"] = "error";
    $_OUT["message"] = "Error #9538, Please contact us.";
}
header("Content-Type: application/json");
exit(json_encode($_OUT));
function GeneRate($length)
{
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
}

?>