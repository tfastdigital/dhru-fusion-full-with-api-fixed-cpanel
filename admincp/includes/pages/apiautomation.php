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
echo "    <div id=\"tabcontent\">\r\n        <ul id=\"tabmenu\">\r\n            <li class=\"tabmenu-header\"><span>Submenu</span></li>\r\n            <li><a  onclick=\"getContect('#tab1','main2.php?page=apisetting.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Synchronize</a></li>\r\n            <li><a  class=\"tabmenu_active\" onclick=\"getContect('#tab3','main2.php?page=apisetting.status','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["status"];
echo "</a></li>\r\n            <li><a onclick=\"getContect('#tab4','main2.php?page=apisetting.quickadd','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["service"];
echo "</a></li>\r\n            <li><a onclick=\"getContect('#tab5','main2.php?page=apiautomation','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >Pricing Automation</a></li>\r\n\r\n            <div style=\"clear: both;\"></div>\r\n        </ul>\r\n\r\n\r\n\r\n        <div id=\"notification\"></div>\r\n\r\n        <div  class=\"groupstabes\">\r\n\r\n            <div class=\"groupstabescontant\">\r\n                ";
$data_query = dquery("SELECT * FROM `tbl_apiservers` WHERE `gateway`='" . $id . "'");
while ($data = mysqli_fetch_assoc($data_query)) {
    $gwv_database_val[$data["setting"]] = $data["value"];
}
if (!$gwv_database_val["currency"]) {
    echo "                    <div id=\"notification1\" class=\"errorbox\">Gateway not support for automation [Currency code missing]</div>\r\n                    ";
    exit;
}
if ($gwv_database_val["priceincrease"]) {
    $Prices = json_decode($gwv_database_val["priceincrease"], true);
}
echo "                <form method=\"post\" id=\"frm\">\r\n                    <input type=\"hidden\" name=\"apiid\" value=\"";
echo $id;
echo "\" />\r\n                    <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\r\n                        <tbody>\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Base Price Increase By </td>\r\n                            <td class=\"fieldarea\">\r\n                                <input type=\"text\" size=\"5\" name=\"priceincrease[base][price]\" value=\"";
echo $Prices["base"]["price"];
echo "\" />\r\n                                <select name=\"priceincrease[base][increaseby]\">";
echo $gwv_database_val["currency"];
echo "                                    <option ";
if ($Prices["base"]["increaseby"] == "Percentage") {
    echo "selected";
}
echo ">Percentage</option>\r\n                                    <option ";
if ($Prices["base"]["increaseby"] == "Fixed") {
    echo "selected";
}
echo ">Fixed</option>\r\n                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Retail Price Increase By </td>\r\n                            <td class=\"fieldarea\">\r\n                                <input type=\"text\" size=\"5\" name=\"priceincrease[retail][price]\" value=\"";
echo $Prices["retail"]["price"];
echo "\" />\r\n                                <select name=\"priceincrease[retail][increaseby]\">";
echo $gwv_database_val["currency"];
echo "                                    <option ";
if ($Prices["retail"]["increaseby"] == "Percentage") {
    echo "selected";
}
echo ">Percentage</option>\r\n\r\n                                    <option ";
if ($Prices["retail"]["increaseby"] == "Fixed") {
    echo "selected";
}
echo ">Fixed</option>\r\n                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        ";
$qg = dquery("select * from tbl_client_group order by displayorder,id asc");
while ($r = mysqli_fetch_assoc($qg)) {
    echo "                            <tr>\r\n                                <td  class=\"fieldlabel\"><strong>";
    echo $r["groupname"];
    echo "</strong> Price Increase By </td>\r\n                                <td class=\"fieldarea\">\r\n                                    <input type=\"text\" size=\"5\" name=\"priceincrease[";
    echo $r["id"];
    echo "][price]\" value=\"";
    echo $Prices[$r["id"]]["price"];
    echo "\" />\r\n                                    <select name=\"priceincrease[";
    echo $r["id"];
    echo "][increaseby]\">";
    echo $gwv_database_val["currency"];
    echo "                                        <option ";
    if ($Prices[$r["id"]]["increaseby"] == "Percentage") {
        echo "selected";
    }
    echo ">Percentage</option>\r\n                                        <option ";
    if ($Prices[$r["id"]]["increaseby"] == "Fixed") {
        echo "selected";
    }
    echo ">Fixed</option>\r\n                                    </select>\r\n                                </td>\r\n                            </tr>\r\n                         ";
}
echo "                        <tr>\r\n                            <td></td>\r\n                            <td class=\"fieldarea\">\r\n                                <strong> <label><input type=\"checkbox\" name=\"iagree\" value=\"1\" id=\"iagree\" onclick=\"iAgree(this);\" />I Agree.</label> </strong><br />\r\n                             <span style=\"color:red\"> This will overwrite incremental price of  all connected service with This APi</span>\r\n                                <div><br />\r\n                                <input type=\"button\"\r\n                                       class=\"applybtn addFromgallery\" id=\"btns\" name=\"save\"\r\n                                       value=\"";
echo $LNG["save"];
echo "\"\r\n                                       onclick=\"javascript: if(confirm('Are you sure want to Perform Bulk changes of Pricing Automation?')){SubmitForm ('#btns','apiautomation','#frm','#notification','true','#main_loader','main2.php?page=apisetting&defaultloadpage=cronsetting.php');}\" />\r\n                                </div>\r\n                            </td>\r\n                        </tr>\r\n                        </tbody>\r\n                    </table>\r\n            </div></div>\r\n        </form>\r\n\r\n\r\n        <style>\r\n            #btns{\r\n                display: none;\r\n            }\r\n        </style>\r\n        <script>\r\n            function iAgree(obj){\r\n                if(obj.checked){\r\n                    \$(\"#btns\").show();\r\n                }else{\r\n                    \$(\"#btns\").hide();\r\n                }\r\n            }\r\n        </script>\r\n    </div>\r\n";
$fileverioncheck = "6.1.0";

?>