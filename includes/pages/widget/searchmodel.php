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
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$val = preg_replace("/[^0-9\\-a-zA-Z ]/i", "", $val);
$start = time();
$sql = dquery("select id,assigned_model from tbl_services_imei \r\nwhere retail='1' and active=1 and assigned_model!='' order\r\n by assigned_model desc");
$models = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $model = explode(",", $row["assigned_model"]);
    $models = array_unique(array_merge($models, $model));
}
$part = explode(" ", $val);
if ($part[0] && $part[1]) {
    $q = dquery("select ID,B_ID,(select tbl_model_brand.Name from tbl_model_brand\r\n     where tbl_model_brand.ID=tbl_mobile.B_ID) as brand\r\n    ,Name,api from tbl_mobile where  Name like '" . $part[1] . "%' and \r\n    (select tbl_model_brand.Name from tbl_model_brand\r\n     where tbl_model_brand.ID=tbl_mobile.B_ID) like '" . $part[0] . "%'");
} else {
    $q = dquery("select ID,B_ID,(select tbl_model_brand.Name from tbl_model_brand\r\n     where tbl_model_brand.ID=tbl_mobile.B_ID) as brand\r\n    ,Name,api from tbl_mobile where  Name like '" . $val . "%' or \r\n    (select tbl_model_brand.Name from tbl_model_brand\r\n     where tbl_model_brand.ID=tbl_mobile.B_ID) like '" . $val . "%'");
}
if (mysqli_num_rows($q)) {
    while ($r = mysqli_fetch_assoc($q)) {
        if (in_array($r["ID"], $models)) {
            if ($imei) {
                echo "<li class=\"list-group-item\" onclick=\"javascript: \r\nlocation.href='";
                echo $config["site_address"];
                echo "/cart.php?service=imei&parentid=1006&mid=";
                echo $r["ID"];
                echo "&bid=";
                echo $r["B_ID"];
                echo "&search=true';\">";
                echo $r["brand"];
                echo "-";
                echo $r["Name"];
                echo "</li>\r\n";
            } else {
                if ($config["quick_checkout"] == 3) {
                    echo "<li class=\"list-group-item\" onclick=\"javascript:setquickValue2('";
                    echo $r["ID"];
                    echo "','";
                    echo $r["B_ID"];
                    echo "',this)\">";
                    echo $r["brand"];
                    echo "-";
                    echo $r["Name"];
                    echo "</li>\r\n";
                } else {
                    if ($config["quick_checkout"] == 4) {
                        echo "<li class=\"list-group-item\" onclick=\"javascript:setquickValue('";
                        echo $r["ID"];
                        echo "','";
                        echo $r["B_ID"];
                        echo "',this)\">";
                        echo $r["brand"];
                        echo "-";
                        echo $r["Name"];
                        echo "</li>\r\n";
                    } else {
                        echo "<li class=\"list-group-item\" onclick=\"javascript:setquickValue('";
                        echo $r["ID"];
                        echo "','";
                        echo $r["B_ID"];
                        echo "',this)\">";
                        echo $r["brand"];
                        echo "-";
                        echo $r["Name"];
                        echo "</li>\r\n";
                    }
                }
            }
        }
    }
} else {
    echo " <li  class=\"list-group-item\"> ";
    echo $lng_languag["noresultfound"];
    echo "</li> \r\n    ";
}

?>