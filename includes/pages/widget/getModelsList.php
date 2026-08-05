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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if ($serviceid) {
    $serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    $imeiservice = getIMEIServices("", md5($serviceid), "", true, "", "", true);
    $serviceid = md5($serviceid);
    $imeiorderdetails = "";
    $imeiorderdetails .= "<input type=\"hidden\" name=\"id\" value=\"" . $serviceid . "\" />";
    if ($imeiservice["info"]) {
        $imeiorderdetails .= "<div class='retailinfo'><strong onclick='showretailinfo();'>Service Information</strong> <div id=retailinfo><h1>Service Information</h1> <div style=padding:15px>" . $imeiservice["info"] . "</div></div></div></div>";
    }
    $currencyPrefix = "\n        <label>" . $_SESSION["currency"]["prefix"] . ($imeiservice["credit"] - $imeiservice["cartdiscount"]) . $_SESSION["currency"]["suffix"] . "</label>";
    if ($imeiservice["time"]) {
        $deliveryTime = "<label class='deliverytime'>" . $lng_languag["deliverytime"] . ":<br />\n      <span>" . $imeiservice["time"] . "</span></label>";
    }
    if (($currencyPrefix || $deliveryTime) && !isset($_SESSION["NEWTEMP"])) {
        $imeiorderdetails .= "<div class=creditCost>" . $currencyPrefix . " " . $deliveryTime . "</div><div class='clearfix'></div>";
    }
    if ($config["quick_checkout"] == 1) {
        if ($imeiservice["reqredfield"]["imei_custom"]) {
            $imeiorderdetails .= "<p  class='clearfix'><label>" . $imeiservice["reqredfield"]["imei_custom_name"] . ":</label><span>\n<textarea name='imei_custom' class='form-control' id='imei_custom' rows='6' cols='50' ></textarea>\n</span></p>";
        } else {
            $imeiorderdetails .= "<p class=\"clearfix\"><label>IMEI :</label><span>\n<input name=\"imei1\" type=\"text\" class=\"imei1 form-control\" id=\"imei1\" onblur=\"remove_imei2()\" onkeyup=\"luhnCheck()\" maxlength=\"14\" /> \n<input name=\"imei2\" type=\"text\" id=\"imei2\" size=\"1\" readonly=\"true\" class=\"imei2 span1 form-control\" /><br />\n</span></p>";
        }
        if ($imeiservice["reqredfield"]["provider"]) {
            if ($imeiservice["reqredfield"]["assigned_country"]) {
                $WHERE = " `ID` IN (" . $imeiservice["reqredfield"]["assigned_country"] . ")";
            } else {
                $WHERE = " 1=1 ";
            }
            $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` WHERE  " . $WHERE);
            $imeiorderdetails .= "<p> <label> Country:</label><span><select name=\"country\" class=\"form-control\" onchange=\"getProvider(this.value,'" . $serviceid . "','#providerdropdown',true,'#loader');\"><option value=\"\">" . $lng_languag["selectprovider"] . "</option>";
            while ($data = mysqli_fetch_assoc($result)) {
                $imeiorderdetails .= "<option value=\"" . $data["ID"] . "\">" . html_entity_decode($data["Name"]) . "</option>";
            }
            $imeiorderdetails .= "</select></span></p>";
            unset($WHERE);
            $imeiorderdetails .= "<p ><label> Provider:</label><span id=\"providerdropdown\"></span></p><div class=\"clear\"></div>";
        }
        if ($imeiservice["reqredfield"]["mep"]) {
            if ($imeiservice["reqredfield"]["assigned_mep"]) {
                $WHERE = " `id` IN (" . $imeiservice["reqredfield"]["assigned_mep"] . ")";
            } else {
                $WHERE = " 1=1 ";
            }
            $result = dquery("SELECT `id`,`mep` FROM `tbl_mep` WHERE " . $WHERE);
            $imeiorderdetails .= "<p> <label> MEP:</label><select name=\"mep\" class=\"form-control\"><option value=\"\">" . $lng_languag["selectmep"] . "</option>";
            while ($data = mysqli_fetch_assoc($result)) {
                $imeiorderdetails .= "<option value=\"" . $data["id"] . "\">" . $data["mep"] . "</option>";
            }
            $imeiorderdetails .= "</select></span></p>";
            unset($WHERE);
        }
        if (!function_exists("getCustomFields")) {
            require ROOTDIR . "/includes/customfield.fun.inc.php";
        }
        if ($imeiservice["reqredfield"]["PIN"]) {
            $imeiorderdetails .= "<p><label>PIN :</label><span><input name=\"PIN\"  class=\"form-control\" type=\"text\" maxlength=\"20\" /></span></p>";
        }
        if ($imeiservice["reqredfield"]["KBH"]) {
            $imeiorderdetails .= "<p><label>KBH :</label><span><input name=\"KBH\"  class=\"form-control\" type=\"text\" maxlength=\"20\" /></span></p>";
        }
        if ($imeiservice["reqredfield"]["PRD"]) {
            $imeiorderdetails .= "<p><label>PRD :</label><span><input name=\"PRD\"  class=\"form-control\" type=\"text\" maxlength=\"20\" /></span></p>";
        }
        if ($imeiservice["reqredfield"]["type"]) {
            $imeiorderdetails .= "<p><label>Type :</label><span><input name=\"type\"  class=\"form-control\" type=\"text\" maxlength=\"20\" /></span></p>";
        }
        if ($imeiservice["reqredfield"]["reference"]) {
            $imeiorderdetails .= "<p><label>Reference :</label><span><input name=\"Reference\"  class=\"form-control\" type=\"text\" maxlength=\"20\"  value=\"25XXXXXXX\"  /></span></p>";
        }
        if ($imeiservice["reqredfield"]["locks"]) {
            $imeiorderdetails .= "   <p><label>Locks:</label><span></span></p>\n    <br />\n    <p><label><input type=\"checkbox\" name=\"Locks[]\" value=\"NCK\" id=\"Lock0\" /> Lock 1 <b>NCK</b></label></p>\n    <p><label><input type=\"checkbox\" name=\"Locks[]\" value=\"NSCK\" id=\"Lock1\" /> Lock 2 <b>NSCK</b></label> </p>\n    <p><label><input type=\"checkbox\" name=\"Locks[]\" value=\"SPK\" id=\"Lock2\" /> Lock 3 <b>SPK</b></label> </p>\n    <p><label><input type=\"checkbox\" name=\"Locks[]\" value=\"CCK\" id=\"Lock3\" /> Lock 4 <b>CCK</b></label> </p>\n    <p><label><input type=\"checkbox\" name=\"Locks[]\" value=\"ESL\" id=\"Lock4\" /> Lock 5 <b>ESL</b></label> </p>\n";
        }
        $customfields = getCustomFields("serviceimei", $imeiservice["id"], "", "on");
        foreach ($customfields as $value) {
            $cst[$value["name"]] = $value;
        }
        if ($cst) {
            foreach ($cst as $k => $v) {
                $imeiorderdetails .= "<p><label>" . $k . " :</label><span>\n" . $v["input"] . " " . $v["required"] . "<br />  <small>" . $v["description"] . "</small></span></p>";
            }
        }
    }
    if ($config["quick_checkout"] == 1) {
        $imeiorderdetails .= "<p class=\"button\"> <label></label> <span>\n        <input type=\"button\" class=\"btn btn-primary\" id=\"placeorder\" onClick=\"SubmitForm('#placeorder','includes/cart.php','#imeiorder_form','#notification2','true','#loader');\" value=\"" . $lng_languag["addtocart"] . "\" />";
        $pay = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='paypal' and setting='active'"));
        if ($pay["value"] && 0 < $imeiservice["credit"] - $imeiservice["cartdiscount"]) {
            $imeiorderdetails .= "   <input type=\"button\" class=\"button_yellow btn btn-warning\" id=\"quickcheckout\" value=\"Paypal Quick Checkout\" onclick=\"SubmitForm('#quickcheckout','" . $config["site_address"] . "/placeholder.php?gat=paypal','#imeiorder_form','#notification2','true','#loader');\"  />";
        }
        $pay = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='googlecheckout' and setting='active'"));
        if ($pay["value"] && 0 < $imeiservice["credit"] - $imeiservice["cartdiscount"]) {
            $imeiorderdetails .= "   <input type=\"button\" \n class=\"button_yellow btn btn-warning\" id=\"googlequick\"\n value=\"Google Checkout\"  onclick=\"SubmitForm('#googlequick','" . $config["site_address"] . "/placeholder.php?gat=googlecheckout','#imeiorder_form','#notification2','true','#loader');\"  />";
        }
        $imeiorderdetails .= "</span></p>";
    } else {
        if (isset($_SESSION["wcountry"]) && isset($_SESSION["wprovider"])) {
            if (isset($_SESSION["NEWTEMP"])) {
                $imeiorderdetails .= "<p class=\"button\">\n<a href=\"javascript:void(0)\"  class=\"btn b-btn btn-primary\" id=\"placeorder\" \nonClick=\"javascript:location.href='" . $config["site_address"] . "cart.php?group=" . $imeiservice["group_id"] . "&item=" . $imeiservice["id"] . "&service=imei&bid=" . $_SESSION["wbrand"] . "&mid=" . $_SESSION["wmodel"] . "&pid=" . $_SESSION["wprovider"] . "&cid=" . $_SESSION["wcountry"] . "'\"\n>" . $_SESSION["currency"]["prefix"] . ($imeiservice["credit"] - $imeiservice["cartdiscount"]) . $_SESSION["currency"]["suffix"] . "&nbsp;&nbsp;&nbsp;" . $lng_languag["ordernow"] . "</a>";
                $imeiorderdetails .= "</p>";
            } else {
                $imeiorderdetails .= "<p class=\"button\"> <label></label> <span>\n<input type=\"button\" id=\"placeorder\"  class=\"btn btn-primary\"\nonClick=\"javascript:location.href='" . $config["site_address"] . "cart.php?group=" . $imeiservice["group_id"] . "&item=" . $imeiservice["id"] . "&service=imei&bid=" . $_SESSION["wbrand"] . "&mid=" . $_SESSION["wmodel"] . "&pid=" . $_SESSION["wprovider"] . "&cid=" . $_SESSION["wcountry"] . "'\"\n value=\"" . $lng_languag["ordernow"] . "\" />";
                $imeiorderdetails .= "</span></p>";
            }
        } else {
            if (isset($_SESSION["NEWTEMP"])) {
                $imeiorderdetails .= "<p class=\"button\"> <label></label> <span>\n<input type=\"button\" id=\"placeorder\" class=\"btn btn-primary\"\nonClick=\"javascript:location.href='" . $config["site_address"] . "cart.php?group=" . $imeiservice["group_id"] . "&item=" . $imeiservice["id"] . "&service=imei&bid=" . $_SESSION["wbrand"] . "&mid=" . $_SESSION["wmodel"] . "'\"\n value=\"" . $_SESSION["currency"]["prefix"] . ($imeiservice["credit"] - $imeiservice["cartdiscount"]) . $_SESSION["currency"]["suffix"] . " &nbsp;&nbsp;&nbsp; " . $lng_languag["ordernow"] . "\" />";
                $imeiorderdetails .= "</span></p>";
            } else {
                $imeiorderdetails .= "<p class=\"button\"> <label></label> <span>\n<input type=\"button\" id=\"placeorder\" class=\"btn btn-primary\"\nonClick=\"javascript:location.href='" . $config["site_address"] . "cart.php?group=" . $imeiservice["group_id"] . "&item=" . $imeiservice["id"] . "&service=imei&bid=" . $_SESSION["wbrand"] . "&mid=" . $_SESSION["wmodel"] . "'\"\n value=\"" . $lng_languag["ordernow"] . "\" />";
                $imeiorderdetails .= "</span></p>";
            }
        }
    }
    echo $imeiorderdetails;
} else {
    if ($countriid && $_SESSION["wbrand"] && $_SESSION["wmodel"] && $config["quick_checkout"] == 3) {
        $countriid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $countriid);
        $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $countriid . "'");
        if (mysqli_num_rows($result)) {
            $models .= "<select name=\"provider_id\"  class=\"form-control\"\nonchange=\"getServiceList2('#servicedropdown',this.value,document.getElementById('country_id').value,'#serviceload');\">";
            $models .= "<option value=\"\">-" . $lng_languag["select_"] . " " . $lng_languag["provider"] . "-</option>";
            while ($data = mysqli_fetch_assoc($result)) {
                $models .= "<option value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
            }
            $models .= "</select>";
        } else {
            $models = $lng_languag["not"] . " " . $lng_languag["found"];
        }
        echo $models;
    } else {
        if ($provider && $country && $_SESSION["wbrand"] && $_SESSION["wmodel"] && $config["quick_checkout"] == 3) {
            $brand = $_SESSION["wbrand"];
            $model = $_SESSION["wmodel"];
            $_SESSION["wprovider"] = $provider;
            $_SESSION["wcountry"] = $country;
            $brand = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $brand);
            $model = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $model);
            $country = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $country);
            $provider = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $provider);
            $sql = dquery("select id,service_name from tbl_services_imei where\n    \t (assigned_brand LIKE '" . $brand . "' Or assigned_brand LIKE '" . $brand . ",%'\n    \t Or assigned_brand LIKE '%," . $brand . ",%'  Or assigned_brand LIKE '%," . $brand . "')\n         \n          AND \n    \t (assigned_model LIKE '" . $model . "' Or assigned_model LIKE '" . $model . ",%'\n    \t Or assigned_model LIKE '%," . $model . ",%'  Or assigned_model LIKE '%," . $model . "')\n         \n          AND \n    \t (assigned_country LIKE '" . $country . "' Or assigned_country LIKE '" . $country . ",%'\n    \t Or assigned_country LIKE '%," . $country . ",%'  Or assigned_country LIKE '%," . $country . "')\n         \n          AND \n    \t (assigned_provider LIKE '" . $provider . "' Or assigned_provider LIKE '" . $provider . ",%'\n    \t Or assigned_provider LIKE '%," . $provider . ",%'  Or assigned_provider LIKE '%," . $provider . "')\n         \n          and retail='1' ORDER BY service_name ASC");
            if (mysqli_num_rows($sql)) {
                $service .= "<select name='service' class='form-control' onchange='getIMEIList(this.value,\"#serviceDetails\",\"#notification\",true,\"#loader\",true)'>";
                $service .= "<option value=\"\">-" . $lng_languag["selectservice"] . "-</option>";
                while ($data = mysqli_fetch_assoc($sql)) {
                    $service .= "<option value=\"" . $data["id"] . "\">" . $data["service_name"] . "</option>";
                }
                $service .= "</select>";
            } else {
                $service = (string) $lng_languag["noserviceformodel"];
            }
            echo $service;
        } else {
            if ($model && $brand) {
                $_SESSION["wbrand"] = $brand;
                $_SESSION["wmodel"] = $model;
                if ($config["quick_checkout"] == 3) {
                    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country`");
                    if (mysqli_num_rows($result)) {
                        $models .= "<select name=\"country_id\"   class=\"form-control\" id=\"country_id\"\n                  onchange=\"getProviderList('#providerdropdown',this.value,'#providerload');\">";
                        $models .= "<option value=\"\">-" . $lng_languag["select_"] . " " . $lng_languag["country"] . "-</option>";
                        while ($data = mysqli_fetch_assoc($result)) {
                            $models .= "<option value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
                        }
                        $models .= "</select>";
                    } else {
                        $models = $lng_languag["not"] . " " . $lng_languag["found"];
                    }
                    echo $models;
                } else {
                    if ($config["quick_checkout"] == 4) {
                        $brand = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $brand);
                        $model = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $model);
                        $sql = dquery("select id,group_id,retail_name,service_name from tbl_services_imei where\n        find_in_set('" . $brand . "',assigned_brand) AND \n        find_in_set('" . $model . "',assigned_model) AND retail=1 \n        ORDER BY service_name ASC");
                        if (mysqli_num_rows($sql)) {
                            $service .= "<select name='service'  class='form-control'\n            onchange='getIMEIRedirect(this.value,\"" . $brand . "\",\"" . $model . "\")'>";
                            $service .= "<option value=\"\">-" . $lng_languag["selectservice"] . "-</option>";
                            while ($data = mysqli_fetch_assoc($sql)) {
                                $service .= "<option value=\"" . $data["id"] . "-" . $data["group_id"] . "\">" . ($data["retail_name"] ? $data["retail_name"] : $data["service_name"]) . "</option>";
                            }
                            $service .= "</select>";
                        } else {
                            $service = (string) $lng_languag["noserviceformodel"];
                        }
                        echo $service;
                    } else {
                        $brand = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $brand);
                        $model = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $model);
                        $sql = dquery("select id,service_name from tbl_services_imei where\n    \t(assigned_brand LIKE '" . $brand . "' Or assigned_brand LIKE '" . $brand . ",%'\n    \tOr assigned_brand LIKE '%," . $brand . ",%'  Or assigned_brand LIKE '%," . $brand . "') AND \n    \t(assigned_model LIKE '" . $model . "' Or assigned_model LIKE '" . $model . ",%'\n    \tOr assigned_model LIKE '%," . $model . ",%'  Or assigned_model LIKE '%," . $model . "')\n        and retail='1' ORDER BY service_name ASC");
                        if (mysqli_num_rows($sql)) {
                            $service .= "<select name='service'  class='form-control'\nonchange='getIMEIList(this.value,\"#serviceDetails\",\"#notification\",true,\"#loader\",true)'>";
                            $service .= "<option value=\"\">-" . $lng_languag["selectservice"] . "-</option>";
                            while ($data = mysqli_fetch_assoc($sql)) {
                                $service .= "<option value=\"" . $data["id"] . "\">" . $data["service_name"] . "</option>";
                            }
                            $service .= "</select>";
                        } else {
                            $service = (string) $lng_languag["noserviceformodel"];
                        }
                        echo $service;
                    }
                }
            } else {
                if ($brand) {
                    if (isset($_POST["model"])) {
                        exit;
                    }
                    echo "    <script type=\"text/javascript\">\njQuery(document).ready(function(){\n\tjQuery(\".chosen\").data(\"placeholder\",\"Select ...\").chosen();\n});\n</script>\n    ";
                    $brand = preg_replace("/[^0-9\\-a-zA-Z,]/i", "", $brand);
                    $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE `B_ID`='" . $brand . "'");
                    if (mysqli_num_rows($result)) {
                        if ($config["quick_checkout"] == 3) {
                            $models .= "<select name=\"model_id\"  class=\"form-control\"  onchange=\"getServiceList('#countrydropdown',this.value,document.getElementById('brand').value,'#countryload');\">";
                        } else {
                            if ($_SESSION["quickwidget"] == "brand") {
                                $models .= "<select name=\"model_id\"  class=\"chosen form-control\" \nonchange=\"getContect('#servicelist','custom-widget/getModelsList.php?brand=" . $brand . "&model='+this.value,'#servicelist',true,'#loader');\n\">";
                            } else {
                                $models .= "<select name=\"model_id\"  \nonchange=\"getServiceList('#servicedropdown',this.value,document.getElementById('brand').value,'#serviceload');\">";
                            }
                        }
                        $models .= "<option value=\"\">-" . $lng_languag["selectmodel"] . "-</option>";
                        while ($data = mysqli_fetch_assoc($result)) {
                            $models .= "<option value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
                        }
                        $models .= "</select>";
                    } else {
                        $models = $lng_languag["not"] . " " . $lng_languag["found"];
                    }
                    echo $models;
                }
            }
        }
    }
}

?>