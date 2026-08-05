<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$isgetcont) {
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\"\tcontent=\"text/html; charset=";
    echo $config["admincharset"];
    echo "\" />\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">\n<title>Dhru Fusion ";
    echo $fusionlite ? "lite" : "";
    echo "</title>\n\n    ";
    global $OnlyEcommerce;
    global $versioncatch;
    echo "<script src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.min.js?v=";
    echo $versioncatch;
    echo "\"></script>\n\n<script src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/chosen.jquery.js?v=";
    echo $versioncatch;
    echo "\"></script>\n<link rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/chosen.min.css?v=";
    echo $versioncatch;
    echo "\" />\n\n<script src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/x-main2.fun.js?v=";
    echo $versioncatch;
    echo "\" type=\"text/javascript\"></script>\n<script src=\"includes/js/messi.min.js?v=";
    echo $versioncatch;
    echo "\" type=\"text/javascript\"></script>\n<script src=\"includes/js/jquery.fileupload.extend.js?v=";
    echo $versioncatch;
    echo "\" type=\"text/javascript\"></script>\n<script src=\"includes/js/validation.js?v=";
    echo $versioncatch;
    echo "\" type=\"text/javascript\"></script>\n\n\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg.js?v=";
    echo $versioncatch;
    echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/languages/js/dg-en.js?v=";
    echo $versioncatch;
    echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/highlight.js?v=";
    echo $versioncatch;
    echo "'></script>\n\n<link rel=\"stylesheet\" href='includes/3rdparty/datagrid/modules/jscalendar/skins/aqua/theme.css?v=";
    echo $versioncatch;
    echo "' />\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar.js?v=";
    echo $versioncatch;
    echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/lang/calendar-en.js?v=";
    echo $versioncatch;
    echo "'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar-setup.js?v=";
    echo $versioncatch;
    echo "'></script>\n\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg_ajax.js?v=";
    echo $versioncatch;
    echo "'></script>\n\n<script type='text/javascript' src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/flexcroll.js?v=";
    echo $versioncatch;
    echo "\"></script>\n\n    <link\n            href=\"includes/bootstrap/css/bootstrap.css?v=";
    echo $versioncatch;
    echo "\"\n            rel=\"stylesheet\">\n\n <link rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/x-main2.css?v=3";
    echo $versioncatch;
    echo "\" />\n\n<link type=\"text/css\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/jquery.ibutton.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\" media=\"all\" />\n\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.ibutton.js?v=";
    echo $versioncatch;
    echo "\"></script>\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.easing.1.3.js?v=";
    echo $versioncatch;
    echo "\"></script>\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.metadata.js?v=";
    echo $versioncatch;
    echo "\"></script>\n\n<script type=\"text/javascript\" src=\"includes/js/jquery.tablesorter.js?v=";
    echo $versioncatch;
    echo "\"></script>\n<script type=\"text/javascript\" src=\"includes/js/jquery.tablesorter.widgets.js?v=";
    echo $versioncatch;
    echo "\"></script>\n\n    <script src=\"includes/bootstrap/js/bootstrap.bundle.js?v=";
    echo $versioncatch;
    echo "\"></script>\n\n\n\n    <link\n            href=\"includes/bootstrap-datepicker/css/bootstrap-datepicker.css?v=";
    echo $versioncatch;
    echo "\"\n            rel=\"stylesheet\">\n    <script type='text/javascript' src='includes/bootstrap-datepicker/js/bootstrap-datepicker.js'></script>\n\n<link rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/font-awesome.css?v=";
    echo $versioncatch;
    echo "\" />\n<link rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/flaticon.css?v=";
    echo $versioncatch;
    echo "\" />\n<link href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/typekit-offline.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\" />\n\n <script type=\"application/javascript\">\n\n     // adds mobile browser class to html tag\n     var ua = navigator.userAgent.toLowerCase();\n     function removeSpaces(ua) {\n         return ua.split(' ').join('');\n     }\n     ua = removeSpaces(ua);\n     var iOS = ua.match(/(iphone|ipod|ipad)/);\n     if(iOS) {\n         \$('html').addClass('ios');\n     }\n     var iPad = ua.match(/(ipad)/);\n     if(iPad) {\n         \$('html').addClass('ipad');\n     }\n     var iPhone = ua.match(/(iphone|ipod)/);\n     if(iPhone) {\n         \$('html').addClass('iphone');\n     }\n     var android = ua.indexOf(\"android\") > -1;\n     if(android) {\n         \$('html').addClass('android');\n     }\n     var android4 = ua.indexOf(\"android4\") > -1;\n     if(android4) {\n         \$('html').addClass('android4');\n     }\n     var android2 = ua.indexOf(\"android2\") > -1;\n     if(android2) {\n         \$('html').addClass('android2');\n     }\n\n\n </script>\n\n\n</head>\n\n\n\n<body class=\"main2 ";
    echo $_SESSION["admintheme"];
    echo "\">\n\n\n\n    <div id=\"main_loader\" style=\"display: none;\">\n<div class=\"aProgress\"><div class=\"aBar slow\"></div><div class=\"aSpinner\"><div class=\"spinner-icon\"></div></div></div>\n</div>\n\n<div id=\"subpage\"  style=\"position: fixed; top: 0px; right: 0px; background: none repeat scroll 0% 0% white; border-left: 1px solid rgb(204, 204, 204); z-index: 1001; bottom: 0px; box-shadow: 0px 0px 10px 5px #ccc; left: 400px;display: none;\">\n  <div id=\"subpageheader\" class=\"clearfix\" style=\"padding:0 15px;background:#f4f4f4\">\n    <div style=\"float: left;\">\n        <span id=\"subpageheader_txt\">";
    echo $LNG["home"];
    echo "</span>\n    </div>\n\n    <div id=\"subpageheader_txt_profile\" style=\"float: right; line-height: 50px !important; margin-right: 20px;\" >\n        <input type=\"button\" value=\"X\" name=\"close\" class=\"close-edit\" id=\"closesubpage\"/>\n    </div>\n\n\n    <div style=\"clear: both;\"></div>\n  </div>\n  <iframe id=\"subpageiframe2\"  frameborder=\"0\" src=\"\" style=\"top:50px;z-index: 9;\"></iframe>\n</div>\n\n<div id=\"iframeforedit\"></div>\n\n\n<div class=\"firstDiv  column-tabbing\">\n\n\n<!--\n<i class=\"fa fa-pencil-square-o\"></i>\n-->\n\n\n";
}

?>