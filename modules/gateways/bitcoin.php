<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_GET["show"] && is_numeric($_GET["show"])) {
    $paramsModule = basename(__FILE__, ".php");
    $params = getGatewayVariables($paramsModule);
    $params = _getPaymentDataByInvoiceId($_GET["show"]);
    $qrString = "bitcoin:" . $params["address"] . "?amount=" . $params["amount"] . "&label=" . urlencode($params["companyname"] . " Invoice #" . $params["invoice_id"]);
    echo "    <!DOCTYPE html>\n    <html>\n    <head>\n        <title>Blockchain.com; Invoice #";
    echo $params["invoice_id"];
    echo ";\n            Amount: ";
    echo $params["amount"];
    echo "</title>\n        <script src=\"blockchain/jquery.min.js\"></script>\n        <script src=\"blockchain/jquery.qrcode.min.js\"></script>\n        <style>\n            body {\n                margin: 0;\n                padding: 0;\n                text-align: right;\n            }\n        </style>\n    </head>\n    <body>\n    <div id=\"qr-canvas\"></div>\n\n    Please send <a id=\"qr-string\" href=\"";
    echo $qrString;
    echo "\">";
    echo $params["amount"];
    echo " BTC</a> to address<br>\n    <a href=\"https://www.blockchain.info/btc/address/";
    echo $params["address"];
    echo "\"\n       target=\"_blank\">";
    echo $params["address"];
    echo "</a>\n\n    <script type=\"text/javascript\">\n        function generateQR() {\n            var \$qrCanvas = \$('#qr-canvas'),\n                \$qrString = \$('#qr-string').attr('href');\n\n            \$qrCanvas.qrcode({\n                text: \$qrString\n            });\n        }\n\n        generateQR();\n\n        function checkStatus() {\n            \$.get(\"blockchain.php?check=";
    echo $params["invoice_id"];
    echo "\",\n                function (data) {\n                    if (data == 'paid') {\n                        \$('body').html(\"Invoice paid\");\n                    } else if (data == 'unpaid') {\n                        setTimeout(checkStatus, 10000);\n                    } else {\n                        \$('body').html(\"Transaction confirming... \" + data + \"/";
    echo $params["confirmations_required"];
    echo " confirmations\");\n                        setTimeout(checkStatus, 10000);\n                    }\n                });\n        }\n\n        checkStatus();\n    </script>\n\n    </body>\n    </html>\n\n\n    ";
}
if ($_GET["check"] && is_numeric($_GET["check"])) {
    header("Content-type: text/plain");
    $params = _getPaymentDataByInvoiceId($_GET["check"]);
    if ($params["status"] == "paid") {
        $status = "paid";
    } else {
        if ($params["status"] == "confirming") {
            $status = $params["confirmations"];
        } else {
            $status = "unpaid";
        }
    }
    exit($status);
}
function bitcoin_config()
{
    return NULL;
}
function bitcoin_link($params)
{
}
function _getAmount($currency = "", $amount = 0)
{
    $url = "https://www.blockchain.com/tobtc?currency=" . $currency . "&value=" . $amount;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (in_array($status, [200, 301]) && is_numeric($response)) {
        return $response;
    }
    return false;
}

?>