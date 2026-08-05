<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction cleanup(){\n    var answer = confirm('";
echo $LNG["areyousuretocleanselectdtables"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnclean','utilities.systemcleanup','#frmcleanup','#notification','true','#main_loader');\n    }\n}\nfunction clearlisting(){\n    var answer = confirm('";
echo $LNG["areusureclearapi"];
echo "');\n    if(answer)\n    {\n        SubmitForm('#btnclean','utilities.clearapi','#frmcleanup','#notification','true','#main_loader');\n    }\n}\n</script>\n";
$pageid = 101;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead>\n  <tr>\n  <th><input type=\"checkbox\" name=\"all_table\" class=\"check-all\" type=\"checkbox\" value=\"";
echo $LNG["all"];
echo "\"/></th><th>";
echo $LNG["tablename"];
echo "</th><th><div align=\"center\">";
echo $LNG["rows"];
echo "</div></th><th><div align=\"right\">";
echo $LNG["size"];
echo " [MB]</div></th><th></th>\n  </tr>\n</thead>\n<tbody>\n";
$database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
$table = ["tbl_loginlog_admin", "tbl_loginlog_user", "tbl_livehelp_conversation", "tbl_smsgatewaylog", "tbl_supplier_log", "tbl_apilog", "tbl_email_history", "tbl_system_activity", "tbl_recent_menu", "tbl_chat"];
foreach ($table as $value) {
    $result = dquery("SHOW TABLE STATUS FROM " . $database["db"] . " where name='" . $value . "'");
    $row = mysqli_fetch_assoc($result);
    $size = round($row["Data_length"] / 1048576, 3);
    echo "<tr><td><input type=checkbox value=1 name=table[" . $value . "]/></td><td>" . $value . "</td><td align=center>" . $row["Rows"] . "</td><td align=right>" . $size . "</td><td></td></tr>";
}
echo "</tbody></table>\n\n<img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin:0px 0 0 5px; border:0px;\">\n\n<input value=\"";
echo $LNG["clear"];
echo " ";
echo $LNG["table"];
echo "\" id=\"btnclean\" class=\"button_remove\"\n type=\"button\"  onclick=\"cleanup();\"/>\n";
if (!$OnlyEcommerce) {
    echo "<br /><br /><br /><br />\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["server"];
    echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\">\n <tbody>\n<tr>\n    <td class=\"fieldarea\">";
    $sql = dquery("SELECT gateway, setting, value FROM tbl_apiservers WHERE setting = 'name'");
    echo "        <select name='api'>\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n        ";
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $row["gateway"] . "'>" . $row["value"] . "</option>";
    }
    echo "        </select> <input value=\"";
    echo $LNG["clear"];
    echo " ";
    echo $LNG["listing"];
    echo "\" id=\"btnclean\" class=\"button_remove\" type=\"button\"  onclick=\"clearlisting();\"/>\n        </td>\n        <td></td>\n</tr>\n\n\n</tbody></table>\n</div></div>\n";
}
echo "\n<p class=\"fixedbtn\"><input type=\"submit\" class=\"btn save\" name=\"optimize\" value=\"";
echo $LNG["optimizedb"];
echo "\" /> </p>\n\n";
if ($optimize) {
    $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
    $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
    echo "    <table id=\"main_tbl\">\n    <thead>\n    <tr>\n    <th>";
    echo $LNG["table"];
    echo "</th>\n    <th>";
    echo $LNG["state"];
    echo "</th>\n    <th>";
    echo $LNG["message"];
    echo "</th>\n    </tr>\n    </thead>\n    ";
    while ($row = mysqli_fetch_assoc($result)) {
        $tabled = $row["Name"];
        $r = mysqli_fetch_assoc(dquery("OPTIMIZE TABLE " . $tabled . " "));
        echo "        <tr>\n        <td>";
        echo $r["Table"];
        echo "</td>\n        <td>";
        echo $r["Op"];
        echo "</td>\n        <td>";
        echo $r["Msg_text"];
        echo "</td>\n        </tr>\n        ";
    }
    echo "    </table>\n    <br /><br />\n    ";
}
echo "</form></div></div> ";
$fileverioncheck = "6.1.0";

?>