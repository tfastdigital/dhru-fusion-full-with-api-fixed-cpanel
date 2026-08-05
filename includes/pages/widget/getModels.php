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
$image = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $image);
$mid = preg_replace("/[^0-9]/i", "", $mid);
$bid = preg_replace("/[^0-9]/i", "", $bid);
if ($image) {
    $data = mysqli_fetch_assoc(dquery("SELECT `image_link` FROM `tbl_mobile` WHERE ID='" . $bid . "'"));
    if ($data["image_link"]) {
        list($width, $height, $type, $attr) = getimagesize("../" . $data["image_link"]);
        if (100 < $width || 130 < $height) {
            echo "<img height='130' width='100' src='" . $data[image_link] . "' />";
        } else {
            echo "<img src='" . $data[image_link] . "' />";
        }
    } else {
        echo "<div style='width:100px;height:130px;background-color:#EEEEEE; line-height:60px; border:1px solid #ccc; color: #999999;' align='center' >No Image Found</div>";
    }
} else {
    echo "<script type=\"text/javascript\">\n        jQuery(document).ready(function(){\n        \tjQuery(\".chosen\").data(\"placeholder\",\"Select Service...\").chosen();        \n        });\n    </script>\n";
    $data = mysqli_fetch_assoc(dquery("SELECT `assigned_model`,`listing` \n    FROM `tbl_services_imei` WHERE md5(id)='" . $serviceid . "'"));
    if ($data["assigned_model"]) {
        $WHERE = " AND `ID` IN (" . $data["assigned_model"] . ")";
    }
    if ($serviceid) {
        $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE `B_ID`='" . $bid . "' AND `api`='" . $data["listing"] . "' " . $WHERE);
    } else {
        $result = dquery("SELECT `ID`,`Name` FROM `tbl_mobile` WHERE `B_ID`='" . $bid . "'");
    }
    $models = "<select name=\"model_id\" class=\"form-control\" \n\tonchange=\"getModelImage(this.value,'" . $serviceid . "','#modelsimage',true,'#loader');\" ><option value=\"\">" . $lng_languag["select"] . "</option>";
    $Models = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $Models[$data["ID"]] = $data["Name"];
    }
    foreach ($Models as $ID) {
        $data["Name"] = $easytoyou_error_decompile;
        if ($mid == $ID) {
            $sel = " selected='selected'";
        } else {
            $sel = " ";
        }
        if (isset($_SESSION["wmodel"]) && $_SESSION["wmodel"] == $ID) {
            $select = "selected='selected'";
        } else {
            $select = "";
        }
        $models .= "<option value=\"" . $ID . "\" " . $sel . " >" . $data["Name"] . "</option>";
    }
    $models .= "</select>";
    echo $models;
}

?>