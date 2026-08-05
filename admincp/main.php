<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace main;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include "../comm.php";

include "../includes/fun.inc.php";
include "includes/fun.inc.php";
require "includes/comm.inc.php";
include ROOTDIR . "/includes/mobiledevice.inc.php";
global $lite;
global $WhiteLabel;
global $liteplus;
global $versioncatch;
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $licinfo = "ads";
    if ($debug_output) {
        echo "<textarea cols=100 rows=20>";
        print_r($licinfo);
        echo "</textarea>";
    }
    if (1==1) {
      
        
       
        if (1==1) {
            $lite = false;
        } else {
            if (1==1) {
                $liteplus = false;
            }
        }
       
            if (1==1) {
                $WhiteLabel = false;
            }
        
        if (1==1) {
            $addons = $licinfo["addons"];
        }
        if ($devmode) {
            $versioncatch = md5(time());
        } else {
            $versioncatch = $licinfo["version"]["release"];
        }
        if ($config["release_candidate"] == "BETA") {
            $versioncatch = md5(time());
        }
    } else {
         $versioncatch = md5(time());
    }
} catch (\Exception $e) {
  $versioncatch = md5(time());
}
if (mysqli_num_rows(dquery("select id from tbl_services_imei")) != 0 && mysqli_num_rows(dquery("select pricingid from tbl_service_pricing")) == 0) {
    include "includes/pages/newpricingmigration.php";
    exit;
}
$mobilebrowser = mobile_device_detect();
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<a   target=\"_parent\" href=\"index.php\" style=\"text-decoration:none;position: absolute;top:20%;left:50%;margin-left: -75px;text-align: center;font-family: arial;font-size:20px\" class=\"session-expired\"><span style=\"color:red\">Session expired <br/> <span style=\"color:#939393;font-size:16px\">Click here to login</span></span></a>";
    exit;
}
$pagetitle = "Home";
if ($mobilebrowser) {
    $templatefile = "main.mobile";
} else {
    $templatefile = "main";
}
$laoddefaultpage = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $laoddefaultpage);
if (isset($_GET["switch"])) {
    $sql = mysqli_fetch_assoc(dquery("select template from\n    tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $_SESSION["admin_template"] = $sql["template"];
}
if (isset($_SESSION["deviceid"])) {
    setcookie("device", $_SESSION["deviceid"], time() + 31536000, "/");
}
$fileverioncheck = "6.1.0";
if (!isset($_SESSION["currencyarray"])) {
    $cq = dquery("SELECT * from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cq)) {
        $_SESSION["currencyarray"][$rc["id"]] = $rc;
    }
}
DiscplyOutputAdmin($templatefile, $pagetitle, $mobilebrowser);
$_GET["pageurl"] = $_GET["pageurl"];
if ($config["keyboard_shortcuts"]) {
    if ($IsFileOnly) {
        echo "<script>\n\$(document).ready(function(){\n     document.onkeyup=function(ev) {\n       if(ev.which==113){\n       }\n}\n\$(function() {\n    var isCtrl = false;\n    var isShift =false;\n    \$(document).keyup(function (e) {\n            if(e.keyCode == 17){\n                    isCtrl = false;\n            }\n            if(e.keyCode == 16){\n                    isShift = false;\n            }\n            if(e.keyCode == 18){\n                    isAlt = false;\n            }\n    }).keydown(function (e) {\n\n            if(e.keyCode == 17){\n                    isCtrl = true;\n            }\n            if(e.keyCode == 16){\n                    isShift = true;\n            }\n            if(e.keyCode == 18){\n                    isAlt = true;\n            }\n            if(e.keyCode == 85 && isAlt && isCtrl == true) {\n                    load_page('addnewclient','Add New Client');\n                    return false;\n            }else if(e.keyCode == 76 && isCtrl == true) {\n                    load_page('clientlist','Client List');\n                    return false;\n            }else if(e.keyCode == 81 && isCtrl == true) {\n                    load_page('generalsettings','General Settings');\n                    return false;\n            }else if(e.keyCode == 70 && isCtrl == true && isAlt == true) {\n                    load_page('fileorder','New File Orders');\n                    return false;\n            }\n    });\n});\n    //subdivtoggle();\n\n});\n</script>\n";
    } else {
        echo "<script>\n\n\$(document).ready(function(){\n\n     document.onkeyup=function(ev) {\n       if(ev.which==113){\n         load_page('pos.sales','Sales [F2]','')\n       }\n}\n\n \$(function() {\n                var isCtrl = false;\n                var isShift =false;\n                \$(document).keyup(function (e) {\n                        if(e.keyCode == 17){\n                                isCtrl = false;\n                        }\n\n\n                        if(e.keyCode == 16){\n                                isShift = false;\n                        }\n\n\n                        if(e.keyCode == 18){\n                                isAlt = false;\n                        }\n                }).keydown(function (e) {\n\n                        if(e.keyCode == 17){\n                                isCtrl = true;\n                        }\n\n\n                         if(e.keyCode == 16){\n                                isShift = true;\n                         }\n\n                        if(e.keyCode == 18){\n                                isAlt = true;\n                        }\n\n                        if(e.keyCode == 85 && isAlt && isCtrl == true) {\n                                load_page('addnewclient','Add New Client');\n                                return false;\n                        }else if(e.keyCode == 76 && isCtrl == true) {\n                                load_page('clientlist','Client List');\n                                return false;\n                        }else if(e.keyCode == 81 && isCtrl == true) {\n                                load_page('generalsettings','General Settings');\n                                return false;\n                        }else if(e.keyCode == 73 && isCtrl == true && isAlt == true) {\n                                load_page('imeiorder','New IMEI Orders');\n                                return false;\n                        }else if(e.keyCode == 70 && isCtrl == true && isAlt == true) {\n                                load_page('fileorder','New File Orders');\n                                return false;\n                        }else if(e.keyCode == 83 && isCtrl == true && isAlt == true) {\n                                load_page('serverorder','New Server Orders');\n                                return false;\n                        }else if(e.keyCode == 80 && isCtrl == true && isAlt == true) {\n                                load_page('productorder','New Product Orders');\n                                return false;\n                        }\n\n                });\n        });\n\n    //subdivtoggle();\n\n\n});\n</script>\n";
    }
}
if ($_GET["pageurl"]) {
    $pageurl = base64_decode($_GET["pageurl"]);
    $pageurl = preg_replace("/[^0-9\\-a-zA-Z&=\\/.?]/i", "", $pageurl);
    $title = preg_replace("/[^0-9\\-a-zA-Z #]/i", "", base64_decode($_GET["title"]));
    if (!$title) {
        $title = "Edit Page";
    }
    if (deregi("pages", $pageurl)) {
        echo "<script>\ntry{\n\n    load_directpage('";
        echo $pageurl;
        echo "','";
        echo $title;
        echo "');\n}catch(e){\n\n    var pageuri='";
        echo $pageurl;
        echo "'.split('/');\n    pageuri=pageuri[2].split('.php?');\n    pageuri=pageuri[0]+'&'+pageuri[1];\n    load_page(pageuri,'";
        echo $title;
        echo "','";
        echo $token;
        echo "');\n}\n</script>\n";
    } else {
        if (isset($_GET["id"])) {
            $JOINTS = "&id=" . urlencode($_GET["id"]);
        }
        echo "    <script>\n\n  load_page('";
        echo $pageurl;
        echo $JOINTS;
        echo "','";
        echo $title;
        echo "','";
        echo $token;
        echo "');\n    </script>\n    ";
    }
}
class main
{
}

?>