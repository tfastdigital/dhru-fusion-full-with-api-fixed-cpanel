<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$search = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $search);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$service = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $service);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$group = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $group);
$model_id = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $model_id);
$provider_id = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $provider_id);
$brand = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $brand);
$country = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $country);
$pagelimit = 1000;
$parentid = 1006;
$currentpage = "productsservices";
$_nav = "<a href='" . _url("index") . "'>" . $lng_languag["home"] . " </a> / ";
$_nav .= "<a href='" . _url("resellerpricing") . "' >" . html_entity_decode($lng_languag[resellerpricing]) . "</a> / ";
$tempalte_ver["displayprice"] = $config["displayprice"];
$pagetitle = html_entity_decode($lng_languag[resellerpricing]) . " / ";
if ($action == "remote") {
    require "includes/imeiservices.fun.php";
    $pagetitle .= $lng_languag["remote"] . " " . $lng_languag["services"];
    $_nav .= "<a href='" . _url("resellerpricing/remote") . "' >" . $lng_languag["remote"] . " " . $lng_languag["service"] . " </a> ";
    $templatefile = "remoteservices";
    $tempalte_ver["rightmenul"] = true;
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    if (0 < $storeowner["id"]) {
        $tempalte_ver["serverservicelist"] = getIMEIServices($group, "", $storeowner["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 2, true);
    } else {
        $tempalte_ver["serverservicelist"] = getIMEIServices($group, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true, 2);
    }
    foreach ($tempalte_ver["serverservicelist"] as $k => $v) {
        foreach ($v as $c => $d) {
            if (!isset($_SESSION["uid"])) {
                if ($d["hideguestgroup"]) {
                    unset($tempalte_ver["serverservicelist"][$k]);
                } else {
                    if ($d["hideguest"] || $d["hideguestgroup"]) {
                        unset($tempalte_ver["serverservicelist"][$k][$c]);
                    }
                }
            }
            if ($cmslink["server"][$d["id"]]) {
                $tempalte_ver["serverservicelist"][$k][$c]["time"] = $d["time"] . "<br />\n                 <span style='float: right;'><a target='_blank' \n                 href='" . $cmslink["server"][$d["id"]] . "'>Edit Service</a></span>";
            } else {
                $tempalte_ver["serverservicelist"][$k][$c]["time"] = $d["time"];
            }
        }
    }
    $cg = dquery("select * from tbl_client_group where showon=1 order by displayorder asc");
    while ($rcg = mysqli_fetch_assoc($cg)) {
        $cgps[$rcg["id"]] = $rcg["groupname"];
    }
    $tempalte_ver["groups"] = $cgps;
    $tempalte_ver["serverservicegroup"] = getIMEIServiceGroup(2);
    $tempalte_ver["group"] = $group;
    if ($config["default_service_remote"] != 1) {
        $templatefile = "client_accessdenied";
        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
    }
} else {
    if ($action == "server") {
        require "includes/imeiservices.fun.php";
        $pagetitle .= $lng_languag["serverservice"];
        $_nav .= "<a href='" . _url("resellerpricing/server") . "' >" . $lng_languag["serverservice"] . " </a> ";
        $templatefile = "serverservices";
        $tempalte_ver["rightmenul"] = true;
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        if (0 < $storeowner["id"]) {
            $tempalte_ver["serverservicelist"] = getIMEIServices($group, "", $storeowner["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 1, true);
        } else {
            $tempalte_ver["serverservicelist"] = getIMEIServices($group, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true, 1);
        }
        foreach ($tempalte_ver["serverservicelist"] as $k => $v) {
            foreach ($v as $c => $d) {
                if (!isset($_SESSION["uid"])) {
                    if ($d["hideguestgroup"]) {
                        unset($tempalte_ver["serverservicelist"][$k]);
                    } else {
                        if ($d["hideguest"] || $d["hideguestgroup"]) {
                            unset($tempalte_ver["serverservicelist"][$k][$c]);
                        }
                    }
                }
                if ($cmslink["server"][$d["id"]]) {
                    $tempalte_ver["serverservicelist"][$k][$c]["time"] = $d["time"] . "<br />\n                 <span style='float: right;'><a target='_blank' \n                 href='" . $cmslink["server"][$d["id"]] . "'>Edit Service</a></span>";
                } else {
                    $tempalte_ver["serverservicelist"][$k][$c]["time"] = $d["time"];
                }
            }
        }
        $cg = dquery("select * from tbl_client_group where showon=1 order by displayorder asc");
        while ($rcg = mysqli_fetch_assoc($cg)) {
            $cgps[$rcg["id"]] = $rcg["groupname"];
        }
        $tempalte_ver["groups"] = $cgps;
        $tempalte_ver["imeiservicegroup"] = getIMEIServiceGroup();
        $tempalte_ver["group"] = $group;
        if ($config["default_service_server"] != 1) {
            $templatefile = "client_accessdenied";
            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
        }
    } else {
        if ($action == "file") {
            require "includes/fileservices.fun.php";
            $pagetitle .= $lng_languag["fileservice"];
            $_nav .= "<a href='" . _url("resellerpricing/file") . "' >" . $lng_languag["fileservice"] . " </a> ";
            $templatefile = "fileservices";
            $tempalte_ver["rightmenul"] = true;
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $tempalte_ver["fileservicelist"] = getFileServices($group);
            foreach ($tempalte_ver["fileservicelist"] as $k => $v) {
                foreach ($v as $c => $d) {
                    if ($cmslink["file"][$d["id"]]) {
                        $tempalte_ver["fileservicelist"][$k][$c]["time"] = $d["time"] . "<br />\n                 <span style='float: right;'><a target='_blank' \n                 href='" . $cmslink["file"][$d["id"]] . "'>Edit Service</a></span>";
                    } else {
                        $tempalte_ver["fileservicelist"][$k][$c]["time"] = $d["time"];
                    }
                }
            }
            $tempalte_ver["fileservicegroup"] = getFileServiceGroup();
            $tempalte_ver["group"] = $group;
            if ($config["default_service_file"] != 1) {
                $templatefile = "client_accessdenied";
                $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
            }
        } else {
            if ($action == "search") {
                $pagetitle .= $lng_languag["searchservice"];
                $_nav .= "<a href='" . _url("resellerpricing/search") . "' >" . $lng_languag["searchservice"] . " </a> ";
                $templatefile = "searchservices";
                $tempalte_ver["rightmenul"] = true;
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $result = dquery("SELECT `ID`,`Name` FROM `tbl_model_brand`");
                $tempalte_ver["brands"] = "<select name=\"brand\" class=\"form-control\" onchange=\"getModels(this.value,'','#modelsdropdown',true,'#loader');\"><option>" . $lng_languag["select"] . "</option>";
                while ($data = mysqli_fetch_assoc($result)) {
                    $tempalte_ver["brands"] .= "<option value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
                }
                $tempalte_ver["brands"] .= "</select>";
                $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country`");
                $tempalte_ver["provider_countrys"] = "<select name=\"country\"  class=\"form-control\" onchange=\"getProvider(this.value,'','#providerdropdown',true,'#loader');\"><option>" . $lng_languag["select"] . "</option>";
                while ($data = mysqli_fetch_assoc($result)) {
                    $tempalte_ver["provider_countrys"] .= "<option value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
                }
                $tempalte_ver["provider_countrys"] .= "</select>";
                if ($config["default_service_imei"] != 1) {
                    $templatefile = "client_accessdenied";
                    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                }
            } else {
                if ($action == "final") {
                    require "includes/imeiservices.fun.php";
                    $pagetitle .= $lng_languag["imeiservice"];
                    $_nav .= "<a href='" . _url("resellerpricing/final") . "' >" . $lng_languag["imeiservice"] . " </a> / ";
                    $templatefile = "servicelist";
                    $tempalte_ver["rightmenul"] = true;
                    $tempalte_ver["searchload"] = true;
                    $where = "";
                    if (!isset($_SESSION["uid"])) {
                        $where = " and hideguest=1";
                    }
                    $pageicon = "";
                    $_nav .= "<a >" . $lng_languag["listofavalableservice"] . " </a>";
                    if ($model_id && $provider_id) {
                        $sql = dquery("SELECT `id`                 FROM `tbl_services_imei`                 WHERE                 (`assigned_model` LIKE \"" . $model_id . ",%\"\n                OR `assigned_model` LIKE \"%," . $model_id . "\"\n                OR `assigned_model` LIKE \"%," . $model_id . ",%\"\n                OR `assigned_model` = \"" . $model_id . "\")  AND                                (`assigned_provider` LIKE \"" . $provider_id . ",%\"\n                OR `assigned_provider` LIKE \"%," . $provider_id . "\"\n                OR `assigned_provider` LIKE \"%," . $provider_id . ",%\"\n                OR `assigned_provider` = \"" . $provider_id . "\")               \n                ");
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $arr[] = $row["id"];
                        }
                    } else {
                        if ($brand && $model_id) {
                            $sql = dquery("SELECT `id` \n                FROM `tbl_services_imei` \n                WHERE `assigned_model` LIKE \"" . $model_id . ",%\"\n                OR `assigned_model` LIKE \"%," . $model_id . "\"\n                OR `assigned_model` LIKE \"%," . $model_id . ",%\"\n                OR `assigned_model` = \"" . $model_id . "\"\n                ");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $arr[] = $row["id"];
                            }
                        } else {
                            if ($country && $provider_id) {
                                $sql = dquery("SELECT `id` \n                FROM `tbl_services_imei` \n                WHERE `assigned_provider` LIKE \"" . $provider_id . ",%\"\n                OR `assigned_provider` LIKE \"%," . $provider_id . "\"\n                OR `assigned_provider` LIKE \"%," . $provider_id . ",%\"\n                OR `assigned_provider` = \"" . $provider_id . "\"\n                ");
                                while ($row = mysqli_fetch_assoc($sql)) {
                                    $arr[] = $row["id"];
                                }
                            } else {
                                if ($brand) {
                                    $sql = dquery("SELECT `id` \n                FROM `tbl_services_imei` \n                WHERE `assigned_brand` LIKE \"" . $brand . ",%\"\n                OR `assigned_brand` LIKE \"%," . $brand . "\"\n                OR `assigned_brand` LIKE \"%," . $brand . ",%\"\n                OR `assigned_brand` = \"" . $brand . "\"\n                ");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        $arr[] = $row["id"];
                                    }
                                } else {
                                    if ($country) {
                                        $sql = dquery("SELECT `id` \n                FROM `tbl_services_imei` \n                WHERE `assigned_country` LIKE \"" . $country . ",%\"\n                OR `assigned_country` LIKE \"%," . $country . "\"\n                OR `assigned_country` LIKE \"%," . $country . ",%\"\n                OR `assigned_country` = \"" . $country . "\" ");
                                        while ($row = mysqli_fetch_assoc($sql)) {
                                            $arr[] = $row["id"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $listing = getIMEIServices("", $arr);
                    if ($arr) {
                        $tempalte_ver["listdata"] = true;
                    } else {
                        $tempalte_ver["listdata"] = false;
                    }
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    foreach ($listing as $k => $v) {
                        foreach ($v as $c => $d) {
                            if (!isset($_SESSION["uid"])) {
                                if ($d["hideguestgroup"]) {
                                    unset($tempalte_ver["imeiservicelist"][$k]);
                                } else {
                                    if ($d["hideguest"] || $d["hideguestgroup"]) {
                                        unset($tempalte_ver["imeiservicelist"][$k][$c]);
                                    }
                                }
                            }
                        }
                    }
                    $tempalte_ver["imeiservicelist"] = $listing;
                    $tempalte_ver["imeiservicegroup"] = getIMEIServiceGroup();
                    $tempalte_ver["group"] = $group;
                } else {
                    if ($action == "getdetail") {
                        require "includes/imeiservices.fun.php";
                        $sql = dquery("SELECT id,`service_name`,`time`,`credit`,group_id,\n    `info`,`assigned_model`,`model`,`provider`,`network`,`image_link`,\n    `assigned_brand`,`assigned_country`,`assigned_provider`\n    ,`listing`,retail FROM `tbl_services_imei` WHERE (id)='" . $service . "'");
                        $data = mysqli_fetch_assoc($sql);
                        $service = descape($service);
                        if ($storeowner["id"]) {
                            $srv = getIMEIServices("", md5($service), $storeowner["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true);
                        } else {
                            $srv = getIMEIServices("", md5($service));
                        }
                        $tempalte_ver["rightmenul"] = true;
                        $tempalte_ver["image_link"] = $data["image_link"];
                        $tempalte_ver["info"] = $data["info"];
                        $pagetitle .= $lng_languag["imeiservice"];
                        $_nav .= "<a href='" . _url("resellerpricing/getdetail") . "' >" . $lng_languag["imeiservice"] . "</a> / ";
                        $_nav .= "<a >" . $data["service_name"] . "</a>";
                        $templatefile = "servicelist";
                        $pageicon = "";
                        $tempalte_ver["serviceid"] = $data["id"];
                        $tempalte_ver["groupid"] = $data["group_id"];
                        $tempalte_ver["service_name"] = $srv["service_name"];
                        $tempalte_ver["seourl"] = $srv["seourl"];
                        $tempalte_ver["time"] = $srv["time"];
                        if (!$config["shoppingcart1"]) {
                            $tempalte_ver["retail"] = $srv["retail"];
                        }
                        $tempalte_ver["credit"] = $srv["credit"];
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        $tempalte_ver["listdetails"] = true;
                        if ($data["assigned_model"]) {
                            if ($data["assigned_model"] == "ALL") {
                                $WHERE = "";
                            } else {
                                $WHERE = " AND `ID` IN (" . $data["assigned_model"] . ")";
                            }
                        }
                        if ($data["assigned_brand"] == "ALL") {
                            $BRANDS = [];
                            $sql = dquery("SELECT `ID`,`Name` FROM `tbl_model_brand` WHERE `api`='" . $data["listing"] . "' ");
                            if (mysqli_num_rows(dquery("SELECT `ID`,`Name` FROM `tbl_model_brand` WHERE `api`='" . $data["listing"] . "' "))) {
                                while ($brand = mysqli_fetch_assoc($sql)) {
                                    $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE B_ID='" . $brand["ID"] . "' " . $WHERE);
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $BRANDS[$brand["Name"]][] = [$rows["ID"], $rows["Name"]];
                                    }
                                }
                            }
                        } else {
                            $brandarr = explode(",", $data["assigned_brand"]);
                            $BRANDS = [];
                            foreach ($brandarr as $bid) {
                                $brand = mysqli_fetch_assoc(dquery("SELECT `ID`,`Name` FROM `tbl_model_brand` WHERE `ID`='" . $bid . "' AND `api`='" . $data["listing"] . "' "));
                                if (mysqli_num_rows(dquery("SELECT `ID`,`Name` FROM `tbl_model_brand` WHERE `ID`='" . $bid . "' AND `api`='" . $data["listing"] . "' "))) {
                                    $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE `B_ID`='" . $bid . "' " . $WHERE);
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        $BRANDS[$brand["Name"]][] = [$rows["ID"], $rows["Name"]];
                                    }
                                }
                            }
                        }
                        $tempalte_ver["brandmodel"] = $BRANDS;
                        unset($BRANDS);
                        $BRANDS = NULL;
                        $WHERE = NULL;
                        if (1) {
                            if ($data["assigned_provider"]) {
                                if ($data["assigned_provider"] == "ALL") {
                                    $WHERE = "";
                                } else {
                                    $WHERE = " AND `ID` IN (" . $data["assigned_provider"] . ")";
                                }
                            }
                            if ($data["assigned_country"] == "ALL") {
                                $BRANDS = [];
                                $sql = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE `api`='" . $data["listing"] . "' ");
                                if (mysqli_num_rows(dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE `api`='" . $data["listing"] . "' "))) {
                                    while ($brand = mysqli_fetch_assoc($sql)) {
                                        $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $brand["ID"] . "' " . $WHERE);
                                        while ($rows = mysqli_fetch_assoc($result)) {
                                            $BRANDS[$brand["Name"]][] = [$rows["ID"], $rows["Name"]];
                                        }
                                    }
                                }
                            } else {
                                $brandarr = explode(",", $data["assigned_country"]);
                                $BRANDS = [];
                                if ($brandarr) {
                                    foreach ($brandarr as $bid) {
                                        $brand = mysqli_fetch_assoc(dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE `ID`='" . $bid . "' AND `api`='" . $data["listing"] . "' "));
                                        if (mysqli_num_rows(dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE `ID`='" . $bid . "' AND `api`='" . $data["listing"] . "' "))) {
                                            $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $bid . "' " . $WHERE);
                                            while ($rows = mysqli_fetch_assoc($result)) {
                                                $BRANDS[$brand["Name"]][] = [$rows["ID"], $rows["Name"]];
                                            }
                                        }
                                    }
                                }
                            }
                            $tempalte_ver["countryprov"] = $BRANDS;
                            unset($BRANDS);
                        }
                    } else {
                        require "includes/imeiservices.fun.php";
                        $pagetitle .= $lng_languag["imeiservice"];
                        $_nav .= "<a href='" . _url("resellerpricing/imei") . "'>" . $lng_languag["imeiservice"] . " </a> ";
                        $templatefile = "imeiservices";
                        $tempalte_ver["rightmenul"] = true;
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        global $cmslink;
                        if (0 < $storeowner["id"]) {
                            $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", $storeowner["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true, "", true);
                        } else {
                            $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true);
                        }
                        foreach ($tempalte_ver["imeiservicelist"] as $k => $v) {
                            foreach ($v as $c => $d) {
                                if (!isset($_SESSION["uid"])) {
                                    if ($d["hideguestgroup"]) {
                                        unset($tempalte_ver["imeiservicelist"][$k]);
                                    } else {
                                        if ($d["hideguest"] || $d["hideguestgroup"]) {
                                            unset($tempalte_ver["imeiservicelist"][$k][$c]);
                                        }
                                    }
                                }
                                if ($cmslink["imei"][$d["id"]]) {
                                    $tempalte_ver["imeiservicelist"][$k][$c]["time"] = $d["time"] . "<br />\n                 <span style='float: right;'><a target='_blank' \n                 href='" . $cmslink["imei"][$d["id"]] . "'>Edit Service</a></span>";
                                } else {
                                    $tempalte_ver["imeiservicelist"][$k][$c]["time"] = $d["time"];
                                }
                            }
                        }
                        $cg = dquery("select * from tbl_client_group where showon=1 order by displayorder asc");
                        while ($rcg = mysqli_fetch_assoc($cg)) {
                            $cgps[$rcg["id"]] = $rcg["groupname"];
                        }
                        $tempalte_ver["groups"] = $cgps;
                        $tempalte_ver["imeiservicegroup"] = getIMEIServiceGroup();
                        $tempalte_ver["group"] = $group;
                        if ($config["default_service_imei"] != 1) {
                            $templatefile = "client_accessdenied";
                            $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
                        }
                    }
                }
            }
        }
    }
}
if ($standalone) {
    echo processSingleTemplate($templatefile);
} else {
    $fileverioncheck = "6.1.0";
    DisplayOutput($templatefile);
}
chkMd5sumsubpage();
class no
{
}

?>