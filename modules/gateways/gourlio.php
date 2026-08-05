<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function gourlio_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "gourl.io (bitcoin)"], "public_key" => ["Type" => "text", "Name" => "Public key", "Size" => "40", "Description" => ""], "private_key" => ["Type" => "text", "Name" => "Private key", "Size" => "40", "Description" => ""]];
    return $configarray;
}
function gourlio_link($params)
{
    global $DB_USER;
    global $DB_PASS;
    global $DB_HOST;
    global $DB_NAME;
    $Dir = ".";
    if (stripos("merchant/", $_SERVER["SCRIPT_FILENAME"])) {
    }
    $Dir = "..";
    DEFINE("CRYPTOBOX_IMG_FILES_PATH", $Dir . "/images/gourl/");
    DEFINE("CRYPTOBOX_JS_FILES_PATH", $Dir . "/includes/js/gourl/");
    DEFINE("CRYPTOBOX_LANGUAGE_HTMLID", "alang");
    DEFINE("CRYPTOBOX_COINS_HTMLID", "acoin");
    DEFINE("CRYPTOBOX_PREFIX_HTMLID", "acrypto_");
    $cryptobox_private_keys = [$params["private_key"]];
    define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
    require_once ROOTDIR . "/modules/gateways/gourl/gourl.class.php";
    $userID = $params["clientdetails"]["userid"];
    $userFormat = "COOKIE";
    $orderID = $params["invoiceid"];
    $amountUSD = 0;
    $period = "NOEXPIRY";
    $def_language = "en";
    $def_coin = "bitcoin";
    $coins = ["bitcoin"];
    $public_key = $params["public_key"];
    $private_key = $params["private_key"];
    $options = ["public_key" => $public_key, "private_key" => $private_key, "webdev_key" => "", "orderID" => $orderID, "userID" => $userID, "userFormat" => "COOKIE", "amount" => 0, "amountUSD" => $params["amount"], "period" => $period, "language" => $def_language];
    $box = new Cryptobox($options);
    $OUT = "\n    <script src=\"" . CRYPTOBOX_JS_FILES_PATH . "support.min.js\" crossorigin=\"anonymous\"></script>\n\n    ";
    $OUT .= "<style>\n        html { font-size: 14px; }\n        @media (min-width: 768px) { html { font-size: 16px; } .tooltip-inner { max-width: 350px; } }\n        .mncrpt .container { max-width: 980px; }\n        .mncrpt .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }\n        img.radioimage-select { padding: 7px; border: solid 2px #ffffff; margin: 7px 1px; cursor: pointer; box-shadow: none; }\n        img.radioimage-select:hover { border: solid 2px #a5c1e5; }\n        img.radioimage-select.radioimage-checked { border: solid 2px #7db8d9; background-color: #f4f8fb; }\n        .acrypto_header{display: none}\n        .acrypto_cryptobox_top {display: none}\n    </style>";
    $custom_text = "";
    if ($box->is_paid()) {
        $paymentInfo = $box->payment_info();
        require_once ROOTDIR . "/includes/invoice.fun.php";
        $IsAggregator = false;
        $IsWallet = false;
        $aggregatordata = explode("_", $params["invoiceid"]);
        $aggregatordata[0] = 0 < $aggregatordata[1] && $aggregatordata[2];
        if ($aggregatordata[0]) {
            $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
            $aggretran = mysqli_fetch_assoc($aggretran);
            if ($aggretran["aggregatortransid"]) {
                $idnumber = $aggregatordata[1];
                $IsAggregator = true;
            }
        }
        $aggregatordata[0] = 0 < $aggregatordata[1];
        if ($aggregatordata[0]) {
            $idnumber = $aggregatordata[1];
            $IsWallet = true;
        }
        logTransaction("gourlio", json_encode($paymentInfo), "Successful", "invoice");
        $userid = $params["clientdetails"]["userid"];
        $invoiceid = $params["invoiceid"];
        $txn_id = $paymentInfo->txID;
        $mc_gross = $paymentInfo->amountUSD;
        $mc_fee = 0;
        $payer_email = $paymentInfo->addr;
        $paypalcurrency = "USD";
        $currency = getCurrency("", $userid);
        $result = select_query("tbl_currencies", "", ["code" => $paypalcurrency]);
        $data = mysqli_fetch_assoc($result);
        $paypalcurrencyid = $data["id"];
        if ($paypalcurrencyid != $currency["id"]) {
            $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
            $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
            $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
            $data = mysqli_fetch_assoc($result);
            $total = round($data["total"], 2);
            if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                $mc_gross = $total;
            }
        }
        $PaidAmount = $mc_gross;
        if ($IsWallet) {
            $INVOSI = explode("_", $params["invoiceid"]);
            $Gateway = loadGatewayModule("gourlio");
            $Wallet = mysqli_fetch_assoc(dquery("select fee,amount from tblWalletTransaction \nwhere transid='" . $INVOSI[1] . "'"));
            $Fee = $Wallet["fee"];
            $PaidAmount = round($PaidAmount, 2);
            if (0 < $Fee) {
                $PaidAmount = $PaidAmount - $Fee;
            }
            if ($Wallet["amount"] <= $PaidAmount) {
                walletTransaction($txn_id, $idnumber, $PaidAmount, $Fee, $Gateway["name"]);
                logTransaction("gourlio", $params, "Wallet Paid", "invoice", $invoiceid);
            } else {
                dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $INVOSI[1] . "'");
                logTransaction("rakbankpay", $params, "Transaction Less Amount", "invoice", $invoiceid);
                include_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $INVOSI[1] . " <br />";
                $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                $adminmessage .= "Amount : " . $PaidAmount;
                sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
            }
        } else {
            addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "gourlio", 1);
        }
        return "<script>location.reload();</script>Already paid";
    }
    return $OUT . $box->display_cryptobox_bootstrap($coins, $def_coin, $def_language, $custom_text, 70, 200, false, "", "default", 250, "", "curl", false);
}

?>