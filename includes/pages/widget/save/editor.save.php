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
error_reporting(0);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($_SESSION["adminid"] || $_SESSION["storeowneredit"]) {
    if ($_SESSION["adminid"]) {
        $chngtmpl = preg_replace("/[^0-9a-z-]/i", "", $chngtmpl);
        if ($chngtmpl && !$cssElements) {
            $config["template"] = $chngtmpl;
            $serialise = serialize($config);
            dquery("update tbl_settings set value='" . $serialise . "' where attribute='config'");
            echo "success: Template save successfully ";
            unset($serialise);
            exit;
        }
    }
    $notfound = "false";
    $time = time();
    krsort($templatePath);
    $reload = false;
    if ($templatePath) {
        foreach ($templatePath as $key => $cssfile) {
            $tmpFile = "../../" . $cssfile;
            $cssfilenamesplit = explode("/", $cssfile);
            $cssfilename = $cssfilenamesplit[count($cssfilenamesplit) - 1];
            $ext = substr($tmpFile, strrpos($tmpFile, ".") + 1);
            if (strpos($ext, "css") !== false && file_exists($tmpFile)) {
                $style = file_get_contents($tmpFile);
                $style = str_replace("\r\n", "", $style);
                $style = str_replace("}", "}\r\n", $style);
                $style = str_replace("*/", "*/\r\n", $style);
                $styles = explode("\n", trim($style));
                $restorepointpath = "../../" . $restorepoint . "/restorepoint/";
                $restorepointpathabs = "../../" . $restorepoint . "/restorepoint/";
                if ($_SESSION["storeowneredit"]) {
                    $restorepointpath = $restorepointpath . $_SESSION["storeowneredit"] . "/";
                }
                if (!is_dir($restorepointpath) && mkdir($restorepointpath, 511, true)) {
                    $notfound = "true";
                }
                if ($notfound == "true") {
                    $default = file_get_contents($tmpFile);
                    $cssfilenamea = explode(".", $cssfilename);
                    $createfile = $restorepointpath . $cssfilenamea[0] . $_SESSION["storeowneredit"] . "." . $cssfilenamea[1];
                    $handle_tmpFile = fopen($createfile, "w");
                    fwrite($handle_tmpFile, $default);
                    if (!file_exists($restorepointpathabs . $cssfilenamea[0] . "." . $cssfilenamea[1])) {
                        $createfile = $restorepointpathabs . $cssfilenamea[0] . "." . $cssfilenamea[1];
                        $handle_tmpFile = fopen($createfile, "w");
                        fwrite($handle_tmpFile, $default);
                    }
                    if ($_SESSION["storeowneredit"]) {
                        $tmpFile = "../../" . $restorepoint . "/" . $cssfilenamea[0] . $_SESSION["storeowneredit"] . "." . $cssfilenamea[1];
                    }
                    $reload = true;
                    unset($default);
                }
                if ($cssElements) {
                    foreach ($cssElements as $key => $element) {
                        $tagpath = $element;
                        $find = "notfound";
                        foreach ($styles as $line => $value) {
                            $value = preg_split("[{|}]", $value);
                            $findme = $value[0];
                            $pos = strpos($tagpath, $findme);
                            $tags = $tagpath;
                            if (trim($tagpath) == trim($findme)) {
                                $li = $line;
                                $find = "find";
                                $element = str_replace(".tmpDisplay", "", $element);
                                if ($cssElements) {
                                    $prop = "";
                                    if ($_backgroundColor[$key]) {
                                        $prop .= "background-color:" . $_backgroundColor[$key] . ";";
                                    }
                                    if ($_backgroundImage[$key]) {
                                        $prop .= "background-image:" . $_backgroundImage[$key] . ";";
                                    }
                                    if ($_backgroundPosition[$key]) {
                                        $prop .= "background-position:" . $_backgroundPosition[$key] . ";";
                                    }
                                    if ($_backgroundRepeat[$key]) {
                                        $prop .= "background-repeat:" . $_backgroundRepeat[$key] . ";";
                                    }
                                    if ($_fontFamily[$key]) {
                                        $prop .= "font-family:" . $_fontFamily[$key] . ";";
                                    }
                                    if ($_color[$key]) {
                                        $prop .= "color:" . $_color[$key] . ";";
                                    }
                                    if ($_fontSize[$key]) {
                                        $prop .= "font-size:" . $_fontSize[$key] . ";";
                                    }
                                    if ($_fontStyle[$key]) {
                                        $prop .= "font-style:" . $_fontStyle[$key] . ";";
                                    }
                                    if ($_fontWeight[$key]) {
                                        $prop .= "font-weight:" . $_fontWeight[$key] . ";";
                                    }
                                    if ($_fontVariant[$key]) {
                                        $prop .= "font-variant:" . $_fontVariant[$key] . ";";
                                    }
                                    if ($_marginTop[$key]) {
                                        $prop .= "margin-top:" . $_marginTop[$key] . ";";
                                    }
                                    if ($_marginRight[$key]) {
                                        $prop .= "margin-right:" . $_marginRight[$key] . ";";
                                    }
                                    if ($_marginBottom[$key]) {
                                        $prop .= "margin-bottom:" . $_marginBottom[$key] . ";";
                                    }
                                    if ($_marginLeft[$key]) {
                                        $prop .= "margin-left:" . $_marginLeft[$key] . ";";
                                    }
                                    if ($_paddingTop[$key]) {
                                        $prop .= "padding-top:" . $_paddingTop[$key] . ";";
                                    }
                                    if ($_paddingRight[$key]) {
                                        $prop .= "padding-right:" . $_paddingRight[$key] . ";";
                                    }
                                    if ($_paddingBottom[$key]) {
                                        $prop .= "padding-bottom:" . $_paddingBottom[$key] . ";";
                                    }
                                    if ($_paddingLeft[$key]) {
                                        $prop .= "padding-left:" . $_paddingLeft[$key] . ";";
                                    }
                                    if ($_height[$key]) {
                                        $prop .= "height:" . $_height[$key] . ";";
                                    }
                                    if ($_width[$key]) {
                                        $prop .= "width:" . $_width[$key] . ";";
                                    }
                                    if ($_lineHeight[$key]) {
                                        $prop .= "line-height:" . $_lineHeight[$key] . ";";
                                    }
                                    if ($_boxShadow[$key]) {
                                        $prop .= "box-shadow:" . $_boxShadow[$key] . ";";
                                    }
                                    if ($_display[$key]) {
                                        $prop .= "display:" . $_display[$key] . ";";
                                    }
                                    if ($_overflow[$key]) {
                                        $prop .= "overflow:" . $_overflow[$key] . ";";
                                    }
                                    if ($_textAlign[$key]) {
                                        $prop .= "text-align:" . $_textAlign[$key] . ";";
                                    }
                                    if ($_textDecoration[$key]) {
                                        $prop .= "text-decoration:" . $_textDecoration[$key] . ";";
                                    }
                                    if ($_textTransform[$key]) {
                                        $prop .= "text-transform:" . $_textTransform[$key] . ";";
                                    }
                                    if ($_textShadow[$key]) {
                                        $prop .= "text-shadow:" . $_textShadow[$key] . ";";
                                    }
                                    if ($_borderColor[$key]) {
                                        $prop .= "border-color:" . $_borderColor[$key] . ";";
                                    }
                                    if ($_borderWidth[$key]) {
                                        $prop .= "border-width:" . $_borderWidth[$key] . ";";
                                    }
                                    if ($_borderStyle[$key]) {
                                        $prop .= "border-style:" . $_borderStyle[$key] . ";";
                                    }
                                    if ($_borderRadius[$key]) {
                                        $prop .= "border-radius:" . $_borderRadius[$key] . ";";
                                    }
                                    if ($_borderTopColor[$key]) {
                                        $prop .= "border-top-color:" . $_borderTopColor[$key] . ";";
                                    }
                                    if ($_borderTopWidth[$key]) {
                                        $prop .= "border-top-width:" . $_borderTopWidth[$key] . ";";
                                    }
                                    if ($_borderTopStyle[$key]) {
                                        $prop .= "border-top-style:" . $_borderTopStyle[$key] . ";";
                                    }
                                    if ($_borderTopLeftRadius[$key]) {
                                        $prop .= "border-top-left-radius:" . $_borderTopLeftRadius[$key] . ";";
                                    }
                                    if ($_borderRightColor[$key]) {
                                        $prop .= "border-right-color:" . $_borderRightColor[$key] . ";";
                                    }
                                    if ($_borderRightWidth[$key]) {
                                        $prop .= "border-right-width:" . $_borderRightWidth[$key] . ";";
                                    }
                                    if ($_borderRightStyle[$key]) {
                                        $prop .= "border-right-style:" . $_borderRightStyle[$key] . ";";
                                    }
                                    if ($_borderTopRightRadius[$key]) {
                                        $prop .= "border-top-right-radius:" . $_borderTopRightRadius[$key] . ";";
                                    }
                                    if ($_borderBottomColor[$key]) {
                                        $prop .= "border-bottom-color:" . $_borderBottomColor[$key] . ";";
                                    }
                                    if ($_borderBottomWidth[$key]) {
                                        $prop .= "border-bottom-width:" . $_borderBottomWidth[$key] . ";";
                                    }
                                    if ($_borderBottomStyle[$key]) {
                                        $prop .= "border-bottom-style:" . $_borderBottomStyle[$key] . ";";
                                    }
                                    if ($_borderBottomLeftRadius[$key]) {
                                        $prop .= "border-bottom-left-radius:" . $_borderBottomLeftRadius[$key] . ";";
                                    }
                                    if ($_borderLeftColor[$key]) {
                                        $prop .= "border-left-color:" . $_borderLeftColor[$key] . ";";
                                    }
                                    if ($_borderLeftWidth[$key]) {
                                        $prop .= "border-left-width:" . $_borderLeftWidth[$key] . ";";
                                    }
                                    if ($_borderLeftStyle[$key]) {
                                        $prop .= "border-left-style:" . $_borderLeftStyle[$key] . ";";
                                    }
                                    if ($_borderBottomRightRadius[$key]) {
                                        $prop .= "border-bottom-right-radius:" . $_borderBottomRightRadius[$key] . ";";
                                    }
                                    if ($_float[$key]) {
                                        $prop .= "float:" . $_float[$key] . ";";
                                    }
                                    if ($_left[$key]) {
                                        $prop .= "left:" . $_left[$key] . ";";
                                    }
                                    if ($_top[$key]) {
                                        $prop .= "top:" . $_top[$key] . ";";
                                    }
                                    if ($_right[$key]) {
                                        $prop .= "right:" . $_right[$key] . ";";
                                    }
                                    if ($_bottom[$key]) {
                                        $prop .= "bottom:" . $_bottom[$key] . ";";
                                    }
                                    if ($_position[$key]) {
                                        $prop .= "position:" . $_position[$key] . ";";
                                    }
                                    if ($_opacity[$key]) {
                                        $prop .= "opacity:" . $_opacity[$key] . ";";
                                    }
                                    if ($_transition[$key]) {
                                        $prop .= $_transition[$key] . ";";
                                    }
                                    if ($_transform[$key]) {
                                        $prop .= $_transform[$key] . ";";
                                    }
                                    if ($prop) {
                                        $order = [" :", ": ", " : "];
                                        if ($find == "notfound") {
                                            $li = sizeof($styles) + 1;
                                        }
                                        $styles[$li] = str_replace($order, ":", $styles[$li]);
                                        $brecketv = preg_split("/({|})/", $styles[$li]);
                                        $colonv = preg_split("/[;]/", $brecketv[1]);
                                        if (end($colonv) == "" || end($colonv) == " ") {
                                            array_pop($colonv);
                                        }
                                        $colon = preg_split("/[;]/", $prop);
                                        if (end($colon) == "" || end($colon) == " ") {
                                            array_pop($colon);
                                        }
                                        foreach ($colon as $k1 => $pro) {
                                            $pro1 = preg_split("/[:]/", $pro);
                                            $flag = "true";
                                            foreach ($colonv as $k2 => $prov) {
                                                $prov1 = preg_split("/[:]/", $prov);
                                                if ($prov1[0] == $pro1[0]) {
                                                    if (!in_array("background-image:", $colonv)) {
                                                        $colonv[$k2] = $pro;
                                                    } else {
                                                        unset($colonv);
                                                        $colonv = $colon;
                                                    }
                                                    $flag = "false";
                                                }
                                            }
                                            if ($flag) {
                                                $colonv[] = $pro;
                                            }
                                        }
                                        $colonv = array_unique($colonv);
                                        $result = implode(";", $colonv);
                                        $copystyle[$li] = $tags . "{" . $result . " !important}";
                                        unset($li);
                                        unset($tags);
                                        unset($result);
                                    }
                                }
                            } else {
                                $find = "notfound";
                            }
                        }
                    }
                }
                foreach ($copystyle as $key => $value) {
                    $styles[$key] = $value;
                }
                foreach ($styles as $key => $value) {
                    if ($value == "") {
                        unset($styles[$key]);
                    }
                }
                $style = "";
                $font = preg_replace("/[^0-9a-z-_+]/i", "", $_GET["font"]);
                if ($font) {
                    $font_ = $font;
                    $_SESSION["fontcss"] = str_replace("_", " ", $font_);
                    $_SESSION["font"] = str_replace(" ", "+", $_SESSION["fontcss"]);
                    unset($font);
                    unset($font_);
                    $fontcss = $_SESSION["fontcss"];
                    $font = $_SESSION["font"];
                    preg_match_all("/\\@import url\\(/", $styles[0], $f);
                    if ($f[0]) {
                        $styles[0] = "@import url(http://fonts.googleapis.com/css?family=" . $_SESSION["font"] . ");body{font-family:'" . $_SESSION["fontcss"] . "' !important}";
                        echo $styles[0];
                    } else {
                        echo $style = "@import url(http://fonts.googleapis.com/css?family=" . $_SESSION["font"] . ");body{font-family:'" . $_SESSION["fontcss"] . "' !important}\n";
                    }
                    $_SESSION["fontcss"] = "";
                    $_SESSION["font"] = "";
                }
                $style .= implode("\n", $styles);
                $handle_tmpFile = fopen($tmpFile, "w");
                fwrite($handle_tmpFile, $style);
                unset($styles);
                unset($style);
                unset($copystyle);
                if ($reload) {
                    echo "reload:Please Wait Reload Page";
                } else {
                    echo "success: " . $_SESSION["fontcss"] . " " . $lng_languag["save"] . " " . $lng_languag["successfully"];
                }
            }
        }
    }
}

?>