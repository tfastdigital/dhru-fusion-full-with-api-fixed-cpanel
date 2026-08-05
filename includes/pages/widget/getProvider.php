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
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$cid = preg_replace("/[^0-9]/i", "", $cid);
$data = mysqli_fetch_assoc(dquery("SELECT `assigned_provider`,`listing`\n FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
if ($data["assigned_provider"]) {
    $WHERE = " AND `ID` IN (" . $data["assigned_provider"] . ")";
} else {
    $WHERE = "";
}
if ($serviceid) {
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $cid . "' AND \n    `api`='" . $data["listing"] . "' " . $WHERE);
} else {
    $result = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $cid . "'");
}
echo "<script type=\"text/javascript\">\n    jQuery(document).ready(function(){\n    \tjQuery(\".chosen\").data(\"placeholder\",\"Select Service...\").chosen();        \n    }); \n</script>\n";
$models = "<select name=\"provider_id\" class=\"form-control\" >\n    <option value=\"\">" . $lng_languag["select"] . "</option>";
while ($data = mysqli_fetch_assoc($result)) {
    if (isset($_SESSION["wprovider"]) && $_SESSION["wprovider"] == $data["ID"]) {
        $select = "selected='selected'";
    } else {
        $select = "";
    }
    $models .= "<option " . $select . " value=\"" . $data["ID"] . "\">" . $data["Name"] . "</option>";
}
$models .= "</select>";
echo $models;

?>