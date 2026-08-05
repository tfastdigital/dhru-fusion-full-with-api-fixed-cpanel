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
global $OnlyEcommerce;
if ($template) {
    $q = dquery("select `group` from tbl_templates group by `group`");
    while ($r = mysqli_fetch_assoc($q)) {
        echo "    <tr>\n    <td colspan=\"3\" style=\"border-bottom:1px solid #dddddd;padding-left:30px;text-align: left !important; color:  #333 !important;background:#f4f4f4;font-size:12px;font-weight:bold;text-transform: uppercase;\" class=\"subsub\">\n    ";
        echo $r["group"];
        echo "</td>\n    </tr> \n        ";
        if ($OnlyEcommerce) {
            $ft = dquery("select * from tbl_templates where `group`='" . $r["group"] . "' and shop='1'");
        } else {
            $ft = dquery("select * from tbl_templates where `group`='" . $r["group"] . "'");
        }
        echo " <tr class=\"subsubnext\">\n           <td> \n";
        while ($rt = mysqli_fetch_assoc($ft)) {
            $flag = false;
            if (deregi("cart/default", $rt["tpl"])) {
                $myDirectory = opendir("../../../templates/" . $template . "/cart/default/");
                while ($ser = readdir($myDirectory)) {
                    $arg = end(explode("/", $rt["tpl"]));
                    if (!deregi(".tpl", $ser) && deregi($arg, $ser) && is_file("../../../templates/" . $template . "/cart/default/" . $ser)) {
                        $flag = true;
                    }
                }
            } else {
                if (deregi("cart/SingalPage", $rt["tpl"])) {
                    $myDirectory = opendir("../../../templates/" . $template . "/cart/SingalPage/");
                    while ($ser = readdir($myDirectory)) {
                        $arg = end(explode("/", $rt["tpl"]));
                        if (!deregi(".tpl", $ser) && deregi($arg, $ser) && is_file("../../../templates/" . $template . "/cart/SingalPage/" . $ser)) {
                            $flag = true;
                        }
                    }
                } else {
                    if (deregi("cart/Steps", $rt["tpl"])) {
                        $myDirectory = opendir("../../../templates/" . $template . "/cart/Steps/");
                        while ($ser = readdir($myDirectory)) {
                            $arg = end(explode("/", $rt["tpl"]));
                            if (!deregi(".tpl", $ser) && deregi($arg, $ser) && is_file("../../../templates/" . $template . "/cart/Steps/" . $ser)) {
                                $flag = true;
                            }
                        }
                    } else {
                        if (deregi("css/", $rt["tpl"])) {
                            $myDirectory = opendir("../../../templates/" . $template . "/css/");
                            while ($ser = readdir($myDirectory)) {
                                $arg = end(explode("/", $rt["tpl"]));
                                if (!endswith($ser, ".css") && deregi($arg, $ser) && is_file("../../../templates/" . $template . "/css/" . $ser)) {
                                    $flag = true;
                                }
                            }
                        } else {
                            $myDirectory = opendir("../../../templates/" . $template);
                            while ($ser = readdir($myDirectory)) {
                                if (!deregi(".tpl", $ser) && str_replace("." . end(explode(".", $ser)), "", $ser) == $rt["tpl"] && is_file("../../../templates/" . $template . "/" . $ser)) {
                                    $flag = true;
                                }
                            }
                        }
                    }
                }
            }
            if (is_file("../../../templates/" . $template . "/" . $rt["tpl"] . ".tpl") || is_file("../../../templates/" . $template . "/" . $rt["tpl"])) {
                if (deregi("css/", $rt["tpl"])) {
                    $arg = end(explode("/", $rt["tpl"]));
                    $ctpl = file_get_contents("../../../templates/" . $template . "/" . $rt["tpl"], FILE_USE_INCLUDE_PATH);
                    $path = "../../../templates/" . $template . "/css/ver/" . $arg . ".txt";
                } else {
                    $ctpl = file_get_contents("../../../templates/" . $template . "/" . $rt["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
                    $path = "../../../templates/" . $template . "/ver/" . $rt["tpl"] . ".txt";
                }
                $cversion = "1.0";
                if (is_file($path)) {
                    $clog = file_get_contents($path, FILE_USE_INCLUDE_PATH);
                    $clog = unserialize($clog);
                    $cversion = $clog["version"];
                }
                $tlog = file("../../../templates/tlog.txt");
                foreach ($tlog as $tl) {
                    $te = explode("=", $tl);
                    if (trim($te[1]) == $template) {
                        $oversion = "1.0";
                        $arg = end(explode("/", $rt["tpl"]));
                        if (is_file("../../../templates/" . trim($te[0]) . "/cart/default/ver/" . $arg . ".txt")) {
                            $clog = file_get_contents("../../../templates/" . trim($te[0]) . "/cart/default/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                            $clog = unserialize($clog);
                            $oversion = $clog["version"];
                        } else {
                            if (is_file("../../../templates/" . trim($te[0]) . "/cart/SingalPage/ver/" . $arg . ".txt")) {
                                $clog = file_get_contents("../../../templates/" . trim($te[0]) . "/cart/SingalPage/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                                $clog = unserialize($clog);
                                $oversion = $clog["version"];
                            } else {
                                if (is_file("../../../templates/" . trim($te[0]) . "/cart/Steps/ver/" . $arg . ".txt")) {
                                    $clog = file_get_contents("../../../templates/" . trim($te[0]) . "/cart/Steps/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                                    $clog = unserialize($clog);
                                    $oversion = $clog["version"];
                                } else {
                                    if (is_file("../../../templates/" . trim($te[0]) . "/css/ver/" . $arg . ".txt")) {
                                        $clog = file_get_contents("../../../templates/" . trim($te[0]) . "/css/ver/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                                        $clog = unserialize($clog);
                                        $oversion = $clog["version"];
                                    } else {
                                        if (is_file("../../../templates/" . trim($te[0]) . "/ver/" . $rt["tpl"] . ".txt")) {
                                            $clog = file_get_contents("../../../templates/" . trim($te[0]) . "/ver/" . $rt["tpl"] . ".txt", FILE_USE_INCLUDE_PATH);
                                            $clog = unserialize($clog);
                                            $oversion = $clog["version"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                echo "          \n            <table style=\"width: 100%;padding-left:30px\">\n                <tr>\n    <td title=\"";
                echo $rt["info"];
                echo "\" style=\"text-align: left !important;\">\n    ";
                echo $rt["name"];
                echo "  ";
                if ($flag) {
                    $flag = false;
                    echo "<strong><small>[modified]</small></strong>";
                }
                echo " </td>\n    <td style=\"padding: 0;\">\n                    ";
                if (trim($oversion) && $oversion != $cversion) {
                    echo "<a href=\"javascript: void(0);\" \nonclick=\"load_subpage('main2.php?page=editor.template&laoddefaultpage=editor.newversion.php&file=";
                    echo $rt["id"];
                    echo "&template=";
                    echo $template;
                    echo "','";
                    echo $rt["name"];
                    echo "');  \nreturn false;\"><span style='color:red;'>\nNew version: ";
                    echo $oversion;
                    echo " Available</span></a>\n                            ";
                }
                echo "                    </td>\n                    <td style=\"text-align: right;padding:0;\">\n                    <a href=\"javascript: void(0)\"  \n        onclick=\"load_subpage('main2.php?page=editor.template&file=";
                echo $rt["id"];
                echo "&template=";
                echo $template;
                echo "', '";
                echo $rt["name"];
                echo "');  \n          return false;\" class=\"editdata\">";
                echo $LNG["edit"];
                echo "</a>\n                    </td>\n                </tr>\n              </table> \n              \n                    ";
            }
        }
        echo "         </td>\n          </tr>  \n        ";
    }
}
$fileverioncheck = "6.1.0";
function get_string_between($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -1 * strlen($needle)) === $needle;
}

?>