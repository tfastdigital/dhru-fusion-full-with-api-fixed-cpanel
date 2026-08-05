<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " <div>\n";
$pageid = 29;
checkPagePermission($pageid);
if ($message && $subject && $type && $name) {
    checkDemoMode(false);
    if ($vadhare) {
        $message = base64_decode($message);
    }
    $data["type"] = $type;
    $data["name"] = $name;
    $data["plaintext"] = $plain;
    $data["fromname"] = $fromname;
    $data["fromemail"] = $frommail;
    $data["copyto"] = $copyto;
    $data["subject"] = $subject;
    $data["message"] = $message;
    if ($config["mail_sending_type"] == 1) {
        $data["scheduled"] = 1;
    }
    $data["custom"] = 1;
    $db->insert("tbl_emailtemplates", $data);
    $data = NULL;
    echo "<div id='notification1' class='successbox' >" . $LNG["newemailtemplate"] . "</div>";
} else {
    if ($saved) {
        echo "<div id='notification1' class='errorbox' >" . $LNG["fieldblank"] . "</div>";
    }
}
include_once "includes/3rdparty/editor/editor.php";
echo "<div id=\"notification\"></div>\n<div class=\"groupstabes first\" >\n\n<div class=\"groupstabescontant\">\n\n<div id=\"content\">\n<h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["add"];
echo " ";
echo $LNG["template"];
echo "</span>\n</h2>\n\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmaddemailtemplate\" id=\"frmaddemailtemplate\">\n<input type='hidden' name='laoddefaultpage' value='emailtemplate.add.php' />\n    ";
echo generate_token("form");
echo "    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n    <tr><td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" name=\"name\"  size=\"100\"/></td></tr>\n\n\n    <tr><td class=\"fieldlabel\">";
echo $LNG["fromname"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"fromname\"  size=\"100\"/> </td></tr>\n\n\n    <tr><td class=\"fieldlabel\">";
echo $LNG["frommail"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"frommail\"  size=\"100\"/> </td></tr>\n\n\n    <tr><td class=\"fieldlabel\">";
echo $LNG["copyto"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"copyto\"  size=\"100\"/> </td></tr>\n\n\n    <tr><td class=\"fieldlabel\">";
echo $LNG["subject"];
echo "</td>\n    <td class=\"fieldarea\"> <input type=\"text\"  name=\"subject\"  size=\"100\"/> </td></tr>\n\n    <tr><td class=\"fieldlabel\">";
echo $LNG["type"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"type\">\n    ";
if ($OnlyEcommerce) {
    $WHERE = " and type!='fileorder' and type!='serverorder' and type!='imeiorder' and type!='remoteorder' ";
}
$tp = dquery("SELECT `type` FROM tbl_emailtemplates where \n           `type`!='imeiorderbulk' " . $WHERE . " GROUP BY `type`");
while ($row = mysqli_fetch_assoc($tp)) {
    echo "<option value=\"";
    echo $row["type"];
    echo "\">";
    echo $row["type"];
    echo "</option>";
}
echo "    <option value=\"other\">Other</option>\n    </select>\n    </td></tr>\n\n    <tr><td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["message"];
echo "</td><td class=\"fieldarea\">\n        <textarea name=\"message\" rows=\"22\" id='message' style=\"width:100%\"></textarea>\n    </td></tr>\n\n    <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n    <input name=\"plain\" value=\"1\" id=\"plain\" type=\"checkbox\"/><label for=\"plain\">\n    ";
echo $LNG["plaintext"];
echo "</label>\n    </td></tr>\n    </tbody>\n    </table>\n    <p class=\"fixedbtn\"><input name=\"saved\" class=\"btn btn-primary\" value=\"";
echo $LNG["save"];
echo "\"\n     id=\"btnaddemailtemplate\" class=\"btn\" type=\"submit\"\n    /></p>\n</form>\n\n</div>\n</div> </div>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>