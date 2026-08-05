<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function payumoney_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayUMoney"], "key" => ["Name" => "Merchant Key", "Type" => "text", "Size" => "20"], "salt" => ["Name" => "Merchant Salt", "Type" => "text", "Size" => "26"]];
    return $configarray;
}
function payumoney_link($params)
{
    global $config;
    $code = "";
    $key = $params["key"];
    $salt = $params["salt"];
    $order_id = $params["invoiceid"];
    $website = $params["website"];
    $amount = round($params["amount"], 2);
    $email = $params["clientdetails"]["email"];
    $firstname = $_SESSION["username"];
    $phone = $params["customerphone"];
    $inv = mysqli_fetch_assoc(dquery("select description from tbl_invoiceitems\n    where invoiceid='" . $order_id . "'"));
    $CALLBACK = $config["site_address"] . "/modules/gateways/callback/payumoney.php";
    $productinfo1 = $inv["description"];
    $hash = hash("sha512", $key . "|" . $order_id . "|" . $amount . "|" . $productinfo1 . "|" . $firstname . "|" . $email . "|||||BOLT_KIT_PHP7||||||" . $salt);
    $code .= "<form action=\"#\" id=\"payment_form\"  >\n    <input type=\"hidden\" id=\"udf5\" name=\"udf5\" value=\"BOLT_KIT_PHP7\" />\n    <input type=\"hidden\" id=\"surl\" name=\"surl\" value=\"" . $CALLBACK . "\" />\n    <input type=\"hidden\" id=\"furl\" name=\"furl\" value=\"" . $CALLBACK . "\" />\n    <input type=\"hidden\" id=\"key\" name=\"key\" placeholder=\"Merchant Key\" value=\"" . $key . "\" />\n    <input type=\"hidden\" id=\"service_provider\" name=\"service_provider\" placeholder=\"Merchant Key\" value=\"\" />\n    <input type=\"hidden\" id=\"txnid\" name=\"txnid\" placeholder=\"Transaction ID\" value=\"" . $order_id . "\" />\n    <input type=\"hidden\" id=\"amount\" name=\"amount\" placeholder=\"Amount\" value=\"" . $amount . "\" />\n    <input type=\"hidden\" id=\"productinfo\" name=\"productinfo\" placeholder=\"Product Info\" value=\"" . $productinfo1 . "\" />\n    <input type=\"hidden\" id=\"firstname\" name=\"firstname\" placeholder=\"First Name\" value=\"" . $firstname . "\" />   \n    <input type=\"hidden\" id=\"email\" name=\"email\" placeholder=\"Email ID\" value=\"" . $email . "\" />\n    <input type=\"hidden\" id=\"phone\" name=\"phone\" placeholder=\"Mobile/Cell Number\" value=\"" . $phone . "\" />\n    <input type=\"hidden\" id=\"hash\" name=\"hash\" placeholder=\"Hash\" value=\"" . $hash . "\" />\n    <input type=\"button\" value=\"Pay\" class=\"btn btn-primary btn-primary paymentbtn\" onclick=\"launchBOLT(); return false;\" />\n\t</form>";
    $code .= "\n<script id=\"bolt\" src=\"https://checkout-static.citruspay.com/bolt/run/bolt.min.js\" bolt-color=\"e34524\" bolt-logo=\"http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png\"></script>";
    $code .= "\n<script type=\"text/javascript\">\nfunction launchBOLT()\n{\n\tbolt.launch({\n        key: \$('#key').val(),\n        txnid: \$('#txnid').val(), \n        hash: \$('#hash').val(),\n        amount: \$('#amount').val(),\n        firstname: \$('#firstname').val(),\n        email: \$('#email').val(),\n        phone: \$('#phone').val(),\n        productinfo: \$('#productinfo').val(),\n        udf5: \$('#udf5').val(),\n        surl : \$('#surl').val(),\n        furl: \$('#furl').val(),\n        mode: 'dropout'\t\n    },\n    {\n\t    responseHandler: function(BOLT){\n\t\t\n        if(BOLT.response.txnStatus != 'CANCEL')\n        {\n            //Salt is passd here for demo purpose only. For practical use keep salt at server side only.\n            var fr = '<form action=\"'+\$('#surl').val()+'\" method=\"post\">' +\n\t\t'<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +\n\t\t'<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +\n\t\t'<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +\n\t\t'<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +\n\t\t'<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +\n\t\t'<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +\n\t\t'<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +\n\t\t'<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +\n\t\t'<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +\n\t\t'<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +\n\t\t'</form>';\n            var form = jQuery(fr);\n            jQuery('body').append(form);\t\t\t\t\t\t\t\t\n            form.submit();\n        }\n    },\n\tcatchException: function(BOLT){\n\t        console.log(BOLT);\n \t\talert( BOLT.message );\n\t}\n\t\n    });\n}\n\n</script>";
    return $code;
}

?>