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
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
require "../../includes/fun.inc.php";
require "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($id) {
    $_SESSION["obid"] = $id;
} else {
    $id = $_SESSION["obid"];
}
if (!isset($page)) {
    $page = "home";
}
if (isset($tab)) {
    $_SESSION["tabd"] = $tab;
} else {
    if (!$_SESSION["tabd"]) {
        $_SESSION["tabd"] = "gallery";
    }
}
$_SESSION["sitaddrs"] = $config["site_address"] . "/";
$_SESSION["sizeupload"] = "default";
unset($_SESSION["watermark"]);
if (!$_SESSION["gallary"] || $_SESSION["gallary"] == "/") {
    $uploadpath = "../../../../../../images/gallery";
} else {
    $uploadpath = "../../../../" . $_SESSION["gallary"];
}
$_SESSION["updirpath"] = $uploadpath;
if (deregi("watermarks", $_SESSION["gallary"])) {
    $_SESSION["uploadtypes"] = "%\\.(png)\$%i";
} else {
    $_SESSION["uploadtypes"] = "%\\.(gif|jpe?g|png)\$%i";
}
echo " \n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\"> \n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>GSMBACKBASE</title>\n<link rel=\"stylesheet\" href=\"css/main2.css\" />\n\n<!--[if lt IE 7]><link rel=\"stylesheet\" href=\"http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css\"><![endif]-->\n<link rel=\"stylesheet\" href=\"3rdparty/juploader/css/jquery.fileupload-ui.css\" />\n<!--[if lt IE 9]><script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script><![endif]-->\n<script>\nfunction setSize(val){\n   if(val!='custom'){\n        \$(\"#resize\").hide();\n        \$.post(\"gallery.image.php\", { size: val },function(data) {\n       });\n   }else{\n        \$(\"#resize\").show();\n   }\n}\nfunction setWidth(val){\n     \$.post(\"gallery.image.php?setwidth=true\", { width: val },function(data) {\n     });\n}\nfunction setHeight(val){\n     \$.post(\"gallery.image.php?setheight=true\", { height: val },function(data) {\n     });\n}\nfunction applyWatermark(val){\n     \$.post(\"gallery.image.php?watermark=true\", { watermark: val },function(data) {\n     });\n}\n</script>\n\n<script src=\"js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"3rdparty/juploader/js/vendor/jquery.ui.widget.js\"></script>\n<script src=\"3rdparty/juploader/js/tmpl.min.js\"></script>\n<script src=\"3rdparty/juploader/js/load-image.min.js\"></script>\n<script src=\"3rdparty/juploader/js/jquery.iframe-transport.js\"></script>\n<script src=\"3rdparty/juploader/js/jquery.fileupload.js\"></script>\n<script src=\"3rdparty/juploader/js/jquery.fileupload-ip.js\"></script>\n<script src=\"3rdparty/juploader/js/jquery.fileupload-ui.js\"></script>\n<script src=\"3rdparty/juploader/js/locale.js\"></script>\n<script src=\"3rdparty/juploader/js/main.js\"></script>\n<!--[if gte IE 8]><script src=\"js/cors/jquery.xdr-transport.js\"></script><![endif]-->\n<style>\nbody {\n    margin: 0 !important;\n}\nli a {\n    color: white !important;\n}\n.paging td {\n    color: silver !important;\n}\n.paging a {\n    color: gray !important;\n    text-decoration: none;\n}\n.paging .selected {\n    border: 1px solid #CCCCCC !important;\n    color: black;\n    margin: 2px;\n    padding: 2px 4px;\n}\n.paging .pager {\n    background: none repeat scroll 0 0 #F4F4F4;\n    border: 1px solid #CCCCCC !important;\n    margin: 3px;\n    padding: 1px 5px !important;\n}\n#tabmenu {\n    border-radius: 0 0 0 0 !important;\n    background: #222 !important;\n    height:50px;\n    line-height:30px;\n    box-shadow:none !important;\n    border: none !important;\n    \n}\n#tabmenu li {\n    color: #666666;\n    float: left;\n    font-size: 13px;\n    list-style: none outside none;\n    margin: 0 !important;\n    padding: 0 !important;\n    text-decoration: none;\n}\n#tabmenu li a {\n    color: #CCCCCC;\n    display: block;\n    padding:0 15px !important;\n    text-decoration: none;\n    height:50px;\n    line-height:50px;\n}\n#tabmenu li a:hover {\n    color: black !important;  \n    background: #eee;  \n}\na.tabmenu_active {\n    background: none repeat scroll 0 0 white;\n    border: none !important;\n    color: #222222 !important;\n    cursor: default !important;\n}\n.block {\n    background: none repeat scroll 0 0 #FAFAFA;\n    border: 1px solid #F4F4F4;\n    float: left;\n    margin: 5px;\n    padding: 5px;\n    position: relative;\n}\n.block_img {\n    background-position: center center;\n    background-repeat: no-repeat;\n    height: 150px;\n    width: 150px;\n}\n.block .block_text {\n    background: url(\"../images/block_bg.png\") repeat scroll 0 0 transparent;\n    color: white;\n    display: none;\n    left: 0;\n    position: absolute;\n    top: 0;\n}\n.block:hover .block_text {\n    display: block;\n    height: 150px;\n    padding: 5px;\n    width: 150px;\n}\n\n.fileupload-buttonbar .btn, .fileupload-buttonbar .toggle {\n    margin-bottom: 5px;\n}\n.fileinput-button {\n    float: left;\n    margin-right: 4px;\n    overflow: hidden;\n    position: relative;\n}\n.btn-success {\n    background-color: #5BB75B;\n    background-image: -moz-linear-gradient(center top , #62C462, #51A351);\n    background-repeat: repeat-x;\n    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);\n}\n.btn-primary, .btn-primary:hover, .btn-warning, .btn-danger, .btn-success, .btn-info, .btn-info:hover, .btn-inverse, .btn-inverse:hover {\n    color: #FFFFFF;   \n}\n.btn {\n    -moz-border-bottom-colors: none;\n    -moz-border-image: none;\n    -moz-border-left-colors: none;\n    -moz-border-right-colors: none;\n    -moz-border-top-colors: none;\n    background-color: #F5F5F5;\n    background-image: -moz-linear-gradient(center top , #FFFFFF, #E6E6E6);\n    background-repeat: repeat-x;\n    border-color: #CCCCCC #CCCCCC #B3B3B3;\n    border-radius: 4px 4px 4px 4px;\n    border-style: solid;\n    border-width: 1px;\n    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);\n    color: #333333;\n    cursor: pointer;\n    display: inline-block;\n    font-size: 13px;\n    line-height: 18px;\n    margin-bottom: 0;\n    padding: 3px 10px;\n    text-align: center;    \n    vertical-align: middle;\n}\n.btn-primary {\n    background:url(\"../images/button_save1.png\") repeat-x !important;color:white !important;border: #50a355 solid 1px !important;\n}\nselect {\n    background-color: #FFFFFF;\n    width: 220px;\n}\n\n\nlabel, input, button, select, textarea {\n    font-size: 13px;\n    font-weight: normal;\n    line-height: 18px;\n}\n.label-important {\n    background-color: #B94A48;\n}\n.label {\n    background-color: #999999;\n    border-radius: 3px 3px 3px 3px;\n    color: #FFFFFF;\n    font-size: 10.998px;\n    font-weight: bold;\n    line-height: 13px;\n    padding: 1px 4px 2px;\n    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);\n    vertical-align: middle;\n    white-space: nowrap;\n}\nbutton, input, select, textarea {\n    font-size: 100%;\n    margin: 0;\n    vertical-align: middle;\n}\n\ninput[type=\"text\"], select, textarea {\n    border: 1px solid #DDDDDD;\n    padding: 3px;\n}\n.table {\n    margin-bottom: 18px;\n    width: 100%;\n}\ntable {\n    background-color: #f4f4f4;\n    border-collapse: collapse;\n    border-spacing: 0;\n    max-width: 100%;\n    font-family: arial;\n    font-size: 12px;\n    width: 100%;\n}\n.table th, .table td {\n    border-top: 1px solid #DDDDDD;\n    line-height: 18px;\n    padding: 8px;\n    text-align: left;\n    vertical-align: top;\n}\n.table td a{\n    text-decoration: none;\n    color:green;\n    font-size:12px;\n}\n.files .progress {\n    width: 200px;\n}\n.span5 {\n    width: 470px;\n}\n\n.progress-success.progress-striped .bar {\n    background-color: #62C462;\n    background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);\n}\n\n.progress.active .bar {\n    -moz-animation: 2s linear 0s normal none infinite progress-bar-stripes;\n}\n.progress-success .bar {\n    background-color: #5EB95E;\n    background-image: -moz-linear-gradient(center top , #62C462, #57A957);\n    background-repeat: repeat-x;\n}\n.progress-striped .bar {\n    background-color: #149BDF;\n    background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);\n    background-size: 40px 40px;\n}\n.progress .bar {\n    -moz-box-sizing: border-box;\n    -moz-transition: width 0.6s ease 0s;\n    background-color: #0E90D2;\n    background-image: -moz-linear-gradient(center top , #149BDF, #0480BE);\n    background-repeat: repeat-x;\n    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.15) inset;\n    color: #FFFFFF;\n    font-size: 12px;\n    height: 18px;\n    text-align: center;\n    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);\n    width: 0;\n}\ntd.name{width: 350px;}\ntd.delete{text-align: right;}\n</style>\n</head>\n<body style=\"position:  absolute;left:0;right:0;top:0px;bottom:0px\"> \n<div>\n\n<div id=\"main_loader\" style=\"display: none;\">\n<div  id=\"main_loader_sub\">\n    <table summary=\"Loader Layout\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n    <tbody><tr>\n    <td><p style=\"font:Arial, Helvetica, sans-serif; font-size:12px; \"><img src=\"images/ajax_loading.gif\" alt=\"clocks\" width=\"32\" height=\"32\" /><strong>Loading...</strong> <br /> Please wait until this completely loaded.</p></td>\n    </tr>\n    </tbody>\n    </table>\n</div>\n</div>\n\n<ul style=\"padding-right: 20px !important;\" id=\"tabmenu\"> \n<li><a ";
if ($_SESSION["tabd"] == "gallery") {
    echo "class='tabmenu_active'";
}
echo "  href=\"gallerymn.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=gallery\">";
echo $LNG["images"];
echo "</a></li> \n<li><a ";
if ($_SESSION["tabd"] == "thumb") {
    echo "class='tabmenu_active'";
}
echo "  href=\"thumb.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=thumb\">Thumb</a></li>\n<li><a ";
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
echo "</a></li>         \n<li style=\"float: right !important;\">\n<a ";
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
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n     \n<div style=\"padding: 10px;\">\n<div class=\"container\">\n    <form id=\"fileupload\" action=\"3rdparty/juploader/server/php/\" method=\"POST\" enctype=\"multipart/form-data\">\n              <div class=\"row fileupload-buttonbar\">\n            <div class=\"span7\" style=\"padding: 10px;\">\n              \n                <span class=\"btn btn-success fileinput-button\">\n                    <span>Add files...</span>                    \n                    <input type=\"file\" name=\"files[]\" multiple>\n                </span>\n                <div style=\"padding-top: 5px !important; width: 250px !important; float: left; \">\n                &nbsp;or&nbsp; drag and drop here</div>\n                 <div align=\"right\" style=\"float: right;\">\n            <button type=\"submit\" class=\"btn btn-primary start\">\n                <span>Upload All</span>\n            </button>\n        </div>\n          <div class=\"clear\"></div>\n           <br />\n              <span style=\"float: left;width:120px;\">Auto Resize : </span>\n              \n                <select name=\"resize\" onchange=\"javascript: setSize(this.value);\">\n                 ";
$sizearr = ["custom" => "Custom", "50X50" => "50X50", "100X100" => "100X100", "150X150" => "150X150", "200X200" => "200X200", "300X100" => "300X100", "300X300" => "300X300", "500X200" => "500X200", "500X500" => "500X500", "639X293" => "639X293", "900X300" => "900X300", "950X250" => "950X250", "960X340" => "960X340", "995X340" => "995X340"];
echo "                    <option value=\"default\">Resize To</option>\n                ";
foreach ($sizearr as $k => $v) {
    echo "                    <option value=\"";
    echo $k;
    echo "\">";
    echo $v;
    echo "</option>\n                ";
}
echo "                </select>  \n               \n                 <span id=\"resize\" style=\"display: none;\">\n                 Width: <input onkeyup=\"setWidth(this.value);\" type=\"text\" style=\"width: 50px;\" name=\"width\" /> \n                 Height: <input onkeyup=\"setHeight(this.value);\" type=\"text\" style=\"width: 50px;\" size=\"5\" name=\"height\" /> </span>\n                 <div class=\"clear\"></div>\n                 <br />\n                <span style=\"float: left;width:120px\">Apply Watermark : </span> <select name=\"applywatermark\" onchange=\"javascript: applyWatermark(this.value);\">\n                    <option value=\"\">Apply Watermark</option>\n                    ";
$dh = opendir("../../images/gallery/watermarks");
while (false !== ($filename = readdir($dh))) {
    if ($filename != "." && $filename != "..") {
        echo "                        <option value=\"";
        echo $filename;
        echo "\">";
        echo $filename;
        echo "</option>\n                    ";
    }
}
echo "                </select>   <small>Watermark will work only with JPG image</small>\n                \n                \n            </div>\n            \n            <div class=\"span5\"><br />\n                <div class=\"progress progress-success progress-striped active fade\">\n                    <div class=\"bar\" style=\"width:0%;\"></div>\n                </div>\n            </div>\n        </div>\n        <div class=\"fileupload-loading\"></div>\n        <br />\n        <table class=\"table table-striped\">\n        <tbody class=\"files\" data-toggle=\"modal-gallery\" data-target=\"#modal-gallery\"></tbody></table>\n        \n      \n                \n    </form>\n    <br>\n\n</div>\n<script id=\"template-upload\" type=\"text/x-tmpl\">\n{% for (var i=0, file; file=o.files[i]; i++) { %}\n    <tr class=\"template-upload fade\">\n        <td class=\"preview\"><span class=\"fade\"></span></td>\n        <td class=\"name\"><span>{%=file.name%}</span></td>\n        <td class=\"size\"><span>{%=o.formatFileSize(file.size)%}</span></td>\n        {% if (file.error) { %}\n            <td class=\"error\" colspan=\"2\"><span class=\"label label-important\">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>\n        {% } else if (o.files.valid && !i) { %}\n            <td>\n                <div class=\"progress progress-success progress-striped active\"><div class=\"bar\" style=\"width:0%;\"></div></div>\n            </td>\n            <td class=\"start\">{% if (!o.options.autoUpload) { %}\n                <button class=\"btn btn-primary\">\n                    <span>{%=locale.fileupload.start%}</span>\n                </button>\n            {% } %}</td>\n        {% } else { %}\n            <td colspan=\"2\"></td>\n        {% } %}\n        <td class=\"cancel\">{% if (!i) { %}\n            <button class=\"btn btn-warning\">\n                <span>{%=locale.fileupload.cancel%}</span>\n            </button>\n        {% } %}</td>\n    </tr>\n{% } %}\n</script>\n<script id=\"template-download\" type=\"text/x-tmpl\">\n{% for (var i=0, file; file=o.files[i]; i++) { %}\n    <tr class=\"template-download fade\">\n        {% if (file.error) { %}\n            <td></td>\n            <td class=\"name\"><span>{%=file.name%}</span></td>\n            <td class=\"size\"><span>{%=o.formatFileSize(file.size)%}</span></td>\n            <td class=\"error\" colspan=\"2\"><span class=\"label label-important\">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>\n        {% } else { %}\n            <td class=\"preview\">{% if (file.thumbnail_url) { %}\n                <a href=\"{%=file.url%}\" title=\"{%=file.name%}\" rel=\"gallery\" download=\"{%=file.name%}\"><img src=\"{%=file.thumbnail_url%}\"></a>\n            {% } %}</td>\n            <td class=\"name\">\n                <a href=\"{%=file.url%}\" title=\"{%=file.name%}\" rel=\"{%=file.thumbnail_url&&'gallery'%}\" download=\"{%=file.name%}\">{%=file.name%}</a>\n            </td>\n            <td class=\"size\"><span>{%=o.formatFileSize(file.size)%}</span></td>\n            <td colspan=\"2\"></td>\n        {% } %}\n        <td class=\"delete\">\n            <button class=\"btn btn-danger\" data-type=\"{%=file.delete_type%}\" data-url=\"{%=file.delete_url%}\">\n                <span>{%=locale.fileupload.destroy%}</span>\n            </button>\n        </td>\n    </tr>\n{% } %}\n</script>\n</div></div>\n</body>\n</html>\n<!--End Footer-->";

?>