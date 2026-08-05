<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace livechat;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
require "../includes/fun.inc.php";
require "includes/fun.inc.php";
define("DATAGRID_DIR", "includes/3rdparty/datagrid/");
define("PEAR_DIR", "includes/3rdparty/datagrid/pear/");
require "includes/comm.inc.php";
global $lite;
global $WhiteLabel;
global $liteplus;
global $versioncatch;
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $licinfo = "asd";
    if ($debug_output) {
        echo "<textarea cols=100 rows=20>";
        print_r($licinfo);
        echo "</textarea>";
    }
    if ($licinfo["status"] === "Active") {
        if (!in_array($_SERVER["SERVER_NAME"], $licinfo["valid_domains"])) {
            throw new \Exception("This License not authorize for this domain name " . $_SERVER["SERVER_NAME"]);
        }
        $_server_ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
        if (!in_array($_server_ip, $licinfo["valid_ips"])) {
        }
        if ($licinfo["item_id"] === "06d2db89-494c-463b-9e21-289991a74952") {
            $lite = true;
        } else {
            if ($licinfo["item_id"] === "3f81242a-7820-44eb-977d-ec68e8b4742b") {
                $liteplus = true;
            }
        }
        foreach ($licinfo["addons"] as $k => $addondetail) {
            if ($addondetail["name"] == "White Label" && $addondetail["status"] == "Active") {
                $WhiteLabel = true;
            }
        }
        if ($licinfo["addons"]) {
            $addons = $licinfo["addons"];
        }
        if ($devmode) {
            $versioncatch = md5(time());
        } else {
            $versioncatch = $licinfo["version"]["release"];
        }
    } else {
        $versioncatch = $licinfo["version"]["release"];
    }
} catch (\Exception $e) {
   $versioncatch = $licinfo["version"]["release"];
}
$pageid = 476;
checkPagePermission($pageid);
unset($_SESSION["admin_afterlogin_re"]);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$time = time();
if ($config["online_status"] != "offline" && $config["live_chat_online_username"] == $_SESSION["adminname"]) {
    saveSettings("online_status", "online");
    saveSettings("live_chat_online_time", $time);
}
dquery("UPDATE `tbl_admin` SET `online` = '1',`online_time`='" . $time . "' WHERE `id` ='" . $_SESSION["adminid"] . "'");
reqaddon("Live Chat");
dquery("UPDATE tbl_admin SET onlinestatus='available' where id='" . $_SESSION["adminid"] . "'");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["admincharset"];
echo "\" />\n\n<title>DHRU FUSION - Live Chat</title> \n<link rel=\"stylesheet\" href=\"templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<link rel=\"stylesheet\" href=\"templates/";
echo $_SESSION["admin_template"];
echo "/css/font-awesome.css\" />\n<script src=\"includes/js/jquery.js\" type=\"text/javascript\" charset=\"iso-8859-15\"></script>\n<script src=\"includes/js/main2.fun.js\" type=\"text/javascript\" charset=\"iso-8859-15\"></script>\n<script src=\"includes/js/jquery.fileupload.extend.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/validation.js\" type=\"text/javascript\"></script>\n<script src=\"includes/3rdparty/jplayer/jplayer.js\" type=\"text/javascript\" charset=\"iso-8859-15\"></script>\n\n<script>\n\$(document).ready(function() {\n    \$(\"#paysound\").jPlayer( {\n      ready: function() { \n        \$(this).jPlayer(\"setMedia\",  {mp3: \"includes/media/chat.mp3\"} ); \n      },\n\t  swfPath: 'includes/3rdparty/jplayer'\n    });\n    \$(\"#paysoundmessage\").jPlayer( {\n      ready: function() { \n        \$(this).jPlayer(\"setMedia\",  {mp3: \"includes/media/message.mp3\"} ); \n      },\n\t  swfPath: 'includes/3rdparty/jplayer'\n    });   \n    \n     LoadVisitorTab(); \n     \n    \$( window ).resize(function() {\n      \$('#conversationMain').css({'height':\$(window).height()-210});\n    });\n             \n    \$('#conversationMain').css({'height':\$(window).height()-210});\n    \n                \n    var olddata = '';\n        setInterval(function(){\n        \$.post('includes/livehelp.php?action=chatrequest',function (data, textStatus){\n            if(data!=''){\n                if(olddata!=data){\n                    \$(\"#paysound\").jPlayer('play');\n                }\n                olddata = data;\n            }\n            if(data){\n                \$(\"#loadchatrequest\").html(data).show();\n            }\n        });\n    },10000);\n\n    setInterval(function(){\n        LoadVisitorTab();\n    },60000);\n    setInterval(function(){\n        if(document.getElementById(\"currenttabid\").value!=''){\n            loadConversation(document.getElementById(\"currenttabid\").value,false);\n        }\n    },3000);\n    \n    \$('#message').keypress(function(event) {\n        if (event.which == '13') {\n             SubmitCahtForm();\n        }\n    });\n    \n    window.onbeforeunload = closeIt;\n \n});\n\n\n\nfunction inviteVisitor(val){\n    var name=prompt(\"Please enter message to Send Visitor \",\"\" ,\"Visitor Message\");\n    \$.post('includes/livehelp.php?action=invite&visitor='+val+'&msg='+name, function (data, textStatus) { });\n}\n\nfunction GeneratetRandomNumber()\n{\n\t_numberOne = 1;\n\t_numberTwo = 50000;\n\tvar _generator = Math.random()*(_numberTwo-_numberOne);\n\t_generator = Math.round(_numberOne+_generator);\n\treturn _generator;\n}\n\n\n\nfunction denyrequest(id){\n    \$.post('includes/livehelp.php?action=denyrequest',{id:id}, function (data, textStatus) {\n        var hideme = '#alert_'+id;\n        \$(hideme).hide();\n    });\n}\nfunction acceptrequest(id,name){\n    \$.post('includes/livehelp.php?action=acceptrequest',{id:id}, function (data, textStatus) {\n        var hideme = '#alert_'+id;\n        \$(hideme).hide();\n    });\n    addLi(id,name);\n}\nfunction addLi(id,name){\n    var rand = GeneratetRandomNumber();\n    \$(\"#tabmenu\").append('<li id=\"li_'+rand+'\"><a   onclick=\"getContect(\\'#a_'+rand+'\\',\\'includes/pages/chatting.php\\',\\''+id+'\\',\\'\\',\\'#tabcontent\\',true,\\'#main_loader\\',true);setCuttentTabID(\\''+id+'\\');\" id=\"a_'+rand+'\"> '+name+' &nbsp;&nbsp; <span onclick=\"removeLi(\\'#li_'+rand+'\\');denyrequest('+id+');LoadVisitorTab();\"> <i class=\"fa fa-remove\"></i> </span> </a> </li>');\n}\nfunction removeLi(id){\n    \$(id).remove();\n}\nfunction setCuttentTabID(id){\n    \$(\"#currenttabid\").val(id);\n}\nfunction closeIt()\n{\n    return \"This page is asking you to confirm that you want to leave - data you have entered may not be saved.\";\n}\nfunction LoadVisitorTab(){\n    getContect('#tab','includes/pages/chatvisitors.php','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');setCuttentTabID('');\n}\n\n\n/*\nsetInterval(\t\t\n\t\tfunction(){\t\t\n\tgetContect('#tab','livechat.php?page=chatvisitors','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\t\n\tsetCuttentTabID('');\n\t\t}\n,30000);\n*/\n\nfunction loadConversation(id,loadall){\n    \$.post('includes/loadchat.php?id='+id+'&loadall='+loadall, function (data, textStatus) {\n        \$(\"#conversation\").append(data);\n        if(data!=''){\n            if(data!=''){\n                \$(\"#paysoundmessage\").jPlayer('play');\n            }\n            olddataConversat = data;\n            \$('#conversationMain').animate({scrollTop: \$('#conversationMain')[0].scrollHeight});\n        }\n    });\n}\n\nfunction SubmitCahtForm (){\n  \$(\"#message\").val( (((\$.trim(document.getElementById(\"message\").value)).replace(/%/g,'%25')).replace(/\\+/g,'%2b')) );\n  if(document.getElementById(\"message\").value!=\"\"){\n      \$(\"#send\").attr(\"disabled\", true);\n      \$.post( \"includes/sendChat.php\" , \$(\"#frmchat\").serialize(), function (data, textStatus) {\n           \$(\"#message\").val(\"\");\n           \$(\"#send\").attr(\"disabled\", false);\n      });\n  }\n}\n\n \nfunction changeStat(v){\n    \$.post('includes/pages/changeChatStat.php',{stat:v}, function (data, textStatus) {\n       \n    });\n}\nfunction changePosition(val){\n    \$.post('includes/pages/changeChatStat.php',{position:val}, function (data, textStatus) {\n     \n    });\n}\nfunction setLiveHelp(ob){\n\n    \$.post('includes/pages/livehelpsetting.save.php',{livehelpservice:\$('#lqe').prop('checked')}, function (data, textStatus) {\n\n    });\n}\n</script>\n\n<script src=\"includes/js/chat.js\" type=\"text/javascript\"></script>\n<link rel=\"stylesheet\" href=\"includes/css/chat.css\" />\n \n\n</head>\n<body class=\"main2 ";
echo $_SESSION["admintheme"];
echo "\" style=\"overflow-y: hidden;\">\n\n\n<div id=\"main_loader\" style=\"display: block !important;\">\n<div class=\"aProgress\"> <div class=\"aSpinner\"><div class=\"spinner-icon\"></div></div></div>            \n</div>\n\n\n<div class=\"firstDiv\" style=\"margin: 0;\">\n\n\n<div id=\"paysound\"></div>\n<div id=\"paysoundmessage\"></div>\n<div id=\"loadchatrequest\"></div>\n<input type=\"hidden\" value=\"\" id=\"currenttabid\" name=\"currenttabid\" />\n\n\n\n\n\n\n<ul id=\"tabmenu\" style=\"margin: 0;\"> \n    <li><a class='tabmenu_active' onclick=\"LoadVisitorTab();\"  id=\"tab\" >Visitors</a></li>\n   \n</ul>\n \n <div class=\"clear\"> </div>\n \n<div id=\"tabcontent\" style=\"padding-top: 10px;\">\n\n   \n</div>\n\n</div>\n</body>\n</html>";
$fileverioncheck = "6.1.0";
echo "\n\n<style> \n    .msgwrapper{\n        margin-bottom:10px;\n    }\n    .client .message{\n       background: #d6ecf7;        \n    }\n    .client .name{         \n        color:#999;\n        font-size:13px;\n        padding:3px;\n    }\n    .staff{\n        text-align: right;\n    }\n    .staff .message{\n       background: #f3f3f3;        \n    }\n    .staff .name{        \n        color:#999;\n        font-size:13px;\n        padding:3px;\n    }\n    .message{        \n        max-width:50%;\n        padding:7px 15px;border-radius:5px;display:inline-block;color:black;\n        font-size:14px;\n        text-align: left;\n    }\n    .t-icon {         \n        text-transform: uppercase;\n        color: white;\n        font-size: 20px;\n        text-align: center;\n        display: block;\n        border-radius: 50%;\n        width: 46px;\n        height: 46px;\n        line-height: 46px;\n    }\n    .staff .t-icon {\n        background: #ec9525;\n     }\n      .client .t-icon {\n        background: #06b306;\n     }\n     #tabmenu .clear{clear:none;} \n</style>";
class livechat
{
}

?>