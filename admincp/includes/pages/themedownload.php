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
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
echo "    <style>\nbody {\n\tfont-family: fantasy;\n\tcolor: gray;\n\tfont-size: 10px;\n}\n\n.header {\n\tcolor: black;\n\tfont-weight: bolder;\n}\n\n.error {\n\tcolor: #C60000;\n}\n</style>\n";
if ($bid || $checkpurchase) {
    checkDemoMode(false);
    if ($licinfo["_lickey"]) {
        echo "Connecting to cloud server...  ";
        $post["action"] = "gettheme";
        if ($checkpurchase) {
            $post["action"] = "checkpurchse";
        }
        $post["bid"] = $bid;
        $post["license"] = $licinfo["_lickey"];
        $data = initCurl("http://banners.dhru.org/index.php", $post);
        if ($data) {
            echo "OK <br/>";
            $response = json_decode($data, true);
            if ($response["success"]) {
                if ($checkpurchase) {
                    echo $response["success"];
                    exit;
                }
                $path = "../../tmp/" . $bid . ".zip";
                if (file_exists($path)) {
                    unlink($path);
                }
                $url = "http://banners.dhru.org/index.php";
                $fp = fopen($path, "w");
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $fields["action"] = "downloadtheme";
                $fields["bid"] = $bid;
                $fields["license"] = $licinfo["_lickey"];
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . "=" . urlencode($value) . "&";
                }
                rtrim($fields_string, "&");
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                $data = curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                if ($data) {
                    echo "License :" . $licinfo["_lickey"] . "<br/>";
                    if (filesize($path) < 512) {
                        $fh = fopen($path, "r");
                        if ($error = fread($fh, filesize($path))) {
                            fclose($fh);
                            $error = json_decode($error, true);
                            if ($error["error"]) {
                                displyOutput($error);
                                unlink($path);
                                exit;
                            }
                        }
                    } else {
                        echo "Getting theme#" . $bid . "...";
                    }
                }
                if (file_exists($path)) {
                    echo "OK <br/>Installing theme...";
                    include_once "../../../includes/dUnzip2.inc.php";
                    $zip = new dUnzip2($path);
                    $zip->debug = false;
                    $vals = $zip->getList();
                    $zip->unzipAll("../../../templates/");
                    unlink($path);
                    $data = NULL;
                    $data["name"] = $response["img_title"];
                    $data["cloud"] = $response["id"];
                    if ($db->insert("tbl_theme", $data)) {
                        echo "OK <br/>";
                    } else {
                        echo "....Error#45875<br/>";
                    }
                } else {
                    echo "....Error<br/>";
                }
                exit;
            } else {
                displyOutput(["error" => $response["error"]]);
                exit;
            }
        } else {
            echo "ERROR <br/> ";
        }
    }
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
                copy($src . "/" . $file, $dst . "/" . $file);
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
            if ($k == "error") {
                $ERRORLOG[] = $v;
            }
            echo "<span " . ($k == "error" ? "class=\"error\" >" . $k : $k) . " => " . $v . "</span><br />";
            if (is_array($v)) {
                foreach ($v as $k1 => $v1) {
                    if ($k1 == "error") {
                        $ERRORLOG[] = $v1;
                    }
                    echo $_t . " <span " . ($k1 == "error" ? "class=\"error\"" . $k1 : $k1) . " => " . $v1 . "</span><br />";
                    if (is_array($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if ($k2 == "error") {
                                $ERRORLOG[] = $v2;
                            }
                            echo $_t . $_t . " <span " . ($k2 == "error" ? "class=\"error\"" . $k2 : $k2) . " => " . $v2 . "</span><br />";
                            if (is_array($v2)) {
                                foreach ($v2 as $k3 => $v3) {
                                    if ($k3 == "error") {
                                        $ERRORLOG[] = $v3;
                                    }
                                    echo $_t . $_t . $_t . " <span " . ($k3 == "error" ? "class=\"error\"" . $k3 : $k3) . " => " . $v3 . "</span><br />";
                                    if (is_array($v3)) {
                                        foreach ($v3 as $k4 => $v4) {
                                            if ($k4 == "error") {
                                                $ERRORLOG[] = $v4;
                                            }
                                            echo $_t . $_t . $_t . $_t . " <span " . ($k4 == "error" ? "class=\"error\"" . $k4 : $k4) . " => " . $v4 . "</span><br />";
                                            if (is_array($v4)) {
                                                foreach ($v4 as $k5 => $v5) {
                                                    if ($k5 == "error") {
                                                        $ERRORLOG[] = $v5;
                                                    }
                                                    echo $_t . $_t . $_t . $_t . " <span " . ($k5 == "error" ? "class=\"error\"" . $k5 : $k5) . " => " . $v5 . "</span><br />";
                                                    if (is_array($v5)) {
                                                        foreach ($v5 as $k6 => $v6) {
                                                            if ($k6 == "error") {
                                                                $ERRORLOG[] = $v6;
                                                            }
                                                            echo $_t . $_t . $_t . $_t . " <span " . ($k6 == "error" ? "class=\"error\"" . $k6 : $k6) . " => " . $v6 . "</span><br />";
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