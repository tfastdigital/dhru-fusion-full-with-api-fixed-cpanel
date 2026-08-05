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
echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js\"\ntype=\"text/javascript\"></script>\n\n<script type=\"text/javascript\" src=\"includes/3rdparty/code/codemirror.js\"></script>\n<link type=\"text/css\" rel=\"stylesheet\" href=\"includes/3rdparty/code/codemirror.css\" />\n<script type=\"text/javascript\" src=\"includes/3rdparty/code/mergely.js\"></script>\n<link type=\"text/css\" rel=\"stylesheet\" href=\"includes/3rdparty/code/mergely.css\" />\n";
if (!isset($_SESSION["srol"])) {
    $_SESSION["srol"] = 1;
    echo "    <form method=\"post\" id=\"srsc\">\n       <input type=\"hidden\" name=\"laoddefaultpage\" value=\"editor.newversion.php\" />\n    </form>\n    <script>\n    \$(\"#srsc\").submit();\n    </script>\n    ";
}
if ($template && $file) {
    $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
    if (deregi("css/", $tpl["tpl"])) {
        $content = file_get_contents("../templates/" . $template . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
    } else {
        $content = file_get_contents("../templates/" . $template . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
    }
    $tlog = file("../templates/tlog.txt");
    foreach ($tlog as $tl) {
        $te = explode("=", $tl);
        if (trim($te[1]) == $template) {
            $origin = trim($te[0]);
        }
    }
}
echo "\t\n<div id=\"notification\"></div>\n<br />\n\n\n\t<script type=\"text/javascript\">\n        \$(document).ready(function () {\n\t\t\t\$('#compare').mergely({\n\t\t\t\tcmsettings: { readOnly: true },\n               \n\t\t\t});\n            \$('#compare').on(\"blur\", function(cm){       \n                  alert('clier');\n            });\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'GET', async: true, dataType: 'text',\n\t\t\t\turl: '";
echo "includes/getTpls.php?template=" . $template . "&file=" . $tpl["tpl"];
echo "',\n\t\t\t\tsuccess: function (response) {\n\t\t\t\t\t\$('#compare').mergely('lhs', response);\n\t\t\t\t}\n\t\t\t});\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'GET', async: true, dataType: 'text',\n\t\t\t\turl: '";
echo "includes/getTpls.php?template=" . $origin . "&file=" . $tpl["tpl"];
echo "',\n\t\t\t\tsuccess: function (response) {\n\t\t\t\t\t\$('#compare').mergely('rhs', response);\n\t\t\t\t}\n\t\t\t});\n\t\t});\n       \n        function getValued()\n        {\n          \n        }\n\t</script>\n  \n  <form method=\"post\" id=\"frmrestore\">\n    <input  type=\"hidden\" name=\"template\" value=\"";
echo $template;
echo "\" />\n    <input  type=\"hidden\" name=\"file\" value=\"";
echo $file;
echo "\" />\n    <input  type=\"hidden\" name=\"action\" value=\"restoreoriginal\" />\n    <input  type=\"hidden\" name=\"content\" id=\"tcontent\" value=\"\" />\n  </form>\n   \n\n   \n\t<div id=\"mergely-resizer\">\n         <span style=\"float: left;width:50%;text-align:center\">Current Template</span><span style=\"float: right;width:50%;text-align:center\">Original Template</span>\n\t\t<div id=\"compare\">\n\t\t</div>\n\t</div>\n    \n     <span style=\"float: right;width:50%;text-align:center\">\n        <br />\n        <input type=\"button\" name=\"gettemplate\" value=\"Restore From Original\" id=\"gettemplate\" />\n    </span>\n    \n    \n    \n\n";
$fileverioncheck = "6.1.0";
function get_string_between($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

?>