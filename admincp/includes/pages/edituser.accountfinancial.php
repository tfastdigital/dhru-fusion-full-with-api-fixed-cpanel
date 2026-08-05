<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction blank(id){\n  bl = document.getElementById(id);\n  bl.value = '';\n}\n\n\$(document).ready(function(){\n   \$('#mtype input[type=\"checkbox\"]').click(function(){\n        \$('#mtype input[type=\"checkbox\"]').prop('checked', false);\n        \$('.pc').removeClass('active');\n        \$(this).prop('checked', true);\n        \$('#'+\$(this).val()).addClass('active');\n   });\n});\nfunction getCustomVal(days){\n\n    if(days==99)\n    {\n        \$(\"#duedate\").show();\n    }else{\n        \$(\"#duedate\").hide();\n    }\n\n}\nfunction calcFees(gateway){\n\n    var credit=\$(\"#creditleft\").val();\n\n    \$.post(\"includes/pages/calfees.php\", {credit: credit,payment:gateway}, function(result){\n        \$(\"#fees\").val(result);\n    });\n}\nfunction setPaidIn(ob){\n    if(\$(\"#paid\").is(\":checked\"))\n    {\n        \$(\".dueselect\").hide();\n    }else{\n        \$(\".dueselect\").show();\n    }\n}\nfunction showpyament(obj){\n    if(obj.checked){\n        \$(\".payments\").show();\n    }else{\n        \$(\".payments\").hide();\n    }\n}\n</script>\n<style>\n    .pc{display: none;}\n    .pc.active{display: block;}\n</style>\n";
$pageid = 213;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($clientDetails["usertype"] != "3") {
    if ($clientDetails["userstatus"] != "0") {
        echo "\n<div id=\"notification1\" class=\"info\">\n  ";
        if ($clientDetails["userstatus"] == "1") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
        } else {
            if ($clientDetails["userstatus"] == "2") {
                $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
            }
        }
        echo "  <span><strong>\n  ";
        echo $status;
        echo "  </strong></span></div>\n";
    }
    echo "\n\n<div title=\"userfinance\" id=\"tutid\"></div>\n<div id=\"notification\"></div>\n    <form id=\"frmedituser\" name=\"\" method=\"post\">\n\n    <div id=\"content\">\n  <div id=\"content_padded\">\n    ";
    if ($clientDetails["credit"]["credit"] < 0) {
        echo "    <div id=\"notification1\" class=\"info\">\n      ";
        echo $LNG["credit"];
        echo "      ";
        echo $LNG["overdrive"];
        echo "    </div>\n    ";
    }
    echo "      ";
    echo generate_token("form");
    echo "      <input type=\"hidden\" name=\"id\" value=\"";
    echo id;
    echo "\"/>\n      ";
    $diff = time() - $clientDetails["credit"]["date"];
    $days = round($diff / 86400);
    $errMsg = "";
    $valMsg = "";
    if ($clientDetails["credit"]["validity"] != 0) {
        if ($clientDetails["credit"]["validity"] < $days) {
            $validity = $clientDetails["credit"]["validity"];
            $errMsg .= "Credit Was Expired on ";
            $errMsg .= formatDate(date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day")));
        } else {
            if ($clientDetails["credit"]["validity"] == $days) {
                $validity = $clientDetails["credit"]["validity"];
                $valMsg .= "Credit Expired on ";
                $valMsg .= formatDate(date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day")));
                $valMsg .= " ( Todays )";
            } else {
                $validity = $clientDetails["credit"]["validity"];
                $valMsg .= "Credit will Expired on ";
                $valMsg .= formatDate(date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day")));
                $days = $validity - $days;
                $valMsg .= "  (after " . $days . " days)";
            }
        }
    }
    echo "      ";
    if ($errMsg) {
        echo "      <div id=\"notification1\" class=\"errorbox\">\n        ";
        echo $errMsg;
        echo "      </div>\n      ";
    }
    echo "      <input type=\"hidden\" value=\"";
    echo $id;
    echo "\" name=\"id\" />\n\n      <h2> <span class=\"groupstabesheadertext\">Financial Account </span>\n      </h2>\n   <div class=\"clear\"></div>\n\n<table class=\"form\"><tr>\n<td class=\"fieldlabel\">Transaction</td>\n<td class=\"fieldarea\">\n\n <div id=\"mtype\">\n\n    <input type=\"checkbox\" value=\"addcredit\" name=\"type\" checked=\"checked\"/> <label>Add Credit</label>\n    <input type=\"checkbox\" value=\"rebatecredit\" name=\"type\" id=\"rebatecr\"/> <label>Rebate Credit</label>\n    <input type=\"checkbox\" value=\"overdrive\" name=\"type\"/> <label>Overdrive</label>\n     ";
    if ($clientDetails["usertype"] == "1" && !$OnlyEcommerce) {
        echo "    <input type=\"checkbox\" value=\"saddcredit\" name=\"type\"/> <label>Add Sell Credit Limit</label>\n    <input type=\"checkbox\" value=\"srebatecredit\" name=\"type\"/> <label>Rebate Sell Credit Limit</label>\n";
    }
    echo " </div>\n</td></tr></table>\n\n\n    <div id=\"overdrive\" class=\"pc\">\n        ";
    if (!$config["allowoverdrive"]) {
        echo "            <div id=\"notification1\" class=\"errorbox\">";
        echo $LNG["overdrive"];
        echo " ";
        echo $LNG["disabled"];
        echo " ";
        echo $LNG["from"];
        echo " ";
        echo $LNG["settings"];
        echo "</div>\n        ";
    }
    echo "        <table class=\"form\">\n          <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["allow"];
    echo " ";
    echo $LNG["overdrive"];
    echo " </td>\n            <td  class=\"fieldarea\"><input type=\"checkbox\"\n name=\"allowoverdrive\" value=\"1\" id=\"see\" ";
    if ($clientDetails["allowoverdrive"] == 1) {
        echo "checked";
    }
    echo " />\n              <label for=\"see\"></label>\n            </td>\n          </tr>\n          <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["overdrive"];
    echo "  ";
    echo $LNG["limit"];
    echo " </td>\n            <td  class=\"fieldarea\"><input name=\"overdrive\" id=\"overdrive\" value=\"";
    echo $clientDetails["overdrive"];
    echo "\"\n         type=\"text\" class=\"small_txt addcredit-icon\"\n          onKeyPress=\"blank('rebatecredit')\"\n          onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n              ";
    echo $LNG["0limit"];
    echo "              <br />\n              <small>\n              ";
    echo $LNG["allow"];
    echo "              ";
    echo $LNG["user"];
    echo "              ";
    echo $LNG["to"];
    echo "              ";
    echo $LNG["place"];
    echo "              ";
    echo $LNG["order"];
    echo "              ";
    echo $LNG["even"];
    echo "              ";
    echo $LNG["after"];
    echo "              0\n              ";
    echo $LNG["credit"];
    echo "              .<br />\n              ";
    echo $LNG["credit"];
    echo "              ";
    echo $LNG["will"];
    echo "              ";
    echo $LNG["go"];
    echo "              ";
    echo $LNG["in"];
    echo "              ";
    echo $LNG["negative"];
    echo "              ";
    echo $LNG["limit"];
    echo "              </small> </td>\n          </tr>\n           <tr>\n            <td class=\"fieldlabel\">\n            Max. ";
    echo $LNG["credit"];
    echo "            </td>\n            <td  class=\"fieldarea\">\n<input name=\"maxcredit\"  value=\"";
    echo $clientDetails["maxcredit"];
    echo "\"\n         type=\"text\" class=\"small_txt addcredit-icon\" />\n            </td>\n          </tr>\n          <tr>\n            <td class=\"\"></td>\n            <td  class=\"fieldarea\" style=\"border: none;\"><input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnovdrv\" class=\"btn save\" type=\"button\"\nonclick=\"SubmitForm('#btnovdrv','edituser.overdrive','#frmedituser','#notification','true','#main_loader');\"/>\n            </td>\n          </tr>\n        </table>\n    </div>\n\n  <input type=\"hidden\" value=\"";
    echo $clientDetails["credit"]["credit"];
    echo "\" id=\"cc\"/>\n  <input type=\"hidden\" value=\"";
    echo $clientDetails["credit"]["selling_limit"];
    echo "\" id=\"cs\"/>\n\n        <div id=\"addcredit\" class=\"pc active\">\n\n          <table class=\"form\">\n            <tr>\n              <td class=\"fieldlabel\">\n\n                ";
    echo $LNG["credit"];
    echo "                 </td>\n              <td  class=\"fieldarea\">\n                <span style=\"font-size:20px\">  ";
    echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
    echo " </span> &nbsp;&nbsp; <span style=\"font-size: 16px;color:#479612;\">+</span> &nbsp;&nbsp;\n                <input name=\"creditleft\" style=\"background: #f4f4f4;width:100px\" id=\"creditleft\" value=\"\" type=\"text\" class=\"small_txt addcredit-icon\" onKeyPress=\"blank('rebatecredit')\" onKeyUp=\"\$('#cca').text( (parseFloat(\$('#cc').val())+parseFloat(this.value)).toFixed(2) );return cF(this,false)\" onBlur=\"return cF(this,true)\"/> = <span id=\"cca\" style=\"font-size: 16px;\"> ";
    echo $clientDetails["credit"]["credit"];
    echo " </span>\n\n              </td>\n            </tr>\n\n            <tr>\n              <td class=\"fieldlabel\">\n\n                 </td>\n              <td  class=\"fieldarea\">\n               <input type=\"checkbox\" onclick=\"showpyament(this)\" checked=\"checked\"\n               id=\"geninvoice\" name=\"geninvoice\"/>\n                <label for=\"geninvoice\">\n                ";
    echo $LNG["geninvoice"];
    echo "                </label>\n                </span> <span onclick=\"javascript: setPaidIn(this);\">\n                <input type=\"checkbox\"  id=\"paid\"\n                name=\"paid\"/>\n                <label for=\"paid\" >\n                ";
    echo $LNG["paid"];
    echo "                </label>\n                </span>\n\n              </td>\n            </tr>\n\n           <tr class=\"dueselect\">\n               <td class=\"fieldlabel\">\n                      ";
    echo $LNG["due"];
    echo " ";
    echo $LNG["days"];
    echo "               </td>\n               <td class=\"fieldarea\">\n                     <select name=\"duedays\" onchange=\"getCustomVal(this.value);\">\n                        <option value=\"1\">1 ";
    echo $LNG["days"];
    echo "</option>\n                        <option value=\"2\">2 ";
    echo $LNG["days"];
    echo "</option>\n                        <option value=\"5\">5 ";
    echo $LNG["days"];
    echo "</option>\n                        <option value=\"7\">";
    echo $LNG["one"];
    echo " ";
    echo $LNG["week"];
    echo "</option>\n                        <option value=\"15\">15 ";
    echo $LNG["days"];
    echo "</option>\n                        <option value=\"30\">";
    echo $LNG["one"];
    echo " ";
    echo $LNG["month"];
    echo "</option>\n                        <option value=\"99\">";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["date"];
    echo "</option>\n                     </select>\n\n               <input type=\"text\" autocomplete=\"off\" name=\"duedate\" style=\"width: 100px;display: none;\"\n                id=\"duedate\" value=\"\" class=\"datepicker\" placeholder=\"yyyy-mm-dd\" />\n\n               </td>\n           </tr>\n\n           <tr class=\"payments\">\n              <td  class=\"fieldlabel\">Payment Gateway</td>\n              <td  class=\"fieldarea \">\n                    <select onchange=\"calcFees(this.value)\" name=\"paymentgateway\">\n                        <option value=\"\">Select</option>\n    ";
    require_once ROOTDIR . "/includes/gateway.fun.php";
    $gatewaysarray = getGatewaysArray();
    foreach ($gatewaysarray as $gae => $gname) {
        echo "        <option value=\"";
        echo $gae;
        echo "\">";
        echo $gname;
        echo "</option>\n    ";
    }
    echo "                    </select>\n\n               </td>\n            </tr>\n\n           <tr  class=\"payments\">\n              <td  class=\"fieldlabel\">Transaction ID\n              </td>\n              <td  class=\"fieldarea\">\n<input name=\"transactionid\"  id=\"transactionid\" value=\"\" type=\"text\"\n class=\"small_txt\"/>\n              </td>\n            </tr>\n              <tr  class=\"payments\">\n                  <td  class=\"fieldlabel\">Fees\n                  </td>\n                  <td  class=\"fieldarea\">\n                      <input name=\"fees\"  id=\"fees\" value=\"\" type=\"text\"\n                             class=\"small_txt\"/>\n                  </td>\n              </tr>\n\n              <tr>\n              <td  class=\"fieldlabel\">";
    echo $LNG["creditbalance"];
    echo "                ";
    echo $LNG["validity"];
    echo "              </td>\n              <td  class=\"fieldarea\"><input name=\"creditvalidity\"  value=\"\" type=\"text\" class=\"small_txt\"/>\n                <br />\n                <small> 0 -\n                ";
    echo $LNG["lifetime"];
    echo "                , # -\n                ";
    echo $LNG["no"];
    echo "                ";
    echo $LNG["of"];
    echo "                ";
    echo $LNG["days"];
    echo "                </small> </td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\">";
    echo $LNG["admin"];
    echo "                ";
    echo $LNG["note"];
    echo "</td>\n              <td  class=\"fieldarea\"><textarea name=\"admin_notea\"></textarea></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\">";
    echo $LNG["user"];
    echo "                ";
    echo $LNG["note"];
    echo "</td>\n              <td  class=\"fieldarea\"><textarea name=\"user_note\"></textarea></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input type=\"checkbox\" id=\"sendmailca\" name=\"sendmailca\" checked=\"checked\"/>\n                <label for=\"sendmailca\">Send Financial Information Via Mail</label></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input value=\"";
    echo $LNG["add"];
    echo "\"\n                id=\"btnedituser1\" class=\"btn save\"\n                type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','edituser.accountfinancial','#frmedituser','#notification','true','#main_loader');\$('#creditleft').val(''); \$('#transactionid').val('');\"/>\n";
    if ($clientDetails["credit_validity"]) {
        echo "<input value=\"";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["expiry"];
        echo "\" id=\"btnedituser24\"\nclass=\"button_remove\" type=\"button\"\nonclick=\"SubmitForm ('#btnedituser24','edituser.removeexpiry','#frmedituser','#notification','true','#main_loader');\"/>\n";
    }
    echo "                </td>\n            </tr>\n          </table>\n        </div>\n\n\n        <div id=\"rebatecredit\" class=\"pc\">\n\n          <table class=\"form\">\n            <tr>\n              <td  class=\"fieldlabel\">\n                ";
    echo $LNG["credit"];
    echo "                </td>\n              <td  class=\"fieldarea\"> <span style=\"font-size:20px\"> ";
    echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
    echo " </span> &nbsp;&nbsp;  <span style=\"font-size: 16px;color: red;\">-</span>  &nbsp;&nbsp;\n              <input name=\"rebatecredit\"  style=\"background: #f4f4f4;width:100px\" value=\"\" id=\"rebatecredit\" type=\"text\" class=\"small_txt rebatecredit-icon\" onKeyPress=\"blank('creditleft')\" onKeyUp=\"\$('#ccr').text(parseFloat(\$('#cc').val())-parseFloat(this.value));return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n               = <span id=\"ccr\" style=\"font-size: 16px;\"> ";
    echo $clientDetails["credit"]["credit"];
    echo " </span>\n                ";
    $sql = dquery("select id,total from tbl_invoices where adminid!='' and status='Unpaid' and userid='" . $id . "'");
    echo "\n        </td>\n            </tr>\n\n           <tr>\n              <td  class=\"fieldlabel\">Rebate credit from</td>\n              <td  class=\"fieldarea\">\n                <select name=\"invoice\">\n                  <option value=\"\"> select invoice</option>\n                  ";
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "                  <option value=\"";
        echo $row["id"];
        echo "\">\n                  ";
        echo "# " . $row["id"] . " - ";
        echo "                  ";
        echo formatCurrency($row["total"], $clientDetails["currency"]);
        echo "                  </option>\n                  ";
    }
    echo "                </select>\n                <small>\n                ";
    echo $LNG["selectinvoicetorebate"];
    echo "                </small>\n              </td>\n            </tr>\n\n            <tr>\n              <td  class=\"fieldlabel\">";
    echo $LNG["admin"];
    echo "                ";
    echo $LNG["note"];
    echo "</td>\n              <td  class=\"fieldarea\"><textarea name=\"admin_noter\"></textarea></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\">";
    echo $LNG["user"];
    echo "                ";
    echo $LNG["note"];
    echo "</td>\n              <td  class=\"fieldarea\"><textarea name=\"user_noter\"></textarea></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input type=\"checkbox\" id=\"sendmailcr\" name=\"sendmailcr\" checked=\"checked\"/>\n                <label for=\"sendmailcr\">Send Financial Information Via Mail</label></td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input value=\"";
    echo $LNG["rebate"];
    echo "\" id=\"btnedituser2\" class=\"button_remove\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser2','edituser.accountfinancial','#frmedituser','#notification','true','#main_loader');\$('#rebatecredit').val('');\"/></td>\n            </tr>\n          </table>\n        </div>\n        <div class=\"clear\"></div>\n      </div>\n\n\n\n  <div id=\"saddcredit\" class=\"pc\">\n      ";
    if ($clientDetails["usertype"] == "1" && !$OnlyEcommerce) {
        echo "\n      <div class=\"groupstabescontant\">\n        <div>\n          <table class=\"form\">\n            <tr>\n                <td class=\"fieldlabel\"></td>\n                <td class=\"fieldarea\" style=\"color: #ccc;\">Only for reseller account</td>\n            </tr>\n            <tr>\n              <td class=\"fieldlabel\"> Credit </td>\n              <td  class=\"fieldarea\">  <span style=\"color:font-size:20px\">  ";
        echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
        echo " </span> &nbsp;&nbsp; <span style=\"font-size: 16px;color:#479612;\">+</span> &nbsp;&nbsp;\n              <input style=\"background: #f4f4f4;width:100px\" name=\"sellcreditlimit\" id=\"sellcreditlimit\" value=\"\" type=\"text\" class=\"small_txt\" onKeyPress=\"blank('rebatesellcredit')\" onKeyUp=\"\$('#csa').text(parseFloat(\$('#cs').val())+parseFloat(this.value));return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n               = <span id=\"csa\" style=\"font-size: 16px;\"> ";
        echo $clientDetails["credit"]["selling_limit"];
        echo " </span>\n              </td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input type=\"checkbox\" id=\"sendmailsa\" name=\"sendmailsa\" checked=\"checked\"/>\n                <label for=\"sendmailsa\">Send Financial Information Via Mail</label>\n              </td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\">\n<input value=\"";
        echo $LNG["add"];
        echo "\" id=\"btnedituser3\" class=\"btn save\" type=\"button\"\nonclick=\"SubmitForm ('#btnedituser3','edituser.accountfinancial','#frmedituser','#notification','true','#main_loader');\$('#sellcreditlimit').val('');\$('#transactionid').val('');\"/>\n              </td>\n            </tr>\n          </table>\n        </div>\n</div>\n\n</div>\n\n<div id=\"srebatecredit\" class=\"pc\">\n\n          <table class=\"form\">\n            <tr>\n                <td class=\"fieldlabel\"></td>\n                <td class=\"fieldarea\" style=\"color: #ccc;\">Only for reseller account</td>\n            </tr>\n            <tr>\n              <td class=\"fieldlabel\"> Credit </td>\n              <td  class=\"fieldarea\">  <span style=\"color:font-size:20px\"> <span style=\"\">  ";
        echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
        echo " </span> &nbsp;&nbsp; <span style=\"font-size: 16px;color:red\">-</span> &nbsp;&nbsp;\n                <input style=\"background: #f4f4f4;width:100px\" name=\"rebatesellcredit\" id=\"rebatesellcredit\" value=\"\" type=\"text\" class=\"small_txt\" onKeyPress=\"blank('sellcreditlimit')\" onKeyUp=\"\$('#csr').text(parseFloat(\$('#cs').val())-parseFloat(this.value));return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n                = <span id=\"csr\" style=\"font-size: 16px;\"> ";
        echo $clientDetails["credit"]["selling_limit"];
        echo " </span>\n              </td>\n            </tr>\n            <tr>\n              <td  class=\"fieldlabel\"></td>\n              <td  class=\"fieldarea\"><input type=\"checkbox\" id=\"sendmailsr\" name=\"sendmailsr\" checked=\"checked\"/>\n                <label for=\"sendmailsr\">Send Financial Information Via Mail</label>\n              </td>\n            </tr>\n            <tr>\n              <td class=\"fieldlabel\"></td>\n              <td class=\"fieldarea\"><input value=\"";
        echo $LNG["rebate"];
        echo "\" id=\"btnedituser4\" class=\"button_remove\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser4','edituser.accountfinancial','#frmedituser','#notification','true','#main_loader');\$('#rebatesellcredit').val('');\"/></td>\n            </tr>\n          </table>\n        </div>\n        <div class=\"clear\"></div>\n        ";
    }
    echo "<!--\n<p class=\"fixedbtn\"> <input value=\"";
    echo $LNG["save"];
    echo " ";
    echo $LNG["all"];
    echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituser.accountfinancial','#frmedituser','#notification','true','#main_loader');\"/></p>\n-->\n\n\n\n</div>\n\n    </form>\n";
} else {
    echo "<div id=notification1 class=info>" . $LNG["logineedres"] . " <br />\n    " . $LNG["reseller"] . " :<a href='javascript:void(0)' \n    onclick='javascript:parent.load_page(\"edituser&id=" . $clientDetails["reseller_id"] . "\",\"" . $clientDetails["reseller_details"]["username"] . "\",\"\")'>" . $clientDetails["reseller_details"]["username"] . "</a></div>";
}
echo "\n<script>\n    ";
if ($ptype === "rebate") {
    echo "    setTimeout(()=>{\n        \$('#mtype input[type=\"checkbox\"]#rebatecr').click()\n    },200)\n    ";
}
echo "</script>\n\n";
$fileverioncheck = "6.1.0";

?>