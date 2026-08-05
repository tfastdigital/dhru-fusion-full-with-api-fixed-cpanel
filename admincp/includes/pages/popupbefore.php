<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    saveSettings("popbefenable", $popbefenable);
    if (mysqli_num_rows(dquery("select * from tbl_settings where attribute='flashpopbefore'"))) {
        $data["value"] = html_entity_decode($tinyvalue);
        $db->update("tbl_settings", $data, "attribute='flashpopbefore'");
    } else {
        $data["value"] = html_entity_decode($tinyvalue);
        $data["attribute"] = "flashpopbefore";
        $db->insert("tbl_settings", $data);
    }
    echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
}
$setting = mysqli_fetch_assoc(dquery("select value from tbl_settings\r\nwhere attribute='flashpopbefore'"));
echo "<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n\r\n        <script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\r\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<div id=\"notification\"></div>\r\n            <table class=\"form\"  >\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <form id=\"frmbrand\" name=\"\" method=\"post\" >\r\n                            <input type=\"hidden\" value=\"\" base64encode=\"true\" name=\"tinyvalue\" id=\"tinyvalue\"/>\r\n                            ";
echo generate_token("form");
echo "                            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  name=\"popbefenable\" value=\"on\" id=\"see\" ";
if ($config["popbefenable"] == "on") {
    echo "checked";
}
echo " /><label for=\"see\"></label>\r\n                            <br />\r\n                            <br />\r\n                        </form>\r\n\r\n    <textarea name=\"info\" id=\"message\">";
echo $setting["value"];
echo "</textarea>\r\n    <p class=\"fixedbtn\">\r\n\r\n<button name=\"save\" class=\"btn save\" id=\"btnedituser2\"\r\nonclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\r\nSubmitFormNew('#btnedituser2','popupbefore','#frmbrand','#notification','true','#main_loader');\"\r\nvalue=\"";
echo $LNG["save"];
echo "\">";
echo $LNG["save"];
echo "</button>\r\n\r\n\r\n    </p>\r\n\r\n\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n\r\n\r\n\r\n    </div>\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>