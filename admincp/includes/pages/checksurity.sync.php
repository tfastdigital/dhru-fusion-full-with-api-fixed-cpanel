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
require_once "../../../comm.php";
require_once ROOTDIR . "/" . $admindirpath . "/" . "includes/fun.inc.php";
require_once ROOTDIR . "/" . $admindirpath . "/includes/comm.inc.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
ob_start();
echo "Checking File Lists....";
ob_flush();
$Directory = new RecursiveDirectoryIterator("../../../", RecursiveDirectoryIterator::SKIP_DOTS);
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, "/^.+\\.php\$/i", RecursiveRegexIterator::GET_MATCH);
unset($txt);
unset($txtphp);
unset($MD5FILEARRY);
if (0 < count($Regex)) {
    echo "Ok<br />";
    ob_flush();
    foreach ($Regex as $file) {
        if (!preg_match("/templates_c/i", $file[0]) && !preg_match("/templates/i", $file[0]) && !preg_match("/configs\\/config.php/i", $file[0])) {
            if (preg_match("/tpl.php/i", $file[0]) || preg_match("/setup_/i", $file[0])) {
                $DELARR[] = $file[0];
                unlink($file[0]);
            } else {
                $filemd5 = md5_file($file[0]);
                $filepath = str_replace("../../../", "", $file[0]);
                $txt .= $filemd5 . " = " . $filepath . "  \n";
                $MD5FILEARRY[$filemd5] = str_replace($admindirpath . "/", "admin/", $filepath);
                unset($filemd5);
            }
        }
    }
    if (is_array($DELARR)) {
        echo "Deleting unnecessary file....<br />";
        ob_flush();
        foreach ($DELARR as $dl) {
            echo " " . $dl . " <br />";
            ob_flush();
        }
        echo "OK<br />";
        ob_flush();
    }
    $myfile = fopen("../md5checksumLocal.txt", "w");
    fwrite($myfile, $txt);
    fclose($myfile);
    $myfile = fopen("../md5checksumLocal.json", "w");
    fwrite($myfile, json_encode($MD5FILEARRY));
    fclose($myfile);
    echo "Getting License Information ...";
    ob_flush();
    $Remote = base64_decode(trim($licinfo["checksum"]));
    $Remote = json_decode($Remote, true);
    echo "Getting fingerprint data from Remote...";
    ob_flush();
    if (!is_array($Remote)) {
        echo "Error<br />";
        ob_flush();
        exit;
    }
    echo "Ok<br/>";
    ob_flush();
    $Patch = file_get_contents("../md5checksumpatch.json");
    $Patch = json_decode($Patch, true);
    foreach ($Remote as $k => $v) {
        if (in_array($v, $Patch)) {
            unset($Remote[$k]);
        }
    }
    $Remote = array_merge_recursive($Remote, $Patch);
    foreach ($MD5FILEARRY as $key => $val) {
        $Rkey = array_search($val, $Remote);
        if ($Rkey != $key) {
            $VUNRABLE[] = $val;
        }
    }
    echo "Checking PHP Version...";
    ob_flush();
    if (0 <= phpversion()) {
        echo "OK<br />";
        ob_flush();
    } else {
        echo phpversion() . "<span style='color:red;'><strong> (5.6 Required)</strong></span><br />";
        ob_flush();
    }
    echo "Checking config directory Access...";
    ob_flush();
    $CODE = cURL($config["config_site_name"] . "/configs/config.php");
    if ($CODE == 200) {
        echo "<span style='color:red'>Accessible (Protect /configs directory using .htaccess)</span> <br />";
        ob_flush();
    } else {
        echo "OK<Br/>";
        ob_flush();
    }
    echo "Checking templates directory Access...";
    ob_flush();
    $CODE = cURL($config["config_site_name"] . "/templates/index.php");
    if ($CODE == 200 || $CODE == 404) {
        echo "<span style='color:red'>Accessible (Protect /templates directory using .htaccess)</span> <br />";
        ob_flush();
    } else {
        echo "OK<Br/>";
        ob_flush();
    }
    echo "Checking templates_c directory Access...";
    ob_flush();
    $CODE = cURL($config["config_site_name"] . "/templates_c/index.php");
    if ($CODE == 200 || $CODE == 404) {
        echo "<span style='color:red'>Accessible (Protect /templates_c directory using .htaccess)</span> <br />";
        ob_flush();
    } else {
        echo "OK<Br/>";
        ob_flush();
    }
    echo "Checking language directory Access...";
    ob_flush();
    $CODE = cURL($config["config_site_name"] . "/language/index.php");
    if ($CODE == 200 || $CODE == 404) {
        echo "<span style='color:red'>Accessible (Protect /language directory using .htaccess)</span> <br />";
        ob_flush();
    } else {
        echo "OK<Br/>";
        ob_flush();
    }
    if (1500 < count($VUNRABLE)) {
        echo "<span style='color:red'>Your new package is released, please use latest downloaded files. <br />Security check failed</span><br />";
        ob_flush();
    } else {
        if (is_array($VUNRABLE)) {
            echo "<span style='color:red'><strong>Files found which is not from our system or no longer used or fingerprint changed</strong></span><br />";
            ob_flush();
            echo "<div  style='color:red'>";
            foreach ($VUNRABLE as $dl) {
                echo "  &nbsp;&nbsp;&nbsp;&nbsp; " . $dl . " <br />";
                ob_flush();
            }
            echo "</div >";
        }
    }
    $fileverioncheck = "6.1.0";
} else {
    echo "Error<br /><span style='color:red'>Security check failed</span><br />";
    ob_flush();
    exit;
}
function cURL($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpcode;
}

?>