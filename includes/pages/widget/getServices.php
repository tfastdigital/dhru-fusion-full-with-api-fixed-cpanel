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
require ROOTDIR . "/includes/clients.fun.inc.php";
$id = preg_replace("/[^0-9]/i", "", $id);
if ($id == 1) {
    if ($servicetype == 2) {
        $result = dquery("SELECT id,service_name from tbl_services_imei where useasserver=2");
    } else {
        if ($servicetype == 1) {
            $result = dquery("SELECT id,service_name from tbl_services_imei where useasserver=1");
        } else {
            $result = dquery("SELECT id,service_name from tbl_services_imei where useasserver=0");
        }
    }
    $Srvs = "<select name=\"imei\" class=\"form-control\" ><option value=\"\">" . $lng_languag["allservices"] . "</option>";
    while ($data = mysqli_fetch_assoc($result)) {
        $Srvs .= "<option value=\"" . md5($data["id"]) . "\">" . $data["service_name"] . "</option>";
    }
    $Srvs .= "</select>";
} else {
    if ($id == 2) {
        $result = dquery("SELECT id,service_name from tbl_services_file");
        $Srvs = "<select name=\"file\"  class=\"form-control\"><option value=\"\">" . $lng_languag["allservices"] . "</option>";
        while ($data = mysqli_fetch_assoc($result)) {
            $Srvs .= "<option value=\"" . md5($data["id"]) . "\">" . $data["service_name"] . "</option>";
        }
        $Srvs .= "</select>";
    } else {
        if ($id == 3) {
            $result = dquery("SELECT id,service_name from tbl_services_imei where useasserver=1");
            $Srvs = "<select name=\"server\"  class=\"form-control\" ><option value=\"\">" . $lng_languag["allservices"] . "</option>";
            while ($data = mysqli_fetch_assoc($result)) {
                $Srvs .= "<option value=\"" . md5($data["id"]) . "\">" . $data["service_name"] . "</option>";
            }
            $Srvs .= "</select>";
        }
    }
}
echo $Srvs;

?>