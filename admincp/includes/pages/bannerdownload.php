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
if ($bid) {
    checkDemoMode(false);
    if ($licinfo["_lickey"]) {
        echo "Connecting to cloud server...  ";
        $post["action"] = "getbanner";
        $post["bid"] = $bid;
        $post["license"] = $licinfo["_lickey"];
        $data = initCurl("http://banners.dhru.org/index.php", $post);
        $response = json_decode($data, true);
        $num = mysqli_num_rows(dquery("select * from tbl_bannerslider_banners where cloud=" . $response["id"]));
        if ($num == 0) {
            if ($response["success"]) {
                echo "OK <br/>";
                $decoded = base64_decode($response["imgdata"]);
                if (!is_dir("../../../images/gallery/cloudbanners")) {
                    mkdir("../../../images/gallery/cloudbanners", 493);
                }
                file_put_contents("../../../images/gallery/cloudbanners/" . $response["img"], $decoded, true);
                if ($response["extra1"]) {
                    $decoded = base64_decode($response["extra1"]);
                    file_put_contents("../../../images/gallery/cloudbanners/" . $response["extra1"], $decoded, true);
                }
                if ($response["extra2"]) {
                    $decoded = base64_decode($response["extra2"]);
                    file_put_contents("../../../images/gallery/cloudbanners/" . $response["extra2"], $decoded, true);
                }
                if ($response["extra3"]) {
                    $decoded = base64_decode($response["extra3"]);
                    file_put_contents("../../../images/gallery/cloudbanners/" . $response["extra3"], $decoded, true);
                }
                if ($response["extra4"]) {
                    $decoded = base64_decode($response["extra4"]);
                    file_put_contents("../../../images/gallery/cloudbanners/" . $response["extra4"], $decoded, true);
                }
                if ($response["extra5"]) {
                    $decoded = base64_decode($response["extra5"]);
                    file_put_contents("../../../images/gallery/cloudbanners/" . $response["extra5"], $decoded, true);
                }
                $data = NULL;
                $data["img"] = "images/gallery/cloudbanners/" . $response["img"];
                $data["img_title"] = $response["img_title"];
                $data["info"] = str_replace("../banners/", "images/gallery/cloudbanners/", $response["info"]);
                $data["info_header"] = $response["info_header"];
                $data["readmore_link"] = $response["readmore_link"];
                $data["infox_box_width"] = $response["infox_box_width"];
                $data["po_top"] = $response["po_top"];
                $data["po_left"] = $response["po_left"];
                $data["bgcolor"] = $response["bgcolor"];
                $data["fontcolor"] = $response["fontcolor"];
                $data["cloud"] = $response["id"];
                $data["backgroundimage"] = $response["backgroundimage"];
                $data["other_html"] = $response["other_html"];
                if ($db->insert("tbl_bannerslider_banners", $data)) {
                    echo "Installing " . $response["img_title"] . "... OK";
                } else {
                    echo "Error in " . $response["img_title"] . " Create <br />";
                }
            }
            exit;
        }
        displyOutput(["error" => $response["error"]]);
        exit;
    }
}
$fileverioncheck = "6.1.0";
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