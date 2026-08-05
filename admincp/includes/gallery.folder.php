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
require "../../comm.php";
require "../../includes/fun.inc.php";
require "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"../index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($id) {
    $_SESSION["obid"] = $id;
} else {
    $id = $_SESSION["obid"];
}
if ($addfolder) {
    $addfolder = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["addfolder"]);
    if ($_SESSION["gallary"] == "" || $_SESSION["gallary"] == "/") {
        $root = "../../images/gallery/";
    } else {
        $root = $_SESSION["gallary"];
    }
    mkdir($root . "/" . $addfolder, 493);
    echo "   <script>\n   parent.frames[\"menus\"].location.reload();\n   </script>\n   ";
}
if ($renamed) {
    $rename = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["rename"]);
    $exp = explode("/", $_SESSION["gallary"]);
    $nos = count($exp);
    unset($exp[$nos - 1]);
    $exp = implode("/", $exp);
    rename($_SESSION["gallary"], $exp . "/" . $rename);
    $folder = $rename;
    echo "   <script>\n   parent.frames[\"menus\"].location.reload();\n   parent.frames[\"main\"].location.reload();\n   </script>\n   ";
}
if ($remove) {
    deleteDir($_SESSION["gallary"]);
    $_SESSION["gallary"] = "/";
    echo "   <script>\n   parent.frames[\"menus\"].location.reload();\n   parent.frames[\"main\"].location.reload();\n   </script>\n   ";
}
if (isset($tab)) {
    $_SESSION["tabd"] = $tab;
} else {
    if (!$_SESSION["tabd"]) {
        $_SESSION["tabd"] = "gallery";
    }
}
if (!isset($_SESSION["gallary"])) {
    $_SESSION["gallary"] = "/";
}
if (!$folder) {
    if ($_SESSION["gallary"] == "/" || $_SESSION["gallary"] == "") {
        $folder = "";
    } else {
        $fo = explode("/", $_SESSION["gallary"]);
        $no = count($fo);
        $folder = $fo[$no - 1];
    }
}
echo " \n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\"> \n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>GSMBACKBASE</title>\n\n<style>\nbody {\n    margin: 0 !important;\n}\nli a {\n    color: white !important;\n}\n.paging td {\n    color: silver !important;\n}\n.paging a {\n    color: gray !important;\n    text-decoration: none;\n}\n.paging .selected {\n    border: 1px solid #CCCCCC !important;\n    color: black;\n    margin: 2px;\n    padding: 2px 4px;\n}\n.paging .pager {\n    background: none repeat scroll 0 0 #F4F4F4;\n    border: 1px solid #CCCCCC !important;\n    margin: 3px;\n    padding: 1px 5px !important;\n}\n#tabmenu {\n    border-radius: 0 0 0 0 !important;\n    background: #222 !important;\n    height:50px;\n    line-height:30px;\n    box-shadow:none !important;\n    border: none !important;\n    \n}\n#tabmenu li {\n    color: #666666;\n    float: left;\n    font-size: 13px;\n    list-style: none outside none;\n    margin: 0 !important;\n    padding: 0 !important;\n    text-decoration: none;\n}\n#tabmenu li a {\n    color: #CCCCCC;\n    display: block;\n    padding:0 15px !important;\n    text-decoration: none;\n    height:50px;\n    line-height:50px;\n}\n#tabmenu li a:hover {\n    color: black !important;    \n}\na.tabmenu_active {\n    background: none repeat scroll 0 0 white;\n    border: none !important;\n    color: #222222 !important;\n    cursor: default !important;\n}\n.block {\n    background: none repeat scroll 0 0 #FAFAFA;\n    border: 1px solid #F4F4F4;\n    float: left;\n    margin: 5px;\n    padding: 5px;\n    position: relative;\n}\n.block_img {\n    background-position: center center;\n    background-repeat: no-repeat;\n    height: 150px;\n    width: 150px;\n}\n.block .block_text {\n    background: url(\"../images/block_bg.png\") repeat scroll 0 0 transparent;\n    color: white;\n    display: none;\n    left: 0;\n    position: absolute;\n    top: 0;\n}\n.block:hover .block_text {\n    display: block;\n    height: 150px;\n    padding: 5px;\n    width: 150px;\n}\n</style>\n\n<link rel=\"stylesheet\" href=\"css/main2.css\" />\n<script src=\"js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"js/main2.fun.js\" type=\"text/javascript\"></script>\n<script src=\"js/jquery.fileupload.extend.js\" type=\"text/javascript\"></script>\n<script>\n    \$(document).ready(function(){       \n       window.resizeTo(1500,600); \n       \n       \$(\".block\").hover(\n          function () {                       \n            \$('.block_text',this).fadeIn('fast');\n          }, \n          function () {                           \n                \$('.block_text',this).fadeOut('fast');\n            });                         \n      \n    });\n</script>\n</head>\n\n<body> \n\n<body style=\"position:  absolute;left:0;right:0;top:0px;bottom:0px\"> \n<div>\n\n<div id=\"main_loader\" style=\"display: none;\">\n<div  id=\"main_loader_sub\">\n    <table summary=\"Loader Layout\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n    <tbody><tr>\n    <td><p style=\"font:Arial, Helvetica, sans-serif; font-size:12px;\"><img src=\"images/ajax_loading.gif\" alt=\"clocks\" width=\"32\" height=\"32\" /><strong>Loading...</strong> <br /> Please wait until this completely loaded.</p></td>\n    </tr>\n    </tbody>\n    </table>\n</div>\n</div>\n\n<ul style=\"padding-right: 20px !important;\" id=\"tabmenu\"> \n    <li><a  href=\"gallerymn.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=gallery\">";
echo $LNG["images"];
echo "</a></li> \n    <li><a ";
if ($_SESSION["tabd"] == "thumb") {
    echo "class='tabmenu_active'";
}
echo "  href=\"thumb.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=thumb\">Thumb</a></li>\n    <li><a ";
if ($_SESSION["tabd"] == "upload") {
    echo "class='tabmenu_active'";
}
echo "  href=\"gallery.upload2.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=upload\" >";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo "</a></li>             \n    <li style=\"float: right !important;\"><a ";
if ($_SESSION["tabd"] == "folder") {
    echo "class='tabmenu_active'";
}
echo " href=\"gallery.folder.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=folder\" >";
echo $LNG["folder"];
echo " ";
echo $LNG["option"];
echo "</a></li>\n    <div style=\"margin-top:8px;float:right\"><input type=\"text\" name=\"search_image\"/><input type=\"submit\" value=\"";
echo $LNG["search"];
echo "\" style=\"border: none;\" name=\"search\"/></div>\n    <div style=\"clear: both;\"></div>\n</ul>\n\n\n<div style=\"padding:0 10px\">\n<span>You are here: \n";
if ($_SESSION["gallary"] == "/" || $_SESSION["gallary"] == "") {
    echo "gallery/";
} else {
    echo str_replace("../../", "", $_SESSION["gallary"]);
}
echo "</span>\n</div>\n<br /><br />\n<div style=\"clear:  both;\"></div>\n<form method=\"post\" style=\"padding: 10px;\">\n<div>\n<table style=\"width: 400px !important;\">\n<tr>\n<td>";
echo $LNG["add"];
echo " ";
echo $LNG["folder"];
echo "</td>\n<td><input type=\"text\" name=\"addfolder\" /></td>\n<td><input type=\"submit\" name=\"save\" value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["folder"];
echo "\" /></td>\n</tr>\n";
if ($folder != "" && $folder != "gallery" && $folder != "supplier" && $folder != "background" && $folder != "tmpImages" && $folder != "watermarks") {
    echo "<tr>\n<td>";
    echo $LNG["rename"];
    echo " ";
    echo $LNG["folder"];
    echo "</td>\n<td><input type=\"text\" name=\"rename\" value=\"";
    echo $folder;
    echo "\" /></td>\n<td><input type=\"submit\" name=\"renamed\" value=\"";
    echo $LNG["rename"];
    echo "\" /></td>\n</tr>\n";
}
echo "</table>\n</div>\n";
if ($folder != "" && $folder != "gallery" && $folder != "background" && $folder != "tmpImages" && $folder != "watermarks" && $folder != "supplier") {
    echo "<div align=\"right\">\n<input type=\"submit\" name=\"remove\" value=\"";
    echo $LNG["remove"];
    echo " ";
    echo $folder;
    echo "\" /></td>\n</div>\n";
}
echo "</form>\n<div style=\"clear: both;\"></div>\n</div>\n</body>\n</html>\n";
function deleteDir($dir)
{
    if (substr($dir, strlen($dir) - 1, 1) != "/") {
        $dir .= "/";
    }
    if ($handle = opendir($dir)) {
        while ($obj = readdir($handle)) {
            if ($obj != "." && $obj != "..") {
                if (is_dir($dir . $obj)) {
                    if (!deleteDir($dir . $obj)) {
                        return false;
                    }
                } else {
                    if (is_file($dir . $obj) && !unlink($dir . $obj)) {
                        return false;
                    }
                }
            }
        }
        closedir($handle);
        if (!@rmdir($dir)) {
            return false;
        }
        return true;
    }
    return false;
}

?>