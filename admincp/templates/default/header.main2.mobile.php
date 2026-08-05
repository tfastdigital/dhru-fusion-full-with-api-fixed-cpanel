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
    echo "\" />\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n<title>Dhru Fusion ";
    echo $fusionlite ? "lite" : "";
    echo "</title>\n\n    ";
    global $OnlyEcommerce;
    global $versioncatch;
    echo "\n<script src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery-1.6.2.min.js\"  type=\"text/javascript\"></script>\n\n\n<link type=\"text/css\" rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/docs.css\" />\n<link type=\"text/css\" rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/mmenu.css\" />\n<link type=\"text/css\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/css/jquery.ibutton.css\" rel=\"stylesheet\" media=\"all\" />\n<link rel=\"stylesheet\" href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/main2.mobile.css\" />\n  \n\n\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg.js'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/languages/js/dg-en.js'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/highlight.js'></script>\n<style type='text/css'>@import url(includes/3rdparty/datagrid/modules/jscalendar/skins/aqua/theme.css);</style>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar.js'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/lang/calendar-en.js'></script>\n<script type='text/javascript' src='includes/3rdparty/datagrid/modules/jscalendar/calendar-setup.js'></script>\n\n<script type='text/javascript' src='includes/3rdparty/datagrid/scripts/dg_ajax.js'></script>\n \n\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.ibutton.js\"></script>  \n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.easing.1.3.js\"></script>\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.metadata.js\"></script>\n\n\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/jquery.mmenu.min.js\"></script>\n<script type=\"text/javascript\" src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/main2.fun.mobile.js\"></script>        \n";
    if (!$mobilebrowser) {
        echo "<script>    \n    function setCheckbox(){\n           \n         \$('input[type=\"checkbox\"]').not('.onoff').parent().not('.nocheckbox').addClass('checkbox');\n         \n         \$('.checkbox').each(function(){\n            if(\$(this).find('label').length==0){        \n                \$(this).find('input[type=\"checkbox\"]').after('<label></label>');   \n             }\n         });          \n         \n         \$('input[type=\"radio\"]').parent().addClass('radio');\n         if(\$('input[type=\"radio\"]').parent().find('label').length==0){\n            \$('input[type=\"radio\"]').parent().append('<label></label>');   \n         } \n    }\n   \n</script>\n";
    } else {
        echo "    \n    \n    <script>\n\n    function setCheckbox(){\n        \n    }                    \n    </script>\n";
    }
    echo " \n<script>\n    \$(document).ready(function(){    \n        //gnDropdown();\n    });\n\nfunction gnDropdown(){\n    \$('.firstDiv').prepend('<div class=\"subselection\"></div>');\n    if(\$(\"#tabmenu a\").length){\n        \$(\"<select />\").appendTo(\".subselection\");            \n        \$(\"<option />\", {\n           \"selected\": \"selected\",\n           \"value\"   : \"\",\n           \"text\"    : \":::\",\n           \"class\"    : 's-icon'\n        }).appendTo(\".subselection select\");\n    }\n    \n    // Populate dropdown with menu items\n    \$(\"#tabmenu a\").each(function() {       \n         \n         console.log(\$(this));\n         console.log(\$(this).html());\n           \n         if(\$(this).parent().find('ul').length=='0'){\n              var el = \$(this); \n              if(\$(this).hasClass('htab')){\n                  \$(\"<option />\", {            \n                     \"text\"    : el.text(),\n                     \"class\"    : 'htab'\n                 }).appendTo(\".subselection select\");\n              }\n              else\n              {                 \n                 \$(\"<option />\", {\n                     \"value\"   : el.attr(\"href\"),\n                     \"text\"    : el.text()\n                 }).appendTo(\".subselection select\");\n               }   \n         }   \n         else{\n             var el = \$(this);\n             \$(\"<optgroup />\", {             \n                 \"label\"    : el.text()\n             }).appendTo(\".subselection select\");\n         }\n       \n    });\n    \n    \$(\".subselection select\").change(function() {\n      window.location = \$(this).find(\"option:selected\").val();\n    });\n}\n</script>\n\n<style>\n    #tabmenu{display:flex;overflow: scroll;border-bottom:#ccc solid 1px;margin-bottom:10px;background: black;} \n    #tabmenu li{list-style: none;}\n    #tabmenu a{white-space: nowrap;padding:15px;display: inline-block;font-size:15px;text-decoration: none;color:white}\n    .subselection select {               \n        width:100%;\n        text-align:center; \n        border:none;\n        font-size:15px;\n        background: black; \n        text-transform: uppercase;\n        padding:7px !important;           \n        color:white                        \n    }    \n</style>\n    \n</head>\n<body style=\"background: white;\" class=\"";
    if ($p != "sub") {
        echo "main2";
    }
    echo "\">\n\n<!--\n<div id=\"header\">\n\t<a href=\"#menu1\"></a>\t\n</div>\n<nav id=\"menu1\">\n    <ul>\n        \n    </ul>\n</nav> \n--> \n\n<div id=\"main_loader\" style=\"display: none;\">\n<div class=\"aProgress\"><div class=\"aBar slow\"></div><div class=\"aSpinner\"><div class=\"spinner-icon\"></div></div></div>            \n</div>\n\n\n\n<div style=\"background:white\" class=\"firstDiv\">\n";
}
$fileverioncheck = "6.1.0";
echo "  ";

?>