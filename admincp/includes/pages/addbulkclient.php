<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n    ";
include "client.head.php";
echo "    <style>\n        .form{margin-bottom: 4px !important;}\n    </style>\n\n    ";
$pageid = 61;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
$custom = getCustomFields("regis", $id, "");
echo "<script>\n    function makeuid(length) {\n        var result           = '';\n        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';\n        var charactersLength = characters.length;\n        for ( var i = 0; i < length; i++ ) {\n            result += characters.charAt(Math.floor(Math.random() * charactersLength));\n        }\n        return result;\n    }\n    function makepass(length) {\n        var result           = '';\n        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';\n        var charactersLength = characters.length;\n        for ( var i = 0; i < length; i++ ) {\n            result += characters.charAt(Math.floor(Math.random() * charactersLength));\n        }\n        return result;\n    }\n    function generate()\n    {\n        var prefix=\$(\"#prefix\").val();\n        var nouser=\$(\"#nouser\").val();\n        if(prefix && nouser){\n            nouser=parseInt(nouser);\n                for(var i=1;i<=nouser;i++){\n                    var user=makeuid(8);\n                    \$('#bulkuser').append(prefix+user+\"\\n\");\n                    var pass=makepass(8);\n                    \$('#bulkpass').append(pass+\"\\n\");\n                    \$('#bulkemail').append(prefix+user+\"@demo.com\\n\");\n\n                }\n        }else{\n            alert('Prefix and No of User required to auto generate');\n        }\n    }\n</script>\n    <div title=\"addnewclient\" id=\"tutid\"></div>\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"\">\n            <form id=\"frmaddclient\" name=\"\" method=\"post\">\n                <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n                ";
echo generate_token("form");
echo "\n                <h2 class=\"mb-3 mt-1\">\n                    <span class=\"groupstabesheadertext\">Create Bulk Client</span>\n                </h2>\n\n\n                <table class=\"form\">\n                    <tr>\n                        <td>\n                    <div>\n\n                        <div>\n                            <div  class=\"form-row m-0 p-0\">\n                                <div style=\"width: 200px\" class=\"mr-3\">\n                                    <label>";
echo $LNG["username"];
echo " ";
echo $LNG["prefix"];
echo "</label>\n                                    <input type=\"text\" name=\"userprefix\" class=\"form-control\" id=\"prefix\" size=\"8\" />\n                                </div>\n\n                                <div  style=\"width: 200px\" class=\"mr-3\">\n                                    <label>No. Of User</label>\n                                    <input type=\"text\" name=\"noofuser\" class=\"form-control\" id=\"nouser\" size=\"5\" />\n                                </div>\n\n                                <div class=\"mt-4\">\n                                    <div>\n                                        <button type=\"button\" name=\"genera\" class=\"btn\"  onclick=\"generate();\" value=\"Generate\">Generate<button>\n                                    </div>\n                                </div>\n\n                            </div>\n                        </div>\n\n                    <div>\n                        <div class=\"p-3\">\n                            <strong>OR</strong>\n                        </div>\n                    </div>\n\n                        <div class=\"form-row m-0 p-0\">\n\n                            <div  style=\"width: 200px\" class=\"mr-3\">\n                                <label>";
echo $LNG["username"];
echo " </label>\n                                <textarea cols=\"40\" name=\"bulkuser\" class=\"form-control\" id=\"bulkuser\" rows=\"5\"></textarea>\n                            </div>\n\n                            <div  style=\"width: 200px\" class=\"mr-3\">\n                                <label>";
echo $LNG["password"];
echo " </label>\n                                <textarea cols=\"40\" name=\"bulkpassword\"  class=\"form-control\" id=\"bulkpass\" rows=\"5\"></textarea>\n                            </div>\n\n                            <div  style=\"width: 200px\" class=\"mr-3\">\n                                <label>";
echo $LNG["email"];
echo " </label>\n                                <textarea cols=\"40\" name=\"bulkemail\" id=\"bulkemail\" class=\"form-control\"  rows=\"5\"></textarea>\n                            </div>\n\n                        </div>\n\n                    </div>\n                        </td>\n                    </tr>\n                </table>\n\n                <hr/>\n\n                    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                        <tbody>\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["creditbalance"];
echo " </td>\n                        <td class=\"fieldarea\"><input name=\"creditleft\"  value=\"0\"  type=\"text\"  class=\"txt small\"\n                                                     onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n\n\n                            <select name=\"currency\">\n                                ";
$query = "SELECT * FROM `tbl_currencies`";
$result = dquery($query);
while ($noticia = mysqli_fetch_assoc($result)) {
    echo "                                    <option value=\"";
    echo $noticia["id"];
    echo "\" ";
    if ($config["base_currency"] == $noticia["code"]) {
        echo "selected";
    }
    echo " >";
    echo $noticia["code"];
    echo "</option>\n                                ";
}
echo "                            </select>\n                            &nbsp;&nbsp;&nbsp;\n                           <!-- <span><input type=\"checkbox\" id=\"geninvoice\" name=\"geninvoice\"\n                                         checked=\"checked\"/><label for=\"geninvoice\"></label></span>\n\n                            <span><input type=\"checkbox\" id=\"invpaid\" name=\"invpaid\" /><label for=\"invpaid\"></label></span>\n\n-->\n\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["usertype"];
echo "</td>\n                        <td class=\"fieldarea\">\n                            <span><input type=\"radio\" id=\"user\" name=\"type\" value=\"0\" checked=\"checked\"/><label for=\"user\">";
echo $LNG["user"];
echo "</label></span>\n                            <span><input type=\"radio\" id=\"reseller\" name=\"type\" value=\"1\" /><label for=\"reseller\">";
echo $LNG["reseller"];
echo "</label></span>\n                            &nbsp;&nbsp;&nbsp;\n                            <input  type=\"checkbox\" name=\"allowtransfer\" value=\"1\" id=\"allowtransfer\"/><label for=\"allowtransfer\">";
echo $LNG["allowtransfer"];
echo "</label>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n                        <td class=\"fieldarea\">\n                            <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"0\" checked=\"checked\"/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n                            <span><input type=\"radio\" name=\"status\" id=\"blocked\" value=\"1\" /><label for=\"blocked\">";
echo $LNG["blocked"];
echo "</label></span>\n                            <span><input type=\"radio\" name=\"status\" id=\"inactive\" value=\"2\" /><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></span>\n                        </td>\n                    </tr>\n\n                    ";
if (!$OnlyEcommerce) {
    echo "                        <tr>\n                            <td class=\"fieldlabel\">";
    echo $LNG["servicesaccess"];
    echo "</td>\n                            <td class=\"fieldarea\">\n                                ";
    $services = explode(",", $config["default_service"]);
    echo "                                ";
    if ($IsFileOnly) {
        echo "                                    <span><input type=\"checkbox\" name=\"fileaccess\" id=\"file\" value=\"1\" ";
        if ($config["default_service_file"]) {
            echo "checked";
        }
        echo "/><label for=\"file\">";
        echo $LNG["file"];
        echo "</label></span>\n                                    ";
    } else {
        echo "                                    <span><input type=\"checkbox\" name=\"imeiaccess\" id=\"imei\" value=\"1\" ";
        if ($config["default_service_imei"]) {
            echo "checked";
        }
        echo " /><label for=\"imei\">";
        echo $LNG["imei"];
        echo "</label></span>\n                                    <span><input type=\"checkbox\" name=\"fileaccess\" id=\"file\" value=\"1\" ";
        if ($config["default_service_file"]) {
            echo "checked";
        }
        echo "/><label for=\"file\">";
        echo $LNG["file"];
        echo "</label></span>\n                                    <span><input type=\"checkbox\" name=\"serveraccess\" id=\"server\" value=\"1\" ";
        if ($config["default_service_server"]) {
            echo "checked";
        }
        echo "/><label for=\"server\">";
        echo $LNG["server"];
        echo "</label></span>\n                                    <span><input type=\"checkbox\" name=\"remoteaccess\" id=\"remote\" value=\"1\" ";
        if ($config["default_service_remote"]) {
            echo "checked";
        }
        echo "/><label for=\"remote\">";
        echo $LNG["remote"];
        echo "</label></span>\n                                    ";
    }
    echo "\n                            </td>\n                        </tr>\n                    ";
}
echo "\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["clientgroup"];
echo "</td>\n                        <td class=\"fieldarea\">\n                            <select name=\"clientgroup\">\n                                <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n                                ";
$sql = dquery("select * from tbl_client_group where fee='' \norder by displayorder asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($row["id"] == $clientDetails["client_group"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo "                            </select>\n                        </td>\n                    </tr>\n\n\n\n                    ";
if ($custom && $val["required"]) {
    echo "\n                        <tr>\n                            <td class=\"fieldlabel\" colspan=\"2\"><strong>";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["field"];
    echo "</strong></td>\n                        </tr>\n                        ";
    foreach ($custom as $val) {
        if ($val["required"]) {
            echo "                            <tr><td class=\"fieldlabel\">";
            echo $val["name"];
            echo "</td><td class=\"fieldarea\"><span>";
            echo $val["input"];
            echo "</span></td></tr>\n                        ";
        }
    }
    echo "                        ";
}
echo "\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td>\n                        <td class=\"fieldarea\">";
echo getLanguageDropdown2();
echo "</td>\n\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["theme"];
echo "</td>\n                        <td class=\"fieldarea\">\n                            ";
echo getTemplatesDropDown();
echo "</td>\n                    </tr>\n\n\n\n                    </tbody></table>\n\n                <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddclient\"\nclass=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddclient','addbulkclient','#frmaddclient','#notification','true','#main_loader');\"/></p>\n            </form>\n        </div>\n        <div class=\"clear\"></div>\n    </div>\n</div></div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Clients---Suppliers/?aid=29&pid=1&cid=5#add-bulk-client\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>