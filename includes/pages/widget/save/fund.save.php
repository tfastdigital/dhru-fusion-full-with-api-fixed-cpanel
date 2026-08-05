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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
if (!isset($_SESSION["uid"]) && $token != $_SESSION["sectoken"]) {
    echo "error: Something Wrong #99821";
    exit;
}
$gatewaywise = json_decode($config["otherfundlimit"], true);
if (0 < $gatewaywise[$paymentmethod]["maxlimit"]) {
    $config["AddFundsMaximum"] = $gatewaywise[$paymentmethod]["maxlimit"];
}
if (0 < $gatewaywise[$paymentmethod]["minlimit"]) {
    $config["AddFundsMinimum"] = $gatewaywise[$paymentmethod]["minlimit"];
}
$bid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
$min = convertCurrency($config["AddFundsMinimum"], $bid["id"], $_ClientsDetails["currency_id"]);
$max = convertCurrency($config["AddFundsMaximum"], $bid["id"], $_ClientsDetails["currency_id"]);
$maxbal = convertCurrency($config["AddFundsMaximumBalance"], $bid["id"], $_ClientsDetails["currency_id"]);
if ($amount && $paymentmethod) {
    $totalcredit = $_ClientsDetails["credit"]["credit"] + $amount;
    if ($maxbal < $totalcredit) {
        $errormessage = "You are not allowed to add max balanace than " . formatCurrency($maxbal);
    }
    if ($max < $amount) {
        $errormessage = "You are not allowed to add max balanace than " . formatCurrency($max);
    }
    if ($amount < $min) {
        $errormessage = "You have to add minimum balance " . formatCurrency($min);
    }
    if ($errormessage) {
        echo "error: " . $errormessage;
    } else {
        $taxed = 0;
        if ($config["AddFunds_taxenabled"]) {
            $taxed = 1;
        }
        dquery("DELETE from tbl_invoiceitems\r\n           where invoiceid='0' and userid='" . $_SESSION["uid"] . "'");
        insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "AddFunds", "relid" => "", "description" => $lng_languag["addfund"], "amount" => $amount, "taxed" => $taxed, "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        require_once ROOTDIR . "/includes/invoice.fun.php";
        $invoiceid = generateInvoice($_SESSION["uid"]);
        echo "redirect:viewinvoice.php?template=default4&webview=1&a=1&id=" . md5($invoiceid);
    }
} else {
    echo "error: Amount & Gatweay Required";
}

?>