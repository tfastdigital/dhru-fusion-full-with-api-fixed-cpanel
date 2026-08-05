<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n<script>\nfunction synchronizeIcontact(){\n    \$(\"#main_loader\").show();\n    \$.post(\"includes/pages/icontactsynch.php?mailchimp=true\", function(data) { \n        \$(\"#synchreport\").html(data);\n        \$(\"#main_loader\").hide(); \n    });\n}\n</script>\n<script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\t\n<script src=\"includes/js/progressbar.js\" type=\"text/javascript\"></script>\n<script>\nfunction sync_load_page(pagename) {\n    var newsl;\n    var confr;\n    if(document.getElementById('fl').checked==true){ newsl=true; } else { newsl=false; }\n    if(document.getElementById('fl').checked==true){ confr=true; } else { confr=false; }\n    \n    var sg=\$(\"#syncgroup\").val();\n    \$(\"#sync_status\").show();\n\t\$(\"#sync_iframe\").show();\n\t\$(\"#sync_button\").hide();\n    \$(\"#sync_iframe\").src(pagename+'?newsletter='+newsl+'&unscr='+confr+'&syncgroup='+sg , function(duration){\n\t\t\t\$(\"#sync_status\").hide();\n\t\t\tdisablescroll();\n\t\t\t\$(\"#sync_button\").show();\n      \t}\n    );\n}\n</script>\n\n<style>\n/* progress bar container */\n#progressbar{\n        border:1px solid black;\n        width:200px;\n        height:20px;\n        position:relative;\n        color:black; \n}\n/* color bar */\n#progressbar div.progress{\n        position:absolute;\n        width:0;\n        height:100%;\n        overflow:hidden;\n        background-color:#369;\n}\n/* text on bar */\n#progressbar div.progress .text{\n        position:absolute;\n        text-align:center;\n        color:white;\n}\n/* text off bar */\n#progressbar div.text{\n        position:absolute;\n        width:100%;\n        height:100%;\n        text-align:center;\n}\n</style>\n";
$pageid = 545;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
unset($_SESSION["chimplimit"]);
echo "<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Instruction</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n1.     <a target=\"_blank\" href=\"https://campaigns.zoho.com/\">Click here to sign-up</a> <br />\n2. after sing-up go Settings >  APIs  & Generate API Authentication Token<br />\n3. Get your api token<br />\n4. Go Contacts > List Management > Create List<br />\n5. Go to Perticular List > List Tools <br />\n6. and get your List Key<br />\n  </div></div>\n \n <div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Zoho Account Information</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\"> \n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">Authentication  Token </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt large\" name=\"zohokey\" \n    value=\"";
echo $config["zohokey"];
echo "\" /> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> ";
echo $LNG["list"];
echo " ";
echo $LNG["key"];
echo "  </td> \n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt large\" name=\"zoholist\"\n     value=\"";
echo $config["zoholist"];
echo "\" /> \n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td> \n    <td class=\"fieldarea\">\n  <input type=\"checkbox\" name=\"zohonewsletter\" value=\"1\"\n   checked=\"checked\" id=\"fl\" /> <label for=\"fl\"> Synchronize Newsletter Users</label>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td> \n    <td class=\"fieldarea\">\n <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settingappear','#frm','#notification','true','#main_loader');\"/>\n<input value=\"";
echo $LNG["start"];
echo " ";
echo $LNG["synchronize"];
echo "\" id=\"btnasr\" class=\"btn\" type=\"button\" onclick=\"sync_load_page('includes/pages/zoho.sync.php');initscroll();\" />\n<select name=\"syncgroup\" id=\"syncgroup\">\n<option value=\"ALL\">Sync All Clients</option>\n";
$b = dquery("select * from tbl_client_group order by displayorder asc");
while ($rb = mysqli_fetch_assoc($b)) {
    echo "    <option ";
    echo $selected;
    echo " value=\"";
    echo $rb["id"];
    echo "\">";
    echo $rb["groupname"];
    echo "</option>\n    ";
}
echo "</select>   \n    </td>\n    <!--onclick=\"javascript: synchronizeIcontact();\"-->\n\n</tr>\n</tbody>\n</table>\n \n<div id=\"synchreport\">\n</div>\n\n<div id=\"sync_status\" style=\"display:none; width: 100% !important;\">\n\n<br /><img  src=\"images/syncloader.gif\" border=\"0\" /><br /> <h3 class=\"textred\">please do not close until Synchronize completed</h3> <br /> </div><br />\n<iframe id=\"sync_iframe\" scrolling=\"auto\" style=\"border:1px solid #CCC; display:none; width:100%; height: 300px;position: relative;\" src=\"\"></iframe>\n\n<script>\n\$(\"#progressbar\").reportprogress(10);\n\n    var sync_iframe;\n    var dwindow;\n    var dbody;\n    var ns = 2000000;\n    var scrolltimer;\n    var doscroll=1;\n    function disablescroll() {\n        clearInterval(scrolltimer);    doscroll=0;\n    }\n    function initscroll () {\n    \tsync_iframe = document.getElementById('sync_iframe'); \n    \tif (sync_iframe.window)\n    \t{ dwindow=sync_iframe.document.window; }\n        else if (sync_iframe.contentWindow) \n    \t{ dwindow=sync_iframe.contentWindow; } \n    \t\n    \tif (sync_iframe.document) { dbody=sync_iframe.document.body; }\n    \telse if (sync_iframe.contentDocument) { dbody=sync_iframe.contentDocument.body; }    \n        checkscroll();   \n    \tscrolltimer = setInterval(checkscroll,500); \n    }\n    function checkscroll() {  \n    \tif (!doscroll) { return; \n    \t}\n        dwindow.scroll(0,dbody.offsetHeight); \n    \tdwindow.scroll(0,ns++);\n    }\n</script>\n</form>\n</div></div>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>