<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\nfunction resetDiscount(){\n    var answer = confirm('";
echo $LNG["areyousuretoresetdiscount"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnreset','editserverservice.resetdiscount','#frm','#notification','true','#main_loader');\n    }\n}\nfunction getMyTempl(val){\n    \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n         \$('#editimail').html(data);\n    });\n}\nfunction getMyTempl2(val){\n    \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n         \$('#editimail2').html(data);\n    });\n}\n</script>\n<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n</script>\n";
$pageid = 171;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_server_log WHERE id='" . $id . "' "));
include_once ROOTDIR . "/includes/serverservices.fun.php";
$group = getServerServiceGroup();
$md5id = md5($id);
$serverserviceDetails = getServerServices("", $md5id);
$happyhours = getServerhappyhours($id);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Basic Details</span> <span style=\"float:right\"><a   href=\"javascript:load_subpage('main2.php?page=editserverservice.seo&id=";
echo $id;
echo "','";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo "');\"> ";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo "</a>  <a target=\"_blank\"\nhref=\"";
echo $config["site_address"] . "cart.php?item=" . $serverserviceDetails["id"] . "&service=server&parentid=1008&group=" . $serverserviceDetails["group_id"] . "";
echo "\">\nView as Client</a>\n\n<a href=\"#\"  onclick=\"showsummary()\">Order Summary</a>\n\n</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\">\n    <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" id=\"hs\" name=\"status\" value=\"1\" ";
if ($serverserviceDetails["status"] == "1") {
    echo "checked";
}
echo "/><label for=\"hs\"></label></span>\n    </td>\n</tr>\n</table>\n\n<div class=\"hs\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["servicename"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"servicename\"  value=\"";
echo $serverserviceDetails["service_name"];
echo "\" type=\"text\"  class=\"txt medium\"/> <span class=\"textgreen\" style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editserverservice.info&id=";
echo $id;
echo "','";
echo $LNG["service"];
echo " ";
echo $LNG["information"];
echo "');\">";
echo $LNG["service"];
echo " ";
echo $LNG["information"];
echo "</a>\n\n    </span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"groupname\">\n        ";
foreach ($group as $key => $value) {
    $value = $group[$key]["name"];
    if ($key == $serverserviceDetails["group_id"]) {
        echo "<option value=" . $key . " selected>" . $value . "</option>";
    } else {
        if ($group[$key]["active"] == 0) {
            echo "<option value=" . $key . " class=textred>" . $value . " (<font style=font-style: italic;>Inactive</font>)</option>";
        } else {
            echo "<option value=" . $key . ">" . $value . "</option>";
        }
    }
}
echo "    </select>\n    &nbsp; <a href=\"#\" data-target=\"addservergroup\" data-target-header=\"";
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
echo "</a>\n    </td>\n</tr>\n";
if ($serverserviceDetails["time"]) {
    $time = explode(" ", $serverserviceDetails["time"]);
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"time1\"  value=\"";
echo $time[0];
echo "\" type=\"text\"  class=\"txt small\" onkeyup=\"return cFd(this,false)\" onblur=\"return cFd(this,true)\"/>\n    <select name=\"timeref\">\n        <option value=\"Minutes\" ";
if ($time[1] == "Minutes") {
    echo "selected";
}
echo ">";
echo $LNG["minutes"];
echo "</option>\n        <option value=\"Hours\" ";
if ($time[1] == "Hours") {
    echo "selected";
}
echo ">";
echo $LNG["hours"];
echo "</option>\n        <option value=\"Weeks\" ";
if ($time[1] == "Weeks") {
    echo "selected";
}
echo ">";
echo $LNG["weeks"];
echo "</option>\n        <option value=\"Days\" ";
if ($time[1] == "Days") {
    echo "selected";
}
echo ">";
echo $LNG["days"];
echo "</option>\n        <option value=\"Months\" ";
if ($time[1] == "Months") {
    echo "selected";
}
echo ">";
echo $LNG["months"];
echo "</option>\n        <option value=\"Instant\" ";
if ($time[1] == "Instant") {
    echo "selected";
}
echo ">";
echo $LNG["instant"];
echo "</option>\n    </select>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\" disabled=\"disabled\"  value=\"";
echo $serverserviceDetails["credit_admin"];
echo "\" type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> <span class=\"textgreen\" style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editserverservice.managecurrency&id=";
echo $id;
echo "','";
echo $LNG["set"];
echo " ";
echo $LNG["pricing"];
echo "');\">";
echo $LNG["set"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["pricing"];
echo "</a></span>\n\n         <br />\n    <small>\n    ";
if ($serverserviceDetails["purchase_cost"]) {
    echo "Purchase Cost: " . $serverserviceDetails["purchase_cost"];
} else {
    echo "      * Your Purchase cost not set yet <a\n\n  onclick=\"load_subpage('main2.php?page=editserverservice.purchasecost&id=";
    echo $id;
    echo "','";
    echo $LNG["service"];
    echo " ";
    echo $LNG["pricing"];
    echo "');\"\n      >Click here</a> to set your purchase cost.\n    ";
}
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["verification"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"vy\" name=\"verification\" value=\"1\" ";
if ($serverserviceDetails["verifiable"] == "1") {
    echo "checked";
}
echo "/><label for=\"vy\">";
echo $LNG["yes"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"verification\" id=\"vn\" value=\"0\" ";
if ($serverserviceDetails["verifiable"] == "0") {
    echo "checked";
}
echo "/><label for=\"vn\">";
echo $LNG["no"];
echo "</label></span>\n    <small>";
echo $LNG["userorderverification"];
echo "</small>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["cancelorder"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"cy\" name=\"cancel\" value=\"1\" ";
if ($serverserviceDetails["usercan_cancel"] == "1") {
    echo "checked";
}
echo "/><label for=\"cy\">";
echo $LNG["yes"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"cancel\" id=\"cn\" value=\"0\" ";
if ($serverserviceDetails["usercan_cancel"] == "0") {
    echo "checked";
}
echo "/><label for=\"cn\">";
echo $LNG["no"];
echo "</label></span>\n    <small>";
echo $LNG["usercancelorder"];
echo "</small>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["iconlink"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"iconlink\" id=\"iconlink\" value=\"";
echo $serverserviceDetails["icon_link"];
echo "\" type=\"text\"  class=\"txt large\"/><input value=\"";
echo $LNG["add"] . " " . $LNG["from"] . " " . $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["downloadlink"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"downloadlink\"  value=\"";
echo $serverserviceDetails["download_link"];
echo "\" type=\"text\"  class=\"txt large\"/></td>\n</tr>\n\n</table>\n <br /><br />\n<div  class=\"groupstabes\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Advance Settings</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n\n";
$result = dquery("select id,title from tbl_knowledgebase");
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["knowledgebase"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"faq\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        ";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["id"] == $serverserviceDetails["faq_id"]) {
            echo "<option value=" . $row["id"] . " selected>" . $row["title"] . "</option>";
        } else {
            echo "<option value=" . $row["id"] . ">" . $row["title"] . "</option>";
        }
    }
}
echo "    </select>\n        &nbsp; <a href=\"#\" data-target=\"addknowledgebase\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["knowledgebase"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["knowledgebase"];
echo "</a>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["email"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type='radio' name='notificationemail' id='eem' value=\"0\" ";
if (!$serverserviceDetails["notificationemail"]) {
    echo "checked='checked'";
}
echo " /><label for='eem'>";
echo $LNG["enable"];
echo "</label>\n    <input type='radio' name='notificationemail' id='dem' value=\"1\" ";
if ($serverserviceDetails["notificationemail"]) {
    echo "checked='checked'";
}
echo " /><label for='dem'>";
echo $LNG["disable"];
echo "</label>\n    <input name=\"notificationmail\"  value=\"";
echo $serverserviceDetails["notification_mail"];
echo "\" type=\"text\"  class=\"txt medium\"/><small>Send order notification email other than admin. If its disable then admin and other supplier will not get emails.</small></td>\n</tr>\n";
if ($config["smsgateway"]) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["new"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["notification"];
    echo " ";
    echo $LNG["by"];
    echo " ";
    echo $LNG["sms"];
    echo " </td>\n    <td class=\"fieldarea\">\n    <input type='radio' name='smsnotification' id='esm' value=\"1\" ";
    if ($serverserviceDetails["smsnotification"]) {
        echo "checked='checked'";
    }
    echo " /><label for='esm'>";
    echo $LNG["enable"];
    echo "</label>\n    <input type='radio' name='smsnotification' id='dsm' value=\"0\" ";
    if (!$serverserviceDetails["smsnotification"]) {
        echo "checked='checked'";
    }
    echo " /><label for='dsm'>";
    echo $LNG["disable"];
    echo "</label>\n    </td>\n</tr>\n";
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["ordersuccemail"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"template1\"  onchange=\"getMyTempl(this.value);\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$e = dquery("select * from tbl_emailtemplates where `type`='serverorder'");
while ($row = mysqli_fetch_assoc($e)) {
    if ($serverserviceDetails["template_id1"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "    </select>\n     <span id=\"editimail\">\n    </span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["orderrejemail"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"template2\"  onchange=\"getMyTempl2(this.value);\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$e = dquery("select * from tbl_emailtemplates where `type`='serverorder'");
while ($row = mysqli_fetch_assoc($e)) {
    if ($serverserviceDetails["template_id2"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "    </select>\n     <span id=\"editimail2\">\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "</td>\n    <td class=\"fieldarea\"><span><input value=\"";
echo $LNG["resetdiscount"];
echo "\" id=\"btnreset\" class=\"btn\" type=\"button\"  onclick=\"resetDiscount();\"/> </span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n</div></div></div>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editserverservice.overview','#frm','#notification','true','#main_loader');\"/>\n     ";
if ($happyhours) {
    echo "        <div style=\"position: absolute;left:40%;top:10px;color:green;font-weight: bold;\">";
    echo $LNG["serviceunderhappyhours"];
    echo "</div>\n    ";
}
echo "    <input  style=\"float: right;\" onclick=\"load_subpage ('main2.php?page=editserverservice.remove&id=";
echo $id;
echo "','";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "' );\" id=\"btnoverview\" name=\"delete\" class=\"button_remove\" value=\"Remove Service\"  type=\"button\"/>\n</div>\n\n</div></div>\n </form>\n<script>\n    function showsummary(){\n        \$('.ordersummary').fadeIn();\n\n        \$('.closes').click(function(){\n            \$('.ordersummary').fadeOut();\n        })\n    }\n</script>\n\n<style>\n    .summary li{list-style: none;padding:10px 5px;display: inline-block;}\n    .summary li span{font-size:28px;font-weight: bold;}\n    .closes{cursor: pointer;font-size: 16px;font-weight: bold;position: absolute;right: 5px;top: 5px;}\n</style>\n\n<div style=\"display: none;position: absolute;width:450px;right:-27px;top:35px;background:white;padding-top:20px;border:#ccc solid 1px;box-shadow:0 0 7px #ccc\" class=\"ordersummary\">\n\n<span class=\"closes\">X</span>\n\n    <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n\n";
$sql = "select count(*) as total,DAY(date) as day,user_can_c,1 as tbl  from tbl_order_server WHERE month( date ) = month( now( ) ) and service_id='" . $id . "' and (user_can_c='3' or user_can_c='4') group by DAY(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["tbl"]][$row["day"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($i = 1; $i <= 1; $i++) {
    for ($j = 1; $j <= 7; $j++) {
        if (!$_order[$i][$j][4]) {
            $_order[$i][$j][4]["count"] = 0;
        }
        if (!$_order[$i][$j][3]) {
            $_order[$i][$j][3]["count"] = 0;
        }
    }
}
echo "\n<script type=\"text/javascript\">\n\$(function () {\n    var chart;\n    \$(document).ready(function() {\n        chart = new Highcharts.Chart({\n\n            chart: {\n                renderTo: 'weekly',\n                type: 'column'\n            },\n\n            title: {\n                text: 'Weekly total completed and rejected orders'\n            },\n\n            xAxis: {\n                categories: [\n                    'Mon',\n                    'Tue',\n                    'Wed',\n                    'Thu',\n                    'Fri',\n                    'Sat',\n                    'Sun'\n                    ]\n            },\n\n            yAxis: {\n                allowDecimals: false,\n                min: 0,\n                title: {\n                    text: 'Number of Orders'\n                }\n            },\n\n            tooltip: {\n                formatter: function() {\n                    return '<b>'+ this.x +'</b><br/>'+\n                        this.series.name +': '+ this.y +'<br/>'+\n                        'Total: '+ this.point.stackTotal;\n                }\n            },\n\n            plotOptions: {\n                column: {\n                    stacking: 'normal'\n                }\n            },\n\n            series: [{\n                name: 'Rejected',\n                data: [";
echo $_order[1][1][3]["count"];
echo ",";
echo $_order[1][2][3]["count"];
echo ",";
echo $_order[1][3][3]["count"];
echo ",";
echo $_order[1][4][3]["count"];
echo ",";
echo $_order[1][5][3]["count"];
echo ",";
echo $_order[1][6][3]["count"];
echo ",";
echo $_order[1][7][3]["count"];
echo "]\n            }, {\n                name: 'Completed',\n                data: [";
echo $_order[1][1][4]["count"];
echo ",";
echo $_order[1][2][4]["count"];
echo ",";
echo $_order[1][3][4]["count"];
echo ",";
echo $_order[1][4][4]["count"];
echo ",";
echo $_order[1][5][4]["count"];
echo ",";
echo $_order[1][6][4]["count"];
echo ",";
echo $_order[1][7][4]["count"];
echo "]\n            }]\n        });\n    });\n\n});\n\n</script>\n\n    <div id=\"weekly\" style=\"width: 430px;height:300px\"></div>\n    <hr />\n";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  from tbl_order_server WHERE year( date ) = year( now( ) ) and service_id='" . $id . "' and (user_can_c='3' or user_can_c='4') group by MONTH(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["tbl"]][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($i = 1; $i <= 1; $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if (!$_order[$i][$j][4]) {
            $_order[$i][$j][4]["count"] = 0;
        }
        if (!$_order[$i][$j][3]) {
            $_order[$i][$j][3]["count"] = 0;
        }
    }
}
echo "\n<script type=\"text/javascript\">\n\$(function () {\n    var chart;\n    \$(document).ready(function() {\n        chart = new Highcharts.Chart({\n\n            chart: {\n                renderTo: 'monthly',\n                type: 'column'\n            },\n\n            title: {\n                text: 'Monthly total completed and rejected orders'\n            },\n\n            xAxis: {\n                categories: [\n                    'Jan',\n                    'Feb',\n                    'Mar',\n                    'Apr',\n                    'May',\n                    'Jun',\n                    'Jul',\n                    'Aug',\n                    'Sep',\n                    'Oct',\n                    'Nov',\n                    'Dec']\n            },\n\n            yAxis: {\n                allowDecimals: false,\n                min: 0,\n                title: {\n                    text: 'Number of Orders'\n                }\n            },\n\n            tooltip: {\n                formatter: function() {\n                    return '<b>'+ this.x +'</b><br/>'+\n                        this.series.name +': '+ this.y +'<br/>'+\n                        'Total: '+ this.point.stackTotal;\n                }\n            },\n\n            plotOptions: {\n                column: {\n                    stacking: 'normal'\n                }\n            },\n\n            series: [{\n                name: 'Rejected',\n                data: [";
echo $_order[1][1][3]["count"];
echo ",";
echo $_order[1][2][3]["count"];
echo ",";
echo $_order[1][3][3]["count"];
echo ",";
echo $_order[1][4][3]["count"];
echo ",";
echo $_order[1][5][3]["count"];
echo ",";
echo $_order[1][6][3]["count"];
echo ",";
echo $_order[1][7][3]["count"];
echo ",";
echo $_order[1][8][3]["count"];
echo ",";
echo $_order[1][9][3]["count"];
echo ",";
echo $_order[1][10][3]["count"];
echo ",";
echo $_order[1][11][3]["count"];
echo ",";
echo $_order[1][12][3]["count"];
echo "]\n            }, {\n                name: 'Completed',\n                data: [";
echo $_order[1][1][4]["count"];
echo ",";
echo $_order[1][2][4]["count"];
echo ",";
echo $_order[1][3][4]["count"];
echo ",";
echo $_order[1][4][4]["count"];
echo ",";
echo $_order[1][5][4]["count"];
echo ",";
echo $_order[1][6][4]["count"];
echo ",";
echo $_order[1][7][4]["count"];
echo ",";
echo $_order[1][8][4]["count"];
echo ",";
echo $_order[1][9][4]["count"];
echo ",";
echo $_order[1][10][4]["count"];
echo ",";
echo $_order[1][11][4]["count"];
echo ",";
echo $_order[1][12][4]["count"];
echo "]\n            }]\n        });\n    });\n\n});\n\n</script>\n\n    <div id=\"monthly\"  style=\"width: 430px;height:300px\"></div>\n\n     <div class=\"summary\" style=\"background: #f4f4f4;\">\n        ";
$total = dquery("select count(*) as total,user_can_c  from tbl_order_server WHERE service_id='" . $id . "' group by user_can_c");
while ($row = mysqli_fetch_assoc($total)) {
    $_total[$row["user_can_c"]] = $row["total"];
}
for ($j = 0; $j <= 4; $j++) {
    if (!$_total[$j]) {
        $_total[$j] = 0;
    }
}
echo "        <table>\n        <tr><td align=\"center\"><li><span> ";
echo $_total[0] + $_total[1];
echo "</span><br />Total Pending  </li></td><td align=\"center\"><li><span> ";
echo $_total[3];
echo "</span><br />Total Rejected </li></td><td align=\"center\"><li> <span>";
echo $_total[4];
echo "</span><br />Total Completed</li>   </td></tr>\n        </table>\n    </div>\n\n</div>\n\n\n</div></div>\n\n <div id=\"page_info\" class=\"page_info\">\n\t<li>This page allows you to update service details</li>\n\t<li>Verification and cancel order set the order verification and order cancelation after place order from user</li>\n\t<li>Icon link specify the icon link of this service from existing system gallery</li>\n\t<li>You can also set new order notification email,order successfull email and order reject email template</li>\n</div>\t";
$fileverioncheck = "6.1.0";

?>