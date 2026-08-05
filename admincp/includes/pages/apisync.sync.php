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
define("API_SYNC", true);
require "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/apiserver.fun.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if (!$setupmyserver) {
    $setupmyserver = "";
}
if (!$imeifixed) {
    $imeifixed = "";
}
if (!$imeiper) {
    $imeiper = "";
}
if (!$serverfixed) {
    $serverfixed = "";
}
if (!$serverper) {
    $serverper = "";
}
if (!$remotefixed) {
    $remotefixed = "";
}
if (!$remoteper) {
    $remoteper = "";
}
if (!$deleteservices) {
    $deleteservices = "";
}
if ($slowsync) {
    $apisyncsleeptime = 6;
} else {
    $apisyncsleeptime = 0;
}
echo "<script src=\"../js/jquery.js\"></script>\n<!--\n<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js\" type=\"text/javascript\"></script>\n-->\n<style>\nbody {\n\tfont-family: \"Courier New\", Courier, monospace;\n\tcolor: gray;\n\tfont-size: 16px;\n}\n\n.header {\n\tcolor: black;\n\tfont-weight: bolder;\n}\n.error {\n\tcolor: #C60000;\n}\n</style>\n<script>\n    function callInstallAPis(apiserver,groupid,onlyservice){\n\n        var  ints=  setTimeout(function(){\n          \$.post( \"installapis.php?id=\"+apiserver+\"&onlyservice=\"+onlyservice+\"&starts=\"+groupid+\"&setupmyserver=";
echo $setupmyserver;
echo "&deleteservices=";
echo $deleteservices;
echo "&setupmyserverserver=";
echo $setupmyserverserver;
echo "&deleteservicesserver=";
echo $deleteservicesserver;
echo "&setupmyremote=";
echo $setupmyremote;
echo "&deleteremote=";
echo $deleteremote;
echo "&imeifixed=";
echo $imeifixed;
echo "&imeiper=";
echo $imeiper;
echo "&serverfixed=";
echo $serverfixed;
echo "&serverper=";
echo $serverper;
echo "&remotefixed=";
echo $remotefixed;
echo "&remoteper=";
echo $remoteper;
echo "\", function( data ) {\n                if(!data.trim()){\n                    console.log(\"installapis.php?id=\"+apiserver+\"&onlyservice=\"+onlyservice+\"&starts=\"+groupid+\"&setupmyserver=";
echo $setupmyserver;
echo "&deleteservices=";
echo $deleteservices;
echo "&setupmyserverserver=";
echo $setupmyserverserver;
echo "&deleteservicesserver=";
echo $deleteservicesserver;
echo "&setupmyremote=";
echo $setupmyremote;
echo "&deleteremote=";
echo $deleteremote;
echo "\");\n                    parent.LoaderHide();\n                    \$(\"#resultapi\").append('<br /><strong style=\"color: green ; font-weight: bold; font-size: 12px;\" >&checkmark; Successfully synchronize</strong> <br />');\n                    parent.checkscroll();\n                    parent.ButtonShow();\n                }else {\n                    var res = data.split(\"+___+\");\n                    \$(\"#resultapi\").append(res[0]);\n\n                    parent.doscroll = 1;\n                    parent.checkscroll();\n                    if (res[1] == 'Finished') {\n                        parent.LoaderHide();\n                        \$(\"#resultapi\").append('<br /><strong style=\"color: green ; font-weight: bold; font-size: 12px;\" >&checkmark; Successfully synchronize</strong> <br />');\n                        parent.checkscroll();\n                        parent.ButtonShow();\n                    } else {\n\n                        if (typeof res[1] !== 'undefined') {\n                            callInstallAPis(apiserver, parseInt(res[1]), onlyservice);\n                        } else {\n                            parent.LoaderHide();\n                            \$(\"#resultapi\").append('<br /><strong style=\"color: green ; font-weight: bold; font-size: 12px;\" >&checkmark; Successfully synchronize</strong> <br />');\n                            parent.checkscroll();\n                            parent.ButtonShow();\n                        }\n                    }\n                }\n            });\n\n        }, ";
echo $apisyncsleeptime ? $apisyncsleeptime * 1000 : 6000;
echo ");\n    }\n\n</script>\n";
global $ERRORLOG;
$ERRORLOG = NULL;
$log = new Log("manualsync");
$multigateway = explode(",", $id);
foreach ($multigateway as $id) {
    if ($multiple) {
        echo "Fetching price from " . $id . " ";
    }
    if (!$multiple) {
        echo syncApi($id);
        displyOutput("Updating services list");
        displyOutput("=============================================");
        echo syncApi($id, false, "services", "");
        dquery("DELETE FROM `tbl_apiserversservices` WHERE `gateway` = '" . $id . "'");
        echo "        <script>\n            parent.LoaderShow();\n            parent.ButtonHide();\n            callInstallAPis('";
        echo $id;
        echo "','','1');\n        </script>\n        ";
    } else {
        $donotdisplayoutput = 1;
        syncApi($id, true, "services", "");
        dquery("DELETE FROM `tbl_apiserversservices` WHERE `gateway` = '" . $id . "'");
        echo "        <script>\n            parent.ButtonHide();\n            parent.LoaderShow();\n            callInstallAPis('";
        echo $id;
        echo "','','1');\n        </script>\n        ";
    }
    if ($syncbrand) {
        echo syncApi($id, true, "mobiles", $delmodels);
    }
    if ($synccontry) {
        echo syncApi($id, true, "provider", $delprovider);
    }
    if ($syncmep) {
        echo syncApi($id, true, "mep", $delmep);
    }
    if ($synccontry) {
        echo syncApi($id, true, "assign_networks");
    }
    if ($syncbrand) {
        echo syncApi($id, true, "assign_mobiles");
    }
    if ($setupmyserver || $setupmyserverserver || $setupmyremote) {
        $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
        displyOutput("Updating your server services--");
        displyOutput("=============================================");
        if ($setupmyserver) {
            if ($deletecurrentimei) {
                dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "') and service_type='imei'");
                dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "') and `type`='serviceimei'");
                dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=0 and API='" . $id . "')");
                dquery("DELETE FROM `tbl_services_imei` WHERE useasserver=0 and API='" . $id . "'");
                dquery("DELETE FROM `tbl_imei_group` WHERE `server`=0 and id not in (select group_id from tbl_services_imei where useasserver=0)");
                displyOutput("Deleting IMEI Services of " . $id . ".....Ok");
            } else {
                if ($deleteservices) {
                    dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=0)");
                    dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=0)");
                    dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=0)");
                    dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=0) and service_type='imei'");
                    dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=0) and `type`='serviceimei'");
                    dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=0)");
                    dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=0)");
                    dquery("DELETE FROM `tbl_services_imei` WHERE useasserver=0");
                    dquery("DELETE FROM  `tbl_imei_group`  WHERE `server`=0");
                    displyOutput("Deleting all current IMEI service.....Ok");
                }
            }
        }
        if ($setupmyserverserver) {
            if ($deletecurrentserver) {
                dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "') and service_type='imei'");
                dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "') and `type`='serviceimei'");
                dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=1 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=1  and API='" . $id . "'");
                dquery("DELETE FROM `tbl_imei_group` WHERE `server`=1 and id not in (select group_id from tbl_services_imei where useasserver=1)");
                displyOutput("Deleting Server Services of " . $id . ".....Ok");
            } else {
                if ($deleteservicesserver) {
                    dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=1)");
                    dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=1)");
                    dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=1)");
                    dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=1) and service_type='imei'");
                    dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=1) and `type`='serviceimei'");
                    dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=1)");
                    dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=1)");
                    dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=1");
                    dquery("DELETE FROM  `tbl_imei_group`  WHERE `server`=1");
                    displyOutput("Deleting all current  SERVER service.....Ok");
                }
            }
        }
        if ($setupmyremote) {
            if ($deletecurrentremote) {
                dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "') and service_type='imei'");
                dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "') and `type`='serviceimei'");
                dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=2 and API='" . $id . "')");
                dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=2 and API='" . $id . "'");
                dquery("DELETE FROM `tbl_imei_group` WHERE `server`=2 and id not in (select group_id from tbl_services_imei where useasserver=2)");
                displyOutput("Deleting Remote Services of " . $id . ".....Ok");
            } else {
                if ($deleteremote) {
                    dquery("DELETE FROM  `tbl_imei_credit` where service_id in (select id from tbl_services_imei\n        where useasserver=2)");
                    dquery("DELETE FROM  `tbl_services_imei_api` where sid in (select id from tbl_services_imei\n        where useasserver=2)");
                    dquery("DELETE FROM  `tbl_discount_imei` where service_id in (select id from tbl_services_imei\n        where useasserver=2)");
                    dquery("DELETE FROM  `tbl_client_group_price` where service_id in (select id from tbl_services_imei\n        where useasserver=2) and service_type='imei'");
                    dquery("DELETE FROM  `tbl_customfields` where relid in (select id from tbl_services_imei\n        where useasserver=2) and `type`='serviceimei'");
                    dquery("DELETE FROM  `tbl_service_status` where serviceid in (select id from tbl_services_imei\n        where useasserver=2)");
                    dquery("DELETE FROM  `tbl_service_pricing` where serviceid in (select id from tbl_services_imei\n        where useasserver=2)");
                    dquery("DELETE FROM  `tbl_services_imei` WHERE useasserver=2");
                    dquery("DELETE FROM  `tbl_imei_group`  WHERE server=2");
                    displyOutput("Deleting all current  REMOTE service.....Ok");
                }
            }
        }
        echo "        <script>\n            parent.LoaderShow();\n            parent.ButtonHide();\n            callInstallAPis('";
        echo $id;
        echo "','','');\n        </script>\n";
    }
    if ($ERRORLOG) {
        echo "<hr /><br/><br/><strong class=\"error\" style=\"font-size: 12px;\">&#x2718; Fusion Pro generated the following error during synchronization</strong><br/>";
        $errors = NULL;
        foreach ($ERRORLOG as $k => $v) {
            $errors .= $v . "<br />";
            echo "<span class='error' > " . $v . " </span><br />";
        }
        echo "<br /><br />";
        echo "<script>alert(\"Fusion Pro generated the following error during synchronization <br />\" " . $errors . ");</script>";
    } else {
        if ($multiple) {
            echo ".. OK <br />";
        }
    }
}
$log->logEnd();
$fileverioncheck = "6.1.0";
echo "<div id=\"resultapi\">\n\n</div>\n";

?>