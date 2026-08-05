<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/js/editinplace.js\"></script>\n<script type=\"text/javascript\">\n\n      \$(\"document\").ready(function() {\n       setClickable();\n      });\n\n      function setClickable() {\n          \$('div#editInPlace').click(function() {\n             var input = '<div id=\"after\"><input type=\"text\" style=\"width: 180px;\" value=\"'+\$(this).html()+'\" name=\"replacecode\"/> <input  value=\"";
echo $LNG["update"];
echo "\" name=\"btnreplace\" id=\"btnreplace\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm (\\'#btnreplace\\',\\'edituser.editserverorderreplacesuccess\\',\\'#frmedituser\\',\\'#notification\\',\\'true\\',\\'#main_loader\\');\"/>';\n              var button     = '<input type=\"button\" value=\"cancel\" class=\"cancelButton\" /></div>';\n              var revert = \$(this).html();\n\n              \$(this).after(input+button).remove();\n              \$('.cancelButton').click(function(){saveChanges(this, revert);});\n          })\n      };\n\n      function saveChanges(obj, revert) {\n      \$(obj).parent().after('<div id=\"editInPlace\">'+revert+'</div>').remove();\n      }\n\n </script>\n<script>\n\n\$(function() {\n  \$(\".click\").editable(\"includes/pages/editshipping.php\", {\n      tooltip   : \"click here to edit\",\n      style  : \"inherit\",\n      cancel    : 'Cancel',\n      submit    : 'OK'\n  });\n\n});\n\n\n</script>\n<style>\n.click{\n  padding-right:20px;\n  background-image: url('images/edit.png');\n  background-repeat: no-repeat;\n  background-position: right;\n}\n</style>\n";
$pageid = 399;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$md5id = md5($id);
$row = getOrdersProduct("", "", "", $md5id);
$clientDetails = getClientsDetails($row[$md5id]["allfield"]["user_id"]);
$diff = time() - $clientDetails["credit"]["date"];
$days = round($diff / 86400);
if ($clientDetails["credit"]["validity"] != 0) {
    if ($days < $clientDetails["credit"]["validity"]) {
        $color = "#779500";
    } else {
        if ($clientDetails["credit"]["validity"] == $days) {
            $color = "#779500";
        } else {
            $color = "#c00";
        }
    }
}
if ($clientDetails["userstatus"] == "0") {
    $status = $LNG["active"];
    $color1 = "#779500";
} else {
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["blocked"];
        $color1 = "#c00";
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["inactive"];
            $color1 = "#c00";
        }
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $md5id;
echo "\" name=\"md5id\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["id"];
echo "\" name=\"uid\"/>\n";
echo generate_token("form");
echo "\n\n<div style=\"float: left;width:49%\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\"><a class='default_dg_a' style=\"text-decoration: none;\" href=\"javascript:redirectedit('edituserprofile','";
echo $row[$md5id]["allfield"]["user_id"];
echo "')\">\n<strong>";
echo $LNG["user"];
echo "  ";
echo $LNG["id"];
echo " [";
echo $row[$md5id]["allfield"]["user_id"];
echo "]</strong></a></span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table border=\"0\"  width=\"100%\">\n<tbody>\n<tr><td>";
echo $LNG["username"];
echo "</td><td><span>";
echo $clientDetails["username"];
echo "</span></td></tr>\n<tr><td>";
echo $LNG["status"];
echo "</td><td><span><strong style=\"color: ";
echo $color1;
echo ";\">";
echo $status;
echo "</strong></span></td></tr>\n\n<tr><td>";
echo $LNG["creditleft"];
echo "</td><td><span>";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "</span></td></tr>\n<tr><td>";
echo $LNG["creditused"];
echo "</td><td><span>";
echo formatCurrency($clientDetails["credit"]["used"], $clientDetails["currency"]);
echo "</span></td></tr>\n<tr><td>";
echo $LNG["credit"];
echo " ";
echo $LNG["expired"];
echo "</td><td style=\"color: ";
echo $color;
echo ";\"><span>\n";
if ($clientDetails["credit"]["validity"] == "0") {
    echo "<strong>" . $LNG["neverexpired"] . "</strong>";
} else {
    $validity = $clientDetails["credit"]["validity"];
    $validity = date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day"));
    echo "<strong>" . formatDate($validity) . "</strong>";
}
echo "</span></td></tr></tbody></table></div>\n\n<div class=\"groupstabescontant\">\n<h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\"><a\nonclick=\"redirectedit('editimeiservice','";
echo $row[$md5id]["allfield"]["service_id"];
echo "');\" id=\"tab2\" ><strong>";
echo $LNG["service"];
echo "  ";
echo $LNG["id"];
echo " [";
echo $row[$id]["service_id"];
echo "]</strong></a></span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr><td class=\"fieldlabel\" width=\"20%\">";
echo $LNG["servicename"];
echo "</td><td colspan=\"3\" ><span>";
echo $row[$id]["service"];
echo "</span></td></tr>\n<tr><td class=\"fieldlabel\" width=\"20%\">";
echo $LNG["credit"];
echo "</td><td><span>";
echo formatCurrency($row[$id]["service_details"]["credit"], $clientDetails["currency"]);
echo "</span></td></tr>\n<tr><td class=\"fieldlabel\" width=\"20%\">";
echo $LNG["apiinfo"];
echo "</td><td><span>";
if ($row[$id]["service_details"]["API"]) {
    echo $row[$id]["service_details"]["API"];
} else {
    echo "-";
}
echo "</span></td></tr>\n</tbody></table>\n</div>\n\n\n<div class=\"groupstabescontant\">\n<h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["send"];
echo " ";
echo $LNG["custom"];
echo " ";
echo $LNG["email"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n\n<table  border=\"0\" width=\"100%\">\n<tbody>\n<tr><td>\n\n   <select name=\"productordermail\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        ";
$d = dquery("select type from tbl_emailtemplates where type='product' or type='other' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "  <optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n ";
    $s = dquery("select id,name,type from tbl_emailtemplates where type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "    <option style=\"background-color: #FFF;\" value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n ";
    }
    echo "      </optgroup>\n";
}
echo " </select>\n\n<input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" class=\"addFromgallery\"\n id=\"btnpmail\"  onclick=\"SubmitForm ('#btnpmail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n\n\n</td></tr>\n</tbody></table>\n</div>\n</div></div>\n\n\n\n\n";
if ($row[$id]["reply_by"]["adminid"]) {
    $reply = $LNG["admin"];
    $replyBy = $row[$id]["reply_by"]["adminid"];
} else {
    if ($row[$id]["reply_by"]["supplierid"]) {
        $reply = $LNG["supplier"];
        $replyBy = $row[$id]["reply_by"]["adminid"];
    }
}
echo "\n<div style=\"float: right;width:49%\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["order"];
echo "  ";
echo $LNG["id"];
echo " - ";
echo $id;
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n\n<table  width=\"100%\" class=\"form\">\n<tbody>\n";
foreach ($row[$id]["customfields"] as $val) {
    echo "<tr><td class=\"fieldlabel\">";
    echo $val["name"];
    echo "</td><td class=\"fieldarea\"><span>";
    echo $val["input"];
    echo "</span></td></tr>\n";
}
if ($row[$md5id]["allfield"]["user_can_c"] == "3") {
    echo " <tr><td class=\"fieldlabel\">";
    echo $LNG["reason"];
    echo "</td><td class=\"fieldarea\" width=\"40%\">";
    echo $row[$md5id]["allfield"]["reply"];
    echo " </td></tr>";
}
echo "<tr><td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td><td class=\"fieldarea\"><span>";
echo $row[$id]["status"];
echo "</span>";
if ($row[$id]["verification"] == "1") {
    echo " | " . $LNG["waiting"] . " " . $LNG["for"] . " " . $LNG["verification"];
}
echo "</td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["order"];
echo " ";
echo $LNG["on"];
echo "</td><td class=\"fieldarea\"><span>";
echo formatDate($row[$md5id]["allfield"]["time"], "time", true);
echo "</span></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["cost"];
echo "</td><td class=\"fieldarea\"><strong>";
echo formatCurrency($row[$id]["credit"] - $row[$id]["discount"], $clientDetails["currency"]);
echo "</strong></td></tr>\n\n<tr><td class=\"fieldlabel\">";
echo $LNG["reply"];
echo " ";
echo $LNG["time"];
echo "</td><td class=\"fieldarea\"><span>";
if ($row[$md5id]["allfield"]["reply_time"]) {
    echo formatDate(date("Y-m-d", $row[$md5id]["allfield"]["reply_time"] . " " . date("h:i:s", $row[$md5id]["allfield"]["reply_time"])));
} else {
    echo "-";
}
echo "</span></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["reply"];
echo " ";
echo $LNG["by"];
echo "</td><td class=\"fieldarea\"><span>";
echo $reply;
echo " [";
if ($replyBy) {
    echo "<a style=\"text-decoration: none !important;\" href=\"javascript:redirectedit('editadmin',";
    echo $replyBy;
    echo ")\">";
    echo $replyBy;
    echo "</a>";
} else {
    echo "-";
}
echo "]</span></td></tr>\n<tr><td class=\"fieldlabel\"> ";
echo $LNG["user"];
echo " ";
echo $LNG["note"];
echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["note"];
echo "\" name=\"note\"/></span></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["comments"];
echo "</td><td class=\"fieldarea\"><span><input type=\"text\" value=\"";
echo $row[$md5id]["allfield"]["comments"];
echo "\" name=\"comments\"/></span></td></tr>\n</tbody>\n</table>\n\n<p class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituser.editserverorder','#frmedituser','#notification','true','#main_loader');\"/>\n</p>\n\n\n</div>\n</div>\n\n<br />\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["shipping"];
echo " ";
echo $LNG["information"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table  border=\"0\" width=\"100%\">\n<tbody>\n<tr><td>";
echo $LNG["trackingid"];
echo " : <span class='click' id='reply|";
echo $id;
echo "'>";
echo $row[$md5id]["allfield"]["reply"];
echo "</span> </td></tr>\n\n";
$s = $row[$id]["gatway"];
$shipped = mysqli_fetch_assoc(dquery("select value,trackingurl,gateway from tbl_shipping_services where id='" . $s . "'"));
echo "<tr><td><span>";
if ($row[$id]["gift"]) {
    echo (string) $LNG["giftwrap"];
}
echo "</span></td></tr>\n<tr><td><span>";
echo $LNG["shippedby"] . " : " . $shipped["value"] . " [" . $shipped["gateway"] . "]";
echo "</span></td></tr>\n<tr><td><span>";
if ($shipped["trackingurl"]) {
    echo (string) $shipped["trackingurl"];
}
echo "</span></td></tr>\n\n<tr><td><span><strong>";
echo $LNG["shipping"];
echo " ";
echo $LNG["address"];
echo "</strong></span></td></tr>\n";
$add = mysqli_fetch_assoc(dquery("select sh_firstname,sh_lastname,sh_address1,sh_address2,sh_email,sh_city,sh_zip,sh_state,sh_country,sh_contact from tbl_order_product where order_id='" . $id . "'"));
$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<tr><td>";
echo "<span class='click' id='sh_firstname|" . $id . "'>" . $add["sh_firstname"] . "</span> <span class='click' id='sh_lastname|" . $id . "'>" . $add["sh_lastname"] . "</span> [<span class='click' id='sh_email|" . $id . "'>" . $add["sh_email"] . "</span>]";
echo "</td></tr>\n<tr><td>";
echo "<span class='click' id='sh_address1|" . $id . "'>" . $add["sh_address1"] . "</span>";
echo "</span></td></tr>\n<tr><td>";
echo "<span class='click' id='sh_address2|" . $id . "'>" . $add["sh_address2"] . "</span>";
echo "</td></tr>\n<tr><td>";
echo "<span class='click' id='sh_city|" . $id . "'>" . $add["sh_city"] . "</span>";
echo "</td></tr>\n<tr><td>";
echo "<span class='click' id='sh_state|" . $id . "'>" . $add["sh_state"] . "</span> - <span class='click' id='sh_zip|" . $id . "'>" . $add["sh_zip"] . "</zip>";
echo "</td></tr>\n<tr><td>";
echo "<span class='click' id='sh_country|" . $id . "'>" . $add["sh_country"] . "</span>";
echo "</td></tr>\n<tr><td>";
echo $LNG["phonenumber"] . " : <span class='click' id='sh_contact|" . $id . "'>" . $add["sh_contact"] . "</span>";
echo "</td></tr>\n</tbody>\n</table>\n\n\n\n</form>\n</div>\n</div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>