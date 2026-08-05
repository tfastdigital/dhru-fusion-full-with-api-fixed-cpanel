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
echo "\t<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js\" type=\"text/javascript\"></script>\n\t\n\n\t<script type=\"text/javascript\" src=\"includes/3rdparty/code/codemirror.js\"></script>\n\t<link type=\"text/css\" rel=\"stylesheet\" href=\"includes/3rdparty/code/codemirror.css\" />\n\t\n\n\t<script type=\"text/javascript\" src=\"includes/3rdparty/code/mergely.js\"></script>\n\t<link type=\"text/css\" rel=\"stylesheet\" href=\"includes/3rdparty/code/mergely.css\" />\n";
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
echo "\t\n\n<div id=\"notification\"></div>\n<br />\n";
if (!$id) {
    echo "<table  id=\"main_tbl\">\n<thead>\n  <tr class=\"odd\">\n    <th>Date</th>\n    <th>File Info</th>   \n    <th><div align=\"right\">Action</div></th>\n  </tr>\n</thead>\n";
    $arg = explode("/", $tpl["tpl"]);
    $arg = end($arg);
    if (deregi("cart/default/", $tpl["tpl"])) {
        $myDirectory = opendir("../templates/" . $template . "/cart/default");
        while ($dir = readdir($myDirectory)) {
            if (is_file("../templates/" . $template . "/cart/default/" . $dir) && deregi($arg, $dir) && !deregi(".tpl", $dir)) {
                $version = end(explode(".", $dir));
                $orders[$version] = str_replace(".tpl", "", $dir);
            }
        }
        $path = "../templates/" . $template . "/cart/default/";
    } else {
        if (deregi("cart/Steps/", $tpl["tpl"])) {
            $myDirectory = opendir("../templates/" . $template . "/cart/Steps");
            while ($dir = readdir($myDirectory)) {
                if (is_file("../templates/" . $template . "/cart/Steps/" . $dir) && deregi($arg, $dir) && !deregi(".tpl", $dir)) {
                    $version = end(explode(".", $dir));
                    $orders[$version] = str_replace(".tpl", "", $dir);
                }
            }
            $path = "../templates/" . $template . "/cart/Steps/";
        } else {
            if (deregi("cart/SingalPage/", $tpl["tpl"])) {
                $myDirectory = opendir("../templates/" . $template . "/cart/SingalPage");
                while ($dir = readdir($myDirectory)) {
                    if (is_file("../templates/" . $template . "/cart/SingalPage/" . $dir) && deregi($arg, $dir) && !deregi(".tpl", $dir)) {
                        $version = end(explode(".", $dir));
                        $orders[$version] = str_replace(".tpl", "", $dir);
                    }
                }
                $path = "../templates/" . $template . "/cart/SingalPage/";
            } else {
                if (deregi("css/", $tpl["tpl"])) {
                    $myDirectory = opendir("../templates/" . $template . "/css");
                    while ($dir = readdir($myDirectory)) {
                        if (is_file("../templates/" . $template . "/css/" . $dir) && deregi($arg, $dir) && !endswith($dir, ".css")) {
                            $version = end(explode(".", $dir));
                            $orders[$version] = $dir;
                        }
                    }
                    $path = "../templates/" . $template . "/css/";
                } else {
                    $myDirectory = opendir("../templates/" . $template);
                    while ($dir = readdir($myDirectory)) {
                        if (is_file("../templates/" . $template . "/" . $dir) && deregi($tpl["tpl"], $dir) && !deregi(".tpl", $dir)) {
                            $version = end(explode(".", $dir));
                            $orders[$version] = str_replace(".tpl", "", $dir);
                        }
                    }
                    $path = "../templates/" . $template . "/";
                }
            }
        }
    }
    krsort($orders);
    foreach ($orders as $version => $tpls) {
        if (is_file($path . "ver/" . str_replace(end(explode(".", $tpls)), "", $tpls) . "txt")) {
            $content = file_get_contents($path . "ver/" . str_replace(end(explode(".", $tpls)), "", $tpls) . "txt", FILE_USE_INCLUDE_PATH);
            $content = trim($content);
            $conu = unserialize($content);
        }
        echo "                <tr>\n                    <td>";
        echo date("Y-m-d H:i:s", $version);
        echo "</td>\n                    <td>";
        echo $conu[$version][1];
        echo " [version: ";
        echo $conu[$version][2];
        echo "]</td>\n                    <td><a \nhref=\"javascript:reloadsubpageiframe('editor.template&laoddefaultpage=templatehistory.php&id=";
        echo $version;
        echo "&template=";
        echo $template;
        echo "&file=";
        echo $file;
        echo "',";
        echo $version;
        echo ") \">View</a></td>\n                </tr>\n                ";
    }
    echo "\n</table>\n";
}
if ($id) {
    echo "\t<script type=\"text/javascript\">\n        \$(document).ready(function () {\n\t\t\t\$('#compare').mergely({\n\t\t\t\tcmsettings: { readOnly: false },\n               \n\t\t\t});\n            \$('#compare').on(\"blur\", function(cm){       \n                  alert('clier');\n            });\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'GET', async: true, dataType: 'text',\n\t\t\t\turl: '";
    echo "includes/getTpls.php?template=" . $template . "&file=" . $tpl["tpl"];
    echo "',\n\t\t\t\tsuccess: function (response) {\n\t\t\t\t  \t\$('#compare').mergely('lhs', response);\n\t\t\t\t}\n\t\t\t});\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'GET', async: true, dataType: 'text',\n\t\t\t\turl: '";
    echo "../templates/" . $template . "/" . $tpl["tpl"] . "." . $id;
    echo "',\n\t\t\t\tsuccess: function (response) {\n\t\t\t\t\t\$('#compare').mergely('rhs', response);\n\t\t\t\t}\n\t\t\t});\n\t\t});\n       \n        function getValued()\n        {\n          \n        }\n\t</script>\n  \n  <form method=\"post\" id=\"frmrestore\">\n    <input  type=\"hidden\" name=\"template\" value=\"";
    echo $template;
    echo "\" />\n    <input  type=\"hidden\" name=\"file\" value=\"";
    echo $file;
    echo "\" />\n    <input  type=\"hidden\" name=\"version\" value=\"";
    echo $id;
    echo "\" />\n    <input  type=\"hidden\" name=\"content\" id=\"tcontent\" value=\"\" />\n  </form>\n  \n\t<div id=\"mergely-resizer\">\n        <span style=\"float: left;width:50%;text-align:center\">Current Template</span><span style=\"float: right;width:50%;text-align:center\"> Template Change on <strong style=\"color: red;\">";
    echo date("Y-m-d H:i:s", $id);
    echo "</strong></span>\n\t\t<div id=\"compare\"></div>\n\t</div>\n    \n    <div class=\"clear\"></div>\n    <span style=\"float: right;width:50%;text-align:center\">\n        <br />\n        <input type=\"button\" name=\"gettemplate\"\n         value=\"Restore Template\" id=\"gettemplate\" class=\"btn-success\"/>\n    </span>\n";
}
echo "    ";
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
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -1 * strlen($needle)) === $needle;
}

?>