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
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$search = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $search);
$templatefile = "client_search_products";
installclient($pagetitle, $pageicon, $breadcrumbnav);
require_once ROOTDIR . "/includes/products.fun.php";
$tempalte_ver["products"] = NULL;
if ($json) {
    $JSON = [];
    if (4 <= strlen($search)) {
        $exp = explode(" ", $search);
        $buff = " (";
        foreach ($exp as $s) {
            $buff .= " `service_name` LIKE '%" . $s . "%' AND";
        }
        $buff = rtrim($buff, "AND");
        $buff .= ")";
        $search = $buff;
        $grp = dquery("select group_name,id from tbl_product_group");
        while ($gde = mysqli_fetch_assoc($grp)) {
            if ($storeowner["id"]) {
                $sql = dquery("select id,group_id,short_info,service_name,image_link1,\n        image_link2,image_link3,image_link4,image_link5,default_image from\n         tbl_products where " . $search . " AND group_id='" . $gde["id"] . "' AND store='1' and active='1' LIMIT 20");
            } else {
                $sql = dquery("select id,group_id,short_info,service_name,image_link1,\n        image_link2,image_link3,image_link4,image_link5,default_image from\n         tbl_products where " . $search . " AND group_id='" . $gde["id"] . "'  and active='1' LIMIT 20");
            }
            if (mysqli_num_rows($sql)) {
                while ($row = mysqli_fetch_assoc($sql)) {
                    $row["default_image"] = 1 ? $row["image_link1"] : $row["default_image"];
                    $imagepath = $row["default_image"];
                    $imageexp = explode("/", $imagepath);
                    $imageexp = end($imageexp);
                    $imagepath = str_replace($imageexp, "", $imagepath);
                    if ($imagepath) {
                    }
                    unlink($row["image_link1"], $row["image_link2"], $row["image_link3"], $row["image_link4"], $row["image_link5"], $row["default_image"]);
                    $row["seourl"] = _url("cart/service/product/group/" . $row["group_id"] . "/item/" . $row["id"]);
                    $JSON["products"][$gde["group_name"]][$row["id"]] = $row;
                }
            }
        }
        if ($storeowner["id"]) {
            $sql = dquery("select id,group_id,(select group_name\nfrom tbl_imei_group where id=group_id) as group_name,service_name, image_link as image_link1 from\n         tbl_services_imei where " . $search . " \n         AND store='1'  and useasserver=1 and (select `status` from tbl_service_status\n         where groupid='retail' and serviceid=id)=1 LIMIT 20");
        } else {
            $sql = dquery("select id,group_id,(select group_name\nfrom tbl_imei_group where id=group_id) as group_name,service_name,image_link as image_link1\n         from  tbl_services_imei  where " . $search . " \n         and (select `status` from tbl_service_status\n         where groupid='retail' and serviceid=id)=1\n          and useasserver=1\n         LIMIT 20");
        }
        if (mysqli_num_rows($sql)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $imagepath = $row["image_link1"];
                $imageexp = explode("/", $imagepath);
                $imageexp = end($imageexp);
                $imagepath = str_replace($imageexp, "", $imagepath);
                if ($imagepath) {
                }
                unlink($row["image_link1"]);
                $row["seourl"] = "cart.php?service=server&group=" . $row["group_id"] . "&parentid=1008&item=" . $row["id"];
                $JSON["server"][$row["group_name"]][$row["id"]] = $row;
            }
        }
        if ($storeowner["id"]) {
            $sql = dquery("select id,group_id,(select group_name\nfrom tbl_imei_group where id=group_id) as group_name,service_name,image_link as image_link1\n        from tbl_services_imei where " . $search . " \n         AND store='1'  and useasserver=0\n          and (select `status` from tbl_service_status\n         where groupid='retail' and serviceid=id)=1 LIMIT 20");
        } else {
            $sql = dquery("select id,group_id,(select group_name\nfrom tbl_imei_group where id=group_id) as group_name,service_name,image_link as image_link1\n         from tbl_services_imei\n          where " . $search . "  and useasserver=0\n         and (select `status` from tbl_service_status\n         where groupid='retail' and serviceid=id)=1   LIMIT 20");
        }
        if (mysqli_num_rows($sql)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $imagepath = $row["image_link1"];
                $imageexp = explode("/", $imagepath);
                $imageexp = end($imageexp);
                $imagepath = str_replace($imageexp, "", $imagepath);
                if ($imagepath) {
                }
                unlink($row["image_link1"]);
                $row["seourl"] = "cart.php?service=imei&group=" . $row["group_id"] . "&parentid=1008&item=" . $row["id"];
                $JSON["imei"][$row["group_name"]][$row["id"]] = $row;
            }
        }
    }
    echo json_encode($JSON);
    exit;
} else {
    if (4 <= strlen($search)) {
        $exp = explode(" ", $search);
        $buff = " (";
        foreach ($exp as $s) {
            $buff .= " `service_name` LIKE '%" . $s . "%' AND";
        }
        $buff = rtrim($buff, "AND");
        $buff .= ")";
        $search = $buff;
        $grp = dquery("select group_name,id from tbl_product_group");
        while ($gde = mysqli_fetch_assoc($grp)) {
            if ($storeowner["id"]) {
                $sql = dquery("select id,group_id,short_info,service_name,image_link1,\n        image_link2,image_link3,image_link4,image_link5,default_image from\n         tbl_products where " . $search . " AND group_id='" . $gde["id"] . "' AND store='1' and active='1' LIMIT 20");
            } else {
                $sql = dquery("select id,group_id,short_info,service_name,image_link1,\n        image_link2,image_link3,image_link4,image_link5,default_image from\n         tbl_products where " . $search . " AND group_id='" . $gde["id"] . "'  and active='1' LIMIT 20");
            }
            if (mysqli_num_rows($sql)) {
                while ($row = mysqli_fetch_assoc($sql)) {
                    $row["default_image"] = 1 ? $row["image_link1"] : $row["default_image"];
                    $imagepath = $row["default_image"];
                    $imageexp = explode("/", $imagepath);
                    $imageexp = end($imageexp);
                    $imagepath = str_replace($imageexp, "", $imagepath);
                    if ($imagepath) {
                        $row["thumb"] = $imagepath . "/thumb" . $imageexp;
                    }
                    $row["seourl"] = "cart.php?service=product&group=" . $row["group_id"] . "&parentid=1008&item=" . $row["id"];
                    $tempalte_ver["products"][$gde["group_name"]][$row["id"]] = $row;
                }
            }
        }
    }
    echo processSingleTemplate($templatefile);
    unset($tempalte_ver);
}

?>