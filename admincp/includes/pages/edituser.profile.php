<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction genpass(){\n    var answer = confirm('";
echo $LNG["areyousuretoresetpassword"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnedituserpass','edituser.sendpasswordmail','#frmedituser','#notification','true','#main_loader');\n    }\n}\nfunction checkAll()\n{\n     \$('.gateways').prop('checked', true);\n}\nfunction uncheckAll()\n{\n      \$('.gateways').prop('checked', false);\n}\nfunction showPaypal(ob){\n    if(ob.checked){\n       \$(\"#paypalacc\").show();\n    }else{\n       \$(\"#paypalacc\").hide();\n    }\n}\n\$( document ).ready(function() {\n\n    \$( \"#grs\" ).click(function() {\n      if(\$(\"#usecustomgateway\").is(\":checked\")){\n         \$(\"#paymentgat\").show();\n      }else{\n         \$(\"#paymentgat\").hide();\n      }\n    });\n});\n\nfunction paymentGat(ob)\n{\n    if(ob.checked)\n    {\n        \$(\"#paymentgat\").show();\n    }else{\n        \$(\"#paymentgat\").hide();\n    }\n}\nfunction changeGroupPrice(val){\n    \$(\".clientgroupmsg\").html(\"If you change group client discount reset for all services\");\n    if(val==0){\n        \$(\"#cprice\").html('');\n        \$(\"#otherdet\").hide();\n    }else{\n          \$.post(\"includes/pages/getclientgroupprice.php?client=";
echo $id;
echo "&gid=\"+val,function(data,status){\n                if(data){\n                    \$(\"#grpd\").css('display','inline');\n                }else{\n                    \$(\"#grpd\").hide();\n                }\n                \$(\"#cprice\").html(data);\n          });\n          \$(\"#otherdet\").show();\n    }\n}\nfunction setPaidto(ob){\n    if(ob.checked){\n        \$(\"#paidshow\").show();\n    }else{\n        \$(\"#paidshow\").hide();\n    }\n}\n</script>\n\n";
$pageid = 220;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
$custom = getCustomFields("regis", "", $id);
$exp = explode(",", $_SESSION["page_access"]);
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["verified"];
echo "\" name=\"verified\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["phonenumber"];
echo "\" name=\"phonenumber\"/>\n";
echo generate_token("form");
echo "\n<div>\n<div  class=\"groupstabes\" style=\"border-bottom:none\">\n\n <div class=\"groupstabescontant\">\n\n<div style=\"display:";
if ($p == "personal") {
    echo "block";
} else {
    echo "none";
}
echo "\">\n\n <h2>\n<span class=\"groupstabesheadertext\">Personal Information</span>\n</h2>\n\n<table class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\"><label>";
echo $clientDetails["username"];
echo "</label>\n    <input type=\"hidden\" name=\"username\" value=\"";
echo $clientDetails["username"];
echo "\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"password\" id=\"password\" value=\"\" type=\"text\" autocomplete=\"off\"   class=\"txt\" style=\"width: 100px;\"/> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["resetpass"];
echo "\" name=\"resetpass\" id=\"btnedituserpass\" onclick=\"genpass();\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">Name</td>\n    <td class=\"fieldarea\"><input name=\"firstname\" placeholder=\"";
echo $LNG["firstname"];
echo "\" value=\"";
echo $clientDetails["firstname"];
echo "\" type=\"text\"  class=\"txt medium\"/> <input name=\"lastname\"  placeholder=\"Last Name\" value=\"";
echo $clientDetails["lastname"];
echo "\" type=\"text\"  class=\"txt medium\"/> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["registeredemail"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"";
echo $clientDetails["email"];
echo "\" type=\"text\"  class=\"txt medium\" onblur=\"checkEmail(this.value)\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["company"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"company\"  value=\"";
echo $clientDetails["companyname"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo " line 1</td>\n    <td class=\"fieldarea\"><textarea name=\"address\">";
echo $clientDetails["address1"];
echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo " line 2</td>\n    <td class=\"fieldarea\"><textarea name=\"address2\">";
echo $clientDetails["address2"];
echo "</textarea></td>\n</tr>\n<tr>\n\t<td class=\"fieldlabel\"></td>\n\t<td class=\"fieldarea\">\n        <input name=\"state\"  placeholder=\"";
echo $LNG["state"];
echo "\" value=\"";
echo $clientDetails["state"];
echo "\" type=\"text\"  class=\"txt medium\"/>\n        <input name=\"city\" placeholder=\"";
echo $LNG["city"];
echo "\"  value=\"";
echo $clientDetails["city"];
echo "\" type=\"text\"  class=\"txt medium\"/>\n        <input name=\"zip\" placeholder=\"";
echo $LNG["zip"];
echo "\"  value=\"";
echo $clientDetails["zip"];
echo "\" type=\"text\"  class=\"txt medium\"/>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown($clientDetails["country"]);
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phonenumber"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input style=\"float:  left;margin-right:20px\" name=\"phonenumber\"\n    value=\"";
echo $clientDetails["phonenumber"];
echo "\"\n    type=\"text\"  class=\"txt medium\"/>  <span><input type=\"checkbox\"\n    class=\"onoff {labelOn: 'Verified', labelOff: 'Unverified'}\"\n         id=\"verifeds\" name=\"verifiedm\" value=\"1\" ";
if ($clientDetails["verified"] == "1") {
    echo "checked";
}
echo "/><label for=\"verifeds\"></label></span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getLanguageDropdown2($clientDetails["language"]);
echo "</td>\n</td>\n</tr>\n <tr>\n <td  class=\"fieldlabel\">";
echo $LNG["send"];
echo "  ";
echo $LNG["profile"];
echo " ";
echo $LNG["email"];
echo "</td>\n <td  class=\"fieldarea\">\n <select name=\"profilemail2\" class=\"chosen\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='general' or type='other' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "<optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n";
    $s = dquery("select id,name,type from tbl_emailtemplates WHERE type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "<option  style=\"background-color: #FFF;\" value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n";
    }
    echo " </optgroup>\n";
}
echo " </select>\n <input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" class=\"addFromgallery\"\n id=\"btnpmail\"  onclick=\"SubmitForm ('#btnpmail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n    </td>\n </tr>\n";
if ($custom) {
    echo "    <tr>\n        <td class=\"fieldlabel\" colspan=\"2\"><div class=\"groupstabes \" style=\"padding: 0\"><h2> <span> ";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["field"];
    echo "s </span> </h2></div> </td>\n    </tr>\n        ";
    foreach ($custom as $val) {
        echo "            <tr><td class=\"fieldlabel\">";
        echo $val["name"];
        echo "</td><td class=\"fieldarea\"><span>";
        echo $val["input"];
        echo "</span></td></tr>\n        ";
    }
}
echo "\n\n</tbody>\n</table>\n</div>\n\n\n<div style=\"display:";
if ($p == "account") {
    echo "block";
} else {
    echo "none";
}
echo "\">\n\n <h2>\n<span class=\"groupstabesheadertext\">Account Information</span>\n</h2>\n\n<table  border=\"0\" class=\"form\" width=\"100%\" style=\"float: left;\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"0\" ";
if ($clientDetails["userstatus"] == "0") {
    echo "checked";
}
echo "/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span> &nbsp;&nbsp;&nbsp;\n    <span><input type=\"radio\" name=\"status\" id=\"inactive\" value=\"2\" ";
if ($clientDetails["userstatus"] == "2") {
    echo "checked";
}
echo "/><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></span> &nbsp;&nbsp;&nbsp;\n    <span><input type=\"radio\" name=\"status\"  id=\"blocked\" value=\"1\" ";
if ($clientDetails["userstatus"] == "1") {
    echo "checked";
}
echo "/><label for=\"blocked\">";
echo $LNG["blocked"];
echo " </label></span>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">\n        ";
echo $LNG["allowed"];
echo "     ";
echo $LNG["services"];
echo "    </td>\n    <td  class=\"fieldarea\">\n\n        <label><input type=\"checkbox\" name=\"imeiservices\" value=\"1\" ";
if ($clientDetails["access"]["imeiservice"]) {
    echo "checked";
}
echo " />IMEI </label>\n        &nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"fileservices\" value=\"1\" ";
if ($clientDetails["access"]["fileservice"]) {
    echo "checked";
}
echo " />File </label>\n        &nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"serverservices\" value=\"1\" ";
if ($clientDetails["access"]["serverlogservice"]) {
    echo "checked";
}
echo " />Server </label>\n\n        <label><input type=\"checkbox\" name=\"remoteservices\" value=\"1\" ";
if ($clientDetails["access"]["remoteservice"]) {
    echo "checked";
}
echo " />Remote </label>\n    </td>\n</tr>\n";
$dc = mysqli_fetch_assoc(dquery("select id,status from tbl_document where uid='" . $clientDetails["id"] . "'"));
echo "<tr>\n    <td class=\"fieldlabel\">ID/KYC</td>\n    <td class=\"fieldarea\">\n<span><input type=\"checkbox\" class=\"onoff {labelOn: 'Verified', labelOff: 'Pending'}\" id=\"shopperes\" name=\"idverification\" value=\"1\" ";
if ($clientDetails["idverification"] == "1") {
    echo "checked";
}
echo "/><label for=\"shopperes\"></label></span>\n\n        ";
echo !$dc["id"] ? "Not Submitted" : "<a  href=\"javascript:load_fromsubpage('document.detail&id=" . $dc["id"] . "','KYC/" . $clientDetails["username"] . "')\"><span class='textred'>" . ($dc["status"] == 2 ? "Rejected" : ($dc["status"] == 1 ? "<span style=\"color:#779500;\">Completed</span>" : "<span style='color: #9B410E;'>Pending Verification</span>")) . "</a>";
echo "    </td>\n</tr>\n\n<script>\n\$('#blocked').click(function() {\n    \$('#showblock').show();\n});\n\$('#active').click(function() {\n    \$('#showblock').hide();\n});\n\$('#inactive').click(function() {\n    \$('#showblock').hide();\n});\n</script>\n<tr id=\"showblock\" style=\"display:";
if ($clientDetails["userstatus"] != "1") {
    echo "none";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["bloack"];
echo " ";
echo $LNG["reason"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"block_reason\">";
echo $clientDetails["block_reason"];
echo "</textarea>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["theme"];
echo "</td>\n    <td class=\"fieldarea\">\n   ";
echo getTemplatesDropDown($clientDetails["template"], "template", false, false);
echo "</td>\n</tr>\n\n";
if (!isset($OnlyEcommerce)) {
    echo "<tr>\n    <td class=\"fieldlabel\"> User Type\n\n    </td>\n    <td class=\"fieldarea\">\n   ";
    $rcnt = mysqli_num_rows(dquery("select id from \n   tblUsers where reseller_id='" . $clientDetails["id"] . "'"));
    if ($clientDetails["usertype"] == "0") {
        echo "   <span><input type=\"radio\" id=\"user\" checked=\"checked\"\n    name=\"type\" value=\"0\"/><label for=\"user\">\n    User</label></span>\n";
    }
    echo "   ";
    if ($clientDetails["usertype"] == "0" || $clientDetails["usertype"] == "1") {
        echo "    <span><input type=\"radio\" id=\"reseller\" ";
        if ($clientDetails["usertype"] == "1") {
            echo "checked=checked";
        }
        echo " name=\"type\" value=\"1\"/><label for=\"reseller\">";
        echo $LNG["advance"];
        echo " ";
        echo $LNG["reseller"];
        echo "</label></span>\n        ";
        if (!mysqli_num_rows(dquery("select id from tblUsers\n          where reseller_id='" . $clientDetails["id"] . "'")) && $clientDetails["usertype"] == "1") {
            echo "            <span><input type=\"radio\" id=\"users\" ";
            if ($clientDetails["usertype"] == "0") {
                echo "checked=checked";
            }
            echo " name=\"type\" value=\"0\"/><label for=\"users\">";
            echo $LNG["user"];
            echo "</label></span>\n            ";
        }
        echo "   ";
    }
    echo "\n ";
    if ($clientDetails["usertype"] == "3") {
        echo "    <span><input type=\"radio\" id=\"resuser\" name=\"type\" checked=\"checked\" value=\"3\"/><label for=\"resuser\">";
        echo $LNG["reseller"];
        echo " ";
        echo $LNG["user"];
        echo "</label></span>\n";
    }
    echo "  ";
    if ($clientDetails["usertype"] != "3") {
        echo "    <br />\n    <script>\n    function shower(ob){\n        if(ob.checked){\n            document.getElementById('donot').style.display='';\n        }else{\n            document.getElementById('donot').style.display='none';\n        }\n    }\n    </script>\n   </td></tr>\n\n   <tr><td class=\"fieldlabel\"> Transfer Credit</td>\n    <td class=\"fieldarea\">\n     <input  type=\"checkbox\" name=\"allowtransfer\" value=\"1\" onclick=\"shower(this)\" id=\"allowtransfer\" ";
        if ($clientDetails["access"]["credit_transfer"] == "1") {
            echo "checked";
        }
        echo "/><label for=\"allowtransfer\">Allow</label>   <br>\n     <span id=\"donot\" ";
        if ($clientDetails["access"]["credit_transfer"] != "1") {
            echo "style='display:none';";
        }
        echo " ><br />\n        <input  type=\"checkbox\" name=\"notdiscounteduser\" value=\"1\" id=\"donotdiscount\" ";
        if ($clientDetails["access"]["notdiscounteduser"] == "1") {
            echo "checked";
        }
        echo "/><label for=\"donotdiscount\">";
        echo $LNG["donotdiscounted"];
        echo "</label>\n       <br /> </span>\n     ";
    }
    echo "     </td>\n   </tr>\n    ";
    if (licince\reqaddon("Wallet merchant", true)) {
        echo "\n     <tr>\n         <td class=\"fieldlabel\">";
        echo $LNG["transfer"];
        echo "  ";
        echo $LNG["fee"];
        echo "</td>\n         <td class=\"fieldarea\">\n             <input type=\"text\" name=\"walletfee\" class=\"\"\n                    value=\"";
        echo $clientDetails["transferfee"];
        echo "\"\n                    style=\"size: 10px !important;\" /> %\n         </td>\n     </tr>\n\n     ";
    }
}
echo "<tr><td class=\"fieldlabel\"> ";
echo $LNG["fraudprotection"];
echo " </td>\n    <td class=\"fieldarea\">\n <input type='checkbox' name='fraud_protection' id='ed' value='1' ";
if ($clientDetails["fraud_protection"]) {
    echo "checked='checked'";
}
echo " />\n <label for=\"ed\"> ";
echo $LNG["enable"];
echo "   ";
echo $LNG["for"];
echo "  ";
echo $LNG["automaticaly"];
echo "  ";
echo $LNG["addfund"];
echo "</label>\n    </td>\n</tr>\n";
if (!$OnlyEcommerce && $config["reseller_can_setup_store"] && $clientDetails["usertype"] == "1") {
    echo " <tr>\n    <td class=\"fieldlabel\">Partner Site</td>\n    <td class=\"fieldarea\">\n<span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"shoppere\" name=\"shopper\" value=\"1\" ";
    if ($clientDetails["reseller_can_setupstore"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"shoppere\"></label></span>\n     <small> User can set up partner site</small>\n    </td>\n</tr>\n ";
}
echo "\n\n ";
if ($clientDetails["usertype"] != 3) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["rechargevoucher"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"rechargee\" name=\"recharge\" value=\"1\" ";
    if (!$clientDetails["rechargeblock"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"rechargee\"></label></span>\n    <small>User use recharge voucher for refill his account</small>\n    </td>\n</tr>\n\n<!--\n";
    if (!$OnlyEcommerce) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["servicesaccess"];
        echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" name=\"imeiaccess\" id=\"imei\" value=\"1\" ";
        if ($clientDetails["access"]["imeiservice"]) {
            echo "checked=checked";
        }
        echo "/><label for=\"imei\">";
        echo $LNG["imei"];
        echo "</label></span>\n    <span><input type=\"checkbox\" name=\"fileaccess\" id=\"file\" value=\"1\" ";
        if ($clientDetails["access"]["fileservice"]) {
            echo "checked=checked";
        }
        echo "/><label for=\"file\">";
        echo $LNG["file"];
        echo "</label></span>\n    <span><input type=\"checkbox\" name=\"serveraccess\" id=\"server\" value=\"1\" ";
        if ($clientDetails["access"]["serverlogservice"]) {
            echo "checked=checked";
        }
        echo "/><label for=\"server\">";
        echo $LNG["server"];
        echo "</label></span>\n     </td>\n</tr>\n";
    }
    echo "-->\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["affiliate"];
    echo "</td>\n    <td class=\"fieldarea\">\n\t   <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"affiliate\" name=\"affiliate\" value=\"1\" ";
    if ($clientDetails["affiliate"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"affiliate\"></label></span>\n     </td>\n</tr>\n";
    if (!$OnlyEcommerce) {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["customize"];
        echo " ";
        echo $LNG["email"];
        echo "</td>\n    <td class=\"fieldarea\">\n\t   <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"cse\" name=\"customize_email\"\n       value=\"1\" ";
        if ($clientDetails["customize_email"] == "1") {
            echo "checked";
        }
        echo "/><label for=\"cse\"></label></span>\n     <small>Note:[";
        echo $LNG["recommended"];
        echo "] Client can customize order reply and success mail</small></span>\n     </td>\n</tr>\n ";
    }
}
echo "\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["newsletter"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"newsactive\" name=\"newsletter\" value=\"1\" ";
if ($clientDetails["access"]["news_letter"] == "1") {
    echo "checked";
}
echo "/><label for=\"newsactive\"></label></span>\n    </td>\n</tr>\n\n";
if (!$OnlyEcommerce) {
    if ($clientDetails["usertype"] != 3) {
        echo "<tr>\n    <td class=\"fieldlabel\"> ";
        echo $LNG["clientgroup"];
        echo " </td>\n    <td class=\"fieldarea\" >\n          <select name=\"clientgroup\" onchange=\"changeGroupPrice(this.value);\">\n           <option value=\"0\">";
        echo $LNG["default"];
        echo "</option>\n           ";
        $sql = dquery("select * from tbl_client_group");
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
        echo "           </select>  &nbsp; <a href=\"#\" data-target=\"clientgroup\" data-target-header=\"";
        echo $LNG["add"];
        echo " ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["group"];
        echo "\" onclick=\"AddnewInpopup(this);\">";
        echo $LNG["add"];
        echo " ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["group"];
        echo "</a>\n        <span class=\"clientgroupmsg\" style=\"color: red;  \"></span>\n ";
        $flag = false;
        if ($clientDetails["client_group"] != 0) {
            $gr = mysqli_fetch_assoc(dquery("select fee from tbl_client_group where id='" . $clientDetails["client_group"] . "'"));
            if (0 < $gr["fee"]) {
                $flag = true;
            }
        }
        echo " <div style=\" ";
        if ($flag) {
            echo "display: inline;";
        } else {
            echo "display:none;";
        }
        echo "\" id=\"grpd\">\n     <span id=\"cprice\" style=\"\">Price:\n";
        if ($clientDetails["currency"]["id"] == $_SESSION["system_default_currency"]["id"]) {
            $code = $_SESSION["system_default_currency"]["code"];
            $price = mysqli_fetch_assoc(dquery("select fee from tbl_client_group \n            where id='" . $clientDetails["client_group"] . "'"));
        } else {
            $price["fee"] = getClientGroupPrice($clientDetails["id"], $clientDetails["client_group"]);
            $code = $clientDetails["currency"]["code"];
        }
        echo $price["fee"] . " " . $code;
        if ($clientDetails["group_start"]) {
            echo "&nbsp;&nbsp; Start Date:" . $clientDetails["group_start"];
            echo " &nbsp; End Date:" . ($clientDetails["group_end"] ? $clientDetails["group_end"] : " -");
        }
        echo "</span>\n         <br />\n         <br />\n     <div id=\"otherdet\">\n<input type=\"checkbox\" name=\"geninvoicegroup\" value=\"1\" id=\"geni\" /> <label for=\"geni\">";
        echo $LNG["geninvoice"];
        echo "</label>\n<input type=\"checkbox\" name=\"paidgroup\" onclick=\"setPaidto(this)\" value=\"1\" id=\"padi\" />\n<label for=\"padi\">";
        echo $LNG["paid"];
        echo "</label>\n    </div>\n </div>\n <div id=\"paidshow\" style=\"display: none; left: 1px;\">\n    Payment Option:\n    <select name=\"payoption\">\n        <option value=\"1\">From Credit</option>\n        <option value=\"2\">For Information</option>\n    </select>\n    </div>\n    </td>\n</tr>\n ";
    }
    if ($clientDetails["credit"]["credit"] == "0" && $clientDetails["credit"]["used"] == "0") {
        echo "<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["currency"];
        echo "</td>\n    <td class=\"fieldarea\">\n<select name=\"currency\">\n    ";
        $query = "SELECT * FROM `tbl_currencies`";
        $result = dquery($query);
        while ($noticia = mysqli_fetch_assoc($result)) {
            echo "<option value=\"";
            echo $noticia["id"];
            echo "\" ";
            if ($clientDetails["currency"]["id"] == $noticia["id"]) {
                echo "selected=selected";
            }
            echo ">";
            echo $noticia["code"];
            echo "</option>\n";
        }
        echo "</select></td>\n</tr>\n";
    }
    echo "<input type=\"hidden\" name=\"clientcurrency\" value=\"";
    echo $clientDetails["currency"]["id"];
    echo "\" />\n";
}
echo "<tr>\n <td  class=\"fieldlabel\">";
echo $LNG["send"];
echo "  ";
echo $LNG["profile"];
echo " ";
echo $LNG["email"];
echo "</td>\n <td  class=\"fieldarea\">\n <select name=\"profilemail\" class=\"chosen\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='general' or type='other' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "<optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n";
    $s = dquery("select id,name,type from tbl_emailtemplates WHERE type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "<option  style=\"background-color: #FFF;\" value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n";
    }
    echo " </optgroup>\n";
}
echo " </select>\n <input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" class=\"addFromgallery\"\n id=\"btnpmail\"  onclick=\"SubmitForm ('#btnpmail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n    </td>\n </tr>\n\n</table>\n\n<div>\n    <table class=\"form\">\n        <tr  >\n            <td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["minimum"];
echo " ";
echo $LNG["limit"];
echo "</td>\n            <td class=\"fieldarea\">\n                <input type=\"text\" class=\"small\"\n                       value=\"";
echo $clientDetails["minaddfund"];
echo "\" name=\"minaddfund\" />\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["maximum"];
echo " ";
echo $LNG["limit"];
echo "</td>\n            <td class=\"fieldarea\">\n                <input type=\"text\" class=\"small\"\n                       value=\"";
echo $clientDetails["maxaddfund"];
echo "\" name=\"maxaddfund\" />\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">\n                Allow Payer emails\n            </td>\n            <td class=\"fieldarea\">\n                <textarea name=\"paypalaccount\" rows=\"4\" cols=\"20\" >";
if ($clientDetails["paypalaccount"]) {
    $acc = json_decode($clientDetails["paypalaccount"], true);
    foreach ($acc as $s) {
        echo $s . "\n";
    }
}
echo "</textarea>\n                <span>";
if (!$config["paypalemailautopay"]) {
    echo "You need to on 'Paypal from email required to Invoice autopay\n' from General Settings->Fraud Protection to use this features.";
}
echo "Each email on new line</span>\n            </td>\n\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">\n                ";
echo $LNG["use"];
echo "  ";
echo $LNG["custom"];
echo " ";
echo $LNG["payment"];
echo " ";
echo $LNG["gateway"];
echo "            </td>\n            <td  class=\"fieldarea\">\n                <span id=\"grs\"><input type=\"checkbox\"\n                ";
if ($clientDetails["customgateway"]) {
    echo "checked";
}
echo "                                      onclick=\"javascript: paymentGat(this);\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"usecustomgateway\" name=\"usecustomgateway\" value=\"1\" /><label for=\"newsactive\"></label></span>\n            </td>\n        </tr>\n        <tr>\n            <td class=\"fieldlabel\">\n\n            </td>\n            <td class=\"fieldarea\">\n                <lable>\n                    <input type=\"checkbox\" ";
if ($clientDetails["otpfordirect"]) {
    echo "checked";
}
echo " name=\"otpfordirect\" value=\"1\" />\n                    OTP ";
echo $LNG["not"];
echo " ";
echo $LNG["required"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["direct"];
echo " PayPal ";
echo $LNG["transaction"];
echo "</lable>\n            </td>\n        </tr>\n        <tr id=\"paymentgat\" style=\"";
if (!$clientDetails["customgateway"]) {
    echo "display:none;";
}
echo "\">\n             <td class=\"fieldarea\" colspan=\"2\">\n             <label>\n          <a href=\"javascript: checkAll();\">Check All</a>/<a href=\"javascript: uncheckAll();\">Uncheck All</a>\n             </label>\n            ";
$gq = dquery("select * from tbl_paymentgateways where setting='name'\n                group by gateway");
while ($rg = mysqli_fetch_assoc($gq)) {
    $selected = "";
    if (mysqli_num_rows(dquery("select  id from tbl_user_gateway \n                    where userid='" . $id . "' and payment='" . $rg["gateway"] . "'"))) {
        if ($rg["value"] == "PayPal") {
            echo "                            <script>\n                                \$('#paypalacc').show();\n                            </script>\n                            ";
        }
        $selected = "checked='checked'";
    }
    echo "                    <label style=\"display: block;\"><input class=\"gateways\"\n                    ";
    if ($rg["value"] == "PayPal") {
        echo "                         onclick=\"showPaypal(this)\"\n                         ";
    }
    echo "                    type=\"checkbox\" ";
    echo $selected;
    echo "                    name=\"gateway[";
    echo $rg["gateway"];
    echo "]\" style=\"vertical-align: middle;\" />";
    echo $rg["value"];
    echo "</label>\n                    ";
}
echo "            </td>\n        </tr>\n\n    </table>\n</div>\n\n</div>\n</div>\n</div> </div>\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituserprofile','#frmedituser','#notification','true','#main_loader');\"/>\n";
if ($clientDetails["sndlogin"]) {
    echo "<input type=\"button\" class=\"button_remove\" style=\"float: right;\" name=\"disableotp\"\nvalue=\"";
    echo $LNG["disable"];
    echo " OTP\" id=\"diotp\"\nonclick=\"SubmitForm ('#diotp','edituser.otp','#frmedituser','#notification','true','#main_loader'); \$('#diotp').hide();\" />\n";
}
echo "<input type=\"button\" class=\"button_remove\"  style=\"float: right;\" name=\"ccinfo\"\nvalue=\"";
echo $LNG["remove"];
echo " Credit Card\" id=\"btncc\"\nonclick=\"SubmitForm ('#btncc','edituser.removecc','#frmedituser','#notification','true','#main_loader');\" />\n";
if (in_array(55, $exp)) {
    echo "<input type=\"button\" class=\"button_remove\"  style=\"float: right;\" name=\"note\" value=\"";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo "\" id=\"btnclose\"\nonclick=\"load_subpage('main2.php?page=edituser.closeaccount&id=";
    echo $id;
    echo "','";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo " : <strong>";
    echo $clientDetails["username"];
    echo "</strong>')\" />\n";
}
echo "</p>\n</div>\n<div class=\"clear\"></div>\n</form>\n\n</div>\n</div>\n ";
$fileverioncheck = "6.1.0";

?>