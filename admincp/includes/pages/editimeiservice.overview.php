<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"includes/css/amsify.suggestags.css\">\n<script type=\"text/javascript\" src=\"includes/js/jquery.amsify.suggestags.js\"></script>\n";
$pageid = 315;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5(trim($id));
$imeiserviceDetails = getIMEIServices("", $md5id);
$happyhours = getIMEIhappyhours($id);
$group = getIMEIServiceGroup($imeiserviceDetails["useasserver"]);
if ($delete) {
    dquery("DELETE FROM tbl_services_imei WHERE id='" . $id . "'");
    dquery("DELETE FROM tbl_imei_credit WHERE service_id='" . $id . "'");
    if ($order) {
        dquery("DELETE FROM tbl_order_imei WHERE service_id='" . $id . "'");
    }
    if ($group) {
        dquery("DELETE FROM tbl_client_group_price WHERE service_id='" . $id . "' AND service_type='imei'");
    }
    dquery("DELETE FROM tbl_discount_imei WHERE service_id='" . $id . "'");
    echo "    <script>\n        \$(function() {\n            \$(\"#subpage\").hide('fast');\n        });\n    </script>\n    <div id=\"notification1\" class=\"successbox\">";
    echo $LNG["remove"] . " " . $LNG["successfully"];
    echo "</div>\n    ";
}
$arrs = [];
$qr = dquery("select id,title from tbl_knowledgebase");
while ($rq = mysqli_fetch_assoc($qr)) {
    $arrs[] = "'" . str_replace(",", "__", $rq["title"]) . "'";
}
if ($imeiserviceDetails["knowledgebase"]) {
    $knowledese = mysqli_fetch_assoc(dquery("select group_concat(replace(title,',','__')) as kart from \n    tbl_knowledgebase where id in (" . $imeiserviceDetails["knowledgebase"] . ")"));
    $knowledese = $knowledese["kart"];
}
echo "<div id=\"notification\"></div>\n<div id=\"content\" style=\"position: relative;\">\n    <div id=\"content_padded\">\n        <form id=\"frm\" name=\"\" method=\"post\">\n\n            <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n            ";
echo generate_token("form");
echo "\n            <div id=\"accountinfo1\" class=\"groupstabes first\" >\n                <h2>\n                    <span class=\"groupstabesheadertext\">";
echo $imeiserviceDetails["service_name"];
echo "</span>\n                    <div style=\"float: right;\">\n                        <a class='default_dg_a2' href=\"javascript:load_subpage('main2.php?page=editimeiservice.seo&id=";
echo $id;
echo "','";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo "');\"> ";
echo $LNG["seo"];
echo " ";
echo $LNG["options"];
echo "</a> &nbsp;&nbsp;&nbsp;&nbsp;\n                        <a target=\"_blank\"  href=\"";
echo $config["site_address"] . "cart.php?item=" . $imeiserviceDetails["id"] . "&service=imei&parentid=1008&group=" . $imeiserviceDetails["group_id"] . "";
echo "\">\n                            View as Client</a> &nbsp;&nbsp;&nbsp;&nbsp;\n                        <a href=\"#\"  onclick=\"showsummary()\">Order Summary</a>\n                    </div>\n                </h2>\n                ";
if ($imeiserviceDetails["lastupdatedby"]) {
    echo "<i>" . $LNG["last"] . " " . $LNG["updated"] . " " . $LNG["by"] . " : " . $imeiserviceDetails["lastupdatedby"] . "</i>";
}
echo "                <div class=\"groupstabescontant\">\n\n                    <table class=\"form\">\n\n\n                        <tr class=\"tele\">\n                            <td class=\"fieldlabel\"></td>\n                            <td class=\"fieldarea\">\n                            </td>\n                        </tr>\n                        <tr>\n                            <td class=\"fieldlabel\">\n                                ";
echo $LNG["status"];
echo "                            </td>\n                            <td class=\"fieldarea\">\n                                <table>\n                                    <tr>\n                                        <td>Base</td>\n                                        ";
$qc = dquery("select id,groupname from tbl_client_group");
while ($rc = mysqli_fetch_assoc($qc)) {
    echo "                                            <td>";
    echo $rc["groupname"];
    echo "</td>\n                                            ";
}
echo "                                    </tr>\n                                    <tr>\n\n\n                                    <td>\n                                        ";
$basestatus = mysqli_fetch_assoc(dquery("select `status` from \n    tbl_service_status where serviceid='" . $id . "' and groupid='base'"));
echo "                                        <input ";
if ($basestatus["status"] == "1") {
    echo "checked=checked";
}
echo " name=\"status[base]\" value=\"1\" type=\"checkbox\"\n                                    </td>\n                                    ";
$qc = dquery("select id,groupname from tbl_client_group");
while ($rc = mysqli_fetch_assoc($qc)) {
    $basestatus = mysqli_fetch_assoc(dquery("select `status` from \n                                            tbl_service_status where serviceid='" . $id . "' and groupid='" . $rc["id"] . "'"));
    echo "                                            <td>\n                                                <input ";
    if ($basestatus["status"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"status[";
    echo $rc["id"];
    echo "]\" value=\"1\" type=\"checkbox\"\n                                                                                                                   class=\"onoff {labelOn: 'Enable',labelOff:'Disable'}\" id=\"hsop";
    echo $rc["id"];
    echo "\"/><label for=\"hsop";
    echo $rc["id"];
    echo "\"></label>\n                                            </td>\n                                            ";
}
echo "                                    </tr>\n                                </table>\n\n                                <label><input type=\"checkbox\" name=\"sendnotification\" value=\"1\" />Send notification to Telegram Channel about service status  </label>\n\n                            </td>\n                        </tr>\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["hide"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["visitors"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                ";
if ($imeiserviceDetails["hideguestgroup"]) {
    echo "<strong>This service is hidden for visitors due to group is hidden for visitors.</strong>";
} else {
    echo "                                    <input name=\"hideguest\" value=\"1\" type=\"radio\"\n                                           id=\"hideguest\" ";
    if ($imeiserviceDetails["hideguest"] == "1") {
        echo "checked";
    }
    echo "/><label\n                                        for=\"hideguest\">";
    echo $LNG["yes"];
    echo "</label>\n                                    <input name=\"hideguest\" value=\"0\" type=\"radio\"\n                                           id=\"hideguestl0\" ";
    if ($imeiserviceDetails["hideguest"] == "0") {
        echo "checked";
    }
    echo "/><label\n                                        for=\"hideguestl0\">";
    echo $LNG["no"];
    echo "</label>\n                                    <small>";
    echo $LNG["do"];
    echo " ";
    echo $LNG["not"];
    echo " ";
    echo $LNG["display"];
    echo " ";
    echo $LNG["in"];
    echo " ";
    echo $LNG["wholesale"];
    echo " ";
    echo $LNG["price"];
    echo " ";
    echo $LNG["without"];
    echo "  ";
    echo $LNG["login"];
    echo "</small>\n                                    ";
}
echo "                            </td>\n                        </tr>\n\n                    </table>\n\n                    <div >\n                        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                            <tbody>\n\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["servicename"];
echo " *</td>\n                                <td class=\"fieldarea\"><input   name=\"servicename\"  value=\"";
echo $imeiserviceDetails["service_name"];
echo "\" type=\"text\"  class=\"txt large\"/>\n\n                                    <span class=\"textgreen\"> <a class='default_dg_a2' onclick=\"load_subpage('main2.php?page=editimeiservice.info&id=";
echo $id;
echo "','";
echo $LNG["edit"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["information"];
echo "');\">";
echo $LNG["service"];
echo " ";
echo $LNG["information"];
echo "</a></span>\n\n                                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  <span class=\"textgreen\"> <a class='default_dg_a2' onclick=\"load_subpage('main2.php?page=editimeiservice.howto&id=";
echo $id;
echo "','How to  ";
echo $LNG["information"];
echo "');\">How to ";
echo $LNG["information"];
echo "</a></span>\n                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n                                <td class=\"fieldarea\"><select name=\"groupname\" class=\"chosen\">\n                                        ";
foreach ($group as $key => $value) {
    $value = $group[$key]["name"];
    if ($key == $imeiserviceDetails["group_id"]) {
        echo "<option value=" . $key . " selected>" . $value . "</option>";
    } else {
        if ($group[$key]["active"] == 0) {
            echo "<option value=" . $key . " class=textred>" . $value . "    (<font style=font-style: italic;>Inactive</font>)</option>";
        } else {
            echo "<option value=" . $key . ">" . $value . "</option>";
        }
    }
}
echo "</select> &nbsp; <a href=\"#\" data-target=\"addimeigroup\" data-value=\"addimeigroup\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "\" onclick=\"AddnewInpopup(this,'";
echo $imeiserviceDetails["useasserver"] ? $imeiserviceDetails["useasserver"] : "";
echo "');\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["group"];
echo "</a> </td>\n                            </tr>\n                            ";
if ($imeiserviceDetails["time"]) {
    $time = explode(" ", $imeiserviceDetails["time"]);
}
echo "                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n                                <td class=\"fieldarea\"><input onkeyup=\"return cFd(this,false)\"  name=\"time1\"  value=\"";
echo $time[0];
echo "\" type=\"text\"  class=\"txt small\" onblur=\"return cFd(this,true)\"/>\n\n                                    <select name=\"timeref\" style=\"width: 290px;\">\n                                        <option value=\"Miniutes\" ";
if ($time[1] == "Miniutes") {
    echo "selected";
}
echo ">";
echo $LNG["minutes"];
echo "</option>\n                                        <option value=\"";
echo $LNG["hours"];
echo "\" ";
if ($time[1] == $LNG["hours"]) {
    echo "selected";
}
echo ">";
echo $LNG["hours"];
echo "</option>\n                                        <option value=\"";
echo $LNG["weeks"];
echo "\" ";
if ($time[1] == $LNG["weeks"]) {
    echo "selected";
}
echo ">";
echo $LNG["weeks"];
echo "</option>\n                                        <option value=\"";
echo $LNG["days"];
echo "\" ";
if ($time[1] == $LNG["days"]) {
    echo "selected";
}
echo ">";
echo $LNG["days"];
echo "</option>\n                                        <option value=\"";
echo $LNG["months"];
echo "\" ";
if ($time[1] == $LNG["months"]) {
    echo "selected";
}
echo ">";
echo $LNG["months"];
echo "</option>\n                                        <option value=\"";
echo $LNG["instant"];
echo "\" ";
if ($time[1] == $LNG["instant"]) {
    echo "selected";
}
echo ">";
echo $LNG["instant"];
echo "</option>\n                                    </select>\n\n                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">Max. Response ";
echo $LNG["time"];
echo " </td>\n                                <td class=\"fieldarea\">\n                                    <input onkeyup=\"return cFd(this,false)\"  name=\"maxresponsetime\"\n                                           value=\"";
echo $imeiserviceDetails["maxresponsetime"];
echo "\" type=\"text\"\n                                           class=\"txt small\" onblur=\"return cFd(this,true)\"/> ";
echo $LNG["hours"];
echo "                                    <br />\n                                    <div class=\"clearfix\">\n                                        Max. response time for Admin only\n                                    </div>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\" >";
echo $LNG["free"];
echo "&nbsp;";
echo $LNG["service"];
echo "\n                                </td>\n                                <td class=\"fieldarea\"  onclick=\"javascript: showforfree();\">\n                                    <input   ";
if ($imeiserviceDetails["free"] == "1") {
    echo "checked=checked";
}
echo " name=\"free\" value=\"1\" type=\"checkbox\" class=\"onoff\n        {labelOn: 'Enable',\n        labelOff: 'Disable'}\" id=\"fred\"/><label  for=\"fred\"></label>\n                                </td>\n                            </tr>\n\n                            <tr class=\"pricings\" style=\"";
if ($imeiserviceDetails["free"] == "1") {
    echo "display:none";
}
echo "\">\n                                <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\"   disabled  size=\"5\" name=\"safalo\" value=\"";
echo $imeiserviceDetails["credit"];
echo "\" />\n                                    <span class=\"textgreen\" ><a class='default_dg_a2'\n                                                                onclick=\"load_subpage('dist/#/grouppricing/";
echo $id;
echo "','";
echo $LNG["service"];
echo " ";
echo $LNG["pricing"];
echo "');\">  ";
echo $LNG["set"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo " </a></span>\n                                    <br />\n                                    <small>\n                                        ";
if ($imeiserviceDetails["purchase_cost"]) {
    echo "Purchase Cost: " . $imeiserviceDetails["purchase_cost"];
} else {
    echo "                                            * Your Purchase cost not set yet <a\n                                                    onclick=\"load_subpage('main2.php?page=editimeiservice.purchasecost&id=";
    echo $id;
    echo "','";
    echo $LNG["service"];
    echo " ";
    echo $LNG["pricing"];
    echo "');\"\n                                            >Click here</a> to set your purchase cost.\n                                            ";
}
echo "</small>\n                                </td>\n                            </tr>\n\n\n                            ";
$result = dquery("select id,type from tbl_service_type");
echo "                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["type"];
echo "</td>\n                                <td class=\"fieldarea\"><select name=\"servicetype\">\n                                        <option value=\"0\">";
echo $LNG["select"];
echo "</option>\n                                        ";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["type"] == $imeiserviceDetails["type"]) {
            echo "<option value=" . $row["id"] . " selected>" . $row["type"] . "</option>";
        } else {
            echo "<option value=" . $row["id"] . ">" . $row["type"] . "</option>";
        }
    }
}
echo "                                    </select></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["iconlink"];
echo " </td>\n                                <td class=\"fieldarea\"><input name=\"iconlink\" id=\"iconlink\" value=\"";
echo $imeiserviceDetails["icon_link"];
echo "\" type=\"text\"  class=\"txt\"/> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\"/></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["downloadlink"];
echo " </td>\n                                <td class=\"fieldarea\"><input name=\"downloadlink\"  value=\"";
echo $imeiserviceDetails["download_link"];
echo "\" type=\"text\"  class=\"txt\"/></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["color"];
echo " Tag</td>\n                                <td class=\"fieldarea\"><input name=\"colortag\"  value=\"";
echo $imeiserviceDetails["colortag"];
echo "\" type=\"text\" class=\"colortag\"  size=\"7\" class=\"txt\"/></td>\n                            </tr>\n\n                            ";
$result = dquery("select id,title from tbl_knowledgebase");
echo "                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["knowledgebase"];
echo "</td>\n                                <td class=\"fieldarea\">\n\n                                    <input type=\"text\" name=\"knowledgebase\" value=\"";
echo $knowledese;
echo "\"  />\n\n                                    <select class=\"chosen\" name=\"faq\" style=\"width: 100% !important;\">\n                                        <option value=\"\">";
echo $LNG["select"];
echo "</option>\n                                        ";
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["id"] == $imeiserviceDetails["faq_id"]) {
            echo "<option value=" . $row["id"] . " selected>" . $row["title"] . "</option>";
        } else {
            echo "<option value=" . $row["id"] . ">" . $row["title"] . "</option>";
        }
    }
}
echo "                                    </select>\n                                    <br /><div style=\"clear: both;\"></div>\n                                    <label><input type=\"checkbox\"\n                                            ";
if ($imeiserviceDetails["knowledgebaseas"]) {
    echo "checked";
}
echo "                                                  name=\"knowledgebaseas\" value=\"1\" />Load Knowledgebase data to service info</label>\n                                </td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["verification"];
echo "</td>\n                                <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"vy\" name=\"verification\" value=\"1\"\n                 onclick=\"getVerify();\" ";
if ($imeiserviceDetails["verifiable"] == "1") {
    echo "checked";
}
echo "/><label for=\"vy\">";
echo $LNG["yes"];
echo "</label></span>\n                                    <span><input onclick=\"getVerify();\" type=\"radio\" name=\"verification\" id=\"vn\" value=\"0\" ";
if ($imeiserviceDetails["verifiable"] == "0") {
    echo "checked";
}
echo "/><label for=\"vn\">";
echo $LNG["no"];
echo "</label></span>\n                                    <small> ";
echo $LNG["userorderverification"];
echo "  </small>\n                                </td>\n                            </tr>\n\n                            <tr class=\"veridays\" ";
if ($imeiserviceDetails["verifiable"] == "0") {
    echo "style=\"display: none;\" ";
}
echo ">\n                                <td class=\"fieldlabel\">User can verify order within</td>\n                                <td class=\"fieldarea\">\n                                    <input type=\"text\" name=\"verificationdays\"\n                                           value=\"";
echo $imeiserviceDetails["verificationdays"];
echo "\" size=\"4\" /> ";
echo $LNG["days"];
echo "                                </td>\n                            </tr>\n                            ";
if ($imeiserviceDetails["useasserver"] == 0) {
    echo "                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["accept"];
    echo "                                        ";
    echo $LNG["duplicate"];
    echo " IMEI ";
    echo $LNG["order"];
    echo "</td>\n                                    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"at\" name=\"autoreply\" value=\"1\" ";
    if ($imeiserviceDetails["autoreply"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"at\">";
    echo $LNG["yes"];
    echo "</label></span>\n                                        <span><input type=\"radio\" name=\"autoreply\" id=\"avn\" value=\"0\" ";
    if ($imeiserviceDetails["autoreply"] == "0") {
        echo "checked";
    }
    echo "/><label for=\"avn\">";
    echo $LNG["no"];
    echo "</label></span>\n                                        <span>  <small>Automatically change new order status to accepted and add previous successful order reply. <br />\n      Admin can confirm this kind of already replied order. </small></span>\n                                    </td>\n                                </tr>\n\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["reply"];
    echo "                                        ";
    echo $LNG["duplicate"];
    echo " IMEI ";
    echo $LNG["order"];
    echo "</td>\n                                    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"atss\" name=\"autoreplycompleted\" value=\"1\" ";
    if ($imeiserviceDetails["autoreplycompleted"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"atss\">";
    echo $LNG["yes"];
    echo "</label></span>\n                                        <span><input type=\"radio\" name=\"autoreplycompleted\" id=\"avnss\" value=\"0\" ";
    if ($imeiserviceDetails["autoreplycompleted"] == "0") {
        echo "checked";
    }
    echo "/><label for=\"avnss\">";
    echo $LNG["no"];
    echo "</label></span>\n                                        <span>  <small>Automatically reply new order and change status to completed and add previous successful order reply. <br />\n      Admin can view admin notes for this kind of already replied order. </small></span>\n                                    </td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["reject"];
    echo "                                        ";
    echo $LNG["duplicate"];
    echo " IMEI ";
    echo $LNG["order"];
    echo "</td>\n                                    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"atssr\" name=\"autorejectduplicate\" value=\"1\" ";
    if ($imeiserviceDetails["autorejectduplicate"] == "1") {
        echo "checked";
    }
    echo "/><label for=\"atssr\">";
    echo $LNG["yes"];
    echo "</label></span>\n                                        <span><input type=\"radio\" name=\"autorejectduplicate\" id=\"avnssr\" value=\"0\" ";
    if ($imeiserviceDetails["autorejectduplicate"] == "0") {
        echo "checked";
    }
    echo "/><label for=\"avnssr\">";
    echo $LNG["no"];
    echo "</label></span>\n                                        <span>  <small>Automatically reject new order and change status to cancelled if same imei placed by user for same service and if order is pending. <br />\n       </small></span>\n                                    </td>\n                                </tr>\n                                ";
}
echo "\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["cancelorder"];
echo "</td>\n                                <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"cy\" name=\"cancel\" value=\"1\" ";
if ($imeiserviceDetails["usercan_cancel"] == "1") {
    echo "checked";
}
echo "/><label for=\"cy\">";
echo $LNG["yes"];
echo "</label></span>\n                                    <span><input type=\"radio\" name=\"cancel\" id=\"cn\" value=\"0\" ";
if ($imeiserviceDetails["usercan_cancel"] == "0") {
    echo "checked";
}
echo "/><label for=\"cn\">";
echo $LNG["no"];
echo "</label></span>\n                                    <span>  <small>";
echo $LNG["usercancelorder"];
echo "</small></span>\n                                </td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
echo $LNG["features"];
echo "</td>\n                                <td class=\"fieldarea\">\n                                    <input type=\"checkbox\" ";
if (deregi($LNG["refundavailable"], $imeiserviceDetails["features"])) {
    echo "checked";
}
echo " name=\"features[]\" id=\"refund\" value=\"";
echo $LNG["refundavailable"];
echo "\" /><label for=\"refund\">";
echo $LNG["refundavailable"];
echo "</label> <br />\n                                    <input type=\"checkbox\" ";
if (deregi($LNG["serviceavailable"], $imeiserviceDetails["features"])) {
    echo "checked";
}
echo " name=\"features[]\" id=\"servav\" value=\"";
echo $LNG["serviceavailable"];
echo "\" /><label for=\"servav\">";
echo $LNG["serviceavailable"];
echo "</label> <br />\n                                    <input type=\"checkbox\" ";
if (deregi($LNG["unlockguran"], $imeiserviceDetails["features"])) {
    echo "checked";
}
echo " name=\"features[]\" id=\"unloc\" value=\"";
echo $LNG["unlockguran"];
echo "\" /><label for=\"unloc\">";
echo $LNG["unlockguran"];
echo "</label> <br />\n                                    <input type=\"checkbox\" ";
if (deregi($LNG["norefund"], $imeiserviceDetails["features"])) {
    echo "checked";
}
echo " name=\"features[]\" id=\"noref\" value=\"";
echo $LNG["norefund"];
echo "\" /><label for=\"noref\">";
echo $LNG["norefund"];
echo "</label> <br />\n                                    <input type=\"checkbox\" ";
if (deregi($LNG["workingon"], $imeiserviceDetails["features"])) {
    echo "checked";
}
echo " name=\"features[]\" id=\"workinon\" value=\"";
echo $LNG["workingon"];
echo "\" /><label for=\"workinon\">";
echo $LNG["workingon"];
echo "</label>\n                                </td>\n                            </tr>\n\n                        </table>\n\n                        <br /><br />\n\n                        <div id=\"accountinfo1\" class=\"groupstabes\" >\n                            <h2>\n                                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                                <span class=\"groupstabesheadertext\">Advance Settings</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                            </h2>\n                            <div class=\"groupstabescontant\">\n\n                                <table class=\"form\">\n\n\n\n                                    <tr>\n                                        <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["email"];
echo " </td>\n                                        <td class=\"fieldarea\">\n                                            <input type='radio' name='notificationemail' id='eem' value=\"0\" ";
if (!$imeiserviceDetails["notificationemail"]) {
    echo "checked='checked'";
}
echo " /><label for='eem'>";
echo $LNG["enable"];
echo "</label>\n\n                                            <input type='radio' name='notificationemail' id='dem' value=\"1\" ";
if ($imeiserviceDetails["notificationemail"]) {
    echo "checked='checked'";
}
echo " /><label for='dem'>";
echo $LNG["disable"];
echo "</label>\n\n                                            <input name=\"notificationmail\"  value=\"";
echo $imeiserviceDetails["notification_mail"];
echo "\" type=\"text\"  class=\"txt\"/><small>Send order notification email other than admin. If its disable then admin and other supplier will not get emails. ";
echo $LNG["email"];
echo " ";
echo $LNG["seperated"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["commas"];
echo "</small></td>\n                                    </tr>\n                                    ";
if ($config["smsgateway"]) {
    echo "                                        <tr>\n                                            <td class=\"fieldlabel\">";
    echo $LNG["new"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["notification"];
    echo " ";
    echo $LNG["by"];
    echo " ";
    echo $LNG["sms"];
    echo " </td>\n                                            <td class=\"fieldarea\">\n                                                <input type='radio' name='smsnotification' id='esm' value=\"1\" ";
    if ($imeiserviceDetails["smsnotification"]) {
        echo "checked='checked'";
    }
    echo " /><label for='esm'>";
    echo $LNG["enable"];
    echo "</label>\n                                                <input type='radio' name='smsnotification' id='dsm' value=\"0\" ";
    if (!$imeiserviceDetails["smsnotification"]) {
        echo "checked='checked'";
    }
    echo " /><label for='dsm'>";
    echo $LNG["disable"];
    echo "</label>\n                                            </td>\n                                        </tr>\n                                        ";
}
echo "\n                                    <tr>\n                                        <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["by"];
echo " Telegram </td>\n                                        <td class=\"fieldarea\">\n                                           <input type=\"text\" name=\"telegramchannel\" value=\"";
echo $imeiserviceDetails["channelid"];
echo "\" />\n                                            <input type=\"button\" class=\"bts\" onclick=\"SubmitForm('#bts','servicestattest','#frm','#notification','true','#main_loader');\"\n                                                   name=\"sendtest\" value=\"Send Test message to Channel\" />\n                                            <small>Telegram channel id (need to add admin Bot to this channel as a Admin)</small>\n                                        </td>\n                                    </tr>\n                                    <tr>\n                                        <td class=\"fieldlabel\">";
echo $LNG["ordersuccemail"];
echo "  </td>\n                                        <td class=\"fieldarea\">\n\n                                            <select name=\"template1\" onchange=\"getMyTempl(this.value);\">\n\n                                                ";
if ($imeiserviceDetails["useasserver"] == 2) {
    $e = dquery("select * from tbl_emailtemplates where `type`='remoteorder'");
} else {
    if ($imeiserviceDetails["useasserver"] == 1) {
        echo "<option value=\"\">Default - Bulk reply in single mail</option>";
        $e = dquery("select * from tbl_emailtemplates where `type`='serverorder'");
    } else {
        echo "<option value=\"\">Default - Bulk reply in single mail</option>";
        $e = dquery("select * from tbl_emailtemplates where `type`='imeiorder'");
    }
}
echo "                                                <option value=\"999999\" ";
if ($imeiserviceDetails["template_id1"] == 999999) {
    echo "selected";
}
echo ">Do not send email</option>\n\n                                                ";
while ($row = mysqli_fetch_assoc($e)) {
    if ($imeiserviceDetails["template_id1"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "                                            </select>\n\n                                            <span id=\"editimail\">\n     <a href=\"javascript: load_subpage('main2.php?page=emailtemplate.edit&id=64','Edit Mail Template')\" class=\"btn\" style=\"float: right;color: white !important;\">\n    ";
echo $LNG["edit"];
echo " ";
echo $LNG["mail"];
echo " ";
echo $LNG["template"];
echo "</a>\n    </span>\n                                        </td>\n                                    </tr>\n\n                                    <tr>\n                                        <td class=\"fieldlabel\">";
echo $LNG["orderrejemail"];
echo "</td>\n                                        <td class=\"fieldarea\">\n                                            <select name=\"template2\" onchange=\"javascript: getMyTempl2(this.value);\">\n                                                ";
if ($imeiserviceDetails["useasserver"] == 2) {
    $e = dquery("select * from tbl_emailtemplates where `type`='remoteorder'");
} else {
    if ($imeiserviceDetails["useasserver"] == 1) {
        echo "<option value=\"\">Default - Bulk reject in single mail</option>";
        $e = dquery("select * from tbl_emailtemplates where `type`='serverorder'");
    } else {
        echo "<option value=\"\">Default - Bulk reject in single mail</option>";
        $e = dquery("select * from tbl_emailtemplates where `type`='imeiorder'");
    }
}
echo "                                                <option value=\"999999\" ";
if ($imeiserviceDetails["template_id2"] == 999999) {
    echo "selected";
}
echo ">Do not send email</option>\n\n                                                ";
while ($row = mysqli_fetch_assoc($e)) {
    if ($imeiserviceDetails["template_id2"] == $row["id"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    if ($row["name"] != "") {
        echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["name"] . "</option>";
    }
}
echo "                                            </select>\n                                            <span id=\"editimail2\"></span>\n                                        </td>\n                                    </tr>\n                                    ";
if ($config["slacktoken"]) {
    $SlackArr = SlackGetChannels();
    if (!$config["slack_servicepricechange"]) {
        echo "                                            <tr>\n                                                <td class=\"fieldlabel\">Slack ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["price"];
        echo " ";
        echo $LNG["change"];
        echo "</td>\n                                                <td class=\"fieldarea\">\n\n                                                    <select name=\"priceslack\">\n                                                        <option value=\"\">Select Price Notification Group</option>\n                                                        ";
        foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
            $selected = "";
            if ($groupid == $imeiserviceDetails["priceslack"]) {
                $selected = "selected";
            }
            echo "                                                            <option ";
            echo $selected;
            echo " value=\"";
            echo $groupid;
            echo "\">";
            echo $groupdetail["name"];
            echo "</option>\n                                                            ";
        }
        echo "                                                    </select>\n\n                                                </td>\n                                            </tr>\n                                            ";
    }
    if (!$config["slack_ordernotification"]) {
        echo "                                            <tr>\n                                                <td class=\"fieldlabel\">Slack ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["new"];
        echo " ";
        echo $LNG["order"];
        echo "</td>\n                                                <td class=\"fieldarea\">\n\n                                                    <select name=\"orderslack\">\n                                                        <option value=\"\">Select Order Notification Group</option>\n                                                        ";
        foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
            $selected = "";
            if ($groupid == $imeiserviceDetails["orderslack"]) {
                $selected = "selected";
            }
            echo "                                                            <option ";
            echo $selected;
            echo " value=\"";
            echo $groupid;
            echo "\">";
            echo $groupdetail["name"];
            echo "</option>\n                                                            ";
        }
        echo "                                                    </select>\n\n                                                </td>\n                                            </tr>\n                                            ";
    }
}
echo "                                    ";
if (licince\reqaddon("eBay", true)) {
    echo "                                        <tr>\n                                            <td class=\"fieldlabel\">ebay ";
    echo $LNG["item"];
    echo " ";
    echo $LNG["number"];
    echo "</td>\n                                            <td class=\"fieldarea\"><span>\n    <input type='text'  name='ebaycode' value=\"";
    echo $imeiserviceDetails["ebay_code"];
    echo "\" /> <small>Ebay Item code</small>\n     </span>\n                                                <a onclick=\"load_subpage('main2.php?page=editimeiservice.retailinfo&id=";
    echo $id;
    echo "','Retail Purchase Information');\">Retail Purchase Information</a>\n                                            </td>\n                                        </tr>\n                                        ";
}
echo "                                    <tr>\n                                        <td class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "</td>\n                                        <td class=\"fieldarea\"><span><input value=\"";
echo $LNG["resetdiscount"];
echo "\" id=\"btnreset\" class=\"btn\" type=\"button\"  onclick=\"resetDiscount();\"/> </span></td>\n                                    </tr>\n\n\n                                    </tbody>\n                                </table>\n\n                            </div>\n                        </div></div>\n                    <div class=\"fixedbtn\">\n                        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"button_save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editimeiservice.overview','#frm','#notification','true','#main_loader');\"/>\n\n                        <!--<input value=\"   \"\nclass=\"button_save s\"\ntype=\"button\"  onclick=\"SubmitForm ('#btnoverview','editimeiservice.sendnotification','#frm','#notification','true','#main_loader');\"/>-->\n                        ";
if ($happyhours) {
    echo "                            <div style=\"position: absolute;left:40%;top:10px;color:green;font-weight: bold;\">";
    echo $LNG["serviceunderhappyhours"];
    echo "</div>\n                            ";
}
echo "                        <input  style=\"float: right;\" onclick=\"load_subpage ('main2.php?page=editimeiservice.remove&id=";
echo $id;
echo "','";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "');\" id=\"btnoverview\" name=\"delete\" class=\"button_remove\" value=\"Remove Service\"  type=\"button\"/>\n                    </div>\n\n\n        </form>\n\n        <script>\n            function showforfree()\n            {\n                if(\$('#fred').prop(\"checked\")){\n                    \$(\".pricings\").hide();\n                }else{\n                    \$(\".pricings\").show();\n                }\n            }\n            function showsummary(){\n                \$('.ordersummary').fadeIn();\n                \$('.closes').click(function(){\n                    \$('.ordersummary').fadeOut();\n                })\n            }\n        </script>\n\n        <style>\n            .summary li{list-style: none;padding:10px 5px;display: inline-block;}\n            .summary li span{font-size:28px;font-weight: bold;}\n            .closes{cursor: pointer;font-size: 16px;font-weight: bold;position: absolute;right: 8px;top: 3px;}\n        </style>\n\n        <div style=\"z-index:99;display: none;position: absolute;width:480px;right:-26px;top:35px;background:white;padding-top:20px;border:#ccc solid 1px;box-shadow:0 0 7px #ccc\" class=\"ordersummary\">\n\n            <span class=\"closes\">X</span>\n\n            <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n\n            ";
$sql = "select count(*) as total,DAY(date) as day,user_can_c,1 as tbl  from tbl_order_imei WHERE month( date ) = month( now( ) ) and service_id='" . $id . "' and (user_can_c='3' or user_can_c='4') group by DAY(date),user_can_c";
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
echo "\n            <script type=\"text/javascript\">\n                \$(function () {\n                    var chart;\n                    \$(document).ready(function() {\n                        chart = new Highcharts.Chart({\n                            chart: {\n                                renderTo: 'weekly',\n                                type: 'column'\n                            },\n                            title: {\n                                text: 'Weekly total completed and rejected orders'\n                            },\n                            xAxis: {\n                                categories: [\n                                    'Mon',\n                                    'Tue',\n                                    'Wed',\n                                    'Thu',\n                                    'Fri',\n                                    'Sat',\n                                    'Sun'\n                                ]\n                            },\n\n                            yAxis: {\n                                allowDecimals: false,\n                                min: 0,\n                                title: {\n                                    text: 'Number of Orders'\n                                }\n                            },\n\n                            tooltip: {\n                                formatter: function() {\n                                    return '<b>'+ this.x +'</b><br/>'+\n                                        this.series.name +': '+ this.y +'<br/>'+\n                                        'Total: '+ this.point.stackTotal;\n                                }\n                            },\n\n                            plotOptions: {\n                                column: {\n                                    stacking: 'normal'\n                                }\n                            },\n\n                            series: [{\n                                name: 'Rejected',\n                                data: [";
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
echo "]\n                            }, {\n                                name: 'Completed',\n                                data: [";
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
echo "]\n                            }]\n                        });\n                    });\n\n                });\n\n            </script>\n\n            <div id=\"weekly\" style=\"width: 430px;height:300px\"></div>\n            <hr />\n            ";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  from tbl_order_imei WHERE year( date ) = year( now( ) ) and service_id='" . $id . "' and (user_can_c='3' or user_can_c='4') group by MONTH(date),user_can_c";
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
echo "            <script type=\"text/javascript\">\n                \$(function () {\n                    var chart;\n                    \$(document).ready(function() {\n                        chart = new Highcharts.Chart({\n                            chart: {\n                                renderTo: 'monthly',\n                                type: 'column'\n                            },\n                            title: {\n                                text: 'Monthly total completed and rejected orders'\n                            },\n                            xAxis: {\n                                categories: [\n                                    'Jan',\n                                    'Feb',\n                                    'Mar',\n                                    'Apr',\n                                    'May',\n                                    'Jun',\n                                    'Jul',\n                                    'Aug',\n                                    'Sep',\n                                    'Oct',\n                                    'Nov',\n                                    'Dec']\n                            },\n                            yAxis: {\n                                allowDecimals: false,\n                                min: 0,\n                                title: {\n                                    text: 'Number of Orders'\n                                }\n                            },\n                            tooltip: {\n                                formatter: function() {\n                                    return '<b>'+ this.x +'</b><br/>'+\n                                        this.series.name +': '+ this.y +'<br/>'+\n                                        'Total: '+ this.point.stackTotal;\n                                }\n                            },\n                            plotOptions: {\n                                column: {\n                                    stacking: 'normal'\n                                }\n                            },\n                            series: [{\n                                name: 'Rejected',\n                                data: [";
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
echo "]\n                            }, {\n                                name: 'Completed',\n                                data: [";
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
echo "]\n                            }]\n                        });\n                    });\n                });\n            </script>\n            <div id=\"monthly\"  style=\"width: 430px;height:300px\"></div>\n            <div class=\"summary\" style=\"background: #f4f4f4;\">\n                ";
$total = dquery("select count(*) as total,user_can_c\n    from tbl_order_imei WHERE service_id='" . $id . "' group by user_can_c");
while ($row = mysqli_fetch_assoc($total)) {
    $_total[$row["user_can_c"]] = $row["total"];
}
for ($j = 0; $j <= 4; $j++) {
    if (!$_total[$j]) {
        $_total[$j] = 0;
    }
}
echo "                <table>\n                    <tr><td align=\"center\">\n                            <li><span> ";
echo $_total[0] + $_total[1];
echo "</span><br />Total Pending  </li></td>\n                        <td align=\"center\">\n                            <li><span> ";
echo $_total[3];
echo "</span><br />Total Rejected </li>\n                        </td><td align=\"center\">\n                            <li> <span>";
echo $_total[4];
echo "</span><br />Total Completed</li>\n                        </td></tr>\n                </table>\n            </div>\n        </div>\n\n\n    </div></div>\n\n<div id=\"page_info\" class=\"page_info\">\n    <li>Change service details</li>\n    <li>Change order settings/mail template for this service</li>\n    <li>Set discount and price currency wise</li>\n</div>\n";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$('.colortag').ColorPicker({\n        onSubmit: function(hsb, hex, rgb, el) {\n            \$(el).val(\"#\"+hex);\n            \$(el).ColorPickerHide();\n        },\n        onBeforeShow: function () {\n            \$(this).ColorPickerSetColor(this.value);\n        },\n        onShow: function (colpkr) {\n            \$(colpkr).fadeIn(500);\n            return false;\n        },\n        onHide: function (colpkr) {\n            \$(colpkr).fadeOut(500);\n            return false;\n        },\n        onChange: function (hsb, hex, rgb) {\n            \$('.colortag').css({'background-color':'#'+hex});\n        }\n    });\n    function resetDiscount(){\n        var answer = confirm('";
echo $LNG["areyousuretoresetdiscount"];
echo "');\n        if(answer)\n        {\n            SubmitForm ('#btnreset','editimeiservice.resetdiscount','#frm','#notification','true','#main_loader');\n        }\n    }\n    function getMyTempl(val){\n        \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n            \$('#editimail').html(data);\n        });\n    }\n    function getMyTempl2(val){\n        \$.post('includes/pages/emailtempedit.php?action=imei&val='+val, function(data) {\n            \$('#editimail2').html(data);\n        });\n    }\n    function newWindow(file,window)\n    {   msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n        if (msgWindow.opener == null) msgWindow.opener = self;\n    }\n</script>\n<script type=\"text/javascript\">\n    function getVerify()\n    {\n        if(\$(\"input[name='verification']:checked\"). val()==1){\n            \$(\".veridays\").show();\n        }else{\n            \$(\".veridays\").hide();\n        }\n    }\n    function showNotifications(){\n\n        \$(\".tele\").show();\n\n    }\n    \$('input[name=\"knowledgebase\"]').amsifySuggestags({\n        suggestions: [";
echo implode(",", $arrs);
echo "]\n    });\n</script>\n";

?>