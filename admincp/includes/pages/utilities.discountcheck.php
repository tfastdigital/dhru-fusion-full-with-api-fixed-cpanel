<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction ajaxRequest(){\n var activexmodes=[\"Msxml2.XMLHTTP\", \"Microsoft.XMLHTTP\"] ;\n if (window.ActiveXObject){ \n  for (var i=0; i<activexmodes.length; i++){\n   try{\n    return new ActiveXObject(activexmodes[i])\n   }\n   catch(e){    \n   }\n  }\n }\n else if (window.XMLHttpRequest) \n  return new XMLHttpRequest()\n else\n  return false\n}\nfunction getdata(val){\n    if(val!=\"\"){\n        var mypostrequest=new ajaxRequest();\n        mypostrequest.onreadystatechange=function(){\n         if (mypostrequest.readyState==4){\n          if (mypostrequest.status==200 || window.location.href.indexOf(\"http\")==-1){\n               var data=mypostrequest.responseText;\n               if(data!=''){\n                    var arr=data.split(\"|\");\n                    for(var i=0;i<arr.length;i++){\n                      var data=arr[i].split(\"=\");\n                      document.getElementById(data[0]).innerHTML=data[1];\n                    }\n               }\n          }\n          else{\n            alert(\"An error has occured making the request\");\n          }\n         }\n        }\n        var typ=document.getElementById('servicetype').value;\n        var parameters=\"id=\"+val+\"&st=\"+typ;\n        mypostrequest.open(\"POST\", \"includes/pages/getPrice.php\", true);\n        mypostrequest.setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");\n        mypostrequest.send(parameters);\n    }\n}\nfunction setType(val){\n    \$.post('includes/pages/getPrice.php?type='+val, function(data) {\n         \$('#service').html(data);\n    });\n}\n</script> \n";
$pageid = 427;
checkPagePermission($pageid);
echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style>\n<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Discount By Service</a></li>\n</ul>\n<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Services</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["service"];
echo " ";
echo $LNG["type"];
echo "</td>\n    <td  class=\"fieldarea\">\n    \n<select name=\"servicetype\" id=\"servicetype\"  onchange=\"setType(this.value)\">\n";
if (!$IsFileOnly) {
    echo "<option value=\"imei\">";
    echo $LNG["imei"];
    echo "</option>\n";
}
echo "<option value=\"file\">";
echo $LNG["file"];
echo "</option>\n";
if (!$IsFileOnly) {
    echo "<option value=\"server\">";
    echo $LNG["server"];
    echo "</option>\n<option value=\"remote\">";
    echo $LNG["remote"];
    echo "</option>\n";
}
echo "</select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["service"];
echo " </td>\n    <td  class=\"fieldarea\">\n";
if ($IsFileOnly) {
    $sql = dquery("SELECT service_name,id,credit FROM tbl_services_file where active='1'");
} else {
    $sql = dquery("SELECT service_name,id,credit FROM \n    tbl_services_imei where active='1' and useasserver=0");
}
echo "    \n<select name=\"service\" id=\"service\" onchange=\"getdata(this.value)\" >\n                <option value=\"\">";
echo $LNG["select"];
echo "</option>\n                ";
while ($row = mysqli_fetch_assoc($sql)) {
    echo " <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["service_name"] . " - " . $row["credit"];
    echo "</option>\n";
}
echo " </select>\n    </td>\n</tr>\n";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
    echo $LNG["credit"];
    echo " ";
    echo $LNG["lowerthan"];
    echo " [";
    echo $row["code"];
    echo "] </td>\n    <td  class=\"fieldarea\">\n        <input type=\"text\" style=\"width: 100px !important;\" name=\"credit[";
    echo $row["id"];
    echo "]\" />&nbsp;&nbsp;<span id=\"";
    echo $row["id"];
    echo "\"></span>\n    </td>\n</tr>\n";
}
echo "<tr>\n<td class=\"fieldlabel\" width=\"15%\"></td>\n    <td  class=\"fieldarea\">\n        <input type=\"submit\" name=\"search\" \n        class=\"btn btn-primary add\" value=\"";
echo $LNG["search"];
echo "\" />\n    </td>\n</tr>\n</tbody>\n</table> </form>\n\n</div></div>\n";
if (isset($_POST["search"]) && $service) {
    if ($servicetype == "server") {
        $table1 = "tbl_server_credit";
        $table2 = "tbl_server_log";
        $table3 = "tbl_discount_server_log";
    } else {
        if ($servicetype == "file") {
            $table1 = "tbl_file_credit";
            $table2 = "tbl_services_file";
            $table3 = "tbl_discount_file";
        } else {
            $table1 = "tbl_file_credit";
            $table2 = "tbl_services_file";
            $table3 = "tbl_discount_file";
        }
    }
    echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Search Result</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n    <table id=\"main_tbl\" style=\"display: ";
    echo $display;
    echo ";\">\n            <thead>\n              <tr>\n                <th>";
    echo $LNG["username"];
    echo "</th>\n                <th>";
    echo $LNG["credit"];
    echo "</th>\n              </tr>\n            </thead>\n            <tbody> \n";
    $service = $_POST["service"];
    $sql = dquery("select id from tbl_currencies");
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($_POST["credit"][$row["id"]] != "") {
            $credit = $_POST["credit"][$row["id"]];
            $icredit = mysqli_fetch_assoc(dquery("select credit from \n            " . $table1 . " where service_id='" . $service . "'\n             and currency_id='" . $row["id"] . "'"));
            if ($icredit["credit"] == "") {
                $icredit = mysqli_fetch_assoc(dquery("select credit from \n                " . $table2 . " where id='" . $service . "'"));
                $def = mysqli_fetch_assoc(dquery("select id from \n                tbl_currencies where `default`='1'"));
                $icredit["credit"] = convertCurrency($icredit["credit"], $def["id"], $row["id"]);
            }
            $u = dquery("select username,id from tblUsers where default_currency='" . $row["id"] . "'");
            while ($user = mysqli_fetch_assoc($u)) {
                $dis = mysqli_fetch_assoc(dquery("select discount from \n                " . $table3 . " where user_id='" . $user["id"] . "' and service_id='" . $service . "' and discount>'0'"));
                $final = $icredit["credit"] - $dis["discount"];
                if ($final <= $credit) {
                    echo "              <tr>\n                <td>";
                    echo $user["username"];
                    echo "</td>\n                <td>";
                    echo $row["prefix"];
                    echo " ";
                    echo $final;
                    echo "</td>\n              </tr>\n                ";
                }
            }
        }
    }
    echo "                \n            </tbody>\n    </table>            \n";
}
echo "</div></div></div></div>\n";
$fileverioncheck = "6.1.0";

?>