<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function paymentaggregator_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Payment Aggregator"], "siteurl" => ["Type" => "text", "Name" => "Site URL", "Size" => "50"], "apikey" => ["Type" => "text", "Name" => "APi Key", "Size" => "30"]];
    return $configarray;
}
function paymentaggregator_link($params)
{
    global $lng_languag;
    global $config;
    global $tid;
    global $status;
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $info = $params["info"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $sitelink = $params["siteurl"] . "/merchant/pay.php";
    $uiid = $params["apikey"];
    $SiteAddress = $config["site_address"];
    if ($config["config_ssl_allow"]) {
        $SiteAddress = $config["config_ssl_allow"];
    }
    $SiteAddress .= _url("viewinvoice/id/" . md5($invoiceid));
    if ($tid) {
        include_once ROOTDIR . "/includes/gateway.fun.php";
        include_once ROOTDIR . "includes/invoice.fun.php";
        $invoiceData = mysqli_fetch_assoc(dquery("select status from tbl_invoices\n        where id='" . $invoiceid . "' "));
        if ($invoiceData["status"] == "Unpaid") {
            $_Transaction_Id = $tid;
            if (!mysqli_num_rows(dquery("select * from tbl_transaction where transid='" . $_Transaction_Id . "'"))) {
                $_Sign = md5($_Transaction_Id . $invoiceid . $uiid);
                $_REQ = file_get_contents($sitelink . "?checktransaction=" . $_Transaction_Id . "&custom=" . $invoiceid . "&uid=" . $uiid . "&sign=" . $_Sign);
                $PaymentDetails = json_decode(decrypt($_REQ, "FKJ2928"), true);
                if ($PaymentDetails["status"] == "success") {
                    addPayment($invoiceid, $_Transaction_Id, $PaymentDetails["amount"], 0, "aggregator", 1, "", "", "");
                    echo "                    <script>\n                        location.href = ";
                    echo _url("viewinvoice/id/" . md5($invoiceid));
                    echo "';\n                    </script>\n                    ";
                } else {
                    echo "                    <script>\n                        location.href = ";
                    echo _url("viewinvoice/id/" . md5($invoiceid));
                    echo ";\n                    </script>\n                    ";
                }
            }
        }
    }
    $data = [];
    $data[time()] = time();
    $data["invoiceid"] = $invoiceid;
    $data["curcode"] = $params["currency"];
    $data["amount"] = $invoicetotal;
    $data["cancelurl"] = $SiteAddress . "&paymentfailed=true";
    $data["successurl"] = $SiteAddress . "&paymentsuccess=true";
    $data["clientid"] = $_SESSION["uid"];
    $data["clientfirstname"] = $params["clientdetails"]["firstname"];
    $data["clientlastname"] = $params["clientdetails"]["lastname"];
    $data["clientemail"] = $params["clientdetails"]["email"];
    $data["clientphone"] = $params["clientdetails"]["phone"];
    $data[time() . "1"] = time();
    $code .= "<form action=\"" . $sitelink . "\" method=\"post\">\n    <input type=\"hidden\" name=\"paymentaggregator\" value=\"1\">    \n    <input type=\"hidden\" name=\"uid\" value=\"" . $uiid . "\">\n    <input type=\"hidden\" name=\"data\" value=\"" . encrypt(base64_encode(json_encode($data)), md5($uiid . "ASHDFKASHDKF31")) . "\">    \n    <input type=\"submit\" class=\"btn btn-success\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\n    </form>";
    return $code;
}

?>