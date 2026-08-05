<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
include_once ROOTDIR . "/includes/fileservices.fun.php";
if ($saver && $purchasecost) {
    checkDemoMode(false);
    if ($purchase) {
        foreach ($purchase as $k => $v) {
            if ($v) {
                if (mysqli_num_rows(dquery("select id from tbl_purchase_cost \n                        where cid='" . $k . "' and sid='" . $id . "' and type='file'"))) {
                    $data["price"] = $v;
                    $db->update("tbl_purchase_cost", $data, "sid='" . $id . "' and type='file' and cid='" . $k . "'");
                    $data = NULL;
                } else {
                    $data["price"] = $v;
                    $data["cid"] = $k;
                    $data["sid"] = $id;
                    $data["type"] = "file";
                    $db->insert("tbl_purchase_cost", $data);
                    $data = NULL;
                }
            }
        }
    }
    $data["purchase_cost"] = formatCurrency2($purchasecost);
    if ($db->update("tbl_services_file", $data, "id=" . $id)) {
        echo "<div id='notification1' class='successbox' >" . $LNG["datasavesuccessfully"] . "</div>";
    }
} else {
    if ($saver) {
        echo "<div id='notification1' class='errorbox' >Default Currency should not blank</div>";
    }
}
$md5id = md5($id);
$fileserviceDetails = getFileServices("", $md5id);
echo "\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"true\" name=\"curs\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<table class=\"form\">\n\n<tr>\n<td class=\"fieldlabel\">";
echo $config["base_currency"];
echo "*</td><td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\"  name=\"purchasecost\" value=\"";
echo $fileserviceDetails["purchase_cost"];
echo "\" /></td><td></td>\n</tr>\n</table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n<table class=\"form\">\n            <tbody>\n\n";
$sql = dquery("select id,code from tbl_currencies WHERE `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    $price = getPurchaseCost($row["id"], $fileserviceDetails["id"], "file");
    echo "<tr>\n     <td class=\"fieldlabel\">";
    echo $row["code"];
    echo "</td>\n     <td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt small\" value=\"";
    echo $price;
    echo "\" name=\"purchase[";
    echo $row["id"];
    echo "]\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> </td><td></td>\n</tr>\n";
}
echo "</tbody></table>\n</div></div>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" name=\"saver\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>