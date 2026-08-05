<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$user = preg_replace("/[^0-9]/i", "", $user);
if (!$config["addfund"]) {
    echo "<div class='errorbox alert'>Add Fund not allowed</div>";
}
if ($user) {
    $password = md5(md5($password) . $passenc);
    $result = dquery("SELECT *,\r\n      (select code from tbl_currencies where id=default_currency)\r\n       as code FROM `tblUsers` WHERE \r\n                `password`='" . $password . "' and userstatus=0 and id='" . $user . "'");
    if (mysqli_num_rows($result)) {
        $detail = mysqli_fetch_assoc($result);
        $_SESSION["uid"] = $detail["id"];
        if (!function_exists(getGateways)) {
            include_once ROOTDIR . "/includes/gateway.fun.php";
        }
        $gateways = getGateways();
        $_SESSION["sectoken"] = rand(300, 20000);
        $token = $_SESSION["sectoken"];
        echo "<!DOCTYPE HTML>\r\n<html>\r\n<head>\r\n\t<meta http-equiv=\"content-type\" content=\"text/html\" />\r\n\t<meta name=\"author\" content=\"bhavanesh vatalia\" />\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0\" />\r\n\r\n\t<title>";
        echo $config["companyname"];
        echo "</title>\r\n    \r\n    <script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\r\n  \r\n    <script src=\"includes/js/custom.js\" type=\"text/javascript\"></script>\r\n    \r\n    <style>\r\n        body{margin:0;padding:0;font-family:Roboto;color:#555;font-size:12px;}\r\n        .field{margin:20px 0;}\r\n        .field .label{text-transform: uppercase;display:block;width:100%;padding:3px 0;}\r\n        .field input,.field select,.field input:focus,.field select:focus{border:none;border-radius:3px;border: #ccc solid 1px;color:#444;width:100%;padding:10px;box-sizing: border-box;background:white;font-size:16px}\r\n        .field .btn{background: #4a90e2;color:white;text-transform:uppercase;padding:15px;border-radius:5px;font-size:14px;width:100%;border:none}\r\n        .clear{clear:both}\r\n        small{font-size:12px;}\r\n        .tax,.tax2{text-align: right;padding:5px 5px;text-transform: uppercase;}\r\n        .tax .label,.tax2 .label{ }\r\n        .tax,.tax2{display:inline-block;width:100px;}\r\n        \r\n        .boxes .span3:hover{background:#eee}\r\n        .xyz{display:none;text-transform: uppercase;}\r\n        .tx-right{text-align:right}\r\n         \r\n        .successbox   {padding:5px;background-color: #E5EDC4;background-image: -moz-linear-gradient(center top , #d7f7c4, #cae9b8);border: 1px solid #B8C97B;color: #3F7227;text-shadow: 0 1px 1px #FFFFFF;}\r\n        .errorbox{padding:5px;background-color: #FAE2E2;background-image: -moz-linear-gradient(center top , #ffcdd1, #ecbcc0);border: 1px solid #EEB7BA;color: #BE4741;text-shadow: 0 1px 1px #FFFFFF;}\r\n        .alert li,.alert1 li{font-size:12px;list-style:none;}\r\n        .alert1.alert-info,.alert1.alert-success,.alert1.alert-error{border-radius:4px 4px 4px 4px;margin-bottom:20px;padding:10px;}\r\n        .alert{display:none;padding:10px;}\r\n        .alert1{margin-bottom:20px;padding:10px;}\r\n        .alert-login{margin-bottom:10px;display:none;padding:5px;}\r\n        \r\n    </style>     \r\n \r\n\r\n\r\n    \r\n</head>\r\n\r\n<body>\r\n \r\n<form method=\"post\" id=\"frmid\">\r\n    <input type=\"hidden\" name=\"token\" value=\"";
        echo $token;
        echo "\" />\r\n<div style=\"background: #f9f9f9;padding:0 20px;\">\r\n    <h1 style=\"color: #4a4a4a;float: left;\">\r\n        ";
        echo $detail["credit_left"];
        echo " ";
        echo $detail["code"];
        echo "   \r\n        <small style=\"font-size: 12px;display:block;font-weight:normal;color:#888\">Your Current Balance</small>     \r\n    </h1>\r\n    <div class=\"clear\"></div>\r\n</div>\r\n<div style=\"background: white none repeat scroll 0% 0%; padding: 0px 20px;\">\r\n <div class=\"alert\"></div>  \r\n    <div class=\"field\">\r\n        <label class=\"label\">Deposit Now ( <small style=\"font-size: 10px;color:#444\">Min : ";
        echo $config["AddFundsMinimum"];
        echo " ";
        echo $detail["code"];
        echo " &nbsp;&nbsp;/&nbsp;&nbsp; Max : ";
        echo $config["AddFundsMaximumBalance"];
        echo " ";
        echo $detail["code"];
        echo "</small> )</label>\r\n        <div class=\"control\" style=\"position: relative;\">\r\n            <input type=\"number\" name=\"amount\" onkeyup=\"addPlus()\" id=\"amount\" value=\"";
        echo $config["AddFundsMinimum"];
        echo "\"/> \r\n            <span style=\"position:absolute;right:30px;top:13px;\">";
        echo $detail["code"];
        echo "</span>\r\n        </div>\r\n    </div>\r\n    \r\n    <div class=\"field\">\r\n        <label class=\"label\">Payment Gateway</label>\r\n        <div class=\"control\">\r\n            <select  name=\"paymentmethod\" onchange=\"addPlus()\" >\r\n                 ";
        foreach ($gateways as $gid => $gat) {
            echo "                    <option value=\"";
            echo $gat["sysname"];
            echo "\">";
            echo $gat["name"];
            echo "</option>\r\n                 ";
        }
        echo "                                                   \r\n            </select>\r\n        </div>\r\n    </div>\r\n    \r\n    <div class=\"xyz\">\r\n        <label class=\"label\"><span class=\"taxname\"></span> : <span class=\"calculate tax\"> 0 </span></label>         \r\n    </div>\r\n    \r\n    <div class=\"xyz\" style=\"display: none;\">\r\n        <label class=\"label\"><span class=\"taxname2\"></span> : <span class=\"calculate tax2\">10 </span> </label>         \r\n    </div>\r\n    \r\n    <div class=\"field\" style=\"position: fixed;bottom:0;left:0;right:0;margin:0;\">        \r\n<button type=\"button\" class=\"btn\" style=\"border-radius:0\"\r\nonclick=\"SubmitForm('.btn','includes/getdata/fund.save.php','#frmid','.alert','true','',true);\"\r\n> PAY <span class=\"calculate total-paynow\" style=\"font-size: 25px;\"> </span> </button>            \r\n\r\n    </div>\r\n    <br /><br /><br />\r\n    \r\n</div>\r\n</form>\r\n \r\n\r\n\r\n<script>\r\n      \$(document).ready(function(){           \r\n                             \r\n           \$(\".my-select\").chosen({width:\"100%\"}); \r\n      });  \r\n        function addPlus(){  \r\n   \r\n\r\n           var gatewayid=\$('select[name=paymentmethod]').val();\r\n           \r\n           var amount=\$(\"#amount\").val();\r\n           \r\n            \$.post('widget/getWithTax', { gateway: gatewayid, amount: amount ,balance: ";
        echo $detail["credit_left"];
        echo " }, function(data) {\r\n                    var arr=data.split(\"_\"); \r\n          //  alert(data);                   \r\n                    \$('.total').html(arr[0]);\r\n                    \$('.tax').html(arr[1]);\r\n                    \$('.taxname').html(arr[2]);                    \r\n                    \$('.amount').html(amount);\r\n                    \$('.tax2').html(arr[3]);\r\n                    \$('.taxname2').html(arr[4]);\r\n                   \r\n                    if(arr[5]=='Inclusive'){\r\n                        \$('.total-paynow').text(' '+parseFloat(\$('#amount').val()));\r\n                    }else{\r\n                        \$('.total-paynow').text(parseFloat(\$('#amount').val())+parseFloat(\$('.tax').text())+parseFloat(\$('.tax2').text())+' / ');\r\n                    }\r\n            });\r\n            if(\$('.updateno').val()==''){\r\n                \$('.updateno').val('0');\r\n            } \r\n            if(amount==0){\r\n                \$('.xyz').slideUp();\r\n            } \r\n            else{\r\n                \$('.xyz').slideDown();\r\n            }\r\n                //do something special\r\n \r\n        } \r\n    </script>\r\n    \r\n\r\n</body>\r\n</html>";
    } else {
        exit;
    }
} else {
    exit;
}
class no
{
}

?>