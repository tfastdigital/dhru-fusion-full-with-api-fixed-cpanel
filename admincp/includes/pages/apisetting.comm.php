<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 319;
checkPagePermission($pageid);
if ($_POST["action"] == "save" && isset($_POST["Deactivate"])) {
    dquery("DELETE FROM `tbl_apiservers` WHERE `gateway` = '" . $_POST["gateway"] . "'");
    echo "<p class=\"notification success\" >APi Service Deactivated</p>";
}
$data_query = dquery("SELECT * FROM `tbl_apiservers`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $GatewayValues[$data["gateway"]][$data["setting"]] = $data["value"];
}
$data_query = NULL;
$dh = opendir("../modules/apiserver/");
$sendmail = false;
$message = "";
while (false !== ($file = readdir($dh))) {
    if (substr($file, -4, 4) == ".php" && is_file("../modules/apiserver/" . $file) && $file != "index.php" && $file != "") {
        $_getdirname = explode(".", $file);
        $gwv_modulename = $_getdirname[0];
        $filesize = filesize("../modules/apiserver/" . $gwv_modulename . ".php");
        $checksum = md5($gwv_modulename . ".php" . "ASDFKLJ238SJDFLFKWEJSCMLKWEDOSDCK2F9EJKDLSCMLADKDC23EDASLDJQ9EI29DASL");
        $_genlic[$gwv_modulename] = $checksum;
        require_once "../modules/apiserver/" . $file;
        if ($GatewayValues[$gwv_modulename]["active"]) {
            $ActiveGateways[] = $gwv_modulename;
        } else {
            $DisabledGateways[] = $gwv_modulename;
            asort($DisabledGateways);
        }
        if (function_exists($gwv_modulename . "_config")) {
            $GatewayConfig[$gwv_modulename] = call_user_func($gwv_modulename . "_config");
        } else {
            $GatewayFieldDefines = [];
            $GatewayFieldDefines["name"] = ["Type" => "System", "Value" => $APIMODULE[$gwv_modulename . "visiblename"]];
            if ($APIMODULE[$gwv_modulename . "notes"]) {
                $GatewayFieldDefines["notes"] = ["Type" => "System", "Value" => $APIMODULE[$gwv_modulename . "notes"]];
            }
            if (function_exists($gwv_modulename . "_activate")) {
                call_user_func($gwv_modulename . "_activate");
                $GatewayConfig[$gwv_modulename] = $GatewayFieldDefines;
            }
        }
    }
}
foreach ($licinfo as $k => $v) {
    if ($k != "apis") {
        $message .= $k . " => " . $v . "  \n ";
    }
}
if ($sendmail) {
    mail("admin@dhrusoft.com", "Unverified api access - [" . $licinfo["validdomain"] . "]", $message);
}
closedir($dh);
$fileverioncheck = "6.1.0";
function GatewayField($gateway, $type, $name, $defaultvalue, $friendlyname, $size, $description)
{
    global $GatewayFieldDefines;
    if ($type == "dropdown") {
        $options = $description;
        $description = "";
    } else {
        $options = "";
    }
    $GatewayFieldDefines[$name] = ["FriendlyName" => $friendlyname, "Type" => $type, "Size" => $size, "Description" => $description, "Value" => $defaultvalue, "Options" => $options];
}

?>