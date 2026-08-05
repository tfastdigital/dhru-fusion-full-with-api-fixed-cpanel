<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 151;
checkPagePermission($pageid);
echo "    <style>\n        .list{\n            cursor: pointer;\n        }\n        .list:hover{\n            background-color: #E9E9E9;\n        }\n        #clientlist{\n            background: none repeat scroll 0 0 white;\n            border: 1px solid #F4F4F4;\n            box-shadow: 0 0 5px rgba(0,0,0,0.2);\n            padding: 5px;\n            width: 152px;\n            z-index:9;\n        }\n        #clientlist li{padding:5px;list-style: none;}\n        .red{\n            color:red;\n        }\n        .clickon{\n            cursor: pointer;\n            display: none;\n        }\n        .tag{\n            background-color: #F4F4F4;\n        }\n    </style>\n    <script>\n        function removeButton(gateway){\n            \$(\".rem\"+gateway).remove();\n        }\n        function addgateway(){\n            var gateway=\$(\"#gatewayname\").val();\n           \n            var gats=gateway.split(\"__\");\n            var limit=\$(\"#limit\").val();\n            gateway=gats[0];\n            if(gateway && limit)\n            {\n                var boday=\"<tr class='rem\"+gateway+\"'><td>\"+gats[1]+\"<input type='hidden' name='gateway[\"+gateway+\"]' value='\"+limit+\"'/> </td><td>\"+limit+\"</td><td><button type='button' name='remove' onclick='removeButton(\\\"\"+gateway+\"\\\")' class='btn red'>Remove</button> </td></tr>\";\n                \$(\"#loadgateway\").append(boday);\n            }\n        }\n        function setValse(vals,val2){\n            \$('#clientlist2').append(\"<li class='rem\"+val2+\"'>\"+val2+\" <span onclick='removeGat(\"+val2+\");' style='color: red' class='remove'>X</span></li> <br />\");\n            var oldg=\$(\"#gatewaylist\").val();\n            if(oldg){\n                \$('#gatewaylist').val(oldg+\",\"+vals);\n            }else {\n                \$('#gatewaylist').val(vals );\n            }\n            \$('#clientlist').hide();\n            \$('#clientlist2').show();\n            \$('#payment').val('');\n        }\n        \$(document).ready(function(){\n            \$('#payment').keyup(function() {\n                var search=\$(this).val();\n                if(search.length>2){\n                    \$.post('includes/pages/searchgateway.php?gateway='+search, function(data) {\n\n                        if(data){\n                            \$('#clientlist').show();\n                            \$('#clientlist').html(data);\n                        }\n                    });\n                }\n            });\n        });\n    </script>\n    <style>\n\n        .form{margin-bottom: 4px !important;}\n\n    </style>\n\n\n\n    <div id=\"notification\"></div>\n\n    <div id=\"content\" style=\"width: 100%;!important \">\n\n        <div id=\"content_padded\" style=\"width: 100%;!important \">\n\n\n            <form method=\"post\" id=\"frms\">\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                    <tbody>\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["aggregator"];
echo " ";
echo $LNG["name"];
echo " *</td>\n                        <td class=\"fieldarea\">\n                            <input name=\"aggregatorname\"  value=\"\" type=\"text\"\n                                   class=\"txt medium \" />\n                        </td>\n                    </tr>\n\n\n                    </tbody></table>\n                <br />\n                <br />\n<table id=\"main_tbl\" >\n    <thead>\n    <tr>\n        <th>Gateway</th>\n        <th>Monthly Limit (";
echo $_SESSION["system_default_currency"]["code"];
echo ")</th>\n        <th>Action</th>\n    </tr>\n    </thead>\n    <tr>\n        <td>\n            <select name=\"gatewayname\" id=\"gatewayname\" >\n                <option value=\"\">Gateway</option>\n                ";
$q = dquery("select value,gateway from tbl_paymentgateways where setting='name' group by gateway");
while ($r = mysqli_fetch_assoc($q)) {
    echo "                    <option value=\"";
    echo $r["gateway"] . "__" . $r["value"];
    echo "\">";
    echo $r["value"];
    echo "</option>\n                    ";
}
echo "            </select>\n        </td>\n        <td><input type=\"text\" name=\"limit\" id=\"limit\" /></td>\n        <td><button type=\"button\"\nonclick=\"addgateway()\"\nname=\"addgatea\" value=\"Add\" class=\"btn\" >Add</button> </td>\n    </tr>\n    <tbody id=\"loadgateway\">\n\n    </tbody>\n</table>\n                <p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\n                                           class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','addaggregation','#frms','#notification','true','#main_loader');\"/></p>\n\n            </form>\n\n\n\n\n\n        </div>\n\n    </div>\n";
$fileverioncheck = "6.1.0";

?>