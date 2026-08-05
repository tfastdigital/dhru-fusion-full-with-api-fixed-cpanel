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
require "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once ROOTDIR . "/includes/features.fun.php";
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $cmslink;
$tempalte_ver["serviceid"] = $serviceid;
if ($action == "features") {
    $features = getFeatures("features", "", $serviceid, "", "", "", true);
    $tempalte_ver["features"] = $features;
    if ($features) {
        echo processSingleTemplate("cart_getfeatures");
    } else {
        echo $lng_languag["norecordsfound"];
    }
}
if ($action == "review") {
    $sql = dquery("select * from tbl_review where pid='" . $serviceid . "' and status=1");
    while ($row = mysqli_fetch_assoc($sql)) {
        $review[$row["id"]] = $row;
    }
    $tempalte_ver["pid"] = $serviceid;
    if (!isset($_SESSION["uid"])) {
        $LoginCaptcha = NULL;
        include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
        $LoginCaptcha = createVerification("review");
        $tempalte_ver["captcha"] = "<span id='inputcaptcha_review' ><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n            <input type='text' class='form-control' name='captcha'>";
        $tempalte_ver["name"] = "<input type='text' class='form-control' name='name' />";
        $tempalte_ver["email"] = "<input type='text' class='form-control' name='email' />";
    } else {
        $tempalte_ver["name"] = $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"];
        $tempalte_ver["email"] = $_ClientsDetails["email"];
    }
    $tempalte_ver["review"] = $review;
    $tempalte_ver["reviewlink"] = _url("widget/save/review/action/save");
    echo processSingleTemplate("cart_review");
} else {
    if ($action == "imeireview") {
        $sql = dquery("select * from tbl_review where md5(sid)='" . $serviceid . "' and status=1");
        while ($row = mysqli_fetch_assoc($sql)) {
            $review[$row["id"]] = $row;
        }
        $services = mysqli_fetch_assoc(dquery("select id from tbl_services_imei\n     where md5(id)='" . $serviceid . "'"));
        $tempalte_ver["sid"] = $services["id"];
        if (!isset($_SESSION["uid"])) {
            $LoginCaptcha = NULL;
            include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
            $LoginCaptcha = createVerification("review");
            $tempalte_ver["captcha"] = "<span id='inputcaptcha_review'><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n            <input type='text'  class='form-control' name='captcha'>";
            $tempalte_ver["name"] = "<input type='text'  class='form-control' name='name' />";
            $tempalte_ver["email"] = "<input type='text'  class='form-control' name='email' />";
        } else {
            $tempalte_ver["name"] = $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"];
            $tempalte_ver["email"] = $_ClientsDetails["email"];
        }
        $tempalte_ver["review"] = $review;
        $tempalte_ver["reviewlink"] = _url("widget/save/review/action/save/imei/true");
        echo processSingleTemplate("cart_review");
    } else {
        if ($action == "serverreview") {
            $sql = dquery("select * from tbl_review where md5(lid)='" . $serviceid . "' and status=1");
            while ($row = mysqli_fetch_assoc($sql)) {
                $review[$row["id"]] = $row;
            }
            $services = mysqli_fetch_assoc(dquery("select id from tbl_server_log where md5(id)='" . $serviceid . "'"));
            $tempalte_ver["lid"] = $services["id"];
            if (!isset($_SESSION["uid"])) {
                $tempalte_ver["captcha"] = "<img src='widget/verificationimage.php?res' alt='verification image, type it in the box' align='absbottom' />\n            <input type='text' class='form-control' name='captcha'>";
                $tempalte_ver["name"] = "<input type='text'  class='form-control' name='name' />";
                $tempalte_ver["email"] = "<input type='text'  class='form-control' name='email' />";
            } else {
                $tempalte_ver["name"] = $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"];
                $tempalte_ver["email"] = $_ClientsDetails["email"];
            }
            $tempalte_ver["review"] = $review;
            $tempalte_ver["reviewlink"] = _url("widget/save/review/action/save/imei/true");
            echo processSingleTemplate("cart_review");
        } else {
            if ($action == "productinfo") {
                $sql = mysqli_fetch_assoc(dquery("select retail_info from tbl_products where id='" . $serviceid . "'"));
                if ($sql["retail_info"]) {
                    if ($cmslink["iteminfo"][$serviceid]) {
                        echo $sql["retail_info"] . "<span style='float: right;'>\n        <a target='_blank' href='" . $cmslink["iteminfo"][$serviceid] . "'>Edit Information</a></span> \n    <div style='clear:both;'>&nbsp;</div>";
                    } else {
                        echo $sql["retail_info"];
                    }
                } else {
                    echo $lng_languag["norecordsfound"];
                }
            } else {
                if ($action == "imeiinfo") {
                    $sql = mysqli_fetch_assoc(dquery("select retail_info,info from tbl_services_imei where md5(id)='" . $serviceid . "'"));
                    if ($sql["retail_info"]) {
                        echo nl2br($sql["retail_info"]);
                    } else {
                        echo $lng_languag["norecordsfound"];
                    }
                } else {
                    if ($action == "serverinfo") {
                        $sql = mysqli_fetch_assoc(dquery("select info from tbl_server_log where md5(id)='" . $serviceid . "'"));
                        if ($sql["info"]) {
                            echo nl2br($sql["info"]);
                        } else {
                            echo $lng_languag["norecordsfound"];
                        }
                    } else {
                        if ($action == "extraimages") {
                            $sql = mysqli_fetch_assoc(dquery("select images from tbl_products where id='" . $serviceid . "'"));
                            $images = explode("|", $sql["images"]);
                            $tempalte_ver["id"] = $serviceid;
                            $tempalte_ver["images"] = $images;
                            if ($images) {
                                echo processSingleTemplate("cart_extraimages");
                            } else {
                                echo $lng_languag["norecordsfound"];
                            }
                        } else {
                            if ($action == "videos") {
                                $sql = mysqli_fetch_assoc(dquery("select videos from tbl_products where id='" . $serviceid . "'"));
                                $images = explode("|", $sql["videos"]);
                                $tempalte_ver["id"] = $serviceid;
                                $tempalte_ver["videos"] = $images;
                                if ($images) {
                                    echo processSingleTemplate("cart_videos");
                                } else {
                                    echo $lng_languag["norecordsfound"];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo " ";

?>