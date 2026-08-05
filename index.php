<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathreq = [];
foreach (explode("/", $path) as $dir) {
    if (!empty($dir)) {
        $dir = explode(".", $dir);
        if (isset($dir[1]) && $dir[1] === "php") {
        }
        if ($dir[0] != "index") {
            $pathreq[] = filter_var(urldecode($dir[0]), FILTER_SANITIZE_STRING);
        }
    }
}
if (isset($pathreq[0])) {
    try {
        $_query = $pathreq;
        if (isset($_query[1])) {
            unset($_query[0]);
            foreach ($_query as $k => $v) {
                if ($k % 2 !== 0) {
                    if ($k === 1) {
                        $_REQUEST["action"] = $pathreq[$k];
                        if ((int) $pathreq[$k]) {
                            $_REQUEST["id"] = (int) $pathreq[$k];
                        }
                    }
                    if (isset($pathreq[$k + 1])) {
                        $_REQUEST[$v] = $pathreq[$k + 1];
                    }
                }
            }
        }
        if (isset($pathreq[0])) {
            if (isset($pathreq[0]) && $pathreq[0] == "dhru") {
                $_pathreq = "dhru"; // Just a placeholder or specific handling if needed, but file doesn't exist
                // If 'dhru.php' is missing, maybe it should point to main or index?
                // Let's assume it should be 'main' for now or handle the 404 gracefully
                if (!file_exists("includes/pages/" . $_pathreq . ".php")) {
                     $_pathreq = "main"; // Fallback to main page
                }
            } else {
                $_pathreq = $pathreq[0];
            }
        }
        if ($pathreq[0] === "widget") {
            $_pathreq = "widget/" . $pathreq[1];
            if ($pathreq[1] === "save") {
                $_pathreq = "widget/save/" . $pathreq[2];
            }
        }
        if ($pathreq[0] === "collections") {
            $_pathreq = "cart";
            $_REQUEST["group_name"] = $pathreq[1];
            $_REQUEST["service"] = "product";
        }
        if ($pathreq[0] === "product") {
            $_pathreq = "cart";
            $_REQUEST["product_name"] = $pathreq[1];
            $_REQUEST["service"] = "product";
            $_REQUEST["item"] = isset($_REQUEST["pid"]) ? $_REQUEST["pid"] : "";
        }
        if ($pathreq[0] === "imei" || $pathreq[0] === "server" || $pathreq[0] === "remote") {
            $_pathreq = "cart";
            list($_REQUEST["service"], $_REQUEST["product_name"]) = $pathreq;
            $_REQUEST["group"] = 1;
            $_REQUEST["item"] = isset($_REQUEST["pid"]) ? $_REQUEST["pid"] : "";
        }
        if (!(include "includes/pages/" . $_pathreq . ".php")) {
            throw new Exception("file not found!");
        }
    } catch (Exception $e) {
        exit("404! File not found.");
    }
    exit;
}
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "comm.php";
$packageversion = "6.1.0";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";

