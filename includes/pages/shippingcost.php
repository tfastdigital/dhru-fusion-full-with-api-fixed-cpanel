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
$_country = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_country);
$action = preg_replace("/[^0-9a-zA-Z]/i", "", $action);
$_zip = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_zip);
$_serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_serviceid);
require_once ROOTDIR . "/includes/shipping.fun.php";
if (isset($_SESSION["uid"])) {
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    global $_ClientsDetails;
}
if ($_serviceid) {
    require_once ROOTDIR . "/includes/products.fun.php";
    $pro = getProducts("", $_serviceid);
    $height = explode(" ", $pro["height"]);
    $width = explode(" ", $pro["width"]);
    $length = explode(" ", $pro["depth"]);
    $_config = ["weight" => $pro["weight"], "weight_units" => "kg", "size_length" => $length[0], "size_width" => $width[0], "size_height" => $height[0], "size_units" => "in", "from_zip" => $pro["warehousedtl"]["zip"], "from_state" => $pro["warehousedtl"]["state"], "from_country" => $pro["warehousedtl"]["country"], "to_zip" => $_zip, "to_state" => "", "to_country" => $_country, "ups_access" => $config["ups_access"], "ups_user" => $config["ups_user"], "ups_pass" => $config["ups_pass"], "ups_account" => $config["ups_account"], "usps_user" => $config["usps_user"], "fedex_account" => $config["fedex_account"], "fedex_meter" => $config["fedex_meter"]];
    $ship = new ShippingCalculator($_config);
    echo "<html>\n<head>\n<style>\n.outfit{\n    border: 1px solid #cccccc;\n    padding: 5px;\n    margin: 5px;\n}\n.bgdark{\n    background: #EEEEEE;\n    border: 1px solid #cccccc;\n}   \ninput[text],select{\n    width: 120px;\n    height: 30px;\n    font-size: 10px;\n}\n.content{\n    font-family: arial;\n    text-align: justify !important;\n\tfont-size: 11px;\n}\n.small-content{\n    font-family: arial;\n    font-size: 11px;\n}\n.curier{\n    width: 430px; \n    font-family: arial;\n    font-size: 12px;    \n}\n.curier tr td{\n    height: 40px;\n    border-bottom: 1px solid silver;\n}\n.price{\n    font-size: 12px;\n    font-weight: bold;\n}\n</style>\n</head>    \n    <body>\n    <div class=\"outfit\">\n<table width=\"50%\">\n<tr>\n<td>\n";
    if (is_file($pro["image_link"][$pro["default_image"]][0])) {
        echo "    <img src=\"";
        echo $pro["image_link"][$pro["default_image"]][0];
        echo "\" border=\"0\" />\n";
    } else {
        echo "    <img src=\"images/noimage.jpg\"  border=\"0\" width=\"200px\" height=\"300px\" />\n";
    }
    echo "</td>\n<td class=\"content\"> \n    ";
    echo $pro["short_info"];
    echo "  \t<br/><br/>\n  \t";
    echo $lng_languag["thisitemshipfrom"];
    echo " <strong>";
    echo $pro["warehousecountry"];
    echo "</strong>\n  \t<br/><br/>\n  \t<strong>";
    echo $lng_languag["shippingweight"];
    echo " =";
    echo $pro["weight"];
    echo " Kg</strong>\n</td>\n</tr>\n</table>\n    <form method=\"POST\">\n";
    $counrty = getCountriesDropDown($selected = $_country, $fieldname = "_country", false);
    echo "<table class='bgdark'><tr><td><small>" . $lng_languag["country"] . " :</small> " . $counrty . " </td><td><small>" . $lng_languag["zip"] . " :</small> <input type='text' name='_zip' value='" . $_zip . "' /> </td><td> <input type='submit' value='Show' /> </td></tr></table>";
    $result = dquery("SELECT * FROM `tbl_shipping_services` WHERE \n    `status`='1' ORDER BY gateway");
    echo "<table class='curier'>";
    while ($data = mysqli_fetch_assoc($result)) {
        if ($data["gateway"] == "custom") {
            $def = mysqli_fetch_assoc(dquery("select id from tbl_currencies where  `default`='1'"));
            $data["cost"] = convertCurrency($data["cost"], $def["id"], $_SESSION["currency"]["id"]);
            $suffix = $_SESSION["currency"]["suffix"];
            $prefix = $_SESSION["currency"]["prefix"];
            $cntry = explode(",", $data["country"]);
            if (in_array($_country, $cntry) || trim($data["country"]) == "") {
                $shippingcost = getGatewayPrice($data["id"], $_SESSION["currency"]["id"], $pro["weight"]);
                echo "<tr><td> " . $data["value"] . " </td><td align='right' class='price'>" . $prefix . " " . $shippingcost . " " . $suffix . " </td></tr>";
            }
        } else {
            $rates = $ship->calculate($data["gateway"], $data["setting"]);
            $rate = $rates[$data["gateway"]][$data["setting"]];
            if ($rate) {
                $def = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `code`='USD'"));
                if ($def["id"]) {
                    $rate = convertCurrency($rate, $def["id"], $_SESSION["currency"]["id"]);
                    $prefix = $_SESSION["currency"]["prefix"];
                    $suffix = $_SESSION["currency"]["suffix"];
                    echo "<tr><td> " . $data["value"] . " [<strong>" . strtoupper($data["gateway"]) . "</strong>] </td><td align='right' class='price'> " . $prefix . " " . $rate . " " . $suffix . "</td></tr>";
                }
            }
            $rate = $rates = "";
        }
    }
    echo "    \n        \n    </table>\n    \n    </form>\n    </div>\n    </body>\n    </html>\n\n\n";
} else {
    if ($action = "shippingdropdown") {
        unset($_SESSION["SHIPPINGID"]);
        if ($country) {
            $country = $country;
        } else {
            $country = $_SESSION["shippingcountry"];
        }
        $flag = false;
        $dropdownarr = [];
        $Shipping = [];
        $select .= "<div>\n\n<select name='currier' id='currier' class='form-control'\nonchange='javascript:cartreload(\"#cart_reload\",this.value,\$(\"#selectedgateway\").val()); setval(this.value);'>";
        $select .= "<option selected value=''>Select Shipping Service</option>";
        if (isset($country)) {
            $countrysupported = false;
            include_once ROOTDIR . "/includes/geo.fun.php";
            $gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
            $login_country_code = ipToCountry($remote_ip);
            $result = dquery("SELECT * FROM `tbl_shipping_services` WHERE `status`='1'\n         ORDER BY gateway");
            while ($data = mysqli_fetch_assoc($result)) {
                if ($data["gateway"] == "custom") {
                    if ($_SESSION["CART"]) {
                        foreach ($_SESSION["CART"] as $key => $_subtotal) {
                            if ($_subtotal["type"] == "product") {
                                $slq = mysqli_fetch_assoc(dquery("select virtual from tbl_products \n                 where id='" . $_subtotal["id"] . "'"));
                                if (!$slq["virtual"]) {
                                    $flag = true;
                                    $cntry = explode(",", $data["country"]);
                                    if (in_array($country, $cntry) || trim($data["country"]) == "") {
                                        $countrysupported = true;
                                        if (!$dropdownarr[$data["id"]]) {
                                            $dropdownarr[$data["id"]] = $data["id"];
                                            $checked = "";
                                            $countreis = explode(",", $data["country"]);
                                            if (in_array($login_country_code, $countreis)) {
                                            }
                                            $Shipping[$data["id"]] = $data[value] . " " . ($data[deliverytime] ? "(" . $data[deliverytime] . ")" : "");
                                            $select .= " <option " . $checked . "  value='" . $data["id"] . "'  > " . $data["value"] . " " . ($data[deliverytime] ? "(" . $data[deliverytime] . ")" : "") . "</option>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($_SESSION["CART"]) {
                        foreach ($_SESSION["CART"] as $key => $_subtotal) {
                            if ($_subtotal["type"] == "product") {
                                $flag = true;
                                $sl = mysqli_fetch_assoc(dquery("select height,width,depth,weight\n                                            ,warehouse_id FROM tbl_products where id='" . $_subtotal["id"] . "'"));
                                $serviceDetails = $sl;
                                $ware = mysqli_fetch_assoc(dquery("select * from `tbl_warehouse` \n                                                    where `id`='" . $sl["warehouse_id"] . "'"));
                                $serviceDetails["warehousedtl"] = $ware;
                                include_once ROOTDIR . "/includes/geo.fun.php";
                                $gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
                                $login_country_code = ipToCountry($remote_ip);
                                $height = explode(" ", $serviceDetails["height"]);
                                $width = explode(" ", $serviceDetails["width"]);
                                $length = explode(" ", $serviceDetails["depth"]);
                                $_config = ["weight" => $serviceDetails["weight"], "weight_units" => "kg", "size_length" => $length[0], "size_width" => $width[0], "size_height" => $height[0], "size_units" => "in", "from_zip" => $serviceDetails["warehousedtl"]["zip"], "from_state" => $serviceDetails["warehousedtl"]["state"], "from_country" => $serviceDetails["warehousedtl"]["country"], "to_zip" => $_SESSION["shippingzip"], "to_state" => $_SESSION["shippingstate"], "to_country" => $country, "ups_access" => $config["ups_access"], "ups_user" => $config["ups_user"], "ups_pass" => $config["ups_pass"], "ups_account" => $config["ups_account"], "usps_user" => $config["usps_user"], "fedex_account" => $config["fedex_account"], "fedex_meter" => $config["fedex_meter"]];
                                $ship = new ShippingCalculator($_config);
                                $rates = $ship->calculate($data["gateway"], $data["setting"]);
                                $rate = $rates[$data["gateway"]][$data["setting"]];
                                if ($rate) {
                                    $countrysupported = true;
                                    if (!$dropdownarr[$data["id"]]) {
                                        $dropdownarr[$data["id"]] = $data["id"];
                                        $checked = "";
                                        $countreis = explode(",", $data["country"]);
                                        if (in_array($login_country_code, $countreis)) {
                                        }
                                        $Shipping[$data["id"]] = $data[value] . " " . ($data[deliverytime] ? "(" . $data[deliverytime] . ")" : "");
                                        $select .= " <option " . $checked . "  value='" . $data["id"] . "' >" . $data["value"] . "</option>";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            include_once ROOTDIR . "/includes/geo.fun.php";
            $gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
            $login_country_code = ipToCountry($remote_ip);
            $countrysupported = true;
            $result = dquery("SELECT * FROM `tbl_shipping_services` WHERE `status`='1' ORDER BY gateway");
            while ($data = mysqli_fetch_assoc($result)) {
                $checked = "";
                $countreis = explode(",", $data["country"]);
                if (in_array($login_country_code, $countreis)) {
                }
                $Shipping[$data["id"]] = $data[value] . " " . ($data[deliverytime] ? "(" . $data[deliverytime] . ")" : "");
                $select .= " <option  " . $checked . "  value='" . $data["id"] . "' >" . $data["value"] . "</option>";
            }
        }
        $select .= "</select></div> ";
        if ($flag) {
            if ($countrysupported) {
                $selecteds = 0;
                echo "            <div>\n            ";
                foreach ($Shipping as $shipid => $shipname) {
                    $selected = "";
                    if (count($Shipping) == 1 && $selecteds == 0) {
                        $selected = "checked=\"checked\"";
                        echo "                                <script>\n\$( document ).ready(function() {\n    cartreload(\"#cart_reload\",";
                        echo $shipid;
                        echo ",\$('#selectedgateway').val()); setval(";
                        echo $shipid;
                        echo ");\n});\n                                </script>\n                                ";
                    }
                    $icon = "";
                    if (dContain($shipname, "fedex")) {
                        $icon = "<i class=\"fab text-lg fa-fedex\"></i>";
                    } else {
                        if (dContain($shipname, "dhl")) {
                            $icon = "<i class=\"fab text-lg fa-dhl\"></i>";
                        } else {
                            if (dContain($shipname, "usps")) {
                                $icon = "<i class=\"fab text-lg fa-usps\"></i>";
                            } else {
                                if (dContain($shipname, "ups")) {
                                    $icon = "<i class=\"fab text-lg fa-ups\"></i>";
                                } else {
                                    $icon = "<i class=\" text-lg fal fa-truck-container\"></i>";
                                }
                            }
                        }
                    }
                    echo "                       <div class=\"custom-control custom-radio\">\n                           <input type=\"radio\" ";
                    echo $selected;
                    echo "                                  onclick='javascript:cartreload(\"#cart_reload\",";
                    echo $shipid;
                    echo ",\$(\"#selectedgateway\").val()); setval(";
                    echo $shipid;
                    echo ");'\n\n                                  id=\"customRadio";
                    echo $shipid;
                    echo "\" name=\"curriers\" value=\"";
                    echo $shipid;
                    echo "\" class=\"custom-control-input\">\n                           <label class=\"custom-control-label align-items-center d-flex\" for=\"customRadio";
                    echo $shipid;
                    echo "\">\n                               ";
                    echo $icon;
                    echo "                               ";
                    echo $shipname;
                    echo "</label>\n                       </div>\n                       ";
                }
                echo "            </div>\n                ";
            } else {
                echo "<div  class='alert1 alert alert-danger'>" . $lng_languag["wecantship"] . "</div>";
            }
        }
    }
}
chkMd5sumsubpage();

?>