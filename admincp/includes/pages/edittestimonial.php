<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 154;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
if ($date && $comment && $author) {
    checkDemoMode(false);
    $data["author"] = $author;
    $data["comment"] = html_entity_decode($tinyvalue);
    $data["date"] = $date;
    $data["status"] = $status;
    $data["email"] = $email;
    $data["ip"] = $_SERVER["REMOTE_ADDR"];
    if ($db->update("tbl_testimonial", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$te = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_testimonial WHERE id='" . $id . "'"));
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"newpost\" name=\"newpost\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table><tr><td width=\"50%\" valign=\"top\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["author"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <select name=\"author\">\n    <option value=\"";
echo $te["author"];
echo "\">";
echo $te["author"];
echo "</option>\n    ";
$sql = dquery("select username from tbl_admin");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value=\"";
    echo $row["username"];
    echo "\"  >";
    echo $row["username"];
    echo "</option> ";
}
echo "</select>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"email\" value=\"";
echo $te["email"];
echo "\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["comments"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <textarea name=\"comment\" id=\"message\">";
echo $te["comment"];
echo "</textarea>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"date\" class=\"datepicker\"  autocomplete=\"off\" id=\"to\" value=\"";
echo $te["date"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"published\" ";
if ($te["status"] == "published") {
    echo "checked";
}
echo " name=\"status\"  id=\"publi\" /> <label for=\"publi\">";
echo $LNG["approved"];
echo "</label>\n    <input type=\"radio\" value=\"pending\"  ";
if ($te["status"] == "pending") {
    echo "checked";
}
echo " name=\"status\" id=\"unpubli\" /> <label for=\"unpubli\">";
echo $LNG["pending"];
echo "</label>\n    </span></td>\n</tr>\n\n\n</tbody>\n</table>\n</td></tr></table>\n<p class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnpost\" class=\"btn save\"\n type=\"submit\"  onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\"/></p>\n</form>\n</div>\n</div>\n";
if ($id) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>