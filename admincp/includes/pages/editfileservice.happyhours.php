<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($config["happyhours"]) {
    echo "\n";
    $pageid = 287;
    checkPagePermission($pageid);
    include_once ROOTDIR . "/includes/apiserver.fun.php";
    $serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_services_file WHERE id='" . $id . "' "));
    include_once ROOTDIR . "/includes/fileservices.fun.php";
    $group = getFileServiceGroup();
    $md5id = md5($id);
    $fileserviceDetails = getFileServices("", $md5id);
    echo "<script>\n\n\n\nfunction mask(str,textbox,loc,delim){\n    var locs = loc.split(',');\n    for (var i = 0; i <= locs.length; i++){\n        for (var k = 0; k <= str.length; k++){\n            if (k == locs[i]){\n                if (str.substring(k, k+1) != delim){\n                    str = str.substring(0,k) + delim + str.substring(k,str.length);\n                }\n            }\n        }\n    }\n    textbox.value = str;\n}\n\nfunction disableDate(){\n    document.getElementById('from').value='';\n    document.getElementById('to').value='';\n    document.getElementById('timefrom').value='';\n    document.getElementById('timeto').value='';\n    document.getElementById('repetation').checked='';\n    document.getElementById('date').checked='';\n    document.getElementById('day').checked=true;\n    document.getElementById('active').checked=true;\n}\nfunction disableDay(){\n    for (var i = 0; i < 7; i++)\n    {\n\t   document.getElementById(i).checked = '';\n    }\n    document.getElementById('date').checked=true;\n    document.getElementById('day').checked='';\n    document.getElementById('active').checked=true;\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<input type=\"text\" style=\"display: none;\"/>\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
    echo $id;
    echo "\" name=\"id\"/>\n";
    echo generate_token("form");
    echo "\n<table class=\"form\"><tr><td class=\"fieldlabel\">Status</td><td class=\"fieldarea\">\n    <input type=\"checkbox\" id=\"hs\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"active\" name=\"status\" value=\"1\" ";
    if ($fileserviceDetails["happy_hours_start"] && $fileserviceDetails["happy_hours_end"] || $fileserviceDetails["happy_hours_weekdays"]) {
        echo "checked";
    }
    echo "/>\n</td></tr>\n</table>\n\n\n<table class=\"form hs\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n  <tbody>\n\n\n    ";
    if ($fileserviceDetails["happy_hours_start"] != "" && $fileserviceDetails["happy_hours_end"] != "") {
        $date = "checked";
        $p3 = $p2 = "style='display:none'";
    } else {
        if ($fileserviceDetails["happy_hours_weekdays"] != "") {
            $day = "checked";
            $p3 = $p1 = "style='display:none'";
        } else {
            $nocrt = "checked";
            $p1 = $p2 = "style='display:none'";
        }
    }
    echo "    ";
    $from = explode(" ", $fileserviceDetails["happy_hours_start"]);
    $to = explode(" ", $fileserviceDetails["happy_hours_end"]);
    echo "    ";
    if ($fileserviceDetails["happy_hours_repetation"] == "month") {
        $month = "checked";
    }
    echo "\n<tr>\n        <td class=\"fieldlabel\">";
    echo $LNG["promotional"];
    echo " ";
    echo $LNG["time"];
    echo " / ";
    echo $LNG["happy"];
    echo " ";
    echo $LNG["hours"];
    echo "</td>\n        <td class=\"fieldarea\">\n            <input name=\"happyhoursch\" onclick=\"\$('.p1').show();\$('.p2').hide();\$('.p3').hide();\"  value=\"date\" type=\"radio\" id=\"date\" ";
    echo $date;
    echo "/>\n            <label for=\"date\"> ";
    echo $LNG["through"];
    echo " ";
    echo $LNG["date"];
    echo "</label>\n            <input name=\"happyhoursch\" onclick=\"\$('.p1').hide();\$('.p2').show();\$('.p3').hide();\" value=\"day\" type=\"radio\" id=\"day\" ";
    echo $day;
    echo "/>\n            <label for=\"day\">  ";
    echo $LNG["through"];
    echo " ";
    echo $LNG["days"];
    echo " </label>\n            <input name=\"happyhoursch\" onclick=\"\$('.p1').hide();\$('.p2').hide();\$('.p3').show();\" value=\"nocrt\" type=\"radio\" id=\"everytim\" ";
    echo $nocrt;
    echo "/>\n            <label for=\"everytim\">";
    echo $LNG["every"];
    echo $LNG["time"];
    echo "        </td>\n    </tr>\n\n\n   <tr class=\"p1\" ";
    echo $p1;
    echo ">\n            <td class=\"fieldlabel\">";
    echo $LNG["start"];
    echo "                  ";
    echo $LNG["on"];
    echo "</td>\n            <td  class=\"fieldarea\"><input id=\"from\" class=\"datepicker\"  autocomplete=\"off\" placeholder=\"yyyy-mm-dd\"  name=\"happyhourstart\"  value=\"";
    echo $from[0];
    echo "\" type=\"text\" />\n                  <input name=\"timefrom\" id=\"timefrom\" class=\"datepicker\"  autocomplete=\"off\" type=\"text\" value=\"";
    echo $from[1];
    echo "\" style=\"width: 60px;\" onKeyUp=\"javascript:return mask(this.value,this,'2',':');\" maxlength=\"5\"/>\n               </td>\n          </tr>\n          <tr  class=\"p1\" ";
    echo $p1;
    echo ">\n            <td class=\"fieldlabel\">";
    echo $LNG["end"];
    echo "                  ";
    echo $LNG["on"];
    echo "</td>\n            <td  class=\"fieldarea\"><input id=\"to\" placeholder=\"yyyy-mm-dd\" class=\"datepicker\"  name=\"happyhourend\"  value=\"";
    echo $to[0];
    echo "\" type=\"text\" />\n                  <input name=\"timeto\" id=\"timeto\" type=\"text\" value=\"";
    echo $to[1];
    echo "\" style=\"width: 60px;\" onKeyUp=\"javascript:return mask(this.value,this,'2',':');\" maxlength=\"5\"/>\n              </td>\n          </tr>\n          <tr  class=\"p1\" ";
    echo $p1;
    echo ">\n            <td class=\"fieldlabel\"></td>\n            <td class=\"fieldarea\">\n              <input type=\"checkbox\" id=\"repetation\" name=\"repetation\" value=\"month\" ";
    echo $month;
    echo "/>\n              <label for=\"repetation\">\n                ";
    echo $LNG["repeat"];
    echo "                ";
    echo $LNG["every"];
    echo "                ";
    echo $LNG["month"];
    echo "                </label>\n             </td>\n          </tr>\n\n\n      <tr class=\"p2\" ";
    echo $p2;
    echo ">\n        <td class=\"fieldlabel\"></td>\n        <td onClick=\"disableDate();\" class=\"fieldarea\">";
    $days = explode(",", $fileserviceDetails["happy_hours_weekdays"]);
    echo "            <input type=\"checkbox\"  name=\"days['sun']\"\n            value=\"sun\" ";
    if (in_array("sun", $days)) {
        echo "checked";
    }
    echo " id=\"days['sun']\"/>\n            <label for=\"days['sun']\">\n            ";
    echo $LNG["sun"];
    echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['mon']\" value=\"mon\" ";
    if (in_array("mon", $days)) {
        echo "checked";
    }
    echo " id=\"1\"/>\n            <label for=\"1\">\n            ";
    echo $LNG["mon"];
    echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['tue']\" value=\"tue\" ";
    if (in_array("tue", $days)) {
        echo "checked";
    }
    echo " id=\"2\"/>\n            <label for=\"2\">\n            ";
    echo $LNG["tue"];
    echo "          </label>\n\n          <input type=\"checkbox\"  name=\"days['wed']\" value=\"wed\" ";
    if (in_array("wed", $days)) {
        echo "checked";
    }
    echo " id=\"3\"/>\n            <label for=\"3\">\n            ";
    echo $LNG["wed"];
    echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['thu']\" value=\"thu\" ";
    if (in_array("thu", $days)) {
        echo "checked";
    }
    echo " id=\"4\"/>\n            <label for=\"4\">\n            ";
    echo $LNG["thr"];
    echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['fri']\" value=\"fri\" ";
    if (in_array("fri", $days)) {
        echo "checked";
    }
    echo " id=\"5\"/>\n            <label for=\"5\">\n            ";
    echo $LNG["fri"];
    echo "          </label>\n\n          <input type=\"checkbox\"  name=\"days['sat']\" value=\"sat\" ";
    if (in_array("sat", $days)) {
        echo "checked";
    }
    echo " id=\"6\"/>\n            <label for=\"6\">\n            ";
    echo $LNG["sat"];
    echo "            </label>\n\n            <small>";
    echo $LNG["repeat"] . " " . $LNG["every"] . " " . $LNG["week"];
    echo "</small>\n                         </td>\n      </tr>\n\n\n\n<tr class=\"p3\"  ";
    echo $p3;
    echo ">\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        ";
    echo $LNG["everydayrepeatpromotioncredit"];
    echo "    </td>\n</tr>\n    <tr id=\"credit\">\n      <td class=\"fieldlabel\">";
    echo $LNG["promotional"];
    echo "          ";
    echo $LNG["discount"];
    echo "</td>\n      <td colspan=\"2\"><input name=\"promotional\"  value=\"";
    if (!$disable) {
        echo $fileserviceDetails["promotiondis"];
    }
    echo "\" type=\"text\"  class=\"txt small\" onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/><span class=\"preforms\">";
    echo $_SESSION["system_default_currency"]["code"];
    echo "</span>\n      &nbsp;&nbsp;&nbsp;\n          ";
    echo $LNG["current"];
    echo " ";
    echo $LNG["price"];
    echo " : ";
    echo $fileserviceDetails["credit_admin"];
    echo "</td>\n    </tr>\n  </tbody>\n</table>\n<br />\n<p class=\"fixedbtn\">\n    <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnhappyhour\" class=\"button_save\" type=\"button\"  onclick=\"SubmitForm ('#btnhappyhour','editfileservice.happyhours','#frm','#notification','true','#main_loader');\"/>\n\n</p>\n\n</form>\n</div></div>\n ";
} else {
    echo "    <div style=\"padding: 50px;\" align=\"center\"><strong>";
    echo $LNG["happy"];
    echo " ";
    echo $LNG["hours"];
    echo " ";
    echo $LNG["is"];
    echo " ";
    echo $LNG["now"];
    echo " ";
    echo $LNG["disable"];
    echo " ";
    echo $LNG["please"];
    echo " ";
    echo $LNG["go"];
    echo " ";
    echo $LNG["on"];
    echo "</strong> Settings > General Settings > Orders <strong>";
    echo $LNG["to"];
    echo " ";
    echo $LNG["enable"];
    echo " it</strong></div>\n    ";
}
echo " <div id=\"page_info\" class=\"page_info\">\n\t<li>This page allows you to manage promotion credit through any date of month or specific date of every month,through days or life time</li>\n</div>";
$fileverioncheck = "6.1.0";

?>