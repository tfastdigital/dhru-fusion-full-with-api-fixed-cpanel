<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function getGateways($disabledgateways = "", $withoutdirect = false)
{
    global $paymentmethod;
    global $config;
    global $_ClientsDetails;
    if ($_ClientsDetails["client_group"]) {
        $CG = mysqli_fetch_assoc(dquery("select * from tbl_client_group\n        where id='" . $_ClientsDetails["client_group"] . "'"));
        if ($CG["paymentgateway"]) {
            $GatewayArr = explode(",", $CG["paymentgateway"]);
        }
    }
    if (!$disabledgateways) {
        $disabledgateways = [];
    }
    $result = select_query("tbl_paymentgateways", "gateway,value", ["setting" => "name"], "order", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        if (!($withoutdirect && ($data["gateway"] == "directpaypal1" || $data["gateway"] == "directpaypal2" || $data["gateway"] == "directpaypal3" || $data["gateway"] == "directpaypal4" || $data["gateway"] == "directpaypal5"))) {
            $flag = false;
            if (isset($_SESSION["uid"]) && (mysqli_num_rows(dquery("select * from tbl_user_gateway\n            where userid='" . $_SESSION["uid"] . "'")) || mysqli_num_rows(dquery("select id from tblUsers \nwhere id='" . $_SESSION["uid"] . "' and customgateway=1")))) {
                if (mysqli_num_rows(dquery("select * from tbl_user_gateway\n                where userid='" . $_SESSION["uid"] . "' and payment='" . $data["gateway"] . "'"))) {
                    $flag = true;
                }
            }
            if ($flag || !($_ClientsDetails["client_group"] && count($GatewayArr)) || in_array($data["gateway"], $GatewayArr)) {
                $spgwgateway = $data["gateway"];
                $spgwvalue = $data["value"];
                $result2 = select_query("tbl_paymentgateways", "value", ["setting" => "type", "gateway" => $spgwgateway]);
                $data2 = mysqli_fetch_assoc($result2);
                $gatewaytype = $data2[0];
                $result2 = select_query("tbl_paymentgateways", "value", ["setting" => "visible", "gateway" => $spgwgateway]);
                $data2 = mysqli_fetch_assoc($result2);
                if ($data2["value"] == "1" && !in_array($spgwgateway, $disabledgateways)) {
                    $gateway[] = ["image" => $config["gatewayicon" . $spgwgateway], "sysname" => $spgwgateway, "name" => $spgwvalue, "type" => $gatewaytype];
                }
            }
        }
    }
    return $gateway;
}
function getGatewaysArray($order = "")
{
    global $_ClientsDetails;
    if ($_ClientsDetails["client_group"]) {
        $CG = mysqli_fetch_assoc(dquery("select * from tbl_client_group\n        where id='" . $_ClientsDetails["client_group"] . "'"));
        if ($CG["paymentgateway"]) {
            $GatewayArr = explode(",", $CG["paymentgateway"]);
        }
    }
    $result = select_query("tbl_paymentgateways", "gateway,value", ["setting" => "name"], "order", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        if ($order) {
            if (!($data["gateway"] == "directpaypal1" || $data["gateway"] == "directpaypal2" || $data["gateway"] == "directpaypal3" || $data["gateway"] == "directpaypal4" || $data["gateway"] == "directpaypal5" || $data["gateway"] == "paypalexpress")) {
                if (mysqli_num_rows(dquery("select gateway from tbl_paymentgateways\n            where setting='visible' and value='1' and gateway='" . $data["gateway"] . "'"))) {
                }
            }
        }
        if (!(isset($_SESSION["uid"]) && (mysqli_num_rows(dquery("select * from tbl_user_gateway\n            where userid='" . $_SESSION["uid"] . "'")) || mysqli_num_rows(dquery("select id from tblUsers \nwhere id='" . $_SESSION["uid"] . "' and customgateway=1"))) && !mysqli_num_rows(dquery("select * from tbl_user_gateway\n            where userid='" . $_SESSION["uid"] . "' and payment='" . $data["gateway"] . "'")))) {
            if (!($_ClientsDetails["client_group"] && count($GatewayArr)) || in_array($data["gateway"], $GatewayArr)) {
                $gatewayarray[$data["gateway"]] = $data["value"];
            }
        }
    }
    return $gatewayarray;
}
function convertCurrencyIfDirect($gateway, $amount)
{
    global $config;
    if (mysqli_num_rows(dquery("select * from tbl_paymentgateways\n         where gateway='" . $gateway . "' and setting='convertto' and value='1'"))) {
        $GATEWAY = mysqli_fetch_assoc(dquery("select value from \n        tbl_paymentgateways where gateway='" . $gateway . "' and setting='curcode'"));
        $currency = mysqli_fetch_assoc(dquery("select id from tbl_currencies\n        where code='" . $GATEWAY["value"] . "'"));
        $code = $GATEWAY["value"];
        $amount = convertCurrency($amount, $_SESSION["currency"]["id"], $currency["id"]);
    }
    return $amount;
}
function loadGatewayModule($gateway, $invoiceid = "", $amount = "0.00")
{
    global $config;
    global $lng_languag;
    global $_ClientsDetails;
    $gateway = strtolower($gateway);
    $gatewaypath = ROOTDIR . "/modules/gateways/" . $gateway . ".php";
    if (file_exists($gatewaypath)) {
        require_once $gatewaypath;
        $GATEWAY = [];
        $GATEWAY["paymentmethod"] = $gateway;
        $result = select_query("tbl_paymentgateways", "", ["gateway" => $gateway]);
        while ($data = mysqli_fetch_assoc($result)) {
            $gVgwsetting = $data["setting"];
            $gVgwvalue = $data["value"];
            $GATEWAY["" . $gVgwsetting] = "" . $gVgwvalue;
        }
        $GATEWAY["companyname"] = $config["companyname"];
        if ($config["config_ssl_allow"]) {
            $GATEWAY["systemurl"] = $config["config_ssl_allow"];
        } else {
            $GATEWAY["systemurl"] = $config["site_address"];
        }
        $GATEWAY["returnurl"] = $GATEWAY["systemurl"];
        $GATEWAY["langpaynow"] = $lng_languag["paynow"];
        if ($invoiceid) {
            $GATEWAY["description"] = $config["companyname"] . " - " . $lng_languag["invoicenumber"] . $invoiceid;
            $GATEWAY["invoiceid"] = $invoiceid;
            $GATEWAY["clientdetails"] = $_ClientsDetails;
            $GATEWAY["returnurl"] = _url("/viewinvoice/id/" . md5($invoiceid), true);
            $invoice_currency_id = $_ClientsDetails["currency"]["id"];
            $invoice_currency_code = $_ClientsDetails["currency"]["code"];
            $ii = dquery("select id,description,amount from tbl_invoiceitems where invoiceid='" . $invoiceid . "'");
            $DESCR = "";
            while ($ri = mysqli_fetch_assoc($ii)) {
                $invoitem[$ri["id"]] = $ri["description"];
                $DESCR = $ri["description"];
                $amtitem[$ri["id"]] = $ri["amount"];
            }
            $GATEWAY["description"] = $config["companyname"] . " " . $DESCR . " - " . $lng_languag["invoicenumber"] . $invoiceid;
            $GATEWAY["items"] = $invoitem;
            $GATEWAY["itemamt"] = $amtitem;
            $ivos = mysqli_fetch_assoc(dquery("select tax,tax2,shippingtax from tbl_invoices where id='" . $invoiceid . "'"));
            $GATEWAY["invtax"] = $ivos["tax"] + $ivos["tax2"];
            $GATEWAY["invship"] = $ivos["shippingtax"];
            if ($GATEWAY["convertto"]) {
                $result = select_query("tbl_currencies", "code", ["id" => $GATEWAY["convertto"]]);
                $data = mysqli_fetch_assoc($result);
                if ($GATEWAY["convertto"] != "DONOTPROCESS") {
                    $converto_currency_code = $data["code"];
                    $converto_amount = convertCurrency($amount, $invoice_currency_id, $GATEWAY["convertto"]);
                }
                $GATEWAY["amount"] = formatCurrency2($converto_amount);
                $GATEWAY["currency"] = $converto_currency_code;
                $GATEWAY["basecurrencyamount"] = formatCurrency2($amount);
                $GATEWAY["basecurrency"] = $invoice_currency_code;
            }
            if (!$GATEWAY["currency"]) {
                $GATEWAY["amount"] = formatCurrency2($amount);
                $GATEWAY["currency"] = $invoice_currency_code;
            }
        }
        $GATEWAY["returnurl"] = str_replace("//", "/", $GATEWAY["returnurl"]);
        $GATEWAY["returnurl"] = str_replace("http:/", "http://", $GATEWAY["returnurl"]);
        $GATEWAY["returnurl"] = str_replace("https:/", "https://", $GATEWAY["returnurl"]);
        return $GATEWAY;
    }
    exit("Invalid gateway request...." . $gateway);
}
function logTransaction($gateway, $data, $result, $type = "", $relid = "", $refid = "")
{
    global $params;
    $invoicedata = "";
    if ($params["invoiceid"]) {
        $invoicedata .= "Invoice ID => " . $params["invoiceid"] . " ";
        $inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices \n        where id='" . $params["invoiceid"] . "'"));
    }
    if ($params["clientdetails"]["userid"]) {
        $invoicedata .= "User ID => " . $params["clientdetails"]["userid"] . " ";
    }
    if ($params["amount"]) {
        $invoicedata .= "Amount => " . $params["amount"] . " ";
    }
    if (is_array($data)) {
        $logdata = "";
        foreach ($data as $k => $v) {
            $logdata .= $k . " => " . $v . " ";
        }
    } else {
        $logdata = $data;
    }
    $array = ["date" => "now()", "gateway" => $gateway, "data" => $invoicedata . $logdata, "result" => $result, "type" => $type, "userid" => $inv["userid"], "refid" => $refid, "relid" => $relid];
    insert_query("tbl_gatewaylog", $array);
}
function checkTransID($transid)
{
    $result = select_query("tbl_transaction", "id", ["transid" => $transid]);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows) {
        return true;
    }
    return false;
}
function checkInvoiceID($invoiceid, $gateway = "Unknown")
{
    $data = mysqli_fetch_assoc(select_query("tbl_invoices", "id", ["id" => $invoiceid]));
    $id = $data["id"];
    if (!$id) {
        logtransaction($gateway, $_REQUEST, "Invoice ID Not Found");
        exit;
    }
    return $id;
}

?>