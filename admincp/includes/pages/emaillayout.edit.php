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
echo " \n<div id=\"tabcontent\"> \n";
if ($newlayoutd && !$save) {
    checkDemoMode(false);
    $data = NULL;
    $data["name"] = $newlayoutd;
    $id = $db->insert("tbl_email_layout", $data);
    $data = NULL;
    unset($newlayout);
    $newlayout = NULL;
}
if ($save && $id) {
    checkDemoMode(false);
    $data = NULL;
    $data["name"] = $named;
    $data["header"] = $headers;
    $data["footer"] = $footers;
    $db->update("tbl_email_layout", $data, "id='" . $id . "'");
    $data = NULL;
    echo "<div id='notification1' class='successbox'>" . $LNG["templateupdate"] . "</div>";
}
$templatedetail = mysqli_fetch_assoc(dquery("SELECT * FROM \n   `tbl_email_layout` WHERE `id`='" . $id . "'"));
echo "\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form method=\"post\" name=\"frmeditemailtemplate\" id=\"frmeditemailtemplate\">\n\n    ";
echo generate_token("form");
echo "  \n    <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n    \n";
if ($id == 1) {
    echo " <tr id=\"\"><td class=\"fieldlabel\">";
    echo $LNG["name"];
    echo "</td>\n    <td colspan=\"2\" class=\"fieldarea\">\n    <input type=\"hidden\" name=\"named\" value=\"";
    echo $templatedetail["name"];
    echo "\" />";
    echo $templatedetail["name"];
    echo "    </td></tr>\n";
} else {
    echo " <tr id=\"\"><td class=\"fieldlabel\">";
    echo $LNG["name"];
    echo "</td>\n    <td colspan=\"2\" class=\"fieldarea\">\n    <input type=\"text\" name=\"named\" value=\"";
    echo $templatedetail["name"];
    echo "\" />\n    </td></tr>\n";
}
echo "\n    <tr id=\"\"><td class=\"fieldlabel\">Header</td>\n    <td colspan=\"2\" class=\"fieldarea\">\n    <textarea name=\"headers\" id=\"header\"  class=\"\" rows=\"35\" style=\"width:700px;height:300px\">";
echo $templatedetail["header"];
echo " </textarea>\n    </td></tr>\n \n\n    <tr id=\"\"><td class=\"fieldlabel\">";
echo $LNG["footer"];
echo "</td>\n    <td colspan=\"2\" class=\"fieldarea\">\n    <textarea name=\"footers\" id=\"footer\"  class=\"\" rows=\"35\" style=\"width:700px;height:300px\"> ";
echo $templatedetail["footer"];
echo " </textarea>\n    </td></tr>   \n     \n               \n    </tbody> \n</table>\n    \n    <p class=\"fixedbtn\">\n        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnditemailtemplate\" name=\"save\"\n         class=\"btn save\" type=\"submit\"  />\n    </p>\n    \n</form>\n</div>\n</div> </div>\n";
$fileverioncheck = "6.1.0";

?>