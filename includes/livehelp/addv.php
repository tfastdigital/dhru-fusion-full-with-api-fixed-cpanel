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
require_once "../../comm.php";
$currentpage = "live";
$sessid = session_id();
if ($cls) {
    dquery("update tbl_visitors set invite='' where sessionid='" . $sessid . "'");
}
$time = time();
$title = nl2br(urlencode($title));
$nowurl = urlencode(base64_decode($nowurl));
$ref = urlencode(base64_decode($ref));
$sql = dquery("select * from tbl_visitors where sessionid='" . $sessid . "'");
if (mysqli_num_rows($sql)) {
    if (isset($_SESSION["uid"])) {
        $visitor = $_SESSION["fullname"] . "', uid='" . $_SESSION["uid"];
    } else {
        $visitor = "Visitor";
    }
    dquery("update tbl_visitors set time='" . $time . "',url='" . $nowurl . "',visitor='" . $visitor . "',title='" . $title . "' where sessionid='" . $sessid . "'");
} else {
    $ua = getBrowserNew();
    $data = NULL;
    $data["sessionid"] = $sessid;
    $data["ip"] = $remote_ip;
    $data["status"] = "Browsing";
    $data["time"] = $time;
    if (stripos($ref, "dhru.com")) {
        $ref = "";
    }
    $data["referalurl"] = $ref;
    $data["url"] = $nowurl;
    $data["title"] = $title;
    $data["os"] = $ua["platform"];
    $data["browser"] = $ua["name"];
    if (isset($_SESSION["uid"])) {
        $data["visitor"] = $_SESSION["fullname"];
        $data["uid"] = $_SESSION["uid"];
    } else {
        $data["visitor"] = "Visitor";
    }
    $db->insert("tbl_visitors", $data);
    $data = NULL;
}
function getBrowserNew()
{
    $u_agent = $_SERVER["HTTP_USER_AGENT"];
    $bname = "Unknown";
    $platform = "Unknown";
    $version = "";
    if (preg_match("/linux/i", $u_agent)) {
        $platform = "linux";
    } else {
        if (preg_match("/macintosh|mac os x/i", $u_agent)) {
            $platform = "mac";
        } else {
            if (preg_match("/windows|win32/i", $u_agent)) {
                $platform = "windows";
            }
        }
    }
    if (preg_match("/MSIE/i", $u_agent) && !preg_match("/Opera/i", $u_agent)) {
        $bname = "Internet Explorer";
        $ub = "MSIE";
    } else {
        if (preg_match("/Firefox/i", $u_agent)) {
            $bname = "Mozilla Firefox";
            $ub = "Firefox";
        } else {
            if (preg_match("/Chrome/i", $u_agent)) {
                $bname = "Google Chrome";
                $ub = "Chrome";
            } else {
                if (preg_match("/Safari/i", $u_agent)) {
                    $bname = "Apple Safari";
                    $ub = "Safari";
                } else {
                    if (preg_match("/Opera/i", $u_agent)) {
                        $bname = "Opera";
                        $ub = "Opera";
                    } else {
                        if (preg_match("/Netscape/i", $u_agent)) {
                            $bname = "Netscape";
                            $ub = "Netscape";
                        }
                    }
                }
            }
        }
    }
    $known = ["Version", $ub, "other"];
    $pattern = "#(?<browser>" . join("|", $known) . ")[/ ]+(?<version>[0-9.|a-zA-Z.]*)#";
    $i = count($matches["browser"]);
    if ($i != 1) {
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches["version"][0];
        } else {
            $version = $matches["version"][1];
        }
    } else {
        $version = $matches["version"][0];
    }
    if ($version == NULL || $version == "") {
        $version = "?";
    }
    return ["userAgent" => $u_agent, "name" => $bname, "version" => $version, "platform" => $platform, "pattern" => $pattern];
}

?>