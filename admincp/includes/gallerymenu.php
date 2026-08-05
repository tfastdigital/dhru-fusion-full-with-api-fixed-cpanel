<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../comm.php";
require_once "../../includes/fun.inc.php";
require_once "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"../index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($dir)) {
    $_SESSION["gallary"] = $dir;
} else {
    $_SESSION["gallary"] = "";
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n\t<head>\n\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />\n        \n        <script type=\"text/javascript\" src=\"js/jquery.js\"></script>\n        \n\t\t<script type=\"text/javascript\">\n      \n            function init_php_file_tree() {\n        \tif (!document.getElementsByTagName) return;\n        \t\n        \tvar aMenus = document.getElementsByTagName(\"LI\");\n        \tfor (var i = 0; i < aMenus.length; i++) {\n        \t\tvar mclass = aMenus[i].className;\n        \t\tif (mclass.indexOf(\"pft-directory\") > -1) {\n        \t\t\tvar submenu = aMenus[i].childNodes;\n        \t\t\tfor (var j = 0; j < submenu.length; j++) {\n        \t\t\t\tif (submenu[j].tagName == \"A\") {\n        \t\t\t\t\t\n        \t\t\t\t\tsubmenu[j].onclick = function() {\n        \t\t\t\t\t\tvar node = this.nextSibling;\n        \t\t\t\t\t\t\t\t\t\n        \t\t\t\t\t\twhile (1) {\n        \t\t\t\t\t\t\tif (node != null) {\n        \t\t\t\t\t\t\t\tif (node.tagName == \"UL\") {\n        \t\t\t\t\t\t\t\t\tvar d = (node.style.display == \"none\")\n        \t\t\t\t\t\t\t\t\tnode.style.display = (d) ? \"block\" : \"none\";\n        \t\t\t\t\t\t\t\t\tthis.className = (d) ? \"open\" : \"closed\";\n                                            parent.frames[\"mains\"].location=this.href;\n        \t\t\t\t\t\t\t\t\treturn false;\n        \t\t\t\t\t\t\t\t}\n        \t\t\t\t\t\t\t\tnode = node.nextSibling;\n        \t\t\t\t\t\t\t} else {\n        \t\t\t\t\t\t\t     parent.frames[\"mains\"].location=this.href;\n        \t\t\t\t\t\t\t     return false;\n        \t\t\t\t\t\t\t}\n        \t\t\t\t\t\t}\n                                 parent.frames[\"mains\"].location=this.href;\n        \t\t\t\t\t\treturn false;\n        \t\t\t\t\t}\n        \t\t\t\t\t        \t\t\t\t\n        \t\t\t\t}\n        \t\t\t\t\n        \t\t\t}\n        \t\t}\n        \t}\n                \n        \treturn false;\n        }\n        window.onload = init_php_file_tree;\n        </script>\n        <style>\n            \n            *{margin:0;padding:0;font-family: arial;}    \n            .logo {\n    background: none repeat scroll 0 0 #222222;\n    color: white;\n    font-size: 25px;\n    font-weight: bold;\n    height: 50px;\n    line-height: 50px;\n    margin-right: -1px;\n    padding: 0 15px;\n    position: relative;\n    text-align: left;\n    text-shadow: 0 1px 1px #404950;\n}\n\n.logo .version.new {\n    animation: 1s linear 0s normal none infinite logo-version;\n    background-color: #B10000;\n}\n.logo .version {\n    border-radius: 10px 10px 10px 10px;\n    color: white;\n    font-size: 9px;\n    font-weight: normal;\n    line-height: 15px;\n    padding: 2px 6px;\n    position: absolute;\n    right: 15px;\n    text-shadow: none;\n    top: 20px;\n}       \n            #folder h2{color:#ccc;padding-left:10px}          \n            #folder li{list-style: none;}           \n            .icon-plus-sign:after{content: '+';cursor: pointer;color:white;font-size:15px;}\n            .icon-minus-sign:after{content: '-';cursor: pointer;color:white;font-size:17px;}                        \n            .php-file-tree a:hover{color:#666666;}\n            .php-file-tree .open{font-style:italic;}\n            .php-file-tree .closed{font-style:normal;}\n            .php-file-tree .pft-directory{}\n            \n            .php-file-tree ul{\n                background: rgba(0,0,0,0.1);\n            }                        \n            .php-file-tree li a{             \n                padding:5px;\n                border-bottom: 1px solid rgba(0, 0, 0, 0.1);\n                box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);                         \n                color: #555555;\n                display: block;\n                font-size: 16px;\n                font-weight: normal;\n                text-decoration: none;                \n            }\n            .php-file-tree li ul li ul li{padding-left:20px}\n            .php-file-tree li ul li ul li a{font-style: italic;font-size:14px;}\n            .php-file-tree li a img{vertical-align: bottom;margin-right:5px} \n               \n        </style>\n\t</head>\n\n\t<body  style=\"position:  absolute;left:0;right:0;top:0px;bottom:0px;background: #eee\">\t\n    \n    <h1 class=\"logo\" title=\"New version available\">Image Manager</h1>\n    \n\t\t";
echo php_file_tree("../../images/gallery/", "");
echo "\t</body>\n\t\n</html>\n\n\n\n";
function php_file_tree($directory, $return_link, $extensions = [])
{
    if (substr($directory, -1) == "/") {
        $directory = substr($directory, 0, strlen($directory) - 1);
    }
    $code .= php_file_tree_dir($directory, $return_link, $extensions);
    return $code;
}
function php_file_tree_dir($directory, $return_link, $extensions = [], $first_call = true)
{
    if (function_exists("scandir")) {
        $file = scandir($directory);
    } else {
        $file = php4_scandir($directory);
    }
    natcasesort($file);
    $files = $dirs = [];
    foreach ($file as $this_file) {
        if (is_dir($directory . "/" . $this_file)) {
            $dirs[] = $this_file;
        } else {
            $files[] = $this_file;
        }
    }
    $file = array_merge($dirs, $files);
    if (!empty($extensions)) {
        foreach (array_keys($file) as $key) {
            if (!is_dir($directory . "/" . $file[$key])) {
                $ext = substr($file[$key], strrpos($file[$key], ".") + 1);
                if (!in_array($ext, $extensions)) {
                    unset($file[$key]);
                }
            }
        }
    }
    if (2 < count($file)) {
        $php_file_tree = "<ul";
        if ($first_call) {
            $php_file_tree .= " id='folder' class=\"php-file-tree\"";
            $first_call = false;
        }
        $php_file_tree .= ">";
        foreach ($file as $this_file) {
            if ($directory . "/" . $this_file == "../../images/gallery/.") {
                $php_file_tree .= "<li class=\"pft-directory\" style=\"\">\n                    <h2> </h2>";
                $php_file_tree .= "<ul>";
            }
            if ($this_file != "." && $this_file != ".." && is_dir($directory . "/" . $this_file)) {
                $php_file_tree .= "<li class=\"pft-directory\"  style=\"\">\n                    <a target=\"main\"  href=\"gallerymn.php?dir=" . base64_encode($directory . "/" . $this_file) . "&id=" . $id . "&shows=true\"><img src=\"../images/folder.png\")'>" . htmlspecialchars($this_file) . "</a>";
                $php_file_tree .= php_file_tree_dir($directory . "/" . $this_file, $return_link, $extensions, false);
                $php_file_tree .= "</li>";
            }
        }
        $php_file_tree .= "</ul>";
    }
    return $php_file_tree;
}

?>