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
echo "<script> \nfunction sendtoopener(myField,myValue)   \n{\n\nif(opener.tinyMCE!=undefined){\n    var ed = opener.tinyMCE.get('message');             \n    var range = ed.selection.getRng();                  \n    var newNode = ed.getDoc().createElement ( \"span\" ); \n    newNode.innerHTML =myValue;\n    //alert(newNode+' - '+ed+' - '+range+' - ');\n    range.insertNode(newNode);   \n}else{\n    if(opener.document.selection) {\n        myField.focus();\n        sel = opener.document.selection.createRange();\n        sel.text = myValue;\n\n    }else if (myField.selectionStart || myField.selectionStart == 0) {\n\n        var startPos = myField.selectionStart;\n        var endPos = myField.selectionEnd;\n        myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos,myField.value.length);\n\n    }else{\n        myField.value += myValue;\n    }\n}\nself.close();\n\n}\n</script>\n\n<style>\n    *{margin: 0;padding:0;font-size:12px;font-family: arial;}\n    table{border-right:#ddd solid 1px;border-bottom:#ddd solid 1px;}\n    table td{border-left: #ddd solid 1px;border-top: #ddd solid 1px;border-collapse: collapse;padding:7px}\n    .left{float:left;width:300px;margin-right:20px}\n    h5{padding:5px;}\n</style>\n\n<div class=\"left\">\n<h5>Personal Info</h5>\n<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"> \t\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$firstname}');\" style=\"text-decoration: none; color : gray;\">{\$firstname}</a></td><td>";
echo $LNG["firstname"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$lastname}');\" style=\"text-decoration: none; color : gray;\">{\$lastname}</a></td><td>";
echo $LNG["lastname"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$email}');\" style=\"text-decoration: none; color : gray;\">{\$email}</a></td><td>";
echo $LNG["email"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$phonenumber}');\" style=\"text-decoration: none; color : gray;\">{\$phonenumber}</a></td><td>";
echo $LNG["phonenumber"];
echo "</td></tr>                                                        \n</table>\n</div>\n\n<div class=\"left\">\n<h5>System Info</h5>\n<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"> \n\t<tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$userid}');\" style=\"text-decoration: none; color : gray; \">{\$userid}</a></td><td>";
echo $LNG["userid"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$email}');\" style=\"text-decoration: none; color : gray;\">{\$email}</a></td><td>";
echo $LNG["email"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$credit_validity}');\" style=\"text-decoration: none; color : gray;\">{\$credit_validity}</a></td><td>";
echo $LNG["credit"];
echo " ";
echo $LNG["validity"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$currency}');\" style=\"text-decoration: none; color : gray;\">{\$currency}</a></td><td>";
echo $LNG["currency"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$lastloginip}');\" style=\"text-decoration: none; color : gray;\">{\$lastloginip}</a></td><td>";
echo $LNG["lastloginip"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$note}');\" style=\"text-decoration: none; color : gray;\">{\$note}</a></td><td>";
echo $LNG["notes"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$language}');\" style=\"text-decoration: none; color : gray;\">{\$language}</a></td><td>";
echo $LNG["language"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$timezone}');\" style=\"text-decoration: none; color : gray;\">{\$timezone}</a></td><td>";
echo $LNG["timezone"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$login_country}');\" style=\"text-decoration: none; color : gray;\">{\$login_country}</a></td><td>";
echo $LNG["login"];
echo " ";
echo $LNG["country"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$credit.credit}');\" style=\"text-decoration: none; color : gray;\">{\$credit.credit}</a></td><td>";
echo $LNG["creditleft"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$credit.used}');\" style=\"text-decoration: none; color : gray;\">{\$credit.used}</a></td><td>";
echo $LNG["creditused"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$credit.inprocess}');\" style=\"text-decoration: none; color : gray;\">{\$credit.inprocess}</a></td><td>";
echo $LNG["creditinprocess"];
echo "</td></tr>\n    <tr><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$siteaddress}/index.php?u={\$enc}');\" style=\"text-decoration: none; color : gray;\">{\$siteaddress}/index.php?u={\$enc}</a></td><td> Unsubscribe</td></tr>\n          \n</table>\n</div>\n\n<div class=\"left\">\n<h5>Address Info</h5>\n<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"> \n\t<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$address1}');\" style=\"text-decoration: none; color : gray;\">{\$address1}</a></td><td>";
echo $LNG["address"];
echo " 1</td></tr>\n    <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$address2}');\" style=\"text-decoration: none; color : gray;\">{\$address2}</a></td><td>";
echo $LNG["address"];
echo " 2</td></tr>\n    <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$city}');\" style=\"text-decoration: none; color : gray;\">{\$city}</a></td><td>";
echo $LNG["city"];
echo "</td></tr>\n    <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$state}');\" style=\"text-decoration: none; color : gray;\">{\$state}</a></td><td>";
echo $LNG["state"];
echo "</td></tr>\n    <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$zip}');\" style=\"text-decoration: none; color : gray;\">{\$zip}</a></td><td>";
echo $LNG["zip"];
echo "</td></tr>\n    <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$country}');\" style=\"text-decoration: none; color : gray;\">{\$country}</a></td><td>";
echo $LNG["country"];
echo "</td></tr>                \n</table>\n</div>\n\n\n    <div class=\"left\">\n        <h5>Order Info</h5>\n        <table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$imeilist}');\" style=\"text-decoration: none; color : gray;\">{\$imeilist}</a></td><td>IMEI List</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$usernote}');\" style=\"text-decoration: none; color : gray;\">{\$usernote}</a></td><td>";
echo $LNG["user"];
echo " ";
echo $LNG["note"];
echo "</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$model}');\" style=\"text-decoration: none; color : gray;\">{\$model}</a></td><td>";
echo $LNG["model"];
echo "</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$provider}');\" style=\"text-decoration: none; color : gray;\">{\$provider}</a></td><td>";
echo $LNG["provider"];
echo "</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$note}');\" style=\"text-decoration: none; color : gray;\">{\$note}</a></td><td>";
echo $LNG["order"];
echo " ";
echo $LNG["note"];
echo "</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$mep}');\" style=\"text-decoration: none; color : gray;\">{\$mep}</a></td><td>MEP</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$pin}');\" style=\"text-decoration: none; color : gray;\">{\$pin}</a></td><td>PIN</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$kbh}');\" style=\"text-decoration: none; color : gray;\">{\$kbh}</a></td><td>KBH</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$prd}');\" style=\"text-decoration: none; color : gray;\">{\$prd}</a></td><td>PRD</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$type}');\" style=\"text-decoration: none; color : gray;\">{\$type}</a></td><td>Type</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$reference}');\" style=\"text-decoration: none; color : gray;\">{\$reference}</a></td><td>Reference</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$qnt}');\" style=\"text-decoration: none; color : gray;\">{\$qnt}</a></td><td>Quantity for Server Order</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$ordertime}');\" style=\"text-decoration: none; color : gray;\">{\$ordertime}</a></td><td>Order Time 24 Hrs</td></tr>\n\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$balance}');\" style=\"text-decoration: none; color : gray;\">{\$balance}</a></td><td>Customer Balance</td></tr>\n            <tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$replydatetime}');\" style=\"text-decoration: none; color : gray;\">{\$replydatetime}</a></td><td>Order Reply Date and Time</td></tr>\n\n        </table>\n    </div>\n\n\n<div class=\"left\">\n<h5>Company Info</h5>\n<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\"> \n<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$companyname}');\" style=\"text-decoration: none; color : gray;\">{\$companyname}</a></td><td>";
echo $LNG["companyname"];
echo "</td></tr>\n<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$adminsignature}');\" style=\"text-decoration: none; color : gray;\">{\$adminsignature}</a></td><td>";
echo $LNG["adminsignature"];
echo "</td></tr>\n<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$adminmail}');\" style=\"text-decoration: none; color : gray;\">{\$adminmail}</a></td><td>";
echo $LNG["adminmail"];
echo "</td></tr>\n<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'{\$siteaddress}');\" style=\"text-decoration: none; color : gray;\">{\$siteaddress}</a></td><td>";
echo $LNG["siteaddress"];
echo "</td></tr>\n";
$sql = mysqli_fetch_assoc(dquery("SELECT template_variable FROM tbl_emailtemplates WHERE id='" . $id . "'"));
$rows = explode(",", $sql["template_variable"]);
foreach ($rows as $r) {
    $cols = explode("-", $r);
    echo "\t<tr ><td><a href=\"javascript:sendtoopener(opener.document.getElementById('message'),'";
    echo $cols[0];
    echo "');\" style=\"text-decoration: none; color : gray;\">";
    echo $cols[0];
    echo "</a></td><td>";
    echo $cols[1];
    echo "</td></tr>\n\t";
}
echo "</table>\n</div>\n";
$fileverioncheck = "6.1.0";

?>