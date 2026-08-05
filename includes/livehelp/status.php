<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "../../comm.php";
$position = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $position);
if (!$position) {
    $position = $config["livehelp_position"];
}
$config["siteurl"] = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
$sessid = session_id();
$_myunikrtr = substr($sessid, 0, 8);
if ($chatpromt) {
    $sql = mysqli_fetch_assoc(dquery("select invite,invite_msg,id from tbl_visitors where sessionid='" . $sessid . "' and invite='1'"));
    if ($sql) {
        echo "1++++" . $sql["invite_msg"];
        exit;
    }
    exit;
}
$status = "Offline";
$sql = dquery("select * from tbl_support_department where status='1' AND `livehelp`=1");
while ($row = mysqli_fetch_assoc($sql)) {
    $online = mysqli_num_rows(dquery("select id from tbl_admin where online='1' and\n     (chatdepartment like '%," . $row["id"] . ",%' or chatdepartment like '" . $row["id"] . ",%' OR chatdepartment like '%," . $row["id"] . "' OR chatdepartment='" . $row["id"] . "') and onlinestatus='available'"));
    if ($online) {
        $status = "Online";
    }
}
$type = base64_decode($type);
$type = preg_replace("/[^0-9\\,a-zA-Z]/i", "", $type);
if ($type == "text") {
    $link = "Live Support " . $status;
} else {
    if ($type != "html") {
        if ($onlystatus) {
            echo "url(" . $config["siteurl"] . "/images/live_" . $status . ".png)";
            exit;
        }
    }
}
$css = "<style>.chat-window.leftbottom{right:auto;left:10px;}.chat-window{position:fixed;bottom:100px;right:10px;border:none;width:350px;height:590px;box-shadow:0 5px 40px rgba(0,0,0,.16)!important;border-radius:8px;overflow:hidden;opacity:1 !important;z-index:9999}.chat-icon{display:none}.chat-icon.active{display:inline-block}.chat-icon-position{box-shadow:0 0 20px rgba(0,0,0,0.3);position:fixed;bottom:30px;right:30px;padding:15px !important;background:black;border-radius:50%;text-align:center;line-height:0 !important;z-index:999;}.chat-icon-position.Online{background:#00b900;color:white !important}.chat-icon-position.Offline{background:#e60000;color:white !important}.chat-icon-position.leftbottom{right:auto;left:30px;}@media (max-width:768px) {.chat-window { bottom: 0 !important;right: 0 !important;width: 100% !important;height: 100% !important;border-radius: 0 !important;} .chat-icon-position.openchat{z-index: 99999;top: 0;bottom: auto;background: transparent;box-shadow: none;right: 0;}}</style>";
$flotdiv = "<div id=\"flt" . $_myunikrtr . "\" style=\" display: none; position:absolute;width:350px;min-height: 50px; top:45%; right:45%;padding:20px;background:#FFFFFF;  border:5px solid #2266AA;   z-index:8000;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;\" > <h1 style=\"color: #666; font-family: aril; font-size: 22px; border-bottom: 1px solid #ccc; line-height: 40px; margin-top: -10px; \">Can I help you?</h1><div style=\"margin-top: -10px;\"><span style=\"color: #666; font-family: inherit; font-size: 12px;\">Our agents are ready to assist you. Click \"Chat Now\" to be connected to one instantly.</span></div><div id=\"msg" . $_myunikrtr . "\"></div><div style=\"color: #666; font-family: Arial,Lucida Grande, Helvetica, Verdana, sans-serif; \"><a style=\"text-decoration: none; color: #666;\" href=\"javascript:void(0);\" onclick=\"chatnow();\" target=\"_blank\"><div style=\" float: left; padding: 5px; width: 150px; margin-top: 10px;\"><strong>Chat Now</strong></div></a> <a style=\"text-decoration: none; color: #666;\" onclick=\"clsChhxxepsx();\" href=\"javascript:void(0);\"> <div align=\"right\" style=\"margin-top: 10px;float: right;padding: 5px; width: 150px;\">No thank you</div></a></div></div> ";
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: text/javascript");
echo "//===============================\n// Dhru\n// Copyright (c) 2001-2012\n// http://www.dhru.com\n// License: http://www.dhru.com/license\n//===============================\n\nvar ImageUse = new Image();\nvar referrer = encodeURIComponent(document.referrer);\n\n\nfunction loadStatus(divid,visitortrack)\n{\n\ndocument.getElementById(divid).innerHTML='<a href=\"javascript:void(0);\" class=\"";
echo $status;
echo " ";
echo $position;
echo " chat-icon-position\" onclick=\"loadChatWindow(\\'";
echo $config["siteurl"];
echo "/livechat.php\\',this); return false;\"><img class=\"chat-icon chat-icon1\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAOlJREFUeNrslmENxCAMhdk5mAUsnAUszMIsoAUtnAQszAKTwEHC5RrCWAtcSC6QvB8LTT/a8rYtzjk2Yj3YoDXBEzwULLxclLqJ5V4WFRt8jJBy3yUKcSbGmLucWDBMenithcNZL94TzGPSsHSyt4OO7Jh8FHCQBACZOZDC5qKCWaz201IRW4+aayt4BTBLmWsrOJ0peq5QtS+Ql9cJnk9yhsqKTVLxlcW6thr6Fd5y/Utwzq85i3UFPwt+1dTbXWMhc7FvKX6ueWlwxBhUD7Ak+BV+xbYWsKBUEXVgLLbM/+oJ/jvwW4ABALGTn9edY0clAAAAAElFTkSuQmCC\" style=\"width: 30px !important;\"/><img class=\"chat-icon chat-icon2 active\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABL9JREFUeNrEmH9MVmUUx9/3FVAERIYMk0oy0380TPwBMceambCyRn+k2IbjD2ZIky3N6Sqdpa3a/Ce31vAfVzk3KJjg0qJQyx84003dClFQwRzNphCIqOHb97jvtdOze997eX/k2T67931+3fOe53nOOc/jDwaDPo8SB3JAHpgHpoMMkAhkkF7QAQ6Dn8FxcM8XqYiCLqSAVeAQ6A16k0HwIygDAQ/fcMTvYsHXwXowQ5XdAm3gMugCAyAAJoKnwNMgRbVvBpvAsWhaMB3sMKxyCrwH8sB4h35jwFy261B9r4M3wrGgXeEk8JMavA2sBAkjHFz+5FZjWWwC/kgUzACtasAGkBXJGgKLQJcac124CoqFatVA28OwmhOz1JTfBS+Ho2A5GOYgu0F8lJSzmA/+4Pi/grSRKCiLvp2dL4DHoqycxVtqht4diYKVqmNFjJSzdvkv/M55kOlFQZnKFnY6B8bGUEFhhTJGqVt7cbALGLZEGsGgL7ZykA5epJBP0WMan/8RKVgEMvm71ajPAmtBKRhl1PlBCXibEcSUyWANWGb0FeV+43sOdZCYvRp8aBdJ6mjuO+BZZd5x4Fs1HSsM87+idv1xxmztsppD9LWiVCfXpZTVsKzcnOJE6nob3FG6PwLy1e9C478VqCmR7GaSqktjvVPfAT61ZVP5/BjM0lPcx/fRIEF1kGSgganUEKg3PrIXXFNr95Kq+1P1lfHrjL5JfN5UKVkD3yWFe59L6P4UbwS3ad5XjamQHV0Mch122UzwEki1qUsCRWC2US6xeB+/12ykYzvVsii23Ewh6Gbhlhi7GGEifaDINqNuGuhjXa21Bo8xExZ50ZjmWMgc8CSn84hR1w6a+D4X5Aa4MX5Q235xjBUs5/rqBEdt6vcrF7fE2oVfcTFLxw1qZ0dbXqDvFNkNemzadNBo8eK8LQVlB9bwXVzLmzFQLh18QCN0g88c2g2paDbOzKStjOYmHXG0NkYy+Frt0JUh2j6jsvB6s1JcxhArb4AlUVBOMvJGpVyNS65ZAP5m28/tGpSprS7PJ8JUTELlcp5pLNnlIUuvUAYqc2q0mY2Gma7rulTGz1HGAUh+J7L9enDCOBVu95jK7WF76T8+zmGhXuTzngpFY5hxVDFEXeOCtuJ3Ml1DNnegJWe5Oeo8bCTxfUUqfPa6mVkynClgBvg+6F3kYHSAmXqmxyURB/ayf491moxz+UfDoBosZc7YT0sM0FpjmWT46RrEr53h3cwZ9vcqVYxkIh+B30PdLFTYWKWRJzOfTfD3R7jTS0A/v/OdyhE9KXgaLDWSUX8UfWS1yqbkOJrtdvUhVNFZvgMmGHWSPu0HB3mDVRmmYhIYvlSGkKx8qpe7GSGH2NXFMxIMqsGbwEIudK8Klqr+3zhdsbhdv4WSXLBNpfMy0AHQwuu5v+iiJPF4nNn7TpXuLwe76KYk/p8K9wIzFPG83Dzp0f3IJeg89n2NZbccNl/EFvQZB558WlOuiB+9n4n8636u0E1N5W9J6W6AL+jsn7M58kbFgnYEGPLSucFSGAbl/RM6f5Gr6ro4byQXmLGmQB2aXBUM+P5/OcKIUc2Yn/jgiGkjD0NBKwn5FDzPne0YEv8RYABOjZJsdY6CAgAAAABJRU5ErkJggg==\" style=\"width: 30px !important;\"/> </a>";
echo $css;
echo " ";
echo $flotdiv;
echo "';\n    setInterval(\"updateStatus()\",30000);\n    setInterval(\"fltCzmopszqqwo()\",10000);\n    if(visitortrack==\"true\")\n    {\n        addV();\n    }\n}\nfunction loadChatWindow(path,obj){\n    \$('.chat-icon1,.chat-icon2').toggleClass('active');\n    \$(obj).toggleClass('openchat');\n    if(\$('body').find('.chat-window').length){\n    \n        if(\$(\"#chat-window\").contents().find('#conversationMain').length){\n            if(confirm(\"Are you sure you want to end chat?\")){ \n                \$('.chat-window').remove(); \n            }\n            else{\n                \$('.chat-icon1,.chat-icon2').toggleClass('active'); \n            }\n        }\n        else{\n            \$('.chat-window').remove(); \n        }\n    }\n    else{\n        var iframe = document.createElement('iframe');   \n        iframe.setAttribute(\"id\", \"chat-window\"); \n        iframe.src=path;   \n        iframe.classList.add('chat-window');\n        iframe.classList.add('";
echo $position;
echo "');        \n        document.body.appendChild(iframe);\n    }     \n}\nfunction clsChhxxepsx(){\n    updateurl = '";
echo $config["siteurl"];
echo "/includes/livehelp/addv.php?cls=true';\n    ImageUse = new Image();\n\tImageUse.onload = imageLoaded;\n\tImageUse.src = updateurl; \n    document.getElementById('flt";
echo $_myunikrtr;
echo "').style.display = \"none\";\n}\nfunction chatnow(){\n    clsChhxxepsx();\n    window.open('";
echo $config["siteurl"];
echo "/livechat.php', 'windowname1', 'width=600, height=700'); \n}\nfunction updateStatus()\n{\n    var PageTitleReg=/[^0-9,a-z,A-Z]/gi;\n    var finalPageTitle=document.title.replace(PageTitleReg, \" \"); \n    var referrer = (document.referrer);\n        referrer = Base64Encode(referrer);\n    var nowurl = (document.URL);   \n        nowurl = Base64Encode(nowurl);\n    updateurl = '";
echo $config["siteurl"];
echo "/includes/livehelp/addv.php?title='+finalPageTitle+'&ref='+referrer+'&nowurl='+nowurl;\n    ImageUse = new Image();\n\tImageUse.onload = imageLoaded;\n\tImageUse.src = updateurl;\n}\n\n\nfunction fltCzmopszqqwo()\n{\n    var xmlhttp;\n    if(window.XMLHttpRequest){\n        xmlhttp=new XMLHttpRequest();\n    }else{\n        xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n    }\n    xmlhttp.onreadystatechange=function(){\n        if (xmlhttp.readyState==4 && xmlhttp.status==200){\n            var responce = xmlhttp.responseText;\n            responce = (responce).split('++++')\n            if(responce[0]=='1'){\n                document.getElementById('flt";
echo $_myunikrtr;
echo "').style.display = \"\";\n                if(responce[1]){\n                    document.getElementById('msg";
echo $_myunikrtr;
echo "').innerHTML = responce[1];\n                }\n            }\n        }\n    }\n    xmlhttp.open(\"GET\",\"";
echo $config["siteurl"];
echo "/includes/livehelp/status.php?chatpromt=true\",true);\n    xmlhttp.send();\n}\n\n\nfunction updateStatus()\n{\n    var xmlhttp;\n    if(window.XMLHttpRequest){\n        xmlhttp=new XMLHttpRequest();\n    }else{\n        xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");\n    }\n    \n    xmlhttp.onreadystatechange=function(){\n        if (xmlhttp.readyState==4 && xmlhttp.status==200){             \n            document.getElementById('liveinner').style.backgroundImage = xmlhttp.responseText;\n        }\n    }\n    xmlhttp.open(\"GET\",\"";
echo $config["siteurl"];
echo "/includes/livehelp/status.php?onlystatus=true\",true);\n    xmlhttp.send();\n}\n\n\nfunction addV()\n{\n    var PageTitleReg=/[^0-9,a-z,A-Z]/gi;\n    var finalPageTitle=document.title.replace(PageTitleReg, \" \"); \n    var referrer = (document.referrer);\n        referrer = Base64Encode(referrer);\n    var nowurl = (document.URL);   \n        nowurl = Base64Encode(nowurl);\n    updateurl = '";
echo $config["siteurl"];
echo "/includes/livehelp/addv.php?title='+finalPageTitle+'&ref='+referrer+'&nowurl='+nowurl;\n    ImageUse = new Image();\n\tImageUse.onload = imageLoaded;\n\tImageUse.src = updateurl;\n}\nfunction imageLoaded() {\n\tif (!ImageUse)\n\t{\n\t\treturn;\n\t}\n\tproactiveAction = ImageUse.width;\n\n\tif (proactiveAction == 3)\n\t{\n\t\tdoProactiveInline_0ukgtai1();\n\t} else if (proactiveAction == 4) {\n\t\tdisplayProactiveChatData_0ukgtai1();\n\t}\n}\n\nfunction Base64Decode(input) {\n\treturn Base64.decode(input);\n}\n\nfunction Base64Encode(input) {\n\treturn Base64.encode(input);\n}\n\nvar Base64 = {\n\n\t// private property\n\t_keyStr : \"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=\",\n\n\t// public method for encoding\n\tencode : function (input) {\n\t\tvar output = \"\";\n\t\tvar chr1, chr2, chr3, enc1, enc2, enc3, enc4;\n\t\tvar i = 0;\n\n\t\tinput = Base64._utf8_encode(input);\n\n\t\twhile (i < input.length) {\n\n\t\t\tchr1 = input.charCodeAt(i++);\n\t\t\tchr2 = input.charCodeAt(i++);\n\t\t\tchr3 = input.charCodeAt(i++);\n\n\t\t\tenc1 = chr1 >> 2;\n\t\t\tenc2 = ((chr1 & 3) << 4) | (chr2 >> 4);\n\t\t\tenc3 = ((chr2 & 15) << 2) | (chr3 >> 6);\n\t\t\tenc4 = chr3 & 63;\n\n\t\t\tif (isNaN(chr2)) {\n\t\t\t\tenc3 = enc4 = 64;\n\t\t\t} else if (isNaN(chr3)) {\n\t\t\t\tenc4 = 64;\n\t\t\t}\n\n\t\t\toutput = output +\n\t\t\tthis._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +\n\t\t\tthis._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);\n\n\t\t}\n\n\t\treturn output;\n\t},\n\n\t// public method for decoding\n\tdecode : function (input) {\n\t\tvar output = \"\";\n\t\tvar chr1, chr2, chr3;\n\t\tvar enc1, enc2, enc3, enc4;\n\t\tvar i = 0;\n\n\t\tinput = input.replace(/[^A-Za-z0-9\\+\\/\\=]/g, \"\");\n\n\t\twhile (i < input.length) {\n\n\t\t\tenc1 = this._keyStr.indexOf(input.charAt(i++));\n\t\t\tenc2 = this._keyStr.indexOf(input.charAt(i++));\n\t\t\tenc3 = this._keyStr.indexOf(input.charAt(i++));\n\t\t\tenc4 = this._keyStr.indexOf(input.charAt(i++));\n\n\t\t\tchr1 = (enc1 << 2) | (enc2 >> 4);\n\t\t\tchr2 = ((enc2 & 15) << 4) | (enc3 >> 2);\n\t\t\tchr3 = ((enc3 & 3) << 6) | enc4;\n\n\t\t\toutput = output + String.fromCharCode(chr1);\n\n\t\t\tif (enc3 != 64) {\n\t\t\t\toutput = output + String.fromCharCode(chr2);\n\t\t\t}\n\t\t\tif (enc4 != 64) {\n\t\t\t\toutput = output + String.fromCharCode(chr3);\n\t\t\t}\n\n\t\t}\n\n\t\toutput = Base64._utf8_decode(output);\n\n\t\treturn output;\n\n\t},\n\n\t// private method for UTF-8 encoding\n\t_utf8_encode : function (string) {\n\t\tstring = string.replace(/\\r\\n/g,\"\\n\");\n\t\tvar utftext = \"\";\n\n\t\tfor (var n = 0; n < string.length; n++) {\n\n\t\t\tvar c = string.charCodeAt(n);\n\n\t\t\tif (c < 128) {\n\t\t\t\tutftext += String.fromCharCode(c);\n\t\t\t}\n\t\t\telse if((c > 127) && (c < 2048)) {\n\t\t\t\tutftext += String.fromCharCode((c >> 6) | 192);\n\t\t\t\tutftext += String.fromCharCode((c & 63) | 128);\n\t\t\t}\n\t\t\telse {\n\t\t\t\tutftext += String.fromCharCode((c >> 12) | 224);\n\t\t\t\tutftext += String.fromCharCode(((c >> 6) & 63) | 128);\n\t\t\t\tutftext += String.fromCharCode((c & 63) | 128);\n\t\t\t}\n\n\t\t}\n\n\t\treturn utftext;\n\t},\n\n\t// private method for UTF-8 decoding\n\t_utf8_decode : function (utftext) {\n\t\tvar string = \"\";\n\t\tvar i = 0;\n\t\tvar c = c1 = c2 = 0;\n\n\t\twhile ( i < utftext.length ) {\n\n\t\t\tc = utftext.charCodeAt(i);\n\n\t\t\tif (c < 128) {\n\t\t\t\tstring += String.fromCharCode(c);\n\t\t\t\ti++;\n\t\t\t}\n\t\t\telse if((c > 191) && (c < 224)) {\n\t\t\t\tc2 = utftext.charCodeAt(i+1);\n\t\t\t\tstring += String.fromCharCode(((c & 31) << 6) | (c2 & 63));\n\t\t\t\ti += 2;\n\t\t\t}\n\t\t\telse {\n\t\t\t\tc2 = utftext.charCodeAt(i+1);\n\t\t\t\tc3 = utftext.charCodeAt(i+2);\n\t\t\t\tstring += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));\n\t\t\t\ti += 3;\n\t\t\t}\n\n\t\t}\n\n\t\treturn string;\n\t}\n\n}";

?>