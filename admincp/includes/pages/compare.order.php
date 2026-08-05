<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\r\n";
$pageid = 186;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/" . $admindirpath . "/includes/pages/imeiservice.fun.inc.php";
echo "<style>\r\n    .txtgray{\r\n        color:#afaeaa;\r\n        font-weight: bold;\r\n    }\r\n    .txtred{\r\n        color:#b5052a;\r\n        font-weight: bold;\r\n    }\r\n    .txtgreen{\r\n        color:#008000;\r\n        font-weight: bold;\r\n    }\r\n    .txtorange{\r\n        color:#dd9303;\r\n        font-weight: bold;\r\n    }\r\n    select{\r\n        max-width: 100px !important;\r\n    }\r\n    input[type=\"text\"]{\r\n        max-width: 120px !important;\r\n    }\r\n    input[type=\"button\"]{\r\n        margin: 2px;\r\n    }\r\n</style>\r\n\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n            <div>\r\n                <div  class=\"groupstabes\" >\r\n                    <div id=\"notification\"></div>\r\n                    <div class=\"groupstabescontant\">\r\n                        <h2>";
echo $LNG["search"];
echo " ";
echo $LNG["result"];
echo " ";
echo $LNG["for"];
echo " : ";
echo $search;
echo " <small>";
echo $LNG["maximum"];
echo " 5 ";
echo $LNG["orders"];
echo "</small></h2>\r\n";
$q = dquery("select *,(select service_name from tbl_services_imei\r\nwhere id=service_id) as service,(select concat(username,' [',email,']')\r\n from tblUsers where id=user_id) as user,(select code from tbl_currencies\r\n where id=(select default_currency from tblUsers where id=user_id)) as code\r\n  ,(select `time` from tbl_services_imei\r\nwhere id=service_id) as dtime,(select username from tbl_admin\r\nwhere id=reply_by_admin) as replyby\r\n\r\n,(select username from tbl_supplier\r\nwhere id=reply_by_sup) as replybysup\r\n\r\n,(select value from tbl_apiservers\r\nwhere gateway=reply_by_api and setting='name') as replybyapi\r\n,(select B_ID from tbl_mobile where ID=model_id) as brand_id\r\n,(select C_ID from tbl_provider where ID=provider_id) as providercountry_id\r\n,(select assigned_model from tbl_services_imei where id=service_id) as assigned_model\r\n,(select assigned_provider from tbl_services_imei where id=service_id) as assigned_provider\r\n  from tbl_order_imei where imei like '%" . $search . "%'\r\n order by order_id desc\r\nlimit 5");
while ($r = mysqli_fetch_assoc($q)) {
    echo "\r\n            <div  class=\"groupstabes\" style=\"width: 19%; margin:4px; float: left;border-right:#ddd solid 1px;\">\r\n                <span class=\"groupstabesheadertext\">Order ID: ";
    echo $r["order_id"];
    echo "/";
    echo $r["encnum"];
    echo "</span><br />\r\n                <span>";
    echo $LNG["imei"];
    echo ": ";
    echo $r["imei"];
    echo "</span><br />\r\n                <span>";
    echo $LNG["service"];
    echo ": ";
    echo $r["service"];
    echo "</span><br />\r\n                <span>";
    echo $LNG["delivery"];
    echo " ";
    echo $LNG["time"];
    echo ": ";
    echo $r["dtime"];
    echo "</span><br />\r\n                <span>";
    echo $LNG["user"];
    echo ": ";
    echo $r["user"];
    echo "</span><br />\r\n                <span>";
    echo $LNG["status"];
    echo ": <span class=\"";
    echo $r["user_can_c"] == 0 ? "txtgray" : ($r["user_can_c"] == 1 ? "txtorange" : ($r["user_can_c"] == 3 ? "txtred" : "txtgreen"));
    echo "\" >\r\n";
    if ($r["user_can_c"] == 0) {
        echo $LNG["new"];
    } else {
        if ($r["user_can_c"] == 1) {
            echo $LNG["accepted"];
        } else {
            if ($r["user_can_c"] == 3) {
                echo $LNG["cancel"];
            } else {
                if ($r["user_can_c"] == 4) {
                    echo $LNG["replied"];
                }
            }
        }
    }
    echo "</span></span><br />\r\n\r\n<span>";
    echo $LNG["order"];
    echo " ";
    echo $LNG["on"];
    echo " : ";
    echo formatDate($r["time"], "time", true);
    echo " </span><br />\r\n<span>";
    echo $LNG["order"];
    echo " ";
    echo $LNG["ip"];
    echo " : <a href=\"javascript: load_subpage('";
    echo $config["ip_location"];
    echo $row[$md5id]["allfield"]["ip"];
    echo "','IP Location');\">";
    echo $r["ip"];
    echo "</a> </span> <br />\r\n<span>";
    echo $LNG["user"];
    echo " ";
    echo $LNG["cost"];
    echo " : ";
    echo $r["credit"] - $r["discount"] . " " . $r["code"];
    echo "</span> <br />\r\n<span>";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["time"];
    echo " : ";
    if ($r["reply_time"]) {
        echo formatDate(date("Y-m-d", $r["reply_time"])) . " " . date("h:i:s", $r["reply_time"]);
    } else {
        echo "-";
    }
    echo "</span> <br />\r\n<span>";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["by"];
    echo " : ";
    if ($r["replyby"]) {
        echo $r["replyby"];
    } else {
        if ($r["replybusup"]) {
            echo $r["replybysup"];
        } else {
            if ($r["replybyapi"]) {
                echo $r["replybyapi"];
            }
        }
    }
    echo "</span> <br />\r\n    ";
    if (0 < $r["acceptedtime"]) {
        echo "     <span>Accepted after:";
        echo getTime($r["acceptedtime"], $r["time"]);
        echo " </span><br />\r\n     ";
    }
    if (0 < $r["reply_time"]) {
        echo "        <span>Replied after:";
        echo getTime($r["reply_time"], $r["time"]);
        echo " </span><br />\r\n        ";
    }
    echo "        <span>Source : ";
    echo $r["API"] ? $r["API"] : "web";
    echo "</span>\r\n\r\n\r\n                <hr />\r\n                <form id=\"frm";
    echo $r["order_id"];
    echo "\" name=\"\" method=\"post\">\r\n                    <input type=\"hidden\" name=\"orderid\" value=\"";
    echo $r["order_id"];
    echo "\" />\r\n                    ";
    echo generate_token("form");
    echo "  <fieldset>\r\n      <legend onclick=\"\$('.show";
    echo $r["order_id"];
    echo "').toggle();\" ><strong>";
    echo $LNG["click"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["detail"];
    echo "</strong> :</legend>\r\n      <table  style=\"display: none;\"  class=\"show";
    echo $r["order_id"];
    echo " form floatleft\">\r\n<tbody>\r\n<tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">";
    echo $LNG["brand"];
    echo "</td>\r\n    <td class=\"fieldarea\"><span>";
    echo getBrandDropdown($r["brand_id"], md5($r["service_id"]), "brandId", true);
    echo "</span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["model"];
    echo "</td><td class=\"fieldarea\"><div id=\"modelsdropdown\" style=\"display: none;\"></div>\r\n        <span id=\"onloadmodelsdropdown\">";
    echo getModelDropdown($r["brand_id"], $r["model_id"], $r["assigned_model"]);
    echo "</span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["country"];
    echo "</td><td class=\"fieldarea\"><span>";
    echo getProviderCountryDropdown($r["providercountry_id"], md5($r["service_id"]), "countryId", true);
    echo "</span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["provider"];
    echo "</td><td class=\"fieldarea\"><div id=\"providerdropdown\" style=\"display: none;\"></div><span id=\"onloadproviderdropdown\">";
    echo getProviderDropdown($r["providercountry_id"], $r["provider_id"], $r["assigned_provider"]);
    echo "</span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["mep"];
    echo "</td><td class=\"fieldarea\"><span>";
    echo getmepDropdown($r["mep"], md5($r["service_id"]), "mepId");
    echo "</span></td></tr>\r\n<tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">";
    echo $LNG["pin"];
    echo "</td><td class=\"fieldarea\"><span>\r\n<input type=\"text\" value=\"";
    echo $r["PIN"];
    echo "\" name=\"pin\"/></span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["kbh"];
    echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $r["KBH"];
    echo "\" name=\"kbh\"/></span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["prd"];
    echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $r["PRD"];
    echo "\" name=\"prd\"/></span></td></tr>\r\n<tr><td class=\"fieldlabel\">";
    echo $LNG["lock"];
    echo " ";
    echo $LNG["type"];
    echo "</td>\r\n    <td class=\"fieldarea\"><span>\r\n   <input type=\"text\" value=\"";
    echo $r["Type"];
    echo "\" name=\"type\"/></span></td></tr>\r\n\r\n<tr><td class=\"fieldlabel\">SN</td><td class=\"fieldarea\"><span>\r\n    <input type=\"text\" value=\"";
    echo $r["SN"];
    echo "\" name=\"SN\"/>\r\n</span></td></tr>\r\n\r\n<tr><td class=\"fieldlabel\">SecRO</td><td class=\"fieldarea\"><span>\r\n <input type=\"text\" value=\"";
    echo $r["SecRo"];
    echo "\"  name=\"SecRO\"/></span></td></tr>\r\n<tr>\r\n    <td></td>\r\n    <td>\r\n        <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnedituser";
    echo $r["order_id"];
    echo "\" class=\"btn\" type=\"button\"\r\nonclick=\"SubmitForm('#btnedituser";
    echo $r["order_id"];
    echo "','editorderdirect','#frm";
    echo $r["order_id"];
    echo "','#notification','true','#main_loader');\"/>\r\n    </td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n\r\n  </fieldset>\r\n        </form>\r\n\r\n<form id=\"frmo";
    echo $r["order_id"];
    echo "\" name=\"\" method=\"post\">\r\n    <input type=\"hidden\" name=\"id\" value=\"";
    echo $r["order_id"];
    echo "\" />\r\n    <input type=\"hidden\" name=\"md5id\" value=\"";
    echo md5($r["order_id"]);
    echo "\" />\r\n    ";
    echo generate_token("form");
    echo "                <input type=\"text\" value=\"\" placeholder=\"";
    if ($r["user_can_c"] == "4") {
        echo $LNG["reject"] . " " . $LNG["reason"];
    } else {
        echo $LNG["reply"] . " " . $LNG["code"];
    }
    echo "\" name=\"replycode\" style=\"background: #f4f4f4;\"/><br />\r\n\r\n              ";
    if ($r["user_can_c"] == "0" || $r["user_can_c"] == "1") {
        echo "                    <input value=\"";
        echo $LNG["reply"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsuccess\" id=\"btnsuccess";
        echo $r["order_id"];
        echo "\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsuccess";
        echo $r["order_id"];
        echo "','edituser.editimeiordersuccess','#frmo";
        echo $r["order_id"];
        echo "','#notification','true','#main_loader');\"/><br />\r\n              ";
    }
    if ($r["user_can_c"] == "0" || $r["user_can_c"] == "1" || $r["user_can_c"] == "4") {
        echo "                    <input value=\"";
        echo $LNG["reject"];
        echo "\" id=\"btnreject";
        echo $r["order_id"];
        echo "\" name=\"btnreject\" class=\"button_remove\" type=\"button\"  onclick=\"SubmitForm ('#btnreject";
        echo $r["order_id"];
        echo "','edituser.editimeiorderreject','#frmo";
        echo $r["order_id"];
        echo "','#notification','true','#main_loader');\"/><br />\r\n                ";
    }
    if ($r["user_can_c"] == "3") {
        echo "                    <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsetback\" id=\"btnsetback";
        echo $r["order_id"];
        echo "\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback";
        echo $r["order_id"];
        echo "','edituser.editimeiordersuccess','#frmo";
        echo $r["order_id"];
        echo "','#notification','true','#main_loader');\"/><br />\r\n                    <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["new"];
        echo "\" name=\"btnsetback\" id=\"btnsetback";
        echo $r["order_id"];
        echo "\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback";
        echo $r["order_id"];
        echo "','edituser.editimeiordernew','#frmo";
        echo $r["order_id"];
        echo "','#notification','true','#main_loader');\"/><br />\r\n                    <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["accepted"];
        echo "\" name=\"btnsetback\" id=\"btnsetback";
        echo $r["order_id"];
        echo "\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback";
        echo $r["order_id"];
        echo "','edituser.editimeiorderaccept','#frmo";
        echo $r["order_id"];
        echo "','#notification','true','#main_loader');\"/>\r\n                ";
    }
    echo "\r\n</form>\r\n\r\n\r\n                <hr />\r\n                <div  class=\"groupstabes\" >\r\n   ";
    echo $LNG["reply"];
    echo " : <br />\r\n    <textarea style=\"width: 200px;\" cols=\"20\" rows=\"10\" >";
    echo $r["reply"];
    echo "</textarea>\r\n                </div>\r\n\r\n\r\n            </div>\r\n\r\n        ";
}
echo "\r\n\r\n\r\n\r\n\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n\r\n";
$fileverioncheck = "6.1.0";
function getTime($end, $start)
{
    $seconds = $end - $start;
    $days = floor($seconds / 86400);
    $hours = floor($seconds / 3600);
    $minutes = floor($seconds / 60 % 60);
    $seconds = $seconds % 60;
    if (0 < $days) {
        return $days . " Days " . $hours . " Hrs";
    }
    if (0 < $hours) {
        return $hours . " Hr " . $minutes . " Min";
    }
    if (0 < $minutes) {
        return $minutes . " Min " . $seconds . " Sec";
    }
    if (0 < $seconds) {
        return $seconds . " Sec";
    }
}

?>