$currentpage = "index";
$action = preg_replace("/[^a-z]/i", "", $action);
$sortby = preg_replace("/[^a-z]/i", "", $sortby);
$prod = preg_replace("/[^0-9]/i", "", $prod);
$viewmode = preg_replace("/[^a-z]/i", "", $viewmode);
$group = preg_replace("/[^0-9a-zA-Z]/i", "", $group);
$serviceId = preg_replace("/[^0-9a-zA-Z]/i", "", $serviceId);
$manufacture = preg_replace("/[^0-9a-zA-Z]/i", "", $manufacture);
$list = preg_replace("/[^0-9a-zA-Z,]/i", "", $list);
$list = preg_replace("/[^0-9a-zA-Z,]/i", "", $list);
global $cmslink;
if ($action == "bestdeal" && $prod != "") {
    $gl = mysqli_fetch_assoc(dquery("select link,type from tbl_generatedlink where id='" . $prod . "'"));
    if ($gl["type"] == "imei") {
        $action = "imeideal";
    }
    $list = $gl["link"];
}
if ($u) {
    $u = preg_replace("/[^0-9a-zA-Z\\-]/i", "", $u);
    $u = explode("-", $u);
    if (!mysqli_num_rows(dquery("select id from tbl_disabledemail\n    where md5(id)='" . $u[0] . "' and md5(tid)='" . $u[1] . "'"))) {
        $user = mysqli_fetch_assoc(dquery("select id from tblUsers\n        where md5(id)='" . $u[0] . "'"));
        $etempl = mysqli_fetch_assoc(dquery("select id from tbl_emailtemplates\n        where md5(id)='" . $u[1] . "'"));
        $datan["uid"] = $user["id"];
        $datan["tid"] = $etempl["id"];
        $db->insert("tbl_disabledemail", $datan);
        $datan = NULL;
        $tempalte_ver["unsub"] = 1;
    }
}
if ($viewmode != "") {
    $_SESSION["viewmode"] = $viewmode;
}
if ($_SESSION["viewmode"]) {
    $tempalte_ver["viewmode"] = $_SESSION["viewmode"];
}
if (mysqli_num_rows(dquery("select id from tbl_homepagegroup"))) {
    $tempalte_ver["ishomepagegroup"] = 1;
}
$tempalte_ver["sortby"] = $sortby;
$tempalte_ver["group"] = $group;
if ($config["Index_page_redirect"] != "") {
    $Index_page_redirect = $config["Index_page_redirect"];
    header("Location: " . $Index_page_redirect);
    echo "<script>location.href='" . $Index_page_redirect . "';</script>";
}
$pagetitle = $config["config_site_name"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a>";
$templatefile = "index";
$pageicon = "";
installclient($pagetitle, $pageicon, $_nav);
$news = mysqli_num_rows(dquery("select id from tbl_blogposts"));
$tempalte_ver["newsitem"] = $news;
if ($config["shoppingcart"]) {
    if ($action != "wishlist") {
        if ($action == "bestdeal") {
            require_once "includes/products.fun.php";
            $serviceId = explode(",", $list);
            $tempalte_ver["productitems"] = getProducts("", $serviceId, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "RI");
        } else {
            if ($action == "imeideal") {
                require_once "includes/imeiservices.fun.php";
                $serviceId = explode(",", $list);
                $tempalte_ver["items"] = getIMEIServices("", $serviceId, "", "", "", "", true, true, "", "", "", "", "500", "featured");
            } else {
                if ($action == "new") {
                    if ($config["default_service_imei"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["items"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "500", "featured");
                    }
                    if ($config["default_service_server"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["serveritems"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "500", "featured", "", "", "", "", "", "", 1);
                    }
                    if ($config["default_service_remote"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["remoteitems"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "500", "featured", "", "", "", "", "", "", 2);
                    }
                    require_once "includes/products.fun.php";
                    $tempalte_ver["productitems"] = getProducts("", "", "", "", "", "", true, true, "", "", "", "500", "", "", "", "", "featured", "", "", "", "RI");
                } else {
                    if ($config["default_service_imei"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["items"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "", $sortby);
                    }
                    if ($config["default_service_server"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["serveritems"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "", $sortby, "", "", "", "", "", "", 1);
                    }
                    if ($config["default_service_remote"]) {
                        require_once "includes/imeiservices.fun.php";
                        $tempalte_ver["remoteitems"] = getIMEIServices("", "", "", "", "", "", true, true, "", "", "", "", "", $sortby, "", "", "", "", "", "", 2);
                    }
                    if ($manufacture != "") {
                        require_once "includes/products.fun.php";
                        $tempalte_ver["productitems"] = getProducts("", "", "", "", "", "", true, true, "", "", "", "", "", "", "", "", $sortby, "", $manufacture, "", "RI");
                    } else {
                        require_once "includes/products.fun.php";
                        $tempalte_ver["productitems"] = getProducts("", "", "", "", "", "", true, true, "", "", "", "", "", "", "", "", $sortby, "", "", "", "RI");
                    }
                }
            }
        }
    }
}
if (isset($_SESSION["WLANG"])) {
    $lang = $_SESSION["WLANG"];
} else {
    $lang = $config["language"];
}
$lang = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $lang);
if (!isset($_SESSION["uid"]) && $config["popbefenable"]) {
    $popus = mysqli_fetch_assoc(dquery("select value from tbl_settings\nwhere attribute='flashpopbefore'"));
    $tempalte_ver["popupcontent"] = $popus["value"];
}
$result = mysqli_fetch_assoc(dquery("SELECT *\nFROM `tbl_custom_page` WHERE type='index' and language='" . $lang . "'"));
$tempalte_ver["indexcontent"] = trim(htmlspecialchars_decode($result["content"]));
if ($cmslink["indexpage"]) {
    $tempalte_ver["indexcontent"] = $tempalte_ver["indexcontent"] . "<span style=\"float: right;\"><a href=\"" . $cmslink["indexpage"] . "\"\ntarget=\"_blank\">Edit Page</a></span>";
}
if ($storeowner["id"]) {
    $sql = mysqli_fetch_assoc(dquery("select value from tbl_store_pages where attribute='index' and uid='" . $storeowner["id"] . "'"));
    $tempalte_ver["indexcontent"] = htmlspecialchars_decode($sql["value"]);
}
if ($storeowner["id"]) {
    $re = dquery("select * from tbl_bannerslider_banners where store='" . $storeowner["id"] . "'");
} else {
    $re = dquery("select * from tbl_bannerslider_banners where store=0  order by `sort`");
}
$config["bannerslider"] = true;
if ($config["bannerslider"] && mysqli_num_rows($re)) {
    $result = select_query("tbl_bannerslider", "", "");
    while ($data = mysqli_fetch_assoc($result)) {
        $banner_config["" . $data["attribute"]] = "" . $data["value"];
    }
    $_bannerHeaderCode = "\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"includes/3rdparty/banner-rotator/css/banner-rotator.css\" />\n    <script type=\"text/javascript\" src=\"includes/3rdparty/banner-rotator/js/jquery.banner-rotator.min.js\"></script>\n    ";
    if ($banner_config["fullWidth"]) {
        $banner_config["mainWidth"] = "100%";
    } else {
        if ($banner_config["mainWidth"]) {
            $banner_config["mainWidth"] = $banner_config["mainWidth"] . "px";
            $banner_config["mainHeight"];
        }
    }
    if ($storeowner["id"]) {
        $result = dquery("select * from tbl_bannerslider_banners where store='" . $storeowner["id"] . "'");
    } else {
        $result = dquery("select * from tbl_bannerslider_banners where store=0  order by `sort`");
    }
    $i = 1;
    $tempalte_ver["bannerarray"] = NULL;
    $_bannerCode = "\n\t<div class=\"banner-container\">\n    <div class=\"banner-width\"   style=\"width:" . $banner_config["mainWidth"] . ";margin:auto;\">\n\t<div class=\"banner-rotator\">\n        <ul>";
    while ($data = mysqli_fetch_assoc($result)) {
        $_bannerinfo = $_readmore_link = NULL;
        if ($data["readmore_link"]) {
            $_readmore_link = "<br/><br/><a href=\"" . $data["readmore_link"] . "\" target=\"_blank\" class=\"btn btn-warning\">Read More</a>";
        }
        if ($data["info"]) {
            if ($data["po_top"] == "") {
                $data["po_top"] = 5;
            }
            if ($data["po_left"] == "") {
                $data["po_left"] = 484;
            }
            if ($data["infox_box_width"] == "") {
                $data["infox_box_width"] = 400;
            }
            if ($data["backgroundimage"]) {
                $data["img"] = $data["backgroundimage"];
            }
            if (!$data["img"]) {
                $data["bg"] = "none";
            }
            $_bannerinfo = "<span style=\"top:" . $data["po_top"] . "px; left:" . $data["po_left"] . "px; width:" . $data["infox_box_width"] . "px;\">\n                           <h1>" . $data["info_header"] . "</h1>  " . html_entity_decode($data["info"]) . "  " . $_readmore_link . "\n                       \t</span>";
        }
        $_bannerCode .= "<li style=\"background-color:" . $data["bgcolor"] . "\">\n                    \t<a style=\"background-color:" . $data["bgcolor"] . "\" href=\"" . $data["img"] . "\" title=\"" . $data["img_title"] . "\" > <img src=\"" . $data["img"] . "\"  alt=\"" . $data["img_title"] . "\"/> </a>\n                        " . $_bannerinfo . "</li>";
        $i++;
        $data["info"] = html_entity_decode($data["info"]);
        if ($data["data"]) {
            $data["data"] = json_decode($data["data"], true);
            $data["img"] = $data["data"]["backgroundImage"];
            $data["data"]["info"] = html_entity_decode($data["data"]["info"]);
        } else {
            $data["data"] = $data;
            $data["data"]["img"] = $data["img"];
            $data["data"]["title"] = $data["img_title"];
            $data["data"]["bg"] = "themedefault";
            $data["data"]["backgroundImage"] = "";
            $data["data"]["backgroundColor"] = "";
            $data["data"]["backgroundSVG"] = "";
            $data["data"]["readmore"] = "";
            $data["data"]["info"] = $data["info"];
        }
        $tempalte_ver["bannerarray"][$data["id"]] = $data;
    }
    $_bannerCode .= "</ul></div></div></div>";
    $_bannerHeaderCode .= "\n        <style>.br-main-img{max-width:100% !important;left:0 !important;top:0 !important;} .br-layer{left:0 !important;top:0 !important;width:100% !important;height:100% !important;}</style>\n    \t<script type=\"text/javascript\">\n        \$(window).load(function() {\n        \tvar e = {\n        \t\tborderWidth: 0,\n        \t\tdelay:" . $banner_config["duration"] . ",\n        \t\teffect: \"" . $banner_config["transition"] . "\",\n        \t\tblockCols: 10,\n        \t\tblockRows: 4,\n        \t\tverticalSlices: 14,\n        \t\thorizontalSlices: 6,\n                easing:\"" . $banner_config["easing"] . "\",\n        \t\tcpanelAlign:\"" . $banner_config["cpalignments"] . "\",\n        \t\tthumbnails: \"" . $banner_config["thumbnails"] . "\",\n        \t\tnavButtons: \"" . $banner_config["navbuttons"] . "\",\n        \t\ttooltip: \"none\",\n        \t\tplayButton: true,\n        \t\ttimer: \"" . $banner_config["timer"] . "\",\n        \t\tpauseOnHover: true,\n        \t\tcpanelOnHover: true,\n        \t\tnavButtonsOnHover: true,\n        \t\tshuffle: false\n        \t};\n            \$(\".banner-rotator\").bannerRotator(e)\n        });\n    </script>";
    $tempalte_ver["bannercode"] = $_bannerHeaderCode;
    $tempalte_ver["banner"] = $_bannerCode;
    $tempalte_ver["banner_config"] = $banner_config;
    unset($banner_config);
    unset($result);
    unset($data);
    unset($_bannerHeaderCode);
    unset($_bannerCode);
    unset($_readmore_link);
    unset($_bannerinfo);
}

if (!$storeowner["id"]) {
    $sql = dquery("select * from tbl_add_management where `type`='index'");
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($row["html_code"] != "") {
            $AdsArr[$row["p_id"]] = html_entity_decode($row["html_code"]);
        }
    }
    if ($config["shoppingcart"] && $action != "bestdeal" && $action != "imeideal") {
        $dailydeals = getProducts("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true, "RI");
        $tempalte_ver["dailydeals"] = $dailydeals;
    }
    if ($action == "imeideal") {
        $action = "bestdeal";
    }
    $tempalte_ver["action"] = $action;
    $smarty->assign("adds_index", $AdsArr);
    unset($AdsArr);
}
$currentpage = "index";
chkMd5sumsubpage();
echo "";
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);

?>