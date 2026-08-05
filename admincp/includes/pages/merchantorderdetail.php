<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($checkpayment) {
    $id = $orderid;
    require_once ROOTDIR . "/includes/gateway.fun.php";
    require_once ROOTDIR . "/includes/invoice.fun.php";
    $params = loadGatewayModule("rakbankpay");
    $wallet = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers where id=merchantid) as merchants,(select value from tbl_paymentgateways\nwhere setting='name' and tbl_paymentgateways.gateway=tblWalletTransaction.gateway) as gate from tblWalletTransaction where transid='" . $id . "'"));
    $payer = mysqli_fetch_assoc(dquery("select * from tblUsers\nwhere id=(select uid  from tbl_statement_user where relid='" . $wallet["transid"] . "'\nand stype='Transfer' and uid!='" . $wallet["merchantid"] . "')"));
    global $rakbankpayprocesssuccess;
    $rakbankpayprocesssuccess = 1;
    $params["invoiceid"] = "B_" . $id;
    $_SESSION["merchantgateway"] = "rakbankpay";
    $taxrate = getTaxRate(1, $User["state"], $User["country"], $_SESSION["merchantgateway"]);
    $taxrate2 = getTaxRate(2, $User["state"], $User["country"], $_SESSION["merchantgateway"]);
    $_SESSION["merchantamount"] = $wallet["amount"];
    $params["amount"] = $_SESSION["merchantamount"];
    $params["description"] = $_SESSION["merchantitem"];
    $params["clientdetails"]["firstname"] = $payer["first_name"];
    $params["firstname"] = $payer["first_name"];
    $params["clientdetails"]["lastname"] = $payer["last_name"];
    $params["lastname"] = $payer["last_name"];
    $params["clientdetails"]["address1"] = $payer["address"];
    $params["clientdetails"]["city"] = $payer["city"];
    $params["clientdetails"]["email"] = $payer["email"];
    $params["emailforstripe"] = $payer["email"];
    $params["customerphone"] = $payer["phonenumber"];
    $params["clientdetails"]["country"] = $payer["country"];
    global $rakbankpayprocesssuccess;
    $SiteAddress = $config["site_address"];
    if ($config["config_ssl_allow"]) {
        $SiteAddress = $config["config_ssl_allow"];
    }
    $rakbankpayprocesssuccess = 1;
    $params["returnurl"] = $SiteAddress . "merchant/index.php?login=success";
    $params["merchantreturnurl"] = $SiteAddress . "merchant/index.php?login=success";
    $res = call_user_func($_SESSION["merchantgateway"] . "_link", $params);
    echo "    <div id='notification1' class='successbox'>Payment recheck done successful</div>\n\n    ";
}
if ($submit && $payment && $orderid) {
    $id = $orderid;
    $wallet = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers where id=merchantid) as merchants,(select value from tbl_paymentgateways\nwhere setting='name' and tbl_paymentgateways.gateway=tblWalletTransaction.gateway) as gate from tblWalletTransaction where transid='" . $orderid . "'"));
    if ($transactionid && 0 < $amount) {
        walletTransaction($transactionid, $orderid, $amount, $fee, $wallet["gate"]);
        echo "<div id='notification1' class='successbox'>" . $LNG["payment"] . " " . $LNG["added"] . "</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["field"] . " " . $LNG["required"] . "</div>";
    }
}
$wallet = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers where id=merchantid) as merchants,(select value from tbl_paymentgateways\nwhere setting='name' and tbl_paymentgateways.gateway=tblWalletTransaction.gateway) as gate from tblWalletTransaction where transid='" . $id . "'"));
$walletdata = json_decode($wallet["data"], true);
$wallet["time"] = date("h:i A", $wallet["time"]);
$state = mysqli_fetch_assoc(dquery("select *,(select email from tblUsers where tblUsers.id=uid) as payer,\n      (select (select code from tbl_currencies where id=default_currency) from tblUsers where tblUsers.id=uid) as defaultcurrency from tbl_statement_user where relid='" . $id . "' and stype='Transfer'"));
$Trans = mysqli_fetch_assoc(dquery("select id,(select email from tblUsers where tblUsers.id=uid) as merchantemail from tbl_statement_user where relid='" . $wallet["transid"] . "'\nand stype='Transfer' and uid='" . $wallet["merchantid"] . "'"));
$payer = mysqli_fetch_assoc(dquery("select id,(select email from tblUsers where tblUsers.id=uid) as payeremail from tbl_statement_user where relid='" . $wallet["transid"] . "'\nand stype='Transfer' and uid!='" . $wallet["merchantid"] . "'"));
$statedata = json_decode($state["data"], true);
if (!$statedata["item"]) {
    $statedata["item"] = $walletdata["merchantitem"];
}
echo "\n    <div id=\"notification\"></div>\n\n\n    <div id=\"content\">\n        <div id=\"content_padded\">\n\n            <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["orderid"];
echo " </td><td class=\"fieldarea\"> ";
echo "B_" . $wallet["transid"];
echo " </td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["date"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["date"];
echo " </td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["time"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["time"];
echo " </td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["merchant"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["merchants"];
echo " [";
echo $Trans["merchantemail"];
echo "]</td></tr>\n                <tr><td  class=\"fieldlabel\">Payer </td><td class=\"fieldarea\"> ";
echo $payer["payeremail"];
echo " </td></tr>\n\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["gate"] ? $wallet["gate"] : "Credit Transfer";
echo " </td></tr>\n\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["gateway"];
echo " ";
echo $LNG["invoicestransid"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["transactionid"];
echo " </td></tr>\n                ";
if ($wallet["status"] == "paid") {
    echo "                    <tr><td  class=\"fieldlabel\">";
    echo $LNG["invoicestransid"];
    echo " </td><td class=\"fieldarea\"> ";
    echo md5($Trans["id"]);
    echo " </td></tr>\n                    ";
}
echo "                <tr><td  class=\"fieldlabel\">";
echo $LNG["amount"];
echo " </td><td class=\"fieldarea\"> ";
echo $state["amount"];
echo " ";
echo $state["defaultcurrency"];
echo "</td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["fee"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["fee"];
echo " ";
echo $state["defaultcurrency"];
echo "</td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["domain"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["domain"];
echo " </td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["invoice"];
echo " </td><td class=\"fieldarea\"> ";
echo $wallet["customid"];
echo " </td></tr>\n                <tr><td  class=\"fieldlabel\">";
echo $LNG["item"];
echo " </td><td class=\"fieldarea\"> ";
echo $statedata["item"];
echo " </td></tr>\n                ";
if ($wallet["domain"]) {
    echo "                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["status"];
    echo " </td>\n                        <td class=\"fieldarea\"> ";
    echo $wallet["status"];
    echo " </td>\n                    </tr>\n                    ";
}
$GatewayLog = mysqli_fetch_assoc(dquery("select * from tbl_gatewaylog \nwhere refid='B_" . $id . "' and result='Received'"));
$Logs = json_decode($GatewayLog["data"], true);
if ($GatewayLog["data"]) {
    echo "                    <tr><td class=\"fieldlabel\">Log</td>\n                        <td class=\"fieldarea\">\n                            <textarea>";
    echo $GatewayLog["data"];
    echo "</textarea>\n                        </td>\n                    </tr>\n                    ";
}
echo "            </table>\n            ";
if ($wallet["gateway"] == "rakbankpay" && $wallet["status"] != "paid") {
    echo "                <form method=\"post\">\n                    <input type=\"hidden\" name=\"payment\" value=\"1\" />\n                    <input type=\"hidden\" name=\"orderid\" value=\"";
    echo $id;
    echo "\" />\n                    <button type=\"submit\" name=\"checkpayment\" value=\"Check Payment\"\n                            class=\"btn btn-primary\">Check Payment Status</button>\n\n                </form>\n                <br/>  <br/>\n                ";
}
if ($wallet["status"] != "paid" && $wallet["domain"]) {
    echo "                <h2>Add Payment to Order </h2>\n\n                <form id=\"frm\" name=\"\" method=\"post\">\n                    <input type=\"hidden\" name=\"payment\" value=\"1\" />\n                    <input type=\"hidden\" name=\"orderid\" value=\"";
    echo $id;
    echo "\" />\n                    ";
    echo generate_token("form");
    echo "                    <table class=\"form\">\n                        <tr><td class=\"fieldlabel\">";
    echo $LNG["payment"];
    echo " ";
    echo $LNG["method"];
    echo "</td>\n                            <td class=\"fieldarea\">\n                                <select name=\"paymentmethod\" >\n                                    ";
    $qp = dquery("select gateway,value from \ntbl_paymentgateways where  setting='name'");
    while ($rqp = mysqli_fetch_assoc($qp)) {
        echo "                                        <option value=\"";
        echo $rqp["gateway"];
        echo "\">";
        echo $rqp["value"];
        echo "</option>\n                                        ";
    }
    echo "                                </select>\n                            </td>\n                        </tr>\n\n                        <tr><td class=\"fieldlabel\">";
    echo $LNG["invoicestransid"];
    echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"transactionid\" value=\"\" />\n                            </td>\n                        </tr>\n\n                        <tr><td class=\"fieldlabel\">";
    echo $LNG["amount"];
    echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"amount\" value=\"";
    echo $wallet["receivedamount"];
    echo "\" />\n                            </td>\n                        </tr>\n\n                        <tr><td class=\"fieldlabel\">";
    echo $LNG["fee"];
    echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"fee\" value=\"\" />\n                            </td>\n                        </tr>\n                        <tr><td class=\"fieldlabel\"></td>\n                            <td class=\"fieldarea\">\n                                <button name=\"submit\" class=\"btn btn-primary\" value=\"submit\" type=\"submit\" >Add Payment</button>\n                            </td>\n                        </tr>\n\n                    </table>\n                </form>\n                ";
}
echo "\n        </div>\n    </div>\n\n\n";
$fileverioncheck = "6.1.0";

?>