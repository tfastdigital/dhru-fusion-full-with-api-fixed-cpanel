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
require_once "../fun.inc.php";
global $LNG;
echo "<script> \nfunction sendtoopener(myField,myValue)   \n{ \n\nif(opener.tinyMCE!=undefined){\n    var ed = opener.tinyMCE.get('message');             \n    var range = ed.selection.getRng();                  \n    var newNode = ed.getDoc().createElement ( \"span\" ); \n    newNode.innerHTML =myValue;\n    range.insertNode(newNode);   \n}else{\n    if (opener.document.selection) {\n        myField.focus();\n        sel = opener.document.selection.createRange();\n        sel.text = myValue;\n    }\n    else if (myField.selectionStart || myField.selectionStart == 0) {\n        var startPos = myField.selectionStart;\n        var endPos = myField.selectionEnd;\n        myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos,myField.value.length);\n    }else{\n        myField.value += myValue;\n    }\n}\nself.close();\n\n}\n</script>\n\n<style>\n    *{font-size:12px;font-family: arial;}\n    table{border-right:#ddd solid 1px;border-bottom:#ddd solid 1px;}\n    table td{border-left: #ddd solid 1px;border-top: #ddd solid 1px;border-collapse: collapse;padding:7px}\n    .left{float:left;width:300px;margin-right:20px}\n    h5{padding:5px;}\n</style>\n\n\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form method=\"post\" name=\"frmeditemailtemplate\" id=\"frmeditemailtemplate\">\n<table class=\"main_tbl\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: 1px solid #ccc; font-size: 14px;\" > \n<tbody>\n";
$sql = dquery("select * from tbl_survey");
for ($i = 1; $r = mysqli_fetch_assoc($sql); $i++) {
    echo "<tr style=\"background-color: #F4F4F4; cursor: pointer;\" style=\"text-align:left;\" \nonclick=\"javascript:sendtoopener(opener.document.getElementById('message'),'";
    echo $config["site_address"] . "survey.php?survey=" . md5($r["id"]);
    echo "');\"  >\n<td>";
    echo $i;
    echo "</td>\n<td style=\"text-decoration: none; color : black; font-family: fantasy;\">";
    echo $r["title"];
    echo "</td>\n</tr>\n";
}
echo "     \n</tbody> \n</table>\n</form>\n</div></div>";
$fileverioncheck = "6.1.0";

?>