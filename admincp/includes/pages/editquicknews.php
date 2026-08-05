<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 180;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($broadcast) {
    checkDemoMode(false);
    if ($id) {
        $_SESSION["IDCG"] = $id;
    }
    if ($news) {
        $_SESSION["MGCG"] = str_replace("&nbsp;", " ", strip_tags(html_entity_decode($news)));
    }
    $batch = [];
    $u = dquery("select gcmid from tblUsers where gcmid!=''");
    $tot = mysqli_num_rows($u);
    if (!$start) {
        $start = 0;
    }
    $limit = 500;
    $u = dquery("select gcmid from tblUsers where gcmid!=''\n             limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($u)) {
        $batch[] = $r["gcmid"];
    }
    $message = ["msg" => $_SESSION["MGCG"], "server" => $_SERVER["SERVER_NAME"], "id" => $_SESSION["IDCG"] . "", "title" => $config["companyname"]];
    $url = "https://android.googleapis.com/gcm/send";
    $fields = ["registration_ids" => $batch, "data" => $message];
    $headers = ["Authorization: key=" . $config["googlegcm"], "Content-Type: application/json"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === false) {
        exit("Curl failed: " . curl_error($ch));
    }
    curl_close($ch);
    if ($start + $limit < $tot) {
        $start = $start + $limit;
        echo "<div id='notification1' class='successbox'> Your Batch is in process...\n<a href=\"javascript:reloadcurrent('editquicknews','&\$broadcast=1&id=";
        echo $_SESSION["IDCG"];
        echo "&start=";
        echo $start;
        echo "&limit=";
        echo $limit;
        echo "')\">Click Here to go to Next Batch</a> </div>\n";
        sleep(5);
        echo "<script>  reloadcurrent('editquicknews','&\$broadcast=1&id=";
        echo $_SESSION["IDCG"];
        echo "&start='+";
        echo $start;
        echo "); </script>\n";
    }
}
if ($news && $date) {
    checkDemoMode(false);
    $data["date"] = $date;
    $data["scroll"] = $scroll;
    $data["status"] = $status;
    $data["beforelogin"] = $beforelogin;
    $data["beforedate"] = $beforedate;
    $data["news"] = html_entity_decode($news);
    if ($db->update("tbl_quick_news", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
if ($id) {
    $news = mysqli_fetch_assoc(dquery("select * from tbl_quick_news where id='" . $id . "'"));
}
echo "<div id=\"content\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["quick"];
echo " ";
echo $LNG["news"];
echo "</span>\n    &nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n<tbody>\n\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["news"];
echo "</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"news\"  id=\"message\" >";
echo $news["news"];
echo "</textarea>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"v\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" placeholder=\"yyyy-mm-dd\" class=\"datepicker\" name=\"date\" value=\"";
echo $news["date"];
echo "\" id=\"to\"\n    />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" >Show Till ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"beforedate\" id=\"from\"\n    value=\"";
echo $news["beforedate"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"1\" name=\"status\"\n   ";
if ($news["status"]) {
    echo "checked='checked'";
}
echo "    id=\"publis\" /> <label for=\"publis\">";
echo $LNG["active"];
echo "</label>\n    <input type=\"radio\" value=\"0\" name=\"status\"\n   ";
if (!$news["status"]) {
    echo "checked='checked'";
}
echo "  id=\"unpublis\" />\n    <label for=\"unpublis\">";
echo $LNG["inactive"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " in Scroll</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"1\" name=\"scroll\"\n   ";
if ($news["scroll"]) {
    echo "checked='checked'";
}
echo "    id=\"publi\" /> <label for=\"publi\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" value=\"0\" name=\"scroll\"\n   ";
if (!$news["scroll"]) {
    echo "checked='checked'";
}
echo "  id=\"unpubli\" />\n    <label for=\"unpubli\">";
echo $LNG["no"];
echo "</label>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"checkbox\" value=\"1\" name=\"beforelogin\"\n  ";
if ($news["beforelogin"]) {
    echo "checked='checked'";
}
echo "    id=\"beforelogin\" /> <label for=\"beforelogin\">";
echo $LNG["show"];
echo " ";
echo $LNG["before"];
echo " ";
echo $LNG["login"];
echo "</label>\n\n    </span></td>\n</tr>\n</tbody>\n</table>\n</div></div>\n\n\n\n<p   class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnpost\" name=\"save\"\n class=\"btn\" type=\"submit\"  />\n ";
if (licince\reqaddon("Custom mobile app", true)) {
    echo " <input value=\"Broadcast To App\" id=\"braod\" name=\"broadcast\"\n class=\"btn\" type=\"submit\"  />\n ";
}
echo " </p>\n</form>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>