<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "install/settings.inc.php";
if (is_file("../configs/config.php")) {
    define("DEFINE_MY_ACCESS", 1);
    define("DEFINE_DHRU_FILE", true);
    include "../configs/config.php";
    $install_type = isset($_REQUEST["install_type"]) ? $_REQUEST["install_type"] : "";
    $link = @mysqli_connect($config["server"], $config["user"], $config["pass"], $config["database"]);
    $sql = mysqli_fetch_assoc(dquery("select value from tbl_settings where attribute='config'", $link));
    $config = unserialize($sql["value"]);
    $config["admin_directory"] = $admindirpath;
    if ($admindirpath) {
        $config["admin_directory"] = $admindirpath;
    } else {
        $config["admin_directory"] = "admin";
    }
    if ($donloaddirpath) {
        $config["download_path"] = $donloaddirpath;
    } else {
        $config["download_path"] = $donloaddirpath = "download";
    }
    if ($templatecompilerpath) {
        $config["config_template_c"] = $templatecompilerpath;
    } else {
        $config["config_template_c"] = $templatecompilerpath = "templates_c";
    }
    if ($languagedirectorypath) {
        $config["lang_folder"] = $languagedirectorypath;
    } else {
        $config["lang_folder"] = "language";
        $languagedirectorypath = $config["lang_folder"];
    }
} else {
    $config["admin_directory"] = "admin";
}
ob_start();
$phpinfo = ["phpinfo" => []];
if (preg_match_all("#(?:<h2>(?:<a name=\".*?\">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=\".*?\")?><t[hd](?: class=\".*?\")?>(.*?)\\s*</t[hd]>(?:<t[hd](?: class=\".*?\")?>(.*?)\\s*</t[hd]>(?:<t[hd](?: class=\".*?\")?>(.*?)\\s*</t[hd]>)?)?</tr>)#s", ob_get_clean(), $matches, PREG_SET_ORDER)) {
    foreach ($matches as $match) {
        if (strlen($match[1])) {
            $phpinfo[$match[1]] = [];
        } else {
            if (isset($match[3])) {
                $phpinfo[end(array_keys($phpinfo))][$match[2]] = isset($match[4]) ? [$match[3], $match[4]] : $match[3];
            } else {
                $phpinfo[end(array_keys($phpinfo))][] = $match[2];
            }
        }
    }
}
$is_error = false;
$error_mg = [];
if (EI_CHECK_PHP_MINIMAL_VERSION && phpversion() < EI_PHP_MINIMAL_VERSION) {
    $is_error = true;
    $is_phpver_error = true;
    $error_mg[] = "This program requires at least PHP version " . EI_PHP_MINIMAL_VERSION . " installed. You cannot proceed the installation.";
}
if (ioncube_loader_version() < EI_IONCUBE_MINIMAL_VERSION) {
    $is_error = true;
    $is_ioncubever_error = true;
    $error_mg[] = "This program requires at least ioncube loader version " . EI_IONCUBE_MINIMAL_VERSION . " installed. You cannot proceed the installation.";
}
if (EI_CHECK_CONFIG_DIR_WRITABILITY && !is_writable(EI_CONFIG_FILE_DIRECTORY)) {
}
echo "\n<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n<html>\n<head>\n<title>Installation Gsmbackbase</title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<link rel=\"stylesheet\" type=\"text/css\" href=\"install/img/styles.css\"></link>\n</head>\n<body>\n\n\t<br />\n\t<br />\n\t<br />\n\t<div style=\"width: 960px; margin: auto;\">\n\t\t<h2 align=\"left\">New/Upgrade Installation of ";
echo EI_APPLICATION_NAME . " [" . EI_APPLICATION_VERSION . "]";
echo "</h2>\n\n\t\t<fieldset>\n\n\n\t\t\tFollow the wizard to setup your database.<br />\n\t\t\t<br />\n\t\t\t<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n\t\t\t\t<tbody>\n\t\t\t\t\t<tr>\n\t\t\t\t\t\t<td class=\"gray_table\">\n\t\t\t\t\t\t\t<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n\t\t\t\t\t\t\t\t<tbody>\n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t<td class=\"ltcorner\"></td>\n\t\t\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t\t\t<td class=\"rtcorner\"></td>\n\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t\t\t<td align=middle>\n\t\t\t\t\t\t\t\t\t\t\t<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"\n\t\t\t\t\t\t\t\t\t\t\t\tborder=\"0\">\n\t\t\t\t\t\t\t\t\t\t\t\t<tbody>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td class=\"text\" align=\"left\"><b>Getting System Info</b></td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>&nbsp;</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td class=\"text\" align=\"left\">\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul>\n                                \n                                ";
$_phpinfoarr = parsePHPModules();
echo "                                    <li>PHP version: <b><i>";
echo phpversion();
if ($is_phpver_error) {
    echo "<span style=\"color:#F00\" > [Requires ";
    echo EI_PHP_MINIMAL_VERSION;
    echo " ]  </span>";
}
echo "</i></b></li>\n                                    \n                                    <li>ioncube loader version: <b><i>";
echo ioncube_loader_version();
if ($is_ioncubever_error) {
    echo "<span style=\"color:#F00\" > [Requires ";
    echo EI_IONCUBE_MINIMAL_VERSION;
    echo " ]  </span>";
}
echo "</i></b></li>\n                                    \n                                    \n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>PHP memory limit : <b><i>";
echo $_phpinfoarr["Core"]["memory_limit"][0];
echo "</b>";
echo $_phpinfoarr["Core"]["memory_limit"][0] != "256M" ? " <span style=\"color:#F00\" >  [Suggested 256M]  </span>" : "";
echo "</i></li>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>PHP Max execution time : <b><i>";
echo $_phpinfoarr["Core"]["max_execution_time"][0];
echo "</b>";
echo $_phpinfoarr["Core"]["max_execution_time"][0] != "300" ? " <span style=\"color:#F00\" >  [Suggested 300]  </span>" : "";
echo "</i></li>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>cURL : <b><i>\n";
if (function_exists("curl_version")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>PHP cURL module not installed </strong>";
    $is_error = true;
    $error_mg[] = "Make sure php cURL is installed ";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>GD Library : <b><i>\n";
if (function_exists("gd_info")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>PHP GD Library not installed </strong>";
    $is_error = true;
    $error_mg[] = "Make sure php  GD Library is installed ";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>DOMDocument/XML Support : <b><i>\n";
if ($_phpinfoarr["dom"]["DOM/XML"] == "enabled") {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>PHP DOMDocument not installed </strong>";
    $is_error = true;
    $error_mg[] = "Make sure php DOMDocument for XML support is installed ";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>License server : <b><i>\n";
$ch = curl_init();
$postfields["check"] = true;
curl_setopt($ch, CURLOPT_URL, "http://dhru.com/broadcast/index.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
if ($data) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Error connecting to license server </strong>";
    $is_error = true;
    $error_mg[] = "Check can ping to dhru.com from your hsoting server ";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\n\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td class=\"text\" align=\"left\"><b>Check Permission</b></td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>&nbsp;</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td class=\"text\" align=\"left\">\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>configs : <b><i>\n";
if (is_writable("../configs")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Make sure configs directory is writable</strong>";
    $is_error = true;
    $error_mg[] = "Make sure configs directory is writable";
}
echo "</i></b></li>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>download : <b><i>\n";
if ($config["download_path"]) {
    $_down_path = "../" . $config["download_path"];
} else {
    $_down_path = "../download";
}
if (is_writable($_down_path)) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Make sure download directory is writable</strong>";
    $is_error = true;
    $error_mg[] = "Make sure download directory is writable";
}
echo "\n</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>template_c : <b><i>";
if (is_writable("../templates_c")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Make sure template_c directory is writable</strong>";
    $is_error = true;
    $error_mg[] = "Make sure template_c directory is writable";
}
echo "</i></b></li>\n\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>temp : <b><i>\n";
if (is_writable("../" . $config["admin_directory"] . "/tmp")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Make sure your admindir/tmp directory is writable</strong>";
    $is_error = true;
    $error_mg[] = "Make sure admin/tmp directory is writable";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li>Backup : <b><i>\n";
if (is_writable("../" . $config["admin_directory"] . "/includes/backup")) {
    echo "..OK";
} else {
    echo "<strong style='color:#F00'>Make sure your admindir/includes/backup directory is writable</strong>";
    $is_error = true;
    $error_mg[] = "Make sure admindir/includes/backup directory is writable";
}
echo "</i></b>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</li>\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td>&nbsp;</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t";
if (!$is_error) {
    echo "\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<td class=text align=left>Click on Start button to\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tcontinue.</td>\n\t\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t";
} else {
    echo "\t\t\t\t\t\t\t";
    if ($is_error) {
        echo "<tr><td colspan=\"2\" ><div id=\"notification\" class=\"errorbox\">";
        foreach ($error_mg as $msg) {
            echo "<li>" . $msg . "</li>";
        }
        echo "</div><td/></tr>";
    }
    echo "\t\t\t\t\t\t\n\t\t\t\t\t\t";
}
echo "\t\t\t\t\t\t</tbody>\n\t\t\t\t\t\t\t\t\t\t\t</table> <br />\n\n\t\t\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t<td class=\"lbcorner\"></td>\n\t\t\t\t\t\t\t\t\t\t<td></td>\n\t\t\t\t\t\t\t\t\t\t<td class=\"rbcorner\"></td>\n\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t</tbody>\n\t\t\t\t\t\t\t</table>\n\n\t\t\t\t\t\t</td>\n\t\t\t\t\t</tr>\n\t\t\t\t</tbody>\n\t\t\t</table>\n\n";
if (!$is_error) {
    echo "\t\t\t\t\t\t\t<p align=\"right\">\n\t\t\t\t<a href=\"install/step1.php\" title=\"Click to start installation\"\n\t\t\t\t\tclass=\"next btn save\">Start</a>\n\t\t\t</p>\t\t\t\t\t\t\n\t\t\t\t\t\t";
}
echo "                        \n        ";
include_once "install/footer.php";
echo "        \n   \n  </fieldset>\n\t</div>\n</body>\n</html>\n\n";
function parsePHPModules()
{
    ob_start();
    phpinfo(INFO_MODULES);
    $s = ob_get_contents();
    ob_end_clean();
    $s = strip_tags($s, "<h2><th><td>");
    $s = preg_replace("/<th[^>]*>([^<]+)<\\/th>/", "<info>\\1</info>", $s);
    $s = preg_replace("/<td[^>]*>([^<]+)<\\/td>/", "<info>\\1</info>", $s);
    $vTmp = preg_split("/(<h2>[^<]+<\\/h2>)/", $s, -1, PREG_SPLIT_DELIM_CAPTURE);
    $vModules = [];
    for ($i = 1; $i < count($vTmp); $i++) {
        if (preg_match("/<h2>([^<]+)<\\/h2>/", $vTmp[$i], $vMat)) {
            $vName = trim($vMat[1]);
            $vTmp2 = explode("\n", $vTmp[$i + 1]);
            foreach ($vTmp2 as $vOne) {
                $vPat = "<info>([^<]+)<\\/info>";
                $vPat3 = "/" . $vPat . "\\s*" . $vPat . "\\s*" . $vPat . "/";
                $vPat2 = "/" . $vPat . "\\s*" . $vPat . "/";
                if (preg_match($vPat3, $vOne, $vMat)) {
                    $vModules[$vName][trim($vMat[1])] = [trim($vMat[2]), trim($vMat[3])];
                } else {
                    if (preg_match($vPat2, $vOne, $vMat)) {
                        $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
                    }
                }
            }
        }
    }
    return $vModules;
}
function dquery($query, $conn)
{
    return mysqli_query($conn, $query);
}

?>