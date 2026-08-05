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
echo "<link rel=\"stylesheet\" href=\"includes/3rdparty/code/doc/docs.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/codemirror.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/addon/lint/lint.css\">\n<link rel=\"stylesheet\" href=\"includes/3rdparty/code/addon/display/fullscreen.css\">\n<script src=\"includes/3rdparty/code/codemirror.js\"></script>\n\n<script src=\"includes/3rdparty/code/mode/javascript/javascript.js\"></script>\n<script src=\"includes/3rdparty/code/mode/htmlmixed/htmlmixed.js\"></script>\n<script src=\"includes/3rdparty/code/mode/smarty/smarty.js\"></script>\n<script src=\"includes/3rdparty/code/mode/smartymixed/smartymixed.js\"></script>\n\n<script src=\"includes/3rdparty/code/css.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/javascript-lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/json-lint.js\"></script>\n<script src=\"includes/3rdparty/code/addon/lint/css-lint.js\"></script>\n<script src=\"includes/3rdparty/code/mode/xml/xml.js\"></script>\n<script src=\"includes/3rdparty/code/addon/display/fullscreen.js\"></script>\n";
unset($_SESSION["srol"]);
if ($id && $template && $file) {
    $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
    $content = file_get_contents("../templates/" . $template . "/" . $tpl["tpl"] . "." . $id, FILE_USE_INCLUDE_PATH);
    $content = str_replace("<textarea", "&lt;textarea", $content);
    $content = str_replace("</textarea", "&lt;/textarea", $content);
} else {
    if ($template && $file) {
        $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
        if (deregi("css/", $tpl["tpl"])) {
            $content = file_get_contents("../templates/" . $template . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
        } else {
            $content = file_get_contents("../templates/" . $template . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
        }
        $content = str_replace("<textarea", "&lt;textarea", $content);
        $content = str_replace("</textarea", "&lt;/textarea", $content);
    }
}
echo "<form method=\"post\" id=\"frmcode\">\n    <div id=\"notification\" ></div>\n<input type=\"hidden\" name=\"coder\" id=\"coder\" />\n <p><textarea style=\"width: 100% !important;\" name=\"code\" id=\"code-js\">";
echo $content;
echo "</textarea></p>\n<script>\n\$(document).ready(function() {\n\n\n\n  var editor = CodeMirror.fromTextArea(document.getElementById(\"code-js\"), {\n    lineNumbers: true,\n    mode: \"smartymixed\",\n    tabSize        : 2,\n    indentUnit     : 2,\n    indentWithTabs : false,\n    lineNumbers    : true,\n    smartyVersion  : 3,\n\n     extraKeys: {\n        \"F11\": function(cm) {\n          cm.setOption(\"fullScreen\", !cm.getOption(\"fullScreen\"));\n        },\n        \"Esc\": function(cm) {\n          if (cm.getOption(\"fullScreen\")) cm.setOption(\"fullScreen\", false);\n        }\n\n      }\n    });\n    editor.setSize(\"100%\", \"600px\");\n    editor.on(\"blur\", function(cm){\n\n       \$('#coder').val(cm.getValue());\n       \$('#code-js').html(cm.getValue());\n    });\n});\n\n\n</script>\n\n<br /><br />\n<table class=\"form\" style=\"width: 95%;margin:auto\">\n<tr>\n    <td class=\"fieldlabel\">\n        Note\n   </td>\n   <td class=\"fieldarea\">\n     <input type=\"text\" name=\"notes\" id=\"notes\" style=\"width: 350px;\" />\n   </td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">\n\n   </td>\n   <td class=\"fieldarea\">\n    <input value=\"";
echo $LNG["save"];
echo "\"\n    id=\"btnaddgroup\" class=\"btn\" type=\"button\" class=\"btn btn-success\"\n     onclick=\"SubmitForm('#btnaddgroup','editor.template','#frmcode','#notification','true','#main_loader');\"/>\n     </td>\n</tr>\n</table>\n    <input type=\"hidden\" name=\"template\" value=\"";
echo $template;
echo "\" />\n    <input type=\"hidden\" name=\"file\" value=\"";
echo $file;
echo "\" />\n   </form>\n   ";
$fileverioncheck = "6.1.0";

?>