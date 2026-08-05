<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 90;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/fileservices.fun.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$md5id = md5($id);
$row = getOrdersFile("", "", "", $md5id);
$clientDetails = getClientsDetails($row[$md5id]["allfield"]["user_id"]);
$replyt = mysqli_fetch_assoc(dquery("select (select reply_type from tbl_services_file where id=service_id)\n  as repli,reply from tbl_order_file where order_id='" . $id . "'"));
$usercurr = mysqli_fetch_assoc(dquery("select code from tbl_currencies where \nid='" . $clientDetails["currency_id"] . "'"));
$diff = time() - $clientDetails["credit"]["date"];
$days = round($diff / 86400);
if ($clientDetails["credit"]["validity"] != 0) {
    if ($days < $clientDetails["credit"]["validity"]) {
        $color = "#779500";
    } else {
        if ($clientDetails["credit"]["validity"] == $days) {
            $color = "#779500";
        } else {
            $color = "#c00";
        }
    }
}
if ($clientDetails["userstatus"] == "0") {
    $status = $LNG["active"];
    $color1 = "#779500";
} else {
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["blocked"];
        $color1 = "#c00";
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["inactive"];
            $color1 = "#c00";
        }
    }
}
if (is_file("../images/avtar/" . $row[$md5id]["allfield"]["user_id"] . "_avtar.jpg")) {
    $avatar = "../images/avtar/" . $row[$md5id]["allfield"]["user_id"] . "_avtar.jpg";
}
if ($replyt["repli"]) {
    echo "<script type=\"text/javascript\">\n      \$(\"document\").ready(function() {\n         setClickable();\n      });\n      function setClickable()\n      {\n          \$('span#editInPlace').click(function() {\n          var input = '<span><input id=\"fileToreplace\" type=\"file\" size=\"45\" name=\"fileToreplace\" class=\"input\" /> <input type=\"button\" name=\"replace\" value=\"";
    echo $LNG["update"];
    echo " \" onclick=\"ajaxFileUpload(\\'";
    echo $md5id;
    echo "\\',\\'fileToreplace\\',\\'edituser.editfileordersuccess\\',\\'#notification\\',\\'true\\',\\'#main_loader\\');\"/>';\n          var button     = '&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"cancel\" class=\"cancelButton\" /></span>';\n          var revert = \$(this).html();\n          \$(this).after(input+button).remove();\n         \t \$('.cancelButton').click(function(){saveChanges(this, revert);});\n          })\n      };\n      function saveChanges(obj, revert) {\n     \t \$(obj).parent().after('<span id=\"editInPlace\">'+revert+'</span>').remove();\n      }\n</script>\n";
} else {
    echo "<script type=\"text/javascript\">\n      \$(\"document\").ready(function() {\n       setClickable();\n      });\n      function setClickable() {\n          \$('span#editInPlace').click(function() {\n          var input = '<span><input id=\"fileToreplace\" type=\"text\" value=\"";
    echo $replyt["reply"];
    echo "\" size=\"45\" name=\"reply\" class=\"input\" /> <input type=\"button\" name=\"replace\" value=\"";
    echo $LNG["update"];
    echo " \" onclick=\"SubmitForm (\\'#btnedituser\\',\\'edituser.editfileorder\\',\\'#frmedituser\\',\\'#notification\\',\\'true\\',\\'#main_loader\\');\"/>';\n          var button     = '<input type=\"button\" value=\"cancel\" class=\"cancelButton\" /></span>';\n          var revert = \$(this).html();\n          \$(this).after(input+button).remove();\n         \t \$('.cancelButton').click(function(){saveChanges(this, revert);});\n          })\n      };\n      function saveChanges(obj, revert) {\n     \t \$(obj).parent().after('<span id=\"editInPlace\">'+revert+'</span>').remove();\n      }\n</script>\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" enctype=\"multipart/form-data\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["id"];
echo "\" name=\"uid\"/>\n<input type=\"hidden\" value=\"";
echo $md5id;
echo "\" name=\"md5id\"/>\n";
echo generate_token("form");
echo "\n\n\n\n\n ";
if ($row[$id]["reply_by"]["adminid"]) {
    $reply = $LNG["admin"];
    $replyBy = $row[$id]["reply_by"]["adminid"];
} else {
    if ($row[$id]["reply_by"]["supplierid"]) {
        $reply = $LNG["supplier"];
        $replyBy = $row[$id]["reply_by"]["adminid"];
    }
}
if ($row[$id]["reply_by"]["verfiedadminid"]) {
    $verify = $LNG["admin"];
    $verifyBy = $row[$id]["reply_by"]["verfiedadminid"];
} else {
    if ($row[$id]["reply_by"]["verfiedsupid"]) {
        $verify = $LNG["supplier"];
        $verifyBy = $row[$id]["reply_by"]["verfiedsupid"];
    }
}
echo "\n<div class=\"groupstabes\" style=\"float: left;border-right:#ddd solid 1px;padding-right:20px;margin-right: 20px;\">\n<h2>\n<span class=\"groupstabesheadertext\">";
echo $LNG["order"];
echo "   - ";
echo $id;
echo "    ";
if ($row[$id]["encnum"]) {
    echo "/ " . $row[$id]["encnum"];
}
if ($ar["ebay"]) {
    echo "[Direct Order]";
}
echo "    </span>\n </h2>\n\n\n\n  <span>  ";
echo $LNG["file"];
echo " :  ";
echo $row[$id]["file"];
echo "</span> <br />\n\n<span>\n";
echo $LNG["status"];
echo " :\n";
if ($row[$id]["user_can_c"] == 0) {
    echo $LNG["new"];
} else {
    if ($row[$id]["user_can_c"] == 1) {
        echo $LNG["accepted"];
    } else {
        if ($row[$id]["user_can_c"] == 3) {
            echo $LNG["cancel"];
        } else {
            if ($row[$id]["user_can_c"] == 4) {
                echo $LNG["replied"];
            }
        }
    }
}
if ($row[$id]["verified"] == "1" && $row[$md5id]["allfield"]["user_can_c"] == "4") {
    echo " | " . $LNG["waiting"] . " " . $LNG["for"] . " " . $LNG["verification"];
}
echo "</span><br />\n\n    <span>";
echo $LNG["servicename"];
echo " : ";
echo $row[$id]["service"];
echo " [";
echo $row[$md5id]["allfield"]["service_id"];
echo "]</span> <br />\n\n     <span>\n  ";
echo $LNG["credit"];
echo "  :\n";
$sids = $row[$md5id]["allfield"]["service_id"];
if ($ar["ebay"]) {
    $svs = mysqli_fetch_assoc(dquery("select retail_credit from tbl_services_file\n\t\t\twhere id='" . $sids . "'"));
    echo formatCurrency($svs["retail_credit"]);
} else {
    echo formatCurrency($row[$id]["service_details"]["credit"]);
}
echo "</span><br />\n";
if ($row[$id]["service_details"]["API"]) {
    echo "<span>\n";
    echo $LNG["apiinfo"];
    echo " : ";
    if ($row[$id]["service_details"]["API"]) {
        $apg = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\nwhere gateway='" . $row[$id]["service_details"]["API"] . "' \nand setting='name'"));
        $apg2 = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\nwhere gateway='" . $row[$id]["service_details"]["API"] . "' \nand setting='customname'"));
        echo $row[$id]["service_details"]["API"] . " (" . ($apg2["value"] ? $apg2["value"] : $apg["value"]) . ")";
    } else {
        echo "-";
    }
    echo "</span><br />\n\n";
}
echo "\n\n";
if ($row[$id]["service_details"]["API"]) {
    echo "<span>";
    echo $LNG["api"];
    echo " ";
    echo $LNG["reference"];
    echo " ";
    echo $LNG["id"];
    echo " :\n";
    if ($row[$id]["apilogreferenceid"]) {
        echo " <a onclick=\"javascript: redirectedit('apilog','";
        echo $row[$id]["apilogreferenceid"];
        echo "');\">";
        echo $row[$id]["apilogreferenceid"];
        echo "</a>\n ";
    }
    echo "</span><br />\n ";
}
echo "\n <span> ";
echo $LNG["order"];
echo " ";
echo $LNG["on"];
echo " : ";
echo formatDate($row[$md5id]["allfield"]["time"], "time", true);
echo " </span><br />\n<span> ";
echo $LNG["order"];
echo " ";
echo $LNG["ip"];
echo " : <a href=\"javascript: load_subpage('";
echo $config["ip_location"];
echo $row[$md5id]["allfield"]["ip"];
echo "','IP Location');\">";
echo $row[$md5id]["allfield"]["ip"];
echo "</a> </span> <br />\n<span> ";
echo $LNG["user"];
echo " ";
echo $LNG["cost"];
echo " : ";
echo $row[$id]["credit"] - $row[$id]["discount"] . " " . $usercurr["code"];
echo "</span> <br />\n<span>";
echo $LNG["reply"];
echo " ";
echo $LNG["time"];
echo " : ";
if ($row[$md5id]["allfield"]["reply_time"]) {
    echo formatDate(date("Y-m-d", $row[$md5id]["allfield"]["reply_time"])) . " " . date("h:i:s", $row[$md5id]["allfield"]["reply_time"]);
} else {
    echo "-";
}
echo "</span> <br />\n<span>";
echo $LNG["reply"];
echo " ";
echo $LNG["by"];
echo " : ";
echo $reply;
echo " [";
if ($replyBy) {
    echo "<a style=\"text-decoration: none !important;\" href=\"javascript:redirectedit('editadmin',";
    echo $replyBy;
    echo ")\">";
    echo $replyBy;
    echo "</a>";
} else {
    echo "-";
}
echo "]</span> <br />\n<span>";
echo $LNG["verified"];
echo " ";
echo $LNG["by"];
echo " : ";
echo $verify;
echo " [";
if ($verifyBy) {
    echo "<a style=\"text-decoration: none !important;\" href=\"javascript:redirectedit('editadmin',";
    echo $verifyBy;
    echo ")\">";
    echo $verifyBy;
    echo "</a>";
} else {
    echo "-";
}
echo "]</span>\n\n</div>\n\n\n<div  style=\"float:left;\">\n\n\n  <div class=\"groupstabes\" >\n\n<h2><span class=\"groupstabesheadertext\">Client info</span></h2>\n                    <div style=\"float:left;text-align: center;\">\n                        ";
if ($avatar) {
    echo "                                    <img src=\"";
    echo $avatar;
    echo "\" height=\"100\" style=\"border-radius: 50%;\"/>\n                                ";
} else {
    echo "                        <div style=\"text-transform: uppercase;font-size: 30px;padding:30px 0;background:rgb(63, 81, 181);color:white;border-radius:50%;width:100px;text-align: center;\">\n                            ";
    echo substr($clientDetails["username"], 0, 2);
    echo "                        </div>\n\n                        ";
}
echo "\n                    </div>\n\n                     <div style=\"float:left;margin-left:20px;padding-right:20px\">\n\n                        <span>\n                            <a href=\"javascript:load_fromsubpage('edituser&id=";
echo $clientDetails["id"];
echo "','";
echo $clientDetails["username"];
echo "');\">";
echo $clientDetails["username"];
echo "</a> [";
echo $row[$md5id]["allfield"]["user_id"];
echo "]\n                        </span>\n\n                        <div>\n                        ";
echo $clientDetails["firstname"] . " " . $clientDetails["lastname"];
echo "                        </div>\n\n\n<span>";
echo $LNG["creditleft"];
echo " : ";
echo $clientDetails["credit"]["credit"] . " " . $usercurr["code"];
echo "</span><br />\n<span>";
echo $LNG["creditused"];
echo " : ";
echo $clientDetails["credit"]["used"] . " " . $usercurr["code"];
echo "</span><br />\n<span>";
echo $LNG["credit"];
echo " ";
echo $LNG["expired"];
echo " :\n";
if ($clientDetails["credit_validity"] == "0") {
    echo "" . $LNG["neverexpired"] . "";
} else {
    $validity = $clientDetails["credit_validity"];
    $validity = date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit_date"]) . "+" . $validity . " day"));
    echo "" . formatDate($validity) . "";
}
echo "</span> <br />\n\n                         <span title=\"";
echo " - " . $clientDetails["block_reason"];
echo "\" style=\"color:";
echo $color1;
echo ";\">\n                            ";
echo $status;
echo "                         </span>\n\n                   </div>\n                   <div class=\"clear\"></div>\n                  </div>\n\n  <h2><span class=\"groupstabesheadertext\" style=\"padding: 0;\">Action</span></h2>\n\n\n\n<table class=\"form\">\n<tbody>\n<tr>\n\n<td>\n     <select name=\"fileordermail\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='fileorder' or type='other' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "  <optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n ";
    $s = dquery("select id,name,type from tbl_emailtemplates where type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "    <option style=\"background-color: #FFF;\"  value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n ";
    }
    echo "     </optgroup>\n";
}
echo " </select>\n\n<input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" id=\"btnpmail\"  class=\"addFromgallery\"\n onclick=\"SubmitForm ('#btnpmail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n\n</td></tr>\n\n<tr>\n<td style=\"padding-top: 3px;\">\n\n\n";
if ($row[$md5id]["allfield"]["user_can_c"] == "0" || $row[$md5id]["allfield"]["user_can_c"] == "1" || $row[$md5id]["allfield"]["user_can_c"] == "3") {
    echo " ";
    if ($replyt["repli"]) {
        echo "  <input id=\"fileToUpload\" type=\"file\" size=\"45\" name=\"fileToUpload\" class=\"input\" />\n  ";
    } else {
        echo "<input style=\"background: #f4f4f4;\" type=\"text\" placeholder=\"";
        if ($row[$md5id]["allfield"]["user_can_c"] == "4") {
            echo $LNG["reject"] . " " . $LNG["reason"];
        } else {
            echo $LNG["reply"];
        }
        echo "\" name=\"reply\" value=\"\"/>\n";
    }
}
echo "\n";
if ($row[$md5id]["allfield"]["user_can_c"] == "4") {
    echo " <input style=\"background: #f4f4f4;\" type=\"text\" placeholder=\"";
    if ($row[$md5id]["allfield"]["user_can_c"] == "4") {
        echo $LNG["reject"] . " " . $LNG["reason"];
    } else {
        echo $LNG["reply"];
    }
    echo "\" name=\"reply\" value=\"\"/>\n";
}
echo "\n";
if ($row[$md5id]["allfield"]["user_can_c"] == "0" || $row[$md5id]["allfield"]["user_can_c"] == "1") {
    echo "     ";
    if ($replyt["repli"]) {
        echo " <input value=\"";
        echo $LNG["reply"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsuccess\" id=\"btnsuccess\" class=\"btn btn-primary\" type=\"button\"  onclick=\"ajaxFileUpload('";
        echo $md5id;
        echo "','fileToUpload','edituser.editfileordersuccess','#notification','true','#main_loader');\"/>\n    ";
    } else {
        echo "  <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsuccess\" id=\"btnsuccess\" class=\"btn btn-primary\"\n  class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsuccess','edituser.editfileorder','#frmedituser','#notification','true','#main_loader');\"/>\n ";
    }
}
if ($row[$md5id]["allfield"]["user_can_c"] == "0" || $row[$md5id]["allfield"]["user_can_c"] == "1" || $row[$md5id]["allfield"]["user_can_c"] == "4") {
    echo " <input value=\"";
    echo $LNG["reject"];
    echo "\" id=\"btnreject\" name=\"btnreject\" class=\"btn delete\" type=\"button\"  onclick=\"SubmitForm ('#btnreject','edituser.editfileorderreject','#frmedituser','#notification','true','#main_loader');\"/>\n";
}
if ($row[$md5id]["allfield"]["user_can_c"] == "3") {
    echo " ";
    if ($replyt["repli"]) {
        echo " <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsetback\" id=\"btnsetback\" class=\"btn btn-primary\" type=\"button\"  onclick=\"ajaxFileUpload('";
        echo $md5id;
        echo "','fileToUpload','edituser.editfileordersuccess','#notification','true','#main_loader');\"/>\n ";
    } else {
        echo "  <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsuccess\" id=\"btnsuccess\"\n  class=\"btn btn-primary\" type=\"button\"  onclick=\"SubmitForm ('#btnsuccess','edituser.editfileorder','#frmedituser','#notification','true','#main_loader');\"/>\n ";
    }
}
echo "\n</td></tr>\n</tbody></table>\n\n\n\n\n</div>\n\n <div class=\"clear\"></div>\n\n\n\n<hr />\n\n\n\n";
if ($row[$id]["reply_by"]["adminid"]) {
    $reply = $LNG["admin"];
    $replyBy = $row[$id]["reply_by"]["adminid"];
} else {
    if ($row[$id]["reply_by"]["supplierid"]) {
        $reply = $LNG["supplier"];
        $replyBy = $row[$id]["reply_by"]["adminid"];
    }
}
if ($row[$id]["reply_by"]["verfiedadminid"]) {
    $verify = $LNG["admin"];
    $verifyBy = $row[$id]["reply_by"]["verfiedadminid"];
} else {
    if ($row[$id]["reply_by"]["verfiedsupid"]) {
        $verify = $LNG["supplier"];
        $verifyBy = $row[$id]["reply_by"]["verfiedsupid"];
    }
}
echo "\n<div>\n<div  class=\"groupstabes\" >\n\n  <div class=\"groupstabescontant\">\n\n\n\n<table class=\"form\" border=\"0\" width=\"100%\">\n<tbody>\n";
$request = explode(".", $row[$id]["file"]);
$downloadrequest = md5(trim($request[0])) . "." . $request[1];
if ($row[$md5id]["allfield"]["user_can_c"] == "4") {
    $replyfile = explode(".", $row[$md5id]["allfield"]["reply"]);
    $downloadreply = md5(trim($replyfile[0])) . "." . $replyfile[1];
}
echo "<tr><td class=\"fieldlabel\">";
echo $LNG["request"];
echo " ";
echo $LNG["file"];
echo "</td><td class=\"fieldarea\"><a href=\"includes/download.php?action=requestfile&id=";
echo $md5id;
echo "\">\n <i class=\"fa fa-download\"></i>  ";
echo $row[$id]["file"];
echo " </a></td></tr>\n<tr><td class=\"fieldlabel\">";
if ($row[$md5id]["allfield"]["user_can_c"] == "3") {
    echo $LNG["reason"];
} else {
    echo $LNG["reply"];
}
echo "</td><td class=\"fieldarea\">\n  <span style=\"cursor: pointer; text-decoration: none;\">\n\n\n";
if (is_file("../" . $donloaddirpath . "/" . $row[$md5id]["allfield"]["reply_enc"])) {
    if ($downloadreply) {
        echo " <a href=\"includes/download.php?action=replyfile&id=";
        echo $md5id;
        echo "\">\n <i class=\"fa fa-download\"></i>  ";
    }
    echo " ";
    echo $row[$md5id]["allfield"]["reply"];
    echo "</a>\n";
}
echo "\n     <span   id=\"editInPlace\">";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo " <i class=\"flaticon-edit\"></i> </span> </span></td></tr>\n\n";
foreach ($row[$id]["customfields"] as $val) {
    echo "<tr><td class=\"fieldlabel\">";
    echo $val["name"];
    echo "</td><td class=\"fieldarea\"><span>";
    echo $val["input"];
    echo "</span></td></tr>\n";
}
echo "<tr><td class=\"fieldlabel\"> ";
echo $LNG["user"];
echo " ";
echo $LNG["note"];
echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["note"];
echo "\" name=\"note\"/></span></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["comments"];
echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["comments"];
echo "\" name=\"comments\"/></span></td></tr>\n\n</tbody>\n</table>\n\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituser.editfileorder','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n\n</form>\n\n</div>\n</div></div>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>