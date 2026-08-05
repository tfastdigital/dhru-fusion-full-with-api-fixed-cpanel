<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link rel=\"stylesheet\" href=\"includes/3rdparty/code/doc/docs.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/codemirror.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/addon/lint/lint.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/addon/display/fullscreen.css\">\n<script src=\"includes/3rdparty/code/codemirror.js\"></script>\n\n<script src=\"includes/3rdparty/code/mode/javascript/javascript.js\"></script>\n<script src=\"includes/3rdparty/code/mode/htmlmixed/htmlmixed.js\"></script>\n<script src=\"includes/3rdparty/code/mode/smarty/smarty.js\"></script>\n<script src=\"includes/3rdparty/code/mode/smartymixed/smartymixed.js\"></script>\n\n<script src=\"includes/3rdparty/code/css.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/javascript-lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/json-lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/css-lint.js\"></script>\n<script src=\"includes/3rdparty/code/mode/xml/xml.js\"></script>\n<script src=\"includes/3rdparty/code/addon/display/fullscreen.js\"></script>\n";
$set = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
licince\reqaddon("POS");
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n";
if ($templ) {
    $set["template"] = $templ;
}
echo "<input type=\"hidden\" name=\"coder\" id=\"coder\" />\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["template"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"template\" \nonchange=\"javascript:reloadcurrent('pos.manage','&loaddefault=pos.setting.php&templ='+this.value)\">\n            <option value=\"1\" ";
if ($set["template"] == 1) {
    echo "selected";
}
echo " >Default</option>\n            <option value=\"2\" ";
if ($set["template"] == 2) {
    echo "selected";
}
echo ">Landscape</option>\n            <option value=\"3\" ";
if ($set["template"] == 3) {
    echo "selected";
}
echo ">Billing</option>\n        </select>          \n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["paper"];
echo " ";
echo $LNG["type"];
echo " </td>\n    <td class=\"fieldarea\">\n        <select name=\"papertype\">\n            <option value=\"1\"  ";
if ($set["papertype"] == 1) {
    echo "selected";
}
echo ">A4 Size</option>\n            <option value=\"2\" ";
if ($set["papertype"] == 2) {
    echo "selected";
}
echo ">Label</option>\n        </select>     \n    </td>\n</tr>\n\n\n\n";
if (!$templ) {
    $templ = $set["template"];
}
if ($templ == 1) {
    $content = file_get_contents("templates/" . $_SESSION["admin_template"] . "/invoice.tpl", FILE_USE_INCLUDE_PATH);
} else {
    if ($templ == 2) {
        $content = file_get_contents("templates/" . $_SESSION["admin_template"] . "/landscape.tpl", FILE_USE_INCLUDE_PATH);
    } else {
        $templ = 3;
        $content = file_get_contents("templates/" . $_SESSION["admin_template"] . "/billing.tpl", FILE_USE_INCLUDE_PATH);
    }
}
$content = str_replace("<textarea", "&lt;textarea", $content);
$content = str_replace("</textarea", "&lt;/textarea", $content);
echo "<input type=\"hidden\" name=\"template\" value=\"";
echo $templ;
echo "\" />\n<tr>\n   \n    <td class=\"fieldarea\" colspan=\"2\">\n<textarea style=\"width: 100% !important;\" name=\"code\" id=\"code-js\">";
echo $content;
echo "</textarea>\n </td>\n</tr>\n<script>\n\$(document).ready(function() {\n \n\n    \n  var editor = CodeMirror.fromTextArea(document.getElementById(\"code-js\"), {\n    lineNumbers: true,\n    mode: \"smartymixed\",\n    tabSize        : 2,\n    indentUnit     : 2,\n    indentWithTabs : false,\n    lineNumbers    : true,\n    smartyVersion  : 3,\n  \n     extraKeys: {\n        \"F11\": function(cm) {\n          cm.setOption(\"fullScreen\", !cm.getOption(\"fullScreen\"));\n        },\n        \"Esc\": function(cm) {\n          if (cm.getOption(\"fullScreen\")) cm.setOption(\"fullScreen\", false);\n        }\n        \n      }    \n    });\n    editor.setSize(\"100%\", \"600px\");\n    editor.on(\"blur\", function(cm){\n       \n       \$('#coder').val(cm.getValue()); \n       \$('#code-js').html(cm.getValue()); \n    });\n});\n\n  \n</script>\n\n\n\n\n\n\n<tr>\n    <td class=\"fieldlabel\" width=\"30%\">&nbsp;</td>\n    <td class=\"fieldarea\">\n <input type=\"button\" id=\"btnoverview\" name=\"save\"  value=\"";
echo $LNG["save"];
echo "\"  class=\"btn save\"\n  onclick=\"SubmitForm ('#btnoverview','pos.setting','#frm','#notification','true','#main_loader');\" />\n    </td>\n</tr>\n\n\n \n</tbody>\n</table>\n</form>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>