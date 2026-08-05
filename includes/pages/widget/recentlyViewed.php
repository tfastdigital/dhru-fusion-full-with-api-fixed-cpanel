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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$limit = preg_replace("/[^0-9]/i", "", $limit);
installclient($pagetitle, $pageicon, $breadcrumbnav);
$nos = 1;
$arrs = [];
$id = 1;
if (isset($_COOKIE["RECENTLYVIEW"])) {
    $arrC = [];
    foreach ($_COOKIE["RECENTLYVIEW"] as $v) {
        $exp = explode("-", $v);
        $arrC[$exp[1]] = $exp[0];
    }
    $arrC = array_reverse($arrC, true);
    foreach ($arrC as $v) {
        if ($limit < $nos) {
        } else {
            $nos++;
            if (is_numeric($v)) {
                $v = preg_replace("/[^0-9.]/i", "", $v);
                if ($storeowner["id"]) {
                    $sql = mysqli_fetch_assoc(dquery("select id,service_name,group_id,image_link1,image_link2\n            ,image_link3,image_link4,image_link5,default_image from tbl_products where id='" . $v . "'\n            AND store='1'"));
                    if ($sql) {
                    }
                } else {
                    $sql = mysqli_fetch_assoc(dquery("select id,service_name,group_id,image_link1,image_link2\n            ,image_link3,image_link4,image_link5,default_image from tbl_products where id='" . $v . "'"));
                }
                $imagepath = "";
                $_servicedtl = NULL;
                if ($sql["default_image"] == 1) {
                    $imagepath = $sql["image_link1"];
                } else {
                    if ($sql["default_image"] == 2) {
                        $imagepath = $sql["image_link2"];
                    } else {
                        if ($sql["default_image"] == 3) {
                            $imagepath = $sql["image_link3"];
                        } else {
                            if ($sql["default_image"] == 4) {
                                $imagepath = $sql["image_link4"];
                            } else {
                                if ($sql["default_image"] == 5) {
                                    $imagepath = $sql["image_link5"];
                                }
                            }
                        }
                    }
                }
                $_servicedtl["default_imagepath"] = $imagepath;
                $imageexp = explode("/", $imagepath);
                $imageexp = end($imageexp);
                $imagepath = str_replace($imageexp, "", $imagepath);
                if ($imagepath) {
                    if (is_file("../" . $imagepath . "thumb" . $imageexp) || is_file($imagepath . "thumb" . $imageexp)) {
                        $_servicedtl["thumb"] = $imagepath . "thumb" . $imageexp;
                    } else {
                        if (is_file("../images/gallery/thumb" . $imageexp) || is_file("images/gallery/thumb" . $imageexp)) {
                            $_servicedtl["thumb"] = "images/gallery/thumb" . $imageexp;
                        }
                    }
                }
                $defautls = "";
                if ($_servicedtl["thumb"]) {
                    $defautls = $_servicedtl["thumb"];
                } else {
                    $defautls = $_servicedtl["default_imagepath"];
                }
                $sql["mdid"] = $sql["id"];
                $sql["thumb"] = $defautls;
                $arr[$v] = $sql;
            }
        }
    }
}
$smarty->assign("itemsds", $arr);
if ($config["shoppingcart"]) {
    echo processSingleTemplate("cart_recentview");
}

?>