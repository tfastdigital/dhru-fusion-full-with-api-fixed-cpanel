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
require "../../../comm.php";
require "../fun.inc.php";
require "../comm.inc.php";
require ROOTDIR . "/includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$licinfo = licince\getLicenseDetails();
$LICENSE = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_license` WHERE `id`=1"));
$_product_token = $LICENSE["license_key"];
checkDemoMode(false);
if ($_SERVER["HTTP_HOST"] == "10.10.10.70" || $_SERVER["HTTP_HOST"] == "fusion.dhru.io" || $devmode) {
    exit("Development mode");
}
echo "    <style>\n        body {\n            font-family: arial;\n            color: gray;\n        }\n\n        .header {\n            color: black;\n            font-weight: bolder;\n        }\n\n        .error {\n            color: #C60000;\n        }\n    </style>\n\n";
$ver_req = json_decode(initCurl("https://api.dhru.com/integration/api/v1/productversions"), true)["data"];
$_product_id = $licinfo["item_id"];
$_release = $ver_req[$_product_id]["version"]["release"];
$_beta = $ver_req[$_product_id]["version"]["beta"];
if ($force != "force_upgrade" && $config["version"] == $_release & $preference != "BETA") {
    $Err["INFO"] = "You are up to date! Dhru Fusion v" . $_release . " is the latest version.";
    displyOutput($Err);
    exit;
}
echo "Connection to server.....";
if ($preference == "BETA") {
    $_stream = "beta";
    $_id = $_beta;
} else {
    $_stream = "";
    $_id = $_release;
}
$_from_version = $config["version"];
$url = "https://api.dhru.com/integration/api/v1/download?type=fusion_patch&stream=" . $_stream . "&id=" . $_id . "&from_version=" . $_from_version . "&token=" . $_product_token;
$_req = json_decode(initCurl($url), true);
if ($_req["status"] == "error") {
    echo "Ok<br/>";
    displyOutput(["ERROR" => $_req["message"]]);
    exit;
}
echo "Ok<br/>Getting patch file from server.....";
$url .= "&start_download=1";
$path = "../../tmp/update.zip";
set_time_limit(0);
$fp = fopen($path, "w");
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Dhru/Fusion");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$data = curl_exec($ch);
if (curl_errno($ch)) {
    displyOutput(["ERROR" => curl_error($ch)]);
    exit;
}
curl_close($ch);
fclose($fp);
if ($data) {
    echo "Ok<br/>Verifying patch files.....";
    if (file_exists("../../tmp/update.zip")) {
        if (filesize("../../tmp/update.zip") < 512) {
            echo "Fail #002<br/>";
        } else {
            echo "Ok<br/>";
        }
        echo "Installing updates.....";
        include_once "../../../includes/dUnzip2.inc.php";
        $zip = new dUnzip2("../../tmp/update.zip");
        $zip->debug = false;
        $vals = $zip->getList();
        $zip->unzipAll("../../tmp/");
        if (file_exists("../../tmp/FUSION/updateconfig.php")) {
            include "../../tmp/FUSION/updateconfig.php";
            $UPDATECONFIG = $_UPDATECONFIG;
            unlink("../../tmp/FUSION/updateconfig.php");
        }
        if ($vals) {
            if (!rename("../../tmp/FUSION/admin", "../../tmp/FUSION/" . $admindirpath)) {
                echo "Fail #003<br/>";
            } else {
                recurse_copy("../../tmp/FUSION/", "../../../");
            }
        }
        unlink("../../tmp/update.zip");
        rrmdir("../../tmp/update");
        rrmdir("../../tmp/FUSION");
        rrmdir("../../tmp/221");
        if ($UPDATECONFIG["VERSION"]) {
            saveSettings("version", $UPDATECONFIG["VERSION"]);
            saveSettings("release_candidate", $UPDATECONFIG["RC"]);
        }
        echo "Ok<br/>Patch Update Completed";
        echo $UPDATECONFIG["AFTERUPDATEMSG"];
        licince\getLicenseDetails(false, true);
        if (is_file("../../../installer/install/step1.php")) {
            echo "  <iframe style=\"border:0px; width:100%; height: 480px;\" src=\"../../../installer/install/step1.php?selfupgrade=true\"  ></iframe>";
            exit;
        }
    } else {
        echo "Fail #001<br/>";
    }
} else {
    echo "Fail";
}
$fileverioncheck = "6.1.0";
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
function recurse_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if ($file != "." && $file != "..") {
            if (is_dir($src . "/" . $file)) {
                recurse_copy($src . "/" . $file, $dst . "/" . $file);
            } else {
                if (!@copy($src . "/" . $file, $dst . "/" . $file)) {
                    $errors = error_get_last();
                    $Err["ERROR"] = $errors["type"] . " " . $errors["message"];
                    displyOutput($Err);
                    exit;
                }
            }
        }
    }
    closedir($dir);
}
function displyOutput($output)
{
    global $ERRORLOG;
    $_t = "&nbsp;&nbsp;&nbsp;&nbsp;";
    if (is_array($output)) {
        foreach ($output as $k => $v) {
            if ($k == "ERROR") {
                $ERRORLOG[] = $v;
            }
            echo "<span " . ($k == "ERROR" ? "class=\"error\" >" . $k : $k) . " => " . $v . "</span><br />";
            if (is_array($v)) {
                foreach ($v as $k1 => $v1) {
                    if ($k1 == "ERROR") {
                        $ERRORLOG[] = $v1;
                    }
                    echo $_t . " <span " . ($k1 == "ERROR" ? "class=\"error\"" . $k1 : $k1) . " => " . $v1 . "</span><br />";
                    if (is_array($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if ($k2 == "ERROR") {
                                $ERRORLOG[] = $v2;
                            }
                            echo $_t . $_t . " <span " . ($k2 == "ERROR" ? "class=\"error\"" . $k2 : $k2) . " => " . $v2 . "</span><br />";
                            if (is_array($v2)) {
                                foreach ($v2 as $k3 => $v3) {
                                    if ($k3 == "ERROR") {
                                        $ERRORLOG[] = $v3;
                                    }
                                    echo $_t . $_t . $_t . " <span " . ($k3 == "ERROR" ? "class=\"error\"" . $k3 : $k3) . " => " . $v3 . "</span><br />";
                                    if (is_array($v3)) {
                                        foreach ($v3 as $k4 => $v4) {
                                            if ($k4 == "ERROR") {
                                                $ERRORLOG[] = $v4;
                                            }
                                            echo $_t . $_t . $_t . $_t . " <span " . ($k4 == "ERROR" ? "class=\"error\"" . $k4 : $k4) . " => " . $v4 . "</span><br />";
                                            if (is_array($v4)) {
                                                foreach ($v4 as $k5 => $v5) {
                                                    if ($k5 == "ERROR") {
                                                        $ERRORLOG[] = $v5;
                                                    }
                                                    echo $_t . $_t . $_t . $_t . " <span " . ($k5 == "ERROR" ? "class=\"error\"" . $k5 : $k5) . " => " . $v5 . "</span><br />";
                                                    if (is_array($v5)) {
                                                        foreach ($v5 as $k6 => $v6) {
                                                            if ($k6 == "ERROR") {
                                                                $ERRORLOG[] = $v6;
                                                            }
                                                            echo $_t . $_t . $_t . $_t . " <span " . ($k6 == "ERROR" ? "class=\"error\"" . $k6 : $k6) . " => " . $v6 . "</span><br />";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo $output . "<br />";
    }
}

?>