<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 32;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
$html = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='htmlcode'"));
echo "<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<div >\n  <h2>\n    <span class=\"groupstabesheadertext\">Site Information</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n\n                <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["companyname"];
echo "</td>\n                <td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" class=\"txt large\" name=\"companyname\" value=\"";
echo $config["companyname"];
echo "\" /> <small>";
echo $LNG["companynameinfo"];
echo "</small></td>\n                </tr>\n\n                <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["sitename"];
echo "</td>\n                <td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" name=\"config_site_name\" value=\"";
echo $config["config_site_name"];
echo "\" /> </td>\n                </tr>\n                <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["logolink"];
echo "</td>\n                <td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" name=\"logo_link\" id=\"logolink\" value=\"";
echo $config["logo_link"];
echo "\" /> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onClick=\"newWindow('includes/gallery.php?id=logolink', 'windowname1')\" />\n     <br /><small>";
echo $LNG["logolinkinfo"];
echo "</small>  </td>\n                </tr>\n             <tr>\n                 <td class=\"fieldlabel\">Favicon ";
echo $LNG["icon"];
echo "</td>\n                 <td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" name=\"faviconicon\" id=\"faviconicon\" value=\"";
echo $config["faviconicon"];
echo "\" /> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onClick=\"newWindow('includes/gallery.php?id=faviconicon', 'windowname1')\" />\n                     <br /><small>64 Kb PNG image recommended </small>  </td>\n             </tr>\n\n         </table>\n  </div>\n</div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">Site Links</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n\n                <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["sitelink"];
echo "</td>\n                <td class=\"fieldarea\"><input type=\"text\" class=\"txt large\" name=\"site_address\" value=\"";
echo $config["site_address"];
echo "\" /> <small>";
echo $LNG["urldhrufusioninfo"];
echo " </small> </td>\n                </tr>\n\n                <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["sitessl"];
echo "</td>\n                <td class=\"fieldarea\"><input type=\"text\" class=\"txt large\" name=\"config_ssl_allow\" value=\"";
echo $config["config_ssl_allow"];
echo "\" /> <small>";
echo $LNG["urlsslinfo"];
echo "</small>  </td>\n                </tr>\n\n         </table>\n   </div>\n</div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">SEO Settings</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["seofriendly"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  name=\"cms_seofriendly\" value=\"on\" id=\"see\" ";
if ($config["cms_seofriendly"] == "on") {
    echo "checked";
}
echo " /><label for=\"see\"></label>\n            <small>";
echo $LNG["reqhtaccess"];
echo "</small>\n            </td>\n        </tr>\n         <tr>\n            <td class=\"fieldlabel\"> ";
echo $LNG["page"];
echo " ";
echo $LNG["title"];
echo " ";
echo $LNG["format"];
echo "</td>\n            <td class=\"fieldarea\">\n<select name=\"page_title_format\">\n  <option ";
if (!$config["page_title_format"]) {
    echo "selected='selected'";
}
echo " value=\"\">Default</option>\n  <option ";
if ($config["page_title_format"] == "type1") {
    echo "selected='selected'";
}
echo " value=\"type1\">Shop name :: Category name :: Product name</option>\n  <option ";
if ($config["page_title_format"] == "type2") {
    echo "selected='selected'";
}
echo "  value=\"type2\">Product name :: Category name :: Shop name</option>\n  <option ";
if ($config["page_title_format"] == "type3") {
    echo "selected='selected'";
}
echo "  value=\"type3\">Category name :: Product name</option>\n  <option ";
if ($config["page_title_format"] == "type4") {
    echo "selected='selected'";
}
echo "  value=\"type4\">Product name :: Category name</option>\n</select>\n            </td>\n        </tr>\n\n        <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["sitedesc"];
echo "</td>\n        <td class=\"fieldarea\"><textarea name=\"site_description\" class=\"textarea large\">";
echo $config["site_description"];
echo "</textarea>  <small>";
echo $LNG["metataginfo"];
echo "</small></td>\n        </tr>\n\n        <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["sitekeywords"];
echo "</td>\n        <td class=\"fieldarea\"><textarea name=\"sitekeywords\" class=\"textarea large\">";
echo $config["sitekeywords"];
echo "</textarea></td>\n        </tr>\n\n        </table>\n  </div>\n </div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">Site Settings</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["fasterbrowse"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"faster_browsing_mode\" value=\"1\" id=\"fbme\" ";
if ($config["faster_browsing_mode"]) {
    echo "checked";
}
echo " /><label for=\"fbme\"></label>            </td>\n        </tr>\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["rechargevoucher"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"voucher\" value=\"1\" id=\"ve\" ";
if ($config["voucher"]) {
    echo "checked";
}
echo " /><label for=\"ve\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["testimonial"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"testimonial\" value=\"1\" id=\"tee\" ";
if ($config["testimonial"]) {
    echo "checked";
}
echo "  /><label for=\"tee\"></label>\n            </td>\n        </tr>\n\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["blog"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"blog\" value=\"1\" id=\"ble\" ";
if ($config["blog"]) {
    echo "checked";
}
echo "   /><label for=\"ble\"></label>\n            </td>\n        </tr>\n        <!--\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["quickaccess"];
echo " ";
echo $LNG["menu"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"config_recent_menu\" value=\"1\" id=\"rec\" ";
if ($config["config_recent_menu"]) {
    echo "checked";
}
echo "   /><label for=\"rec\"></label>\n            </td>\n        </tr>\n        -->\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["knowledgebase"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"faq\" id=\"faqe\" value=\"1\" ";
if ($config["faq"]) {
    echo "checked";
}
echo "  /><label for=\"faqe\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["support"];
echo " ";
echo $LNG["ticket"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"supportticketservice\" id=\"sqe\" value=\"1\" ";
if ($config["supportticketservice"]) {
    echo "checked";
}
echo "  /><label for=\"sqe\"></label>\n            </td>\n        </tr>\n\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["show"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"displayprice\" id=\"dhe\" value=\"1\" ";
if ($config["displayprice"]) {
    echo "checked";
}
echo "  /><label for=\"dhe\"></label>\n            </td>\n        </tr>\n  <!--\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["facebook"];
echo " ";
echo $LNG["like"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"facebooklike\" id=\"fhe\" value=\"1\" ";
if ($config["facebooklike"]) {
    echo "checked";
}
echo "  /><label for=\"fhe\"></label>\n            </td>\n        </tr>\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["google"];
echo " +1 ";
echo $LNG["like"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"googlelike\" id=\"gphe\" value=\"1\" ";
if ($config["googlelike"]) {
    echo "checked";
}
echo "  /><label for=\"gphe\"></label>\n            </td>\n        </tr>\n              -->\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["affiliate"];
echo " ";
echo $LNG["system"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"affiliate\" id=\"afe\" value=\"1\" ";
if ($config["affiliate"]) {
    echo "checked";
}
echo "  /><label for=\"afe\"></label>\n            </td>\n        </tr>\n        <!--\n        <tr>\n            <td class=\"fieldlabel\">Wiki ";
echo $LNG["help"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"wikihelp\" id=\"wfe\" value=\"1\" ";
if ($config["wikihelp"]) {
    echo "checked";
}
echo "  /><label for=\"wfe\"></label>\n            </td>\n        </tr>\n         -->\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["giftcerti"];
echo "</td>\n            <td class=\"fieldarea\" class=\"\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"giftcerti\" id=\"gtfe\" value=\"1\" ";
if ($config["giftcerti"]) {
    echo "checked";
}
echo "  /><label for=\"gtfe\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["giftcerti"];
echo " ";
echo $LNG["tax"];
echo "</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"giftvoucher_tax\" id=\"txfe\" value=\"1\" ";
if ($config["giftvoucher_tax"]) {
    echo "checked";
}
echo "  /><label for=\"txfe\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["withdrawal"];
echo " ";
echo $LNG["request"];
echo "</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"withdrawal_req\" id=\"wtfe\" value=\"1\" ";
if ($config["withdrawal_req"]) {
    echo "checked";
}
echo "  /><label for=\"wtfe\"></label>\n            </td>\n        </tr>\n\n         <tr>\n            <td class=\"fieldlabel\">EU Cookie Law</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"eucookielaw\"\n id=\"eucfe\" value=\"1\" ";
if ($config["eucookielaw"]) {
    echo "checked";
}
echo "  /><label for=\"eucfe\"></label>\n            </td>\n        </tr>\n             <!--\n               <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["dashboard"];
echo " Mode</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Light', labelOff: 'Advance'}\" name=\"litedashboard\"\n id=\"dscfe\" value=\"1\" ";
if ($config["litedashboard"]) {
    echo "checked";
}
echo "  /><label for=\"dscfe\"></label>\n            </td>\n        </tr> -->\n\n\n         <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["email"];
echo " ";
echo $LNG["history"];
echo " ";
echo $LNG["save"];
echo "</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"mail_history\"\n id=\"emcfe\" value=\"1\" ";
if ($config["mail_history"]) {
    echo "checked";
}
echo "  /><label for=\"emcfe\"></label>\n            </td>\n        </tr>\n\n\n         <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " can ";
echo $LNG["manage"];
echo " Credit Card ";
echo $LNG["detail"];
echo "</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"ccdetails\"\n id=\"cccfe\" value=\"1\" ";
if (!$config["ccdetails"]) {
    echo "checked";
}
echo "  /><label for=\"cccfe\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">Mobile App</td>\n            <td class=\"fieldarea\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"installapp\"\n id=\"instpp\" value=\"111\" ";
if (!$config["installapp"]) {
    echo "checked";
}
echo "  /><label for=\"instpp\"></label>\n            </td>\n        </tr>\n\n\n\n              <!--\n        <tr>\n            <td class=\"fieldlabel\">\n            ";
echo $LNG["display"];
echo " ";
echo $LNG["quick"];
echo " ";
echo $LNG["news"];
echo "</td>\n            <td class=\"fieldarea\">\n <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n name=\"quicknews\" id=\"aloves\" value=\"1\" ";
if ($config["quicknews"]) {
    echo "checked";
}
echo "  />\n <label for=\"aloves\"></label>\n            </td>\n        </tr>\n        -->\n        <tr>\n            <td class=\"fieldlabel\">\n            ";
echo $LNG["display"];
echo " Track ";
echo $LNG["order"];
echo "</td>\n            <td class=\"fieldarea\">\n <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n name=\"trackorder\" id=\"tracks\" value=\"1\" ";
if ($config["trackorder"]) {
    echo "checked";
}
echo "  />\n <label for=\"tracks\"></label>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">\n            ";
echo $LNG["display"];
echo "  ";
echo $LNG["download"];
echo "s</td>\n            <td class=\"fieldarea\">\n <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n name=\"downloads\" id=\"dws\" value=\"1\" ";
if ($config["downloads"]) {
    echo "checked";
}
echo "  />\n <label for=\"dws\"></label>\n            </td>\n        </tr>\n\n\n\n\n             <!--\n                     <tr>\n                         <td class=\"fieldlabel\"> ";
echo displayNew("3.1", "RC5");
echo "                         Gravatar</td>\n                         <td class=\"fieldarea\">\n              <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n              name=\"gravatar\" id=\"gswr\" value=\"1\" ";
if ($config["gravatar"]) {
    echo "checked";
}
echo "  />\n              <label for=\"gswr\"></label>\n\n              <small>display Avtar image from gravatar.com</small>\n                         </td>\n                     </tr>\n             -->\n\n\n         </table>\n   </div>\n</div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">Site Page Redirect</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n<!--             <tr>-->\n<!--                 <td class=\"fieldlabel\">-->\n<!--                     --><!--  Captcha</td>-->\n<!--                 <td class=\"fieldarea\">-->\n<!--                     <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"-->\n<!--                            name=\"captchaoncontact\" id=\"dwss\" value=\"1\" --><!--  />-->\n<!--                     <label for=\"dwss\"></label>-->\n<!--                 </td>-->\n<!--             </tr>-->\n\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["indexredirectmsg"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"text\" class=\"txt large\" name=\"Index_page_redirect\" value=\"";
echo $config["Index_page_redirect"];
echo "\" /> <small>";
echo $LNG["indexredirect"];
echo "</small>\n            </td>\n        </tr>\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["logoutredirectmsg"];
echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"text\" class=\"txt large\" name=\"logout_page_redirect\" value=\"";
echo $config["logout_page_redirect"];
echo "\" /> <small>";
echo $LNG["logoutredirect"];
echo "</small>\n            </td>\n        </tr>\n         </table>\n   </div>\n</div>\n\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">Fund Settings</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n            <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["addfund"];
echo " </td>\n                <td class=\"fieldarea\">\n                <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"addfund\" id=\"ade\" value=\"1\" ";
if ($config["addfund"]) {
    echo "checked";
}
echo "  /><label for=\"ade\"></label>\n                <small>";
echo $LNG["adddingfund"];
echo "</small><br />\n                </td>\n            </tr>\n\n            <tr>\n                <td class=\"fieldlabel\"> Tax for add fund </td>\n                <td class=\"fieldarea\">\n                <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" id=\"enabd\" name=\"fundtax\"  ";
if ($config["AddFunds_taxenabled"]) {
    echo "checked";
}
echo " /><small>";
echo $LNG["enabletaxaddfund"];
echo "</small>\n                </td>\n            </tr>\n\n\n            <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["minaddfund"];
echo " </td>\n                <td class=\"fieldarea\">\n            <input type=\"text\" class=\"txt small\"  name=\"AddFundsMinimum\" value=\"";
echo $config["AddFundsMinimum"];
echo "\" />\n                    <a class=\"default_dg_a2\" href=\"javascript: void(0)\" onclick=\"load_subpage('main2.php?page=addfundothergateway&min=1', 'Add Fund Other Gateway');\n  return false;\">";
echo $LNG["set"];
echo " ";
echo $LNG["minimum"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["limit"];
echo " ";
echo $LNG["payment"];
echo " ";
echo $LNG["gateway"];
echo " ";
echo $LNG["wise"];
echo "</a>\n                    <small>";
echo $LNG["addfundmininfo"];
echo "</small>\n                </td>\n            </tr>\n\n\n            <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["maxaddfund"];
echo "  </td>\n                <td class=\"fieldarea\">\n                <input type=\"text\" class=\"txt small\" name=\"AddFundsMaximum\" value=\"";
echo $config["AddFundsMaximum"];
echo "\" />\n\n                    <a class=\"default_dg_a2\" href=\"javascript: void(0)\" onclick=\"load_subpage('main2.php?page=addfundothergateway', 'Add Fund Other Gateway');\n      return false;\">";
echo $LNG["set"];
echo " ";
echo $LNG["maximum"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["limit"];
echo " ";
echo $LNG["payment"];
echo " ";
echo $LNG["gateway"];
echo " ";
echo $LNG["wise"];
echo "</a>\n\n                    <small>";
echo $LNG["addfundmaxinfo"];
echo "</small>    </td>\n            </tr>\n\n\n             <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["maxbalance"];
echo " </td>\n                <td class=\"fieldarea\">\n            <input type=\"text\" class=\"txt small\" name=\"AddFundsMaximumBalance\" value=\"";
echo $config["AddFundsMaximumBalance"];
echo "\" /> <small>";
echo $LNG["addfundminbal"];
echo "</small>\n                </td>\n            </tr>\n\n         </table>\n   </div>\n</div>\n\n\n <!--\n<div  class=\"groupstabes\" >\n  <h2>\n\n    <span class=\"groupstabesheadertext\">Page Records</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n         <table class=\"form\">\n            <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["products"];
echo " ";
echo $LNG["perpage"];
echo " </td>\n            <td class=\"fieldarea\">\n                    <input type=\"text\" class=\"txt small\"  name=\"cart_page_limit\" value=\"";
echo $config["cart_page_limit"];
echo "\" /> <small>";
echo $LNG["cart"];
echo " ";
echo $LNG["items"];
echo " ";
echo $LNG["perpage"];
echo "</small>\n            </td>\n            </tr>\n\n       <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["data"];
echo " ";
echo $LNG["list"];
echo " per ";
echo $LNG["page"];
echo "</td>\n            <td class=\"fieldarea\">\n                    <input type=\"text\" class=\"txt small\"\n                    name=\"adminlistlimit\"\n                    value=\"";
echo $config["adminlistlimit"];
echo "\" /> <small>";
echo $LNG["recordpage"];
echo " Minimum 10 will display if not set</small>\n            </td>\n            </tr>\n\n            <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["nodisplayitem"];
echo " </td>\n            <td class=\"fieldarea\">\n                    <input type=\"text\" class=\"txt small\"\n                    name=\"default_page_limit\"\n                    value=\"";
echo $config["default_page_limit"];
echo "\" /> <small>";
echo $LNG["recordpage"];
echo "</small>\n            </td>\n            </tr>\n\n            <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["blogpostperpage"];
echo " </td>\n            <td class=\"fieldarea\">\n                 <input type=\"text\" class=\"txt small\"  name=\"BlogPostsperpage\" value=\"";
echo $config["BlogPostsperpage"];
echo "\" /> <small>";
echo $LNG["blogperpage"];
echo "</small>\n            </td>\n            </tr>\n            <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["activitylog"];
echo "  </td>\n            <td class=\"fieldarea\">\n                 <input type=\"text\" class=\"txt small\" name=\"ActivityLogLimit\" value=\"";
echo $config["ActivityLogLimit"];
echo "\" /> <small>";
echo $LNG["activitylog"];
echo "</small>      </td>\n            </tr>\n         </table>\n   </div>\n</div>\n-->\n\n\n</form>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','generalsetting','#frm','#notification','true','#main_loader');\"/></p>\n</div></div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/General-Settings/?aid=5&cid=2&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>