<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
echo "<script>\nfunction isin(n,a){\n  for (var i=0;i<a.length;i++){\n    if (a[i]== n) {\n      var b = true;\n      return b;\n    } else {\n      var c = false;\n      return c;\n   }\n  }\n}\n\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selected');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('imei');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n   txtSelectedValuesObj.value = selectedArray;\n}\n</script>\n<script> \nfunction sendtoopener()   \n{ \n    if(opener.document.getElementById('imei').value==\"\"){\n        opener.document.getElementById('imei').value=document.getElementById('selected').value;\n    }else{\n        opener.document.getElementById('imei').value=opener.document.getElementById('imei').value+\",\"+document.getElementById('selected').value;\n    } \n    opener.document.getElementById('server').value=\"\";\n    opener.document.getElementById('product').value=\"\";\n    self.close();    \n}\n</script>\n<link rel=\"stylesheet\" href=\"../css/x-main2.css\" />\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldarea\" colspan=\"2\">\n<select style=\"width: 100%;\" name='grp' id='grpimei' onchange=\"location.href='imeilist.php?grp='+this.value\" >\n";
$sql = dquery("select group_name ,id from tbl_imei_group");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "\t\t<option  value='";
    echo $row["id"];
    echo "' ";
    if ($row["id"] == $grp) {
        echo "selected";
    }
    echo "  >";
    echo $row["group_name"];
    echo "</option>\n        ";
}
echo "</select>\n<input type='hidden' name='selected' id='selected'  />\n</td>\n</tr>\n<tr>\n    <td class=\"fieldarea\" colspan=\"2\">\n    ";
echo $LNG["imeiservice"];
echo "<br />\n \n<select name='imei' id='imei' multiple=\"multiple\" style=\"width: 100%;\" size=\"10\" onchange=\"loopSelected();\">\n";
if (!$grp) {
    $grp = mysqli_fetch_assoc(dquery("select id from tbl_imei_group"));
    $grp = $grp["id"];
}
$sql = dquery("select service_name ,id from tbl_services_imei WHERE group_id='" . $grp . "'");
while ($row = mysqli_fetch_assoc($sql)) {
    $selectf = "";
    $ex = explode(",", $sels);
    foreach ($ex as $s) {
        if ($s == $row["id"]) {
            $selectf = " selected='selected'";
        }
    }
    echo "<option " . $selectf . " value='" . $row["id"] . "'>" . $row["service_name"] . "</option>";
}
echo "</select>\n</td>\n</tr>\n\n<tr> \n    <td class=\"fieldlabel\"> </td><td>\n   <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn\" onclick='sendtoopener()' type=\"button\" name=\"Add\"  /> \n    </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>