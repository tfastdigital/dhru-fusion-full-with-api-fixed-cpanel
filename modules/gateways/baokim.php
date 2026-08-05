<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function baokim_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "baokim"], "business" => ["Type" => "text", "Name" => "Business", "Size" => "60", "Description" => "email tai BK"], "merchantid" => ["Type" => "text", "Name" => "Merchant id", "Description" => "duoc cung cap boi bao kim"], "securepass" => ["Type" => "text", "Name" => "Secure pass", "Description" => "duoc cung cap boi bao kim"], "tickbox" => ["Type" => "yesno", "Name" => "SandBox"]];
    return $configarray;
}
function baokim_link($params)
{
    global $lng_languag;
    global $mrc_order_id;
    global $link;
    global $txn_id;
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $index = $params["systemurl"];
    $business = $params["business"];
    $merchant_id = $params["merchantid"];
    $secure_pass = $params["securepass"];
    $order_id = $params["invoiceid"];
    $total_amount = number_format($params["amount"], 3, ".", "");
    $order_description = nl2br($params["description"]);
    $url_success = $index . _url("/viewinvoice/inv/" . md5($order_id) . "/paymentsuccess/true");
    $url_cancel = $index . _url("/viewinvoice/inv/" . md5($order_id) . "/paymentfailed/true");
    $url_detail = $index . _url("/viewinvoice/id/" . $order_id);
    $baokim_url = "http://baokim.vn/payment/customize_payment/order";
    if ($params["basecurrency"] != "VND") {
        $curr = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='VND'"));
        if (!$curr["id"]) {
            exit("Currency Not Supported");
        }
        $total_amount = round(convertCurrency($total_amount, $params["currency"]["id"], $curr["id"]));
    }
    if ($mrc_order_id) {
        $parts = parse_url($link);
        parse_str($parts["query"], $query);
        $checksum = $query["checksum"];
        unset($query["checksum"]);
        unset($query["inv"]);
        unset($query["paymentsuccess"]);
        ksort($query);
        $signData = http_build_query($query);
        $myChecksum = hash_hmac("sha256", http_build_query($query), $secure_pass);
        if ($myChecksum == $checksum) {
            logTransaction("baokim", $query, "Received", "", "", $mrc_order_id);
            logTransaction("baokim", $query, "Success Callback", "", "", $mrc_order_id);
            $Inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices where id='" . $mrc_order_id . "'"));
            if ($Inv["status"] == "Unpaid" && !mysqli_num_rows(dquery("select * from tbl_transaction where transid='" . $txn_id . "'"))) {
                if ($params["basecurrency"] != "VND") {
                    $curr = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='VND'"));
                    $total_amount = round(convertCurrency($total_amount, $curr["id"], $params["currency"]["id"]));
                }
                addPayment($mrc_order_id, $txn_id, $total_amount, 0, "baokim", true);
                header("Location: " . _url("./viewinvoice/id/" . md5($mrc_order_id)));
            }
        }
    }
    $BAOKIM = "https://www.baokim.vn/payment/checkout";
    if ($params["SandBox"]) {
        $BAOKIM = "http://sandbox.baokim.vn/payment/checkout";
    }
    $code = "<form method=\"post\" action=\"" . $BAOKIM . "\" >\n    <input type=\"hidden\" name=\"api_key\" value=\"" . $merchant_id . "\">\n    <input type=\"hidden\" name=\"mrc_order_id\" value=\"" . $order_id . "\">\n    <input type=\"hidden\" name=\"total_amount\" value=\"" . $total_amount . "\">\n    <input type=\"hidden\" name=\"success_url\" value=\"" . $url_success . "\">\n    <input type=\"hidden\" name=\"cancel_url\" value=\"" . $url_cancel . "\">\n    <input type=\"hidden\" name=\"payment_method_type\" value=\"card\">\n    <button type=\"submit\" id=\"customButton\" class=\"stripe-button-el btn-primary  paymentbtn\" style=\"check_out\" >Pay Now\n    </button>\n</form>";
    return $code;
}
function createRequestUrl($order_id, $business, $total_amount, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail, $merchant_id, $secure_pass, $baokim_url)
{
    $params = ["merchant_id" => strval($merchant_id), "order_id" => strval($order_id), "business" => strval($business), "total_amount" => strval($total_amount), "shipping_fee" => strval($shipping_fee), "tax_fee" => strval($tax_fee), "order_description" => strval($order_description), "url_success" => strtolower($url_success), "url_cancel" => strtolower($url_cancel), "url_detail" => strtolower($url_detail)];
    ksort($params);
    $str_combined = $secure_pass . implode("", $params);
    $params["checksum"] = strtoupper(md5($str_combined));
    $redirect_url = $baokim_url;
    if (strpos($redirect_url, "?") === false) {
        $redirect_url .= "?";
    } else {
        if (substr($redirect_url, strlen($redirect_url) - 1, 1) != "?" && strpos($redirect_url, "&") === false) {
            $redirect_url .= "&";
        }
    }
    $url_params = "";
    foreach ($params as $key => $value) {
        if ($url_params == "") {
            $url_params .= $key . "=" . urlencode($value);
        } else {
            $url_params .= "&" . $key . "=" . urlencode($value);
        }
    }
    return $redirect_url . $url_params;
}
function format_price_baokim($price)
{
    $price_bk = str_replace(",", "", $price);
    $price_bk = str_replace(".", "", $price_bk);
    $price_bk = strip_tags($price_bk);
    $price_bk = trim($price_bk);
    return $price_bk;
}

?>