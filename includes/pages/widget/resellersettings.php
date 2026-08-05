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
if (!isset($_SESSION["uid"])) {
    exit;
}
global $next;
global $pagelimit;
if ($actions) {
    $action = $actions;
}
$id = preg_replace("/[^0-9a-zA-Z]/i", "", $id);
$user = preg_replace("/[^0-9a-zA-Z]/i", "", $users);
$searchvalue = preg_replace("/[^0-9a-zA-Z]/i", "", $searchvalue);
$action = preg_replace("/[^0-9a-zA-Z]/i", "", $action);
$next = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $next);
$pagelimit = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $pagelimit);
if ($_SESSION["uid"]) {
    if ($action == "page") {
        if ($id) {
            dquery("delete from tbl_cms_pages_store where md5(id)='" . $id . "'");
            echo "success:Page Removed successfully:" . $id;
        }
        exit;
    }
    if ($action == "userimeiorder") {
        $pagetitle = $lng_languag["imei"] . " " . $lng_languag["orders"];
        $_nav .= "<a href='" . _url("resellersettings/actions/userimeiorder") . "' >" . $lng_languag["imei"] . " " . $lng_languag["orders"] . "</a> / ";
        $templatefile = "client_reseller_imeiorders";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        if ($searchvalue != "" || $user != "") {
            if ($searchvalue != "") {
                $cond = " AND imei LIKE '%" . $searchvalue . "%'";
            } else {
                $cond = "";
            }
            if ($user != "") {
                $q = "select *,(select service_name from tbl_services_imei where id=service_id) \n\t\t\t\tas service,IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) as status \n                from tbl_order_imei where user_id='" . $user . "' " . $cond . " ORDER BY order_id DESC LIMIT " . $next . "," . $pagelimit;
                $sql = dquery($q);
            } else {
                $q = "select *,(select service_name from tbl_services_imei where id=service_id) \n\t\t\t\tas service from tbl_order_imei where user_id IN (select id from tblUsers\n\t        \t where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "') \n                 " . $cond . "  ORDER BY order_id DESC LIMIT " . $next . "," . $pagelimit;
                $sql = dquery($q);
            }
        } else {
            $q = "select *,(select service_name from tbl_services_imei where id=service_id) \n            as service,\n            IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) \n            as status from tbl_order_imei where user_id IN (select id from tblUsers\n        \twhere storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "') \n            ORDER BY order_id DESC LIMIT " . $next . "," . $pagelimit;
            $sql = dquery($q);
        }
        generatePaginate($q);
        while ($row = mysqli_fetch_assoc($sql)) {
            $tempalte_ver["imeiorderslist"][$row["order_id"]] = $row;
        }
        $sql = dquery("select * from tblUsers where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $tempalte_ver["myusers"][$row["id"]] = $row;
        }
        $tempalte_ver["imeilink"] = _url("resellersettings/actions/userimeiorder");
    } else {
        if ($action == "userfileorder") {
            $pagetitle = $lng_languag["file"] . " " . $lng_languag["orders"];
            $_nav .= "<a href='" . _url("resellersettings/actions/userfileorder") . "' >" . $lng_languag["file"] . " " . $lng_languag["orders"] . "</a> / ";
            $templatefile = "client_reseller_fileorders";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            if ($searchvalue != "" || $user != "") {
                if ($searchvalue != "") {
                    $cond = " AND file LIKE '%" . $searchvalue . "%'";
                } else {
                    $cond = "";
                }
                if ($user != "") {
                    $q = "select *,(select service_name from tbl_services_file where id=service_id) \n\t\t\t\tas service\n                ,IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) as status\n                 from tbl_order_file where user_id='" . $user . "' " . $cond . "  \n                 ORDER BY order_id DESC  LIMIT " . $next . "," . $pagelimit;
                    $sql = dquery($q);
                } else {
                    $q = "select *,(select service_name from tbl_services_file where id=service_id) \n\t\t\t\tas service from tbl_order_file where user_id IN (select id from tblUsers\n\t        \t where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "') " . $cond . " \n                  ORDER BY order_id DESC LIMIT " . $next . "," . $pagelimit;
                    $sql = dquery($q);
                }
            } else {
                $q = "select *,(select service_name from tbl_services_file where id=service_id) as service \n,IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) as status \n                from tbl_order_file where user_id IN (select id from tblUsers\n        \t where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "')  \n             ORDER BY order_id DESC LIMIT " . $next . "," . $pagelimit;
                $sql = dquery($q);
            }
            generatePaginate($q);
            while ($row = mysqli_fetch_assoc($sql)) {
                $tempalte_ver["fileorderslist"][$row["order_id"]] = $row;
            }
            $sql = dquery("select * from tblUsers where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $tempalte_ver["myusers"][$row["id"]] = $row;
            }
        } else {
            if ($action == "userserverorder") {
                $pagetitle = $lng_languag["server"] . " " . $lng_languag["orders"];
                $_nav .= "<a href='" . _url("resellersettings/actions/userserverorder") . "' >" . $lng_languag["server"] . " " . $lng_languag["orders"] . "</a> / ";
                $templatefile = "client_reseller_serverorders";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                if ($searchvalue != "" || $user != "") {
                    if ($searchvalue != "") {
                        $cond = " AND server LIKE '%" . $searchvalue . "%'";
                    } else {
                        $cond = "";
                    }
                    if ($user != "") {
                        $q = "select *,(select service_name from tbl_server_log where id=service_id) \n\t\t\t\tas service,\n            IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) \n            as status from tbl_order_server where user_id='" . $user . "' " . $cond . "  ORDER BY order_id DESC  \n            LIMIT " . $next . "," . $pagelimit;
                        $sql = dquery($q);
                    } else {
                        $q = "select *,(select service_name from tbl_server_log where id=service_id) \n\t\t\t\tas service from tbl_order_server where user_id IN (select id from tblUsers\n\t        \t where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "') " . $cond . " \n                  ORDER BY order_id DESC  LIMIT " . $next . "," . $pagelimit;
                        $sql = dquery($q);
                    }
                } else {
                    $q = "select *,(select service_name from tbl_server_log where id=service_id) \n            as service,\n            IF(user_can_c=0,'Pending',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Rejected','Replied'))) \n            as status from tbl_order_server where user_id IN (select id from tblUsers\n        \t where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "')\n               ORDER BY order_id DESC  LIMIT " . $next . "," . $pagelimit;
                    $sql = dquery($q);
                }
                generatePaginate($q);
                while ($row = mysqli_fetch_assoc($sql)) {
                    $tempalte_ver["serverorderslist"][$row["order_id"]] = $row;
                }
                $sql = dquery("select * from tblUsers where storeownerid='" . $_ClientsDetails["id"] . "' OR reseller_id='" . $_ClientsDetails["id"] . "'");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $tempalte_ver["myusers"][$row["id"]] = $row;
                }
            } else {
                if ($action == "email") {
                    $pagetitle = $lng_languag["emailsetting"];
                    $_nav .= "<a href='" . _url("resellersettings/actions/email") . "' >" . $lng_languag["emailsetting"] . "</a> / ";
                    $templatefile = "client_reseller_emailsettings";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    $tempalte_ver["emailtemplatelist"] = getResellerEmailtemplatelist($_ClientsDetails["id"]);
                    $tempalte_ver["action_link"] = _url("widget/save/reseller/action/email");
                } else {
                    if ($action == "bannerd") {
                        if ($id) {
                            dquery("delete from tbl_bannerslider_banners where md5(id)='" . $id . "'");
                            echo "success:Banner Removed successfully:" . $id;
                        }
                        exit;
                    }
                    if ($action == "store") {
                        $pagetitle = $lng_languag["store"];
                        $_nav .= "<a href='" . _url("resellersettings/actions/store") . "' >" . $lng_languag["store"] . "</a> / ";
                        $templatefile = "client_reseller_store";
                        $pageicon = "";
                        global $lng_languag;
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        $tempalte_ver["linkip"] = $_SERVER["SERVER_ADDR"];
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='domain'"));
                        $tempalte_ver["domain"] = "<input type='text'  class='form-control' name='store[domain]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='currency'"));
                        $tempalte_ver["currency"] = getCurrency2($selected = $store["value"], $fieldname = "store[currency]");
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='site_address'"));
                        $tempalte_ver["site_address"] = "<input type='text'  class='form-control' name='store[site_address]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='config_ssl_allow'"));
                        $tempalte_ver["config_ssl_allow"] = "<input type='text'  class='form-control' name='store[config_ssl_allow]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='template'"));
                        $tempalte_ver["template"] = getTemplatesDropDown($selected = $store["value"], $fieldname = "store[template]", true);
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='language'"));
                        $tempalte_ver["language"] = getLanguageDropdown2($selected = $store["value"], $fieldname = "store[language]");
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='logo_link'"));
                        $tempalte_ver["logo_link"] = "<input type='text'  class='form-control' name='store[logo_link]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='adminsignature'"));
                        $tempalte_ver["adminsignature"] = "<textarea  class='form-control' name='store[adminsignature]'>" . $store["value"] . "</textarea>";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='signup_type'"));
                        if ($store["value"] == "1") {
                            $check = "checked='checked'";
                            $checkn = "";
                        } else {
                            $checkn = "checked='checked'";
                            $check = "";
                        }
                        $tempalte_ver["signuptype"] = "<input type='radio' name='store[signup_type]' value='1' " . $check . "  />" . $lng_languag["regular"] . " \n                                      <input type='radio' name='store[signup_type]' value='2' " . $checkn . "  />" . $lng_languag["advance"] . " ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='companyname'"));
                        $tempalte_ver["companyname"] = "<input type='text' name='store[companyname]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='config_site_name'"));
                        $tempalte_ver["config_site_name"] = "<input type='text' name='store[config_site_name]' value='" . $store["value"] . "'/> ";
                        $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_config` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='config_admin_mail'"));
                        $tempalte_ver["config_admin_mail"] = "<input type='text' name='store[config_admin_mail]' value='" . $store["value"] . "'/> ";
                        $tempalte_ver["action_link"] = _url("widget/save/reseller/action/savestore");
                    } else {
                        if ($action == "index") {
                            $pagetitle = $lng_languag["store"];
                            $_nav .= "<a href='" . _url("resellersettings/actions/index") . "' >" . $lng_languag["indexcontent"] . "</a> / ";
                            $templatefile = "client_reseller_index";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            $tempalte_ver["linkip"] = $_SERVER["SERVER_ADDR"];
                            $store = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_store_pages` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `attribute`='index'"));
                            $tempalte_ver["index"] = "<textarea cols='70'  class='form-control' rows='8' name='index'>" . $store["value"] . "</textarea> ";
                            $tempalte_ver["action_link"] = _url("widget/save/reseller/action/saveindex");
                            $sql = dquery("select * from tbl_bannerslider_banners where store='" . $_SESSION["uid"] . "' ORDER by id");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $row["id"] = md5($row["id"]);
                                $tempalte_ver["mybanner"][] = $row;
                            }
                        } else {
                            if ($action == "editemail") {
                                $pagetitle = $lng_languag["emailsetting"];
                                $_nav .= "<a href='" . _url("resellersettings/actions/email") . "' >" . $lng_languag["emailsetting"] . "</a> / ";
                                $templatefile = "client_reseller_editemail";
                                $pageicon = "";
                                installclient($pagetitle, $pageicon, $breadcrumbnav);
                                $tempalte_ver["id"] = $id;
                                $sql = dquery("SELECT * FROM `tbl_emailtemplates_reseller` WHERE `uid`='" . $_ClientsDetails["id"] . "' AND `template_id`='" . $id . "'");
                                $cnt = mysqli_num_rows($sql);
                                if ($cnt) {
                                    $rows = mysqli_fetch_assoc($sql);
                                    $tempalte_ver["id"] = $rows["id"];
                                    $tempalte_ver["name"] = $rows["name"];
                                    $tempalte_ver["subject"] = "<input class='form-control' type='text' name='subject'  value='" . $rows["subject"] . "' />";
                                    $tempalte_ver["message"] = "<textarea class='form-control' name='message' rows='10' cols='70' >" . $rows["message"] . " </textarea>";
                                    $tempalte_ver["fromname"] = "<input class='form-control' type='text' name='fromname' value='" . $rows["fromname"] . "' />";
                                    $tempalte_ver["fromemail"] = "<input  class='form-control' type='text' name='fromemail' value='" . $rows["fromemail"] . "' />";
                                } else {
                                    $rows = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_emailtemplates` WHERE `id`='" . $id . "'"));
                                    $tempalte_ver["name"] = $rows["name"];
                                    $tempalte_ver["subject"] = "<input type='text'  class='form-control' name='subject'  value='" . $rows["subject"] . "' />";
                                    $tempalte_ver["message"] = "<textarea name='message'  class='form-control'  rows='10' cols='70' >" . $rows["message"] . " </textarea>";
                                    $tempalte_ver["fromname"] = "<input type='text'  class='form-control' name='fromname' value='" . $rows["fromname"] . "' />";
                                    $tempalte_ver["fromemail"] = "<input type='text'  class='form-control' name='fromemail' value='" . $rows["fromemail"] . "' />";
                                }
                                $tempalte_ver["action_link"] = _url("widget/save/reseller/action/saveemail/id/" . $id);
                            }
                        }
                    }
                }
            }
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}
echo " ";

?>