<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei where id='" . $id . "'"));
echo "<script>\n\$(document).ready(function() {\n        MgetIMEIOrder('";
echo $id;
echo "','#userlistni','false','');\n});\nfunction getAccept(){\n    var buffer=\"\";\n    \$(\"input:checkbox[name=ids]:checked\").each(function()\n    {\n         buffer =buffer+\$(this).val()+\",\";\n    });\n    buffer = buffer.slice(0, -1);\n    \$('#parameter').val(buffer);\n    SubmitForm ('#btnedituserpass','order.accept','#frmedituser','#notificationni','false','');\n    MgetIMEIOrder('";
echo $id;
echo "','#userlistni','false','');\n   }\n function getAcceptAll(){\n       \$('#selall').val('1');\n        SubmitForm ('#btnedituserpass','order.accept','#frmedituser','#notificationni','false','');\n        MgetIMEIOrder('";
echo $id;
echo "','#userlistni','false','');\n   }\n   function getReject(){\n    var buffer=\"\";\n    \$(\"input:checkbox[name=ids]:checked\").each(function()\n    {\n         buffer =buffer+\$(this).val()+\",\";\n    });\n    buffer = buffer.slice(0, -1);\n    \$('#parameter').val(buffer);\n    \$('#values').val('REJECT');\n    SubmitForm ('#btnedituserpass','order.accept','#frmedituser','#notificationni','false','');\n    MgetIMEIOrder('";
echo $id;
echo "','#userlistni','false','');\n   }\n   function setSel(ids){\n        if(document.getElementById(ids).checked){\n            document.getElementById(ids).checked=false;\n        }else{\n            document.getElementById(ids).checked=true;\n        }\n   }\n</script>\n    <div  id=\"notificationni\"></div>\n\n<form id=\"frmedituser\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" id=\"values\" name=\"values\" value=\"\" />\n<input type=\"hidden\" name=\"alls\" value=\"1\" />\n\n<input type=\"hidden\" name=\"sid\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"selall\" id=\"selall\" value=\"0\" />\n<input type=\"hidden\" id=\"parameter\" name=\"parameter\" value=\"\" />\n</form>\n\n\n<div class=\"content\">\n<div class=\"panel\">\n            <h2>IMEI Orders <span>[";
echo $serv["service_name"];
echo "]</span></h2>\n            <div class=\"grid\"  id=\"userlistni\" >\n\n            </div>\n</div>\n</div>\n\n <div class=\"action\">\n        <div class=\"panel\">\n            <p><a id=\"btnedituserpass\" onclick=\"getReject();\" class=\"btn\">Reject</a></p>\n            <p><a onclick=\"getAccept()\" class=\"btn\">Accept Selected</a></p>\n            <p><a onclick=\"getAcceptAll()\" class=\"btn\">Accept All</a></p>\n        </div>\n </div>\n\n\n";

?>