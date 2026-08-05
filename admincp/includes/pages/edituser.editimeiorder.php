<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$DonotLoad = 1;
include_once "includes/3rdparty/editor/editor.php";
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/" . $admindirpath . "/includes/pages/imeiservice.fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$color = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];
echo "<script type=\"text/javascript\">\n      tinymce.init({\n          selector: \"textarea.editors\",\n          menu:{},\n          plugins: \" table textcolor code\",\n          toolbar: \"bold italic underline | code | forecolor backcolor | removeformat \"\n      });\n  </script>\n  <script type=\"text/javascript\">\n      function forgetError(orderid){\n\n          \$.post(\"includes/pages/resetorderstat.php?orderid=\"+orderid, function(data, status){\n\n              \$(\".apimsg\").removeClass();\n              alert('Will try to send in next batch');\n          });\n\n      }\n      \$(\"document\").ready(function() {\n          setClickable();\n          \$('#mail-server input[type=\"radio\"]').click(function(){\n              \$('.groupstabes9').removeClass('active');\n              \$('#'+\$(this).val()).addClass('active');\n          });\n      });\n\n      function setClickable() {\n          \$('span#editInPlace').click(function () {\n              var input = '<span id=\"after\"><input type=\"text\" style=\"width: 180px;\" value=\"' + \$(this).html() + '\" name=\"replacecode\"/> <input  value=\"";
echo $LNG["update"];
echo "\" name=\"btnreplace\" id=\"btnreplace\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm (\\'#btnreplace\\',\\'edituser.editimeiorderreplacesuccess\\',\\'#frmedituser\\',\\'#notification\\',\\'true\\',\\'#main_loader\\');\"/>';\n              var button = '&nbsp;&nbsp;<input type=\"button\" value=\"cancel\" class=\"cancelButton\" /></span>';\n              var revert = \$(this).html();\n              \$(this).after(input + button).remove();\n              \$('.cancelButton').click(function () {\n                  saveChanges(this, revert);\n              });\n          })\n      }\n      function saveChanges(obj, revert) {\n          \$(obj).parent().after('<span id=\"editInPlace\">'+revert+'</span>').remove();\n      }\n      function ConnectToAPI()\n      {\n          load_subpage('main2.php?page=connectapi&o=";
echo $id;
echo "','Connect API');\n      }\n  </script>\n  <style>\n      .mce-tinymce{\n          width: 400px !important;\n          box-shadow: none;\n          margin-bottom: 15px;\n      }\n      .txtgray{\n          color:#afaeaa;\n          font-weight: bold;\n      }\n      .txtred{\n          color:#b5052a;\n          font-weight: bold;\n      }\n      .txtgreen{\n          color:#008000;\n          font-weight: bold;\n      }\n      .txtorange{\n          color:#dd9303;\n          font-weight: bold;\n      }\n      .text-muted{\n          color:#4a4a4a !important;\n      }\n\n      .groupstabes9{display: none;}\n      .groupstabes9.active{display: block;}\n  </style>\n  ";
$pageid = 186;
checkPagePermission($pageid);
$row = getOrdersIMEI("", "", "", $id, "", false);
$md5id = md5($id);
$usid = $row[$md5id]["allfield"]["user_id"];
$clientDetails = getClientsDetails($usid);
$usercurr = mysqli_fetch_assoc(dquery("select code from tbl_currencies where\n  id='" . $clientDetails["currency_id"] . "'"));
$diff = time() - $clientDetails["credit_date"];
$days = round($diff / 86400);
if ($clientDetails["credit_validity"] != 0) {
    if ($days < $clientDetails["credit_validity"]) {
        $color = "#779500";
    } else {
        if ($clientDetails["credit_validity"] == $days) {
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
$ar = mysqli_fetch_assoc(dquery("select ebay from tbl_order_imei\n  \t\twhere order_id=" . $id));
if (is_file("../images/avtar/" . $usid . "_avtar.jpg")) {
    $avatar = "../images/avtar/" . $usid . "_avtar.jpg";
}
echo "\n<style>\n    .custom-table .text-muted{\n        display: inline-block;\n        width: 150px;\n    }\n</style>\n  <div id=\"notification\"></div>\n\n  <form id=\"frmedituser\" name=\"\" method=\"post\">\n      <input type=\"text\" value=\"";
echo $id;
echo "\" name=\"id\" style=\"display: none\"/>\n      <input type=\"hidden\" value=\"";
echo $clientDetails["id"];
echo "\" name=\"uid\"/>\n      <input type=\"hidden\" value=\"";
echo $md5id;
echo "\" name=\"md5id\"/>\n      ";
echo generate_token("form");
echo "\n\n      <script type=\"text/javascript\">\n\n          \$(\"document\").ready(function() {\n              ";
if ($row[$id]["user_can_c"] == 3) {
    echo "              \$('#mail-server input[type=\"radio\"][value=\"s2\"]').click();\n              ";
}
if ($row[$id]["user_can_c"] == 4) {
    echo "              \$('#mail-server input[type=\"radio\"][value=\"s1\"]').click();\n              ";
}
echo "          });\n\n      </script>\n\n      <div id=\"content\">\n          <div id=\"content_padded\">\n              <div>\n                  <div  class=\"groupstabes\" >\n                      <div class=\"groupstabescontant\">\n                          ";
if ($row[$id]["reply_by"]["adminid"]) {
    $supdetail = mysqli_fetch_assoc(dquery("select username from\n      tbl_admin where id='" . $row[$id]["reply_by"]["adminid"] . "'"));
    $reply = $LNG["admin"] . " [" . $supdetail["username"] . "]";
    $replyBy = $row[$id]["reply_by"]["adminid"];
} else {
    if ($row[$id]["reply_by"]["supplierid"]) {
        $supdetail = mysqli_fetch_assoc(dquery("select username from\n      tbl_supplier where id='" . $row[$id]["reply_by"]["supplierid"] . "'"));
        $reply = $LNG["supplier"] . " [" . $supdetail["username"] . "]";
        $replyBy = $row[$id]["reply_by"]["supplierid"];
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
echo "\n                          <div class=\"custom-table\">\n\n                              <div>\n\n                          <div>\n                              <h2>\n  <span class=\"groupstabesheadertext\"> #";
echo $id;
echo "      ";
if ($row[$md5id]["allfield"]["encnum"]) {
    echo "/ " . $row[$md5id]["allfield"]["encnum"];
}
if ($ar["ebay"]) {
    echo "[Direct Order]";
}
echo "      </span>\n                              </h2>\n\n\n\n                              <div  class=\"table-row\"> <strong> ";
echo $row[$id]["service"];
echo "  </strong><a href=\"javascript:load_fromsubpage('editimeiservice&id=";
echo $row[$id]["service_id"];
echo "','";
echo $row[$id]["service"];
echo "');\">[";
echo $LNG["edit"];
echo " ";
echo $LNG["service"];
echo " #";
echo $row[$id]["service_id"];
echo "]</a></div>\n\n                              <div class=\"table-row\">\n                                  ";
if ($row[$id]["user_can_c"] == 0 && $row[$id]["apierror"]) {
    echo "\n<div id='notification1' class='info' style='cursor:auto'>" . $LNG["apiprocessingerror"] . "\n<div class='apimsg'><i  class='fa fa-exclamation-triangle' style='color:#f59731 '></i> " . strip_tags($row[$id]["apierror"]) . " </div>\n<div><strong  onclick='forgetError(" . $id . ");' style='cursor: pointer'> " . $LNG["clickheretoresend"] . " </strong> </div>\n</div>\n";
}
echo "                              </div>\n\n                              <div  class=\"table-row\">\n                                  <span class=\"text-muted\"> ";
echo $LNG["status"];
echo " </span>\n                                  <span class=\"";
echo $row[$id]["user_can_c"] == 0 ? "txtgray" : ($row[$id]["user_can_c"] == 1 ? "txtorange" : ($row[$id]["user_can_c"] == 3 ? "txtred" : "txtgreen"));
echo "\" >\n  ";
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
echo "  </span>\n\n                                  ";
if ($row[$id]["verified"] == "1" && $row[$md5id]["allfield"]["user_can_c"] == "4") {
    echo "<span class='badge badge-secondary'> " . $LNG["waiting"] . " " . $LNG["for"] . " " . $LNG["verification"] . "</span>";
}
echo "\n\n\n                              </div>\n\n\n\n\n\n\n\n\n                              <div>\n\n                                  <div  class=\"table-row\"><span class=\"text-muted\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo "</span>  ";
echo $row[$id]["service_details"]["time"];
echo "</div>\n                                  ";
if (0 < $row[$id]["points"]) {
    echo "                                      <div  class=\"table-row\">\n                                          <span class=\"text-muted\">";
    echo $LNG["points"];
    echo " </span>\n                                          ";
    echo $row[$id]["points"];
    echo "                                      </div>\n                                      ";
} else {
    echo "                                      <div  class=\"table-row\">\n                                          <span class=\"text-muted\">";
    echo $LNG["service"];
    echo " ";
    echo $LNG["credit"];
    echo " </span>\n                                          <strong>\n                                          ";
    $sids = $row[$md5id]["allfield"]["service_id"];
    if ($ar["ebay"]) {
        $svs = mysqli_fetch_assoc(dquery("select retail_credit from tbl_services_imei\twhere id='" . $sids . "'"));
        echo formatCurrency($svs["retail_credit"]);
    } else {
        echo formatCurrency($row[$id]["service_details"]["credit"]);
    }
    echo "                                          </strong>\n                                      </div>\n                                      ";
}
echo "\n\n\n                                  <div  class=\"table-row\"> <span class=\"text-muted\">";
echo $LNG["user"];
echo " ";
echo $LNG["cost"];
echo " </span>  ";
echo $row[$id]["credit"] - $row[$id]["discount"] . " " . $usercurr["code"];
echo "                                      ";
$GRP = "";
if ($row[$id]["pricefrom"] == "Client Group") {
    $GRP = $clientDetails["groupname"];
}
echo " <span class='badge badge-secondary'>" . $row[$id]["pricefrom"] . ($GRP ? " (" . $GRP . ")" : "") . "</span>";
echo "                                  </div>\n                                  ";
if (0 < $row[$id]["qnt"]) {
    echo "                                      <div  class=\"table-row\"> <span class=\"text-muted\">";
    echo $LNG["total"];
    echo " ";
    echo $LNG["paid"];
    echo " </span> <strong style=\"color: #28ac7c\">";
    echo formatCurrency($row[$id]["qnt"] * ($row[$id]["credit"] - $row[$id]["discount"]));
    echo "</strong>\n                                      </div>\n                                      ";
}
echo "\n\n                                  ";
if ($row[$id]["service_details"]["API"]) {
    echo "                                      <div  class=\"table-row\">\n                                          <span class=\"text-muted\"> ";
    echo $LNG["api"];
    echo " </span>  ";
    if ($row[$id]["apiname"]) {
        echo $row[$id]["apiname"];
    } else {
        if ($row[$id]["service_details"]["API"]) {
            $apg = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n  where gateway='" . $row[$id]["service_details"]["API"] . "'\n  and setting='name'"));
            $apg2 = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n  where gateway='" . $row[$id]["service_details"]["API"] . "'\n  and setting='customname'"));
            echo $row[$id]["service_details"]["API"] . " (" . ($apg2["value"] ? $apg2["value"] : $apg["value"]) . ")";
        } else {
            echo "-";
        }
    }
    echo "\n\n\n                                          ";
    if ($row[$id]["user_can_c"] == 0 || $row[$id]["user_can_c"] == 1) {
        echo "                                              <a   style=\"text-decoration: underline\"  class=\"ml-2\" onclick=\"javascript: ConnectToAPI();\"     >Connect/Change APi</a>\n                                              ";
    }
    if ($row[$id]["service_details"]["API"] && $row[$id]["user_can_c"] == 0) {
        echo "\n                                             <a  style=\"text-decoration: underline\"  class=\"ml-2\" onclick=\"javascript: SubmitForm('#btnsuccess','sendapiorder','#frmedituser','#notification','true','#main_loader','";
        echo urldecode("main2.php?page=edituser.editimeiorder&id=" . $id);
        echo "');\"\n                                             > Forcefully send to APi </a>\n\n                                              ";
    }
    echo "\n\n                                      </div>\n                                  ";
}
if ($row[$id]["apilogreferenceid"]) {
    echo "                                      <div  class=\"table-row\"> <span class=\"text-muted\"> ";
    echo $LNG["api"];
    echo " ";
    echo $LNG["order"];
    echo "  ";
    echo $LNG["id"];
    echo " </span>\n                                          ";
    if ($row[$id]["apilogreferenceid"]) {
        echo " ";
        echo $row[$id]["apilogreferenceid"];
        echo " ";
    }
    echo "</div>\n                                      ";
}
echo "\n\n\n\n\n                                  <div  class=\"table-row\"><span class=\"text-muted\">";
echo $LNG["client"];
echo "</span>\n                                      <a style=\"text-decoration: underline\"  href=\"javascript:load_fromsubpage('edituser&id=";
echo $clientDetails["id"];
echo "','";
echo $clientDetails["username"];
echo "');\">";
echo $clientDetails["firstname"] . " " . $clientDetails["lastname"];
echo "</a>\n                                      [";
echo $clientDetails["credit"]["credit"] . " " . $usercurr["code"];
echo "]</div>\n\n\n\n\n                              </div>\n\n\n\n                              <div  class=\"table-row\"> <span class=\"text-muted\"> ";
echo $LNG["order"];
echo " ";
echo $LNG["on"];
echo " </span>  ";
echo formatDate($row[$md5id]["allfield"]["time"], "time", true);
echo " </div>\n                              ";
if (0 < $row[$md5id]["allfield"]["acceptedtime"]) {
    $accept = mysqli_fetch_assoc(dquery("select username from tbl_admin where id='" . $row[$md5id]["allfield"]["acceptedby"] . "'"));
    echo "                                  <div  class=\"table-row\"><span class=\"text-muted\"> ";
    echo $LNG["accepted"];
    echo " ";
    echo $LNG["after"];
    echo " </span>\n                                       ";
    echo gettime($row[$md5id]["allfield"]["acceptedtime"], $row[$md5id]["allfield"]["time"]);
    echo "                                      [";
    echo $accept[username];
    echo "]\n                                  </div>\n                                  ";
}
if (0 < $row[$md5id]["allfield"]["reply_time"]) {
    if (0 < $row[$md5id]["allfield"]["reply_by_admin"]) {
        $accept = mysqli_fetch_assoc(dquery("select username\n            from tbl_admin where id='" . $row[$md5id]["allfield"]["reply_by_admin"] . "'"));
    } else {
        if (0 < $row[$md5id]["allfield"]["reply_by_api"]) {
            $accept["username"] = "APi";
        }
    }
    echo "\n\n                                  <div  class=\"table-row\"><span class=\"text-muted\"> ";
    echo $LNG["replied"];
    echo " ";
    echo $LNG["on"];
    echo " </span>\n                                       ";
    echo formatDate($row[$md5id]["allfield"]["reply_time"], "time", true);
    echo "                                      <strong>";
    echo $LNG["after"];
    echo "  ";
    echo gettime($row[$md5id]["allfield"]["reply_time"], $row[$md5id]["allfield"]["time"]);
    echo "</strong>\n                                      ";
    echo $LNG["by"];
    echo " ";
    echo $accept[username];
    echo "                                     </div>\n                                  ";
}
echo "                              <div  class=\"table-row\"> <span class=\"text-muted\">";
echo $LNG["order"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["ip"];
echo " </span>  <a href=\"javascript: load_subpage('";
echo $config["ip_location"];
echo $row[$md5id]["allfield"]["ip"];
echo "','IP Location');\">";
echo $row[$md5id]["allfield"]["ip"];
echo "</a> </div>\n\n                              <div  class=\"table-row\">\n                                  <span class=\"text-muted\">Source </span>  ";
echo $row[$id]["placedfrom"] == 3 ? "Telegram Bot" : ($row[$id]["placedfrom"] ? "API" : "Web");
echo "\n                                  ";
if ($row[$id]["retail_shop"]) {
    echo "<span style='padding:0 5px;border-radius:3px;background:green;color:white'>Retail</span>";
}
echo "\n                              </div>\n                              <!--<div  class=\"table-row\"> <span class=\"text-muted\"> </span>  </div>-->\n\n\n\n                              ";
if ($row[$id]["retail_shop"]) {
    $qi = dquery("select invoiceid from tbl_invoiceitems where `type`='IMEI' and relid='" . $id . "'");
    if (mysqli_num_rows($qi)) {
        $inq = mysqli_fetch_assoc($qi);
        echo " <div  class='table-row'> \n                                  <span class='text-muted'> Invoice </span> <a style='text-decoration: underline' class=\"editdata\" onclick=\"load_subpage('main2.php?page=edituser.editinvoice&id=" . $inq["invoiceid"] . "','Edit Invoice');\">#" . $inq["invoiceid"] . "</a> </div>";
    }
}
echo "\n\n\n                          </div>\n\n\n\n\n                              </div>\n\n\n\n\n                          </div>\n\n\n\n\n\n\n                          <div class=\"mt-2\">\n\n\n                              <div class=\"wrapper center-block\" >\n                                  <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">\n\n                                      <div class=\"panel panel-default\">\n\n                                          <div class=\"panel-heading active\" role=\"tab\" id=\"headingTwo\">\n                                              <h4 class=\"panel-title\">\n                                                  <a role=\"button\" data-toggle=\"collapse\"  href=\"#collapseTwo\" aria-expanded=\"true\" aria-controls=\"collapseTwo\">\n                                                      Fields\n                                                  </a>\n                                              </h4>\n                                          </div>\n                                          <div id=\"collapseTwo\" class=\"panel-collapse collapse show\" data-parent=\"#accordion\" role=\"tabpanel\" aria-labelledby=\"headingTwo\">\n                                              <div class=\"panel-body\">\n\n                                                  <div class=\"custom-table\">\n                                                      ";
if ($row[$id]["server"] == 0) {
    echo "                                                          <div class=\"table-row\"> <span class=\"text-muted\">    ";
    echo $LNG["imei"];
    echo " </span>  <strong> ";
    echo $row[$id]["imei"];
    echo " </strong> </h2>  </div>\n                                                          ";
}
echo "\n\n                                                  ";
if ($row[$id]["server"]) {
    echo "                                                      <div class=\"table-row\">\n                                                          <span class=\"text-muted\">";
    echo $LNG["qnt"];
    echo " </span>\n                                                          : ";
    echo $row[$id]["qnt"] ? $row[$id]["qnt"] : 1;
    echo "                                                      </div>\n                                                      ";
}
if ($verifyBy) {
    echo "                                                      <div class=\"table-row\">\n                                                          <span class=\"text-muted\">";
    echo $LNG["verified"];
    echo " ";
    echo $LNG["by"];
    echo "   </span>\n                                                          : ";
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
    echo "]\n                                                      </div>\n                                                      ";
}
echo "\n\n                                                  ";
if ($row[$id]["server"] == 0) {
    echo "\n\n                                                      <div>\n                                                          ";
    if ($row[$id]["pin"]) {
        echo " <div  class=\"table-row\">\n                                                              <span class=\"text-muted\">";
        echo $LNG["pin"];
        echo "</span>\n                                                              ";
        echo $row[$id]["pin"];
        echo "                                                          </div> ";
    }
    echo "                                                          ";
    if ($row[$id]["kbh"]) {
        echo " <div class=\"table-row\">\n                                                              <span class=\"text-muted\">";
        echo $LNG["kbh"];
        echo "</span>\n                                                              ";
        echo $row[$id]["kbh"];
        echo "                                                          </div> ";
    }
    echo "                                                          ";
    if ($row[$id]["prd"]) {
        echo "  <div class=\"table-row\">\n                                                              <span class=\"text-muted\">";
        echo $LNG["prd"];
        echo "</span>\n                                                              ";
        echo $row[$id]["prd"];
        echo "                                                          </div> ";
    }
    echo "                                                          ";
    if ($row[$id]["type"]) {
        echo "  <div class=\"table-row\">\n                                                              <span class=\"text-muted\">";
        echo $LNG["lock"];
        echo " ";
        echo $LNG["type"];
        echo "</span>\n                                                              ";
        echo $row[$id]["type"];
        echo "                                                          </div> ";
    }
    echo "\n                                                          ";
    if ($row[$id]["sn"]) {
        echo "  <div class=\"table-row\">\n                                                              <span class=\"text-muted\">SN</span>\n                                                              ";
        echo $row[$id]["sn"];
        echo "                                                          </div> ";
    }
    echo "\n                                                          ";
    if ($row[$id]["secro"]) {
        echo "  <div class=\"table-row\">\n                                                              <span class=\"text-muted\">SecRO</span>\n                                                              ";
        echo $row[$id]["secro"];
        echo "                                                          </div> ";
    }
    echo "\n                                                      </div>\n\n                                                      ";
}
echo "\n\n                                                  ";
foreach ($row[$id]["customfields"] as $val) {
    if ($val["value"]) {
        echo "                                                          <div  class=\"table-row\">\n                                                              <span class=\"text-muted\">";
        echo $val["name"];
        echo "</span>\n                                                              ";
        echo $val["value"];
        echo "                                                          </div>\n                                                      ";
    }
}
echo "                                                  ";
if ($row[$md5id]["allfield"]["note"]) {
    echo "  <div class=\"table-row\">\n                                                      <span class=\"text-muted\"> ";
    echo $LNG["user"];
    echo " ";
    echo $LNG["note"];
    echo "</span>\n                                                      ";
    echo $row[$md5id]["allfield"]["note"];
    echo "                                                  </div> ";
}
echo "                                                  ";
if ($row[$md5id]["allfield"]["comments"]) {
    echo " <div class=\"table-row\">\n                                                      <span class=\"text-muted\">";
    echo $LNG["user"];
    echo " ";
    echo $LNG["comments"];
    echo "</span>\n                                                      ";
    echo $row[$md5id]["allfield"]["comments"];
    echo "                                                  </div> ";
}
echo "                                                  ";
if ($row[$md5id]["allfield"]["adminnote"]) {
    echo "  <div class=\"table-row\">\n                                                      <span class=\"text-muted\">Admin ";
    echo $LNG["note"];
    echo "</span>\n                                                      ";
    echo $row[$md5id]["allfield"]["adminnote"];
    echo "                                                  </div> ";
}
echo "                                                  ";
if ($row[$id]["response_email"]) {
    echo "  <div class=\"table-row\">\n                                                      <span class=\"text-muted\">Response ";
    echo $LNG["email"];
    echo "</span>\n                                                      ";
    echo $row[$id]["response_email"];
    echo "                                                  </div> ";
}
echo "\n\n\n                                                  </div>\n\n                                              </div>\n                                          </div>\n\n\n                                          <div class=\"panel-heading\" role=\"tab\" id=\"headingOne\">\n                                              <h4 class=\"panel-title\">\n                                                  <a role=\"button\" data-toggle=\"collapse\"  href=\"#collapseOne\" aria-expanded=\"true\" aria-controls=\"collapseOne\">\n                                                      Edit Fields\n                                                  </a>\n                                              </h4>\n                                          </div>\n                                          <div id=\"collapseOne\" class=\"panel-collapse collapse\" data-parent=\"#accordion\" role=\"tabpanel\" aria-labelledby=\"headingOne\">\n                                              <div class=\"panel-body\">\n                                                  <table  class=\"form\">\n                                                      <tbody>\n\n                                                      ";
if ($row[$id]["server"]) {
    echo "\n                                                          <tr>\n                                                              <td class=\"fieldlabel\">";
    echo $LNG["qnt"];
    echo " : </td>\n                                                              <td class=\"fieldarea\"> <strong>";
    echo $row[$id]["qnt"] ? $row[$id]["qnt"] : 1;
    echo "</strong></span>\n                                                              </td>\n                                                          </tr>\n                                                          ";
}
if ($verifyBy) {
    echo "                                                          <tr>\n                                                              <td class=\"fieldlabel\">";
    echo $LNG["verified"];
    echo " ";
    echo $LNG["by"];
    echo " : </td>\n                                                              <td class=\"fieldarea\">";
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
    echo "]</span>\n                                                              </td>\n                                                          </tr>\n                                                          ";
}
echo "\n\n                                                      </tbody>\n                                                  </table>\n\n                                                  ";
if ($row[$id]["server"] == 0) {
    echo "                                                      <table  class=\"form floatleft\">\n                                                          <tbody>\n                                                          ";
    if ($row[$id]["service_details"]["model"]) {
        echo "                                                              <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">";
        echo $LNG["brand"];
        echo "</td><td class=\"fieldarea\"><span>";
        echo getBrandDropdown($row[$id]["brand_id"], md5($row[$id]["service_details"]["id"]), "brandId", true);
        echo "</span></td></tr>\n\n                                                              <tr><td class=\"fieldlabel\">";
        echo $LNG["model"];
        echo "</td><td class=\"fieldarea\"><div id=\"modelsdropdown\" style=\"display: none;\"></div>\n\n                                                                      <span id=\"onloadmodelsdropdown\">";
        echo getModelDropdown($row[$id]["brand_id"], $row[$id]["model_id"], $row[$id]["service_details"]["assigned_model"]);
        echo "</span></td></tr>\n                                                              ";
    }
    if ($row[$id]["service_details"]["provider"]) {
        echo "                                                              <tr><td class=\"fieldlabel\">";
        echo $LNG["country"];
        echo "</td><td class=\"fieldarea\"><span>";
        echo getProviderCountryDropdown($row[$id]["providercountry_id"], md5($row[$id]["service_details"]["id"]), "countryId", true);
        echo "</span></td></tr>\n                                                              ";
    }
    if ($row[$id]["service_details"]["provider"]) {
        echo "                                                              <tr><td class=\"fieldlabel\">";
        echo $LNG["provider"];
        echo "</td><td class=\"fieldarea\"><div id=\"providerdropdown\" style=\"display: none;\"></div><span id=\"onloadproviderdropdown\">";
        echo getProviderDropdown($row[$id]["providercountry_id"], $row[$id]["provider_id"], $row[$id]["service_details"]["assigned_provider"]);
        echo "</span></td></tr>\n                                                              ";
    }
    if ($row[$id]["service_details"]["mep"]) {
        echo "                                                              <tr><td class=\"fieldlabel\">";
        echo $LNG["mep"];
        echo "</td><td class=\"fieldarea\"><span>";
        echo getmepDropdown($row[$id]["mep_id"], md5($row[$id]["service_details"]["id"]), "mepId");
        echo "</span></td></tr>\n                                                              ";
    }
    echo "                                                          </tbody>\n                                                      </table>\n\n                                                      <table  class=\"form floatleft\" style=\"margin: 0 20px 0 0;\">\n                                                          <tbody>\n                                                          <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">";
    echo $LNG["pin"];
    echo "</td><td class=\"fieldarea\"><span>\n      <input type=\"text\" value=\"";
    echo $row[$id]["pin"];
    echo "\" name=\"pin\"/></span></td></tr>\n                                                          <tr><td class=\"fieldlabel\">";
    echo $LNG["kbh"];
    echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $row[$id]["kbh"];
    echo "\" name=\"kbh\"/></span></td></tr>\n                                                          <tr><td class=\"fieldlabel\">";
    echo $LNG["prd"];
    echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $row[$id]["prd"];
    echo "\" name=\"prd\"/></span></td></tr>\n                                                          <tr><td class=\"fieldlabel\">";
    echo $LNG["lock"];
    echo " ";
    echo $LNG["type"];
    echo "</td>\n                                                              <td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $row[$id]["type"];
    echo "\" name=\"type\"/></span></td></tr>\n\n                                                          <tr><td class=\"fieldlabel\">SN</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $row[$id]["sn"];
    echo "\" name=\"SN\"/>\n      </span></td></tr>\n\n                                                          <tr><td class=\"fieldlabel\">SecRO</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
    echo $row[$id]["secro"];
    echo "\"\n                                                                                                                                  name=\"SecRO\"/></span></td></tr>\n\n                                                          </tbody>\n                                                      </table>\n                                                      ";
}
echo "                                                  <table  class=\"form floatleft\">\n                                                      <tbody>\n\n                                                      ";
foreach ($row[$id]["customfields"] as $val) {
    echo "                                                          <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\">";
    echo $val["name"];
    echo "</td>\n                                                              <td class=\"fieldarea\"> <div style=\"width:200px\"><span>";
    echo $val["input"];
    echo "</span></div> </td></tr>\n                                                      ";
}
echo "                                                      <tr><td class=\"fieldlabel\"  style=\"min-width: 80px;\"> ";
echo $LNG["user"];
echo " ";
echo $LNG["note"];
echo "</td><td  class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["note"];
echo "\" style=\"width: 200px;\" name=\"note\"/></span></td></tr>\n                                                      <tr><td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["comments"];
echo "</td><td  class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["comments"];
echo "\" name=\"comments\"/></span></td></tr>\n                                                      <tr><td class=\"fieldlabel\">Admin ";
echo $LNG["note"];
echo "</td><td  class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["adminnote"];
echo "\" name=\"adminnote\"/></span></td></tr>\n                                                      <tr><td class=\"fieldlabel\">Response ";
echo $LNG["email"];
echo "</td>\n                                                          <td class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$id]["response_email"];
echo "\"\n                                                                                             name=\"response_email\"/></span></td></tr>\n\n                                                      <tr>\n                                                          <td>\n\n                                                          </td>\n                                                          <td>\n                                                              <div class=\"py-3\">\n                                                                  <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\"\n                                                                         class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituser.editimeiorder','#frmedituser','#notification','true','#main_loader');\"/>\n                                                              </div>\n                                                          </td>\n                                                      </tr>\n\n                                                      </tbody></table>\n                                              </div>\n                                          </div>\n\n\n\n\n\n\n                                      </div>\n\n                                  </div>\n                              </div>\n\n\n\n\n\n                              <div  class=\"mt-2\">\n                              <div>\n\n\n\n                                  <div id=\"mail-server\">\n\n                                      <div>\n\n                                          <div class=\"form-radio\"><div class=\"radio\"><label><input type=\"radio\" name=\"ds\" value=\"s1\" checked=\"\"><i class=\"helper\"></i>Reply Code</label></div></div> <label>Default Settings</label>\n\n                                          <div class=\"form-radio\"><div class=\"radio\"><label><input type=\"radio\" name=\"ds\" value=\"s2\"><i class=\"helper\"></i>Reject Order</label></div></div> <label>Mail Server 1</label>\n\n                                          <div class=\"form-radio\"><div class=\"radio\"><label><input type=\"radio\" name=\"ds\" value=\"s3\"><i class=\"helper\"></i>Send Email</label></div></div> <label>Mail Server 2</label>\n                                      </div>\n\n\n                                      <div id=\"content\" class=\"default\" style=\"margin-top: 10px\">\n                                          <div class=\"ms groupstabes9 active\" id=\"s1\">\n                                              <div class=\"groupstabescontant\">\n\n                                                  <textarea  placeholder=\"";
echo $LNG["reply"] . " " . $LNG["code"];
echo "\" id=\"replycode\" onchange=\"\$('#rejectreason').val(this.value)\" class=\"editors\" name=\"replycode\" style=\"background: #f4f4f4;padding:10px\">";
echo $row[$md5id]["allfield"]["reply"];
echo "</textarea>\n                                                  <input type=\"hidden\" base64encode=\"true\" id=\"replyscode\" name=\"replyscode\" value=\"\" />\n\n                                                  <div style=\"margin-top: 10px\">\n\n                                                      <input value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["success"];
echo "\"\n                                                             name=\"btnsuccess\" id=\"btnsuccess\" class=\"btn btn-success\" type=\"button\"\n                                                             onclick=\"document.getElementById('replyscode').value=tinyMCE.get('replycode').getContent();SubmitFormNew('#btnsuccess','edituser.editimeiordersuccess','#frmedituser','#notification','true','#main_loader');\"/>\n\n                                                  </div>\n                                              </div>\n                                          </div>\n\n                                          <div class=\"ms groupstabes9\" id=\"s2\">\n\n                                              <div class=\"groupstabescontant\">\n                                                  <div id=\"content\" class=\"server1\">\n                                                      <textarea placeholder=\"";
echo $LNG["reject"] . " " . $LNG["reason"];
echo "\" name=\"replycode\" onchange=\"\$('#replycode').val(this.value)\" id=\"rejectreason\" style=\"background: #f4f4f4;padding:10px\" >";
echo $row[$md5id]["allfield"]["reply"];
echo "</textarea>\n                                                      <input type=\"hidden\" id=\"replyscode2\" name=\"replyscode\" value=\"\" />\n                                                      <div style=\"margin-top: 10px\"> <input value=\"";
echo $LNG["reject"];
echo "\" id=\"btnreject\" name=\"btnreject\" class=\"btn button_remove\" type=\"button\"  onclick=\"SubmitFormNew ('#btnreject','edituser.editimeiorderreject','#frmedituser','#notification','true','#main_loader');\"/></div>\n                                                  </div>\n                                              </div>\n                                          </div>\n\n\n                                          <div class=\"ms groupstabes9\" id=\"s3\">\n                                              <div class=\"groupstabescontant\">\n                                                  <div id=\"content\" class=\"server2\">\n                                                      <select name=\"imeiordermail\">\n                                                          <option value=\"\">";
echo $LNG["select"];
echo "</option>\n                                                          ";
if ($row[$id]["server"] == 0) {
    $d = dquery("select type from tbl_emailtemplates where type='imeiorder'\n           or type='other' group by type");
    while ($ss = mysqli_fetch_assoc($d)) {
    }
    echo "                                                      </select>\n\n                                                      <div style=\"margin-top: 10px\">\n                                                          <input type=\"button\" name=\"resetpin\" class=\"addFromgallery\"\n                                                                 value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["email"];
    echo "\"   id=\"btnpmail\"\n                                                                 onclick=\"SubmitForm ('#btnpmail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n                                                      </div>\n                                                  </div>\n                                              </div>\n                                          </div>\n\n                                          <div class=\"mt-1\">\n                                              ";
    if ($row[$md5id]["allfield"]["user_can_c"] == "3") {
        echo "                                                  <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["success"];
        echo "\" name=\"btnsetback\" id=\"btnsetback\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback','edituser.editimeiordersuccess','#frmedituser','#notification','true','#main_loader');\"/>\n                                                  <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["new"];
        echo "\" name=\"btnsetback\" id=\"btnsetback\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback','edituser.editimeiordernew','#frmedituser','#notification','true','#main_loader');\"/>\n                                                  <input value=\"";
        echo $LNG["setbackto"];
        echo " ";
        echo $LNG["accepted"];
        echo "\" name=\"btnsetback\" id=\"btnsetback\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsetback','edituser.editimeiorderaccept','#frmedituser','#notification','true','#main_loader');\"/>\n                                              ";
    }
    echo "                                          </div>\n\n\n                                      </div>\n\n\n\n\n\n                                  </div>\n                              </div>\n\n\n                          </div>\n\n                          </div>\n\n                      </div>\n\n                  </div>\n\n                          ";
    $qa = dquery("select *,(select value from tbl_apiservers\n  where tbl_apiservers.gateway=tbl_apilog.gateway and setting='name') as api\n  from tbl_apilog where orderid='" . $id . "' order by id asc");
    if (mysqli_num_rows($qa)) {
        echo "\n                  <hr/> \n                          <div  class=\"groupstabes mt-2\" >\n\n                              <div class=\"groupstabescontant\">\n\n                          <h2><span class=\"groupstabesheadertext\">APi Log</span></h2>\n                          <div class=\"responsive-table\">\n                              <table id=\"main_tbl\">\n                                  <thead>\n                                  <tr>\n                                      <th style=\"text-align: left;\">";
        echo $LNG["server"];
        echo "</th>\n                                      <th style=\"text-align: left;\">";
        echo $LNG["service"];
        echo "</th>\n                                      <th style=\"text-align: left;\">";
        echo $LNG["date"];
        echo " ";
        echo $LNG["time"];
        echo "</th>\n                                      <th style=\"text-align: left;\">";
        echo $LNG["status"];
        echo "</th>\n                                      <th style=\"text-align: left;\">";
        echo $LNG["message"];
        echo "</th>\n                                      <th style=\"text-align: left;\">Connections</th>\n                                      <th style=\"text-align: right;\">";
        echo $LNG["action"];
        echo "</th>\n                                  </tr>\n                                  </thead>\n                                  ";
    }
    while ($ra = mysqli_fetch_assoc($qa)) {
        echo "                                      <tr>\n                                          <td>\n                                              ";
        echo (string) $ra["api"];
        echo "                                          </td>\n                                          <td>\n                                              ";
        $serv = mysqli_fetch_assoc(dquery("select `name` from\n  tbl_apiserversservices where gateway='" . $ra["gateway"] . "' and id='" . $ra["apiserviceid"] . "'"));
        echo wordwrap($serv["name"], 30, "<br />");
        echo "                                          </td>\n                                          <td>\n                                              ";
        echo $ra["date"];
        echo "                                          </td>\n\n                                          <td>\n                                              ";
        if (strpos($ra["data"], "ERROR") !== false) {
            echo "ERROR";
        } else {
            if (strpos($ra["result"], "Sending") !== false) {
                echo "ERROR";
            } else {
                echo "SUCCESS";
            }
        }
        echo "                                          </td>\n\n                                          <td>\n                                              ";
        $error = get_string_between2($ra["data"], "ERROR =>", "MESSAGE");
        $message = get_string_between2($ra["data"], "MESSAGE =>", "=>");
        if (!trim($message)) {
            $arr = explode("MESSAGE =>", $ra["data"]);
            $message = $arr[1];
        } else {
            if (strpos($message, " ") !== false) {
                $message = preg_replace("/\\W\\w+\\s*(\\W*)\$/", "\$1", $message);
            }
        }
        if (!$error) {
            $error = $ra["data"];
        }
        echo $error . ":::\n";
        echo wordwrap($message, 40, "\n");
        echo "                                          </td>\n                                          <td>";
        $rs = explode("=>", rtrim($ra["connections"], "=>"));
        foreach ($rs as $bbs) {
            echo $bbs . " <br />";
        }
        echo "</td>\n                                          <td>";
        echo $ra["send"] ? "send" : "get";
        echo "</td>\n                                      </tr>\n                                      ";
    }
    if (mysqli_num_rows($qa)) {
        echo "                              </table>\n                          </div>\n\n                              </div>\n                          </div>\n                      ";
    }
    echo "\n\n\n\n\n  </form>\n\n  </div>\n  </div></div>\n\n  <div class=\"clear\"></div>\n  </div></div>\n";
    $fileverioncheck = "6.1.0";
    echo "\n\n\n<script>\n    \$(document).ready(function (){\n        \$('.panel-collapse').on('show.bs.collapse', function () {\n            \$(this).siblings('.panel-heading').addClass('active');\n        });\n\n        \$('.panel-collapse').on('hide.bs.collapse', function () {\n            \$(this).siblings('.panel-heading').removeClass('active');\n        });\n    })\n</script>\n\n\n<style>\n    .panel-default{\n        border: #ddd solid 1px;\n        border-radius: 3px;\n        margin-top: 10px;\n    }\n    .panel-title{\n        margin-bottom: 0;\n    }\n    .panel-title>a{\n        display: block;\n        color: #555;\n        font-size: 16px;\n        text-decoration: none;\n        background: #f5f5f5;\n        padding: 15px;\n        border-radius: 3px 3px 0 0;\n    }\n    .panel-heading.active .panel-title>a{\n        border-bottom: #ddd solid 1px;\n    }\n    .panel-heading  a:before {\n        font-family: 'FontAwesome';\n        content: '\\f107';\n        float: right;\n        transition: all 0.5s;\n    }\n    .panel-heading.active a:before {\n        -webkit-transform: rotate(180deg);\n        -moz-transform: rotate(180deg);\n        transform: rotate(180deg);\n    }\n    .panel-collapse{\n        padding: 10px;\n        overflow: auto;\n    }\n</style>\n";
} else {
    $d = dquery("select type from tbl_emailtemplates where type='serverorder'\n           or type='other' group by type");
}
echo "                                                              <optgroup   label=\"";
echo $ss["type"];
echo "\" >\n                                                                  ";
$s = dquery("select id,name,type from  tbl_emailtemplates where `type`='" . $ss["type"] . "'");
while ($r = mysqli_fetch_assoc($s)) {
    echo "                                                                      <option   value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["name"];
    echo "</option>\n                                                                      ";
}
echo "                                                              </optgroup>\n                                                              ";
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
function get_string_between2($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

?>