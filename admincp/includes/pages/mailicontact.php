<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 543;
checkPagePermission($pageid);
echo "<script>\nfunction synchronizeIcontact(){\n    \$(\"#main_loader\").show();\n    \$.post(\"includes/pages/icontactsynch.php\", function(data) {\n        \$(\"#synchreport\").html(data);\n        \$(\"#main_loader\").hide();\n    });\n}\n</script>\n<script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/progressbar.js\" type=\"text/javascript\"></script>\n<script>\nfunction sync_load_page(pagename) {\n    var newsl;\n    var confr;\n    if(document.getElementById('fl').checked==true){ newsl=true; } else { newsl=false; }\n\n    \$(\"#sync_status\").show();\n\t\$(\"#sync_iframe\").show();\n\t\$(\"#sync_button\").hide();\n    \$(\"#sync_iframe\").src(pagename+'?newsletter='+newsl+'&unscr='+confr , function(duration){\n\t\t\t\$(\"#sync_status\").hide();\n\t\t\tdisablescroll();\n\t\t\t\$(\"#sync_button\").show();\n      \t}\n    );\n}\n</script>\n\n<style>\n/* progress bar container */\n#progressbar{\n        border:1px solid black;\n        width:200px;\n        height:20px;\n        position:relative;\n        color:black;\n}\n/* color bar */\n#progressbar div.progress{\n        position:absolute;\n        width:0;\n        height:100%;\n        overflow:hidden;\n        background-color:#369;\n}\n/* text on bar */\n#progressbar div.progress .text{\n        position:absolute;\n        text-align:center;\n        color:white;\n}\n/* text off bar */\n#progressbar div.text{\n        position:absolute;\n        width:100%;\n        height:100%;\n        text-align:center;\n}\n</style>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Instruction</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n1. <a target=\"_blank\" href=\"https://www.icontact.com/email-marketing-solution/signup2\">Click here to Signup</a><br />\n2. Open Developer Panel of icontact http://developer.icontact.com<br />\n3. Login into your account and provider information <br />\n4. API Key and Account ID will display there <br />\n  </div>\n  </div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">iContact Account Information</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["account"];
echo "  ";
echo $LNG["id"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"icontact_account_id\" value=\"";
echo $config["icontact_account_id"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["key"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"icontact_api_key\" value=\"";
echo $config["icontact_api_key"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"icontact_username\" value=\"";
echo $config["icontact_username"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"icontact_api_password\" value=\"";
echo $config["icontact_api_password"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["folder"];
echo " ";
echo $LNG["id"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt medium\" name=\"icontact_folder_id\" value=\"";
echo $config["icontact_folder_id"];
echo "\" />\n    <br />\n    <small>";
echo $LNG["optional"];
echo " ";
echo $LNG["required"];
echo "  ";
echo $LNG["for"];
echo "     ";
echo $LNG["synchronize"];
echo "  ";
echo $LNG["without"];
echo "  ";
echo $LNG["login"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\">\n  <input type=\"checkbox\" name=\"chimpnewsletter\" value=\"1\" checked=\"checked\" id=\"fl\" /> <label for=\"fl\"> Synchronize Newsletter Users</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\">\n <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','basicmail','#frm','#notification','true','#main_loader');\"/>\n<input value=\"";
echo $LNG["start"];
echo " ";
echo $LNG["synchronize"];
echo "\"\nid=\"btnasr\"\nclass=\"btn\" type=\"button\"\n onclick=\"sync_load_page('includes/pages/icontactsynch.php');initscroll();\" />\n    </td>\n</tr>\n</tbody>\n</table>\n\n<div id=\"synchreport\">\n</div>\n\n\n<div id=\"sync_status\" style=\"display:none; width: 100% !important;\">\n<br /><img  src=\"images/syncloader.gif\" border=\"0\" /><br /> <h3 class=\"textred\">please do not close until Synchronize completed</h3> <br /> </div><br />\n<iframe id=\"sync_iframe\" scrolling=\"auto\" style=\"border:1px solid #CCC; display:none; width:100%; height: 300px;position: relative;\" src=\"\"></iframe>\n<script>\n\$(\"#progressbar\").reportprogress(10);\n\n    var sync_iframe;\n    var dwindow;\n    var dbody;\n    var ns = 2000000;\n    var scrolltimer;\n    var doscroll=1;\n    function disablescroll() {\n        clearInterval(scrolltimer);    doscroll=0;\n    }\n    function initscroll () {\n    \tsync_iframe = document.getElementById('sync_iframe');\n    \tif (sync_iframe.window)\n    \t{ dwindow=sync_iframe.document.window; }\n        else if (sync_iframe.contentWindow)\n    \t{ dwindow=sync_iframe.contentWindow; }\n\n    \tif (sync_iframe.document) { dbody=sync_iframe.document.body; }\n    \telse if (sync_iframe.contentDocument) { dbody=sync_iframe.contentDocument.body; }\n        checkscroll();\n    \tscrolltimer = setInterval(checkscroll,500);\n    }\n    function checkscroll() {\n    \tif (!doscroll) { return;\n    \t}\n        dwindow.scroll(0,dbody.offsetHeight);\n    \tdwindow.scroll(0,ns++);\n    }\n</script>\n\n\n\n</form>\n</div></div>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>