<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<style>\n.chathistory{border: 1px solid #DDD;  margin: auto; margin-bottom: 2px;}\n.header{padding: 5px;}\n.adminblue{color: #143d55;}\n.userorange{color: #f99d39;}\n</style>\n";
licince\reqaddon("Live Chat");
$pageid = 396;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["staff"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"adminlist\">\n        <option>";
echo $LNG["select"];
echo "</option>\n";
$result = dquery("select distinct `from` from tbl_chat,tbl_admin where tbl_chat.from=tbl_admin.username");
while ($row = mysqli_fetch_assoc($result)) {
    if ($adminlist == (string) $row["from"]) {
        $selected = "selected";
    } else {
        $selected = " ";
    }
    echo "<option " . $selected . " value=" . $row["from"] . ">" . $row["from"] . "</option>";
}
echo "</select></td>\n<td class=\"fieldlabel\">";
echo $LNG["chat"] . " " . $LNG["with"];
echo "</td>\n<td class=\"fieldarea\"><select name=\"clientlist\">\n        <option>";
echo $LNG["select"];
echo "</option>\n";
$result = dquery("select distinct `from` from tbl_chat,tblUsers where tbl_chat.from=tblUsers.username");
while ($row = mysqli_fetch_assoc($result)) {
    if ($clientlist == (string) $row["from"]) {
        $selected = "selected";
    } else {
        $selected = " ";
    }
    echo "<option " . $selected . " value=" . $row["from"] . ">" . $row["from"] . "</option>";
}
echo "</select></td></tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["from"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"startdate\" class=\"datepicker\"   autocomplete=\"off\" id=\"from\" value=\"";
echo $blog["date"];
echo "\" />\n    </span></td>\n\n    <td class=\"fieldlabel\">";
echo $LNG["to"];
echo " ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"enddate\" class=\"datepicker\"  autocomplete=\"off\"  id=\"to\" value=\"";
echo $blog["date"];
echo "\" />\n    </span></td>\n</tr>\n<tr><td class=\"fieldlabel\"></td><td>\n<input type=\"submit\" value=\"";
echo $LNG["show"];
echo "\" name=\"showHistory\"/></td></tr></tbody></table>\n</form>\n<br />\n";
if ($showHistory) {
    if (!$startdate && !$enddate) {
        $date = "1=1";
    } else {
        $date = "DATE(sent) between '" . $startdate . "' and '" . $enddate . "'";
    }
    $result = dquery("select * from tbl_chat where (`from`='" . $adminlist . "' or `from`='" . $clientlist . "') AND (`to`='" . $adminlist . "' or `to`='" . $clientlist . "') AND (" . $date . ") order by sent");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class=\"chathistory\">\n    <div class=\"header\"><strong ";
        if ($adminlist == $row["from"]) {
            echo "class=adminblue";
        } else {
            echo "class=userorange";
        }
        echo " style=\"float: left;\">";
        echo $row["from"];
        echo " : </strong>  <span style=\"float: left; width: 90%;\">";
        echo $row["message"];
        echo "</span> <div style=\"clear: both;\"></div><br /><span style=\"font-size: 10px; margin-left: 50px;\">";
        echo $LNG["chat"] . " " . $LNG["on"];
        echo " ";
        echo $row["sent"];
        echo "</span> </div>\n</div>\n";
    }
}
echo "</div></div> ";
$fileverioncheck = "6.1.0";

?>