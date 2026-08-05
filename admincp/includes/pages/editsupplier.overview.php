<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 196;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($id);
include_once DATAGRID_DIR . "comm.php";
echo "<script>\n\$( document ).ready(function() {     \n    \$('#mail-server input[type=\"radio\"]').click(function(){\n        \$('.groupstabes').removeClass('active');        \n        \$('#'+\$(this).val()).addClass('active');\n    })                \n});\n</script>\n<style>\n    .groupstabes{display: none;}\n    .groupstabes.active{display: block;}\n</style>\n\n<div id=\"notification\"></div>\n<div id=\"content\"> \n<div id=\"content_padded\">\n \n<div id=\"mail-server\">\n<input type=\"radio\" name=\"ds\" checked=\"\" value=\"s1\" checked=\"\"/> <label>";
echo $LNG["imeiallowedservice"];
echo "</label>\n<input type=\"radio\" name=\"ds\" value=\"s2\"/> <label>";
echo $LNG["fileallowedservice"];
echo "</label>\n\n<input type=\"radio\" name=\"ds\" value=\"s5\"/> <label>";
echo $LNG["serverallowedservice"];
echo " (";
echo $LNG["api"];
echo " ";
echo $LNG["support"];
echo ")</label>\n\n<input type=\"radio\" name=\"ds\" value=\"s3\"/> <label>";
echo $LNG["serverallowedservice"];
echo "</label>\n<input type=\"radio\" name=\"ds\" value=\"s6\"/> <label>";
echo $LNG["remote"] . " " . $LNG["service"];
echo "</label>\n<input type=\"radio\" name=\"ds\" value=\"s4\"/> <label>";
echo $LNG["shop"];
echo " ";
echo $LNG["services"];
echo "</label>\n</div>\n <br />\n";
if (!$IsFileOnly && !$OnlyEcommerce) {
    echo "<div  id=\"s1\" class=\"groupstabes active\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["imeiallowedservice"];
    echo "</span> \n  </h2>\n  <div class=\"groupstabescontant\">\n  \n";
    if ($clientDetails["imei_service_access"]) {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<thead><tr><th>";
        echo $LNG["service"];
        echo "</th>\n<th>";
        echo $LNG["order"];
        echo "</th></tr></thead>\n<tbody>\n";
        $imeiarr = explode(",", $clientDetails["imei_services"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_services_imei` WHERE `id`='" . $arr . "' and useasserver=0"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_imei where reply_by_sup='" . $id . "' and user_can_c='4' and `server`=0 and service_id='" . $arr . "'"));
            if ($service["service_name"]) {
                echo "    <tr><td>";
                echo $service["service_name"];
                echo "</td><td>";
                echo $cnt["cnt"];
                echo "</td></tr>\n    ";
            }
        }
        echo "</tbody></table>\n";
    } else {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["imei"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n</tbody></table>\n";
    }
    echo "</div></div>\n";
}
echo "\n";
if (!$OnlyEcommerce) {
    echo "<div  id=\"s2\" class=\"groupstabes\">\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["fileallowedservice"];
    echo "</span> \n  </h2>\n  <div class=\"groupstabescontant\">\n  \n";
    if ($clientDetails["file_service_access"]) {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<thead><tr><th>";
        echo $LNG["service"];
        echo "</th>\n<th>";
        echo $LNG["order"];
        echo "</th></tr></thead>\n<tbody>\n";
        $imeiarr = explode(",", $clientDetails["file_services"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_services_file` WHERE `id`='" . $arr . "'"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_file where reply_by_sup='" . $id . "' and user_can_c='4' and service_id='" . $arr . "'"));
            echo "     <tr><td>";
            echo $service["service_name"];
            echo "</td><td>";
            echo $cnt["cnt"];
            echo "</td></tr>\n    ";
        }
        echo "</tbody></table>\n";
    } else {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["file"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n</tbody></table>\n";
    }
    echo "</div></div>\n";
}
if (!$IsFileOnly && !$OnlyEcommerce) {
    echo "<div  id=\"s5\" class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["serverallowedservice"];
    echo "</span> \n  </h2>\n  <div class=\"groupstabescontant\">\n\n";
    if ($clientDetails["server_log_access"]) {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<thead><tr><th>";
        echo $LNG["service"];
        echo "</th>\n<th>";
        echo $LNG["order"];
        echo "</th></tr></thead>\n<tbody>\n";
        $imeiarr = explode(",", $clientDetails["server_logs"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_services_imei` WHERE `id`='" . $arr . "' and useasserver=1"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_imei where reply_by_sup='" . $id . "' and user_can_c='4' and service_id='" . $arr . "'\n        and  `server`='1'"));
            if ($service["service_name"]) {
                echo "    <tr><td>";
                echo $service["service_name"];
                echo "</td><td>";
                echo $cnt["cnt"];
                echo "</td></tr>\n    ";
            }
        }
        echo "</tbody></table>\n";
    } else {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["server"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n</tbody></table>\n";
    }
    echo "</div></div>\n\n\n    <div  id=\"s6\" class=\"groupstabes\" >\n        <h2>\n            <span class=\"groupstabesheadertext\">";
    echo $LNG["remote"] . " " . $LNG["service"];
    echo "</span>\n        </h2>\n        <div class=\"groupstabescontant\">\n\n            ";
    if ($clientDetails["remote_service_access"]) {
        echo "                <table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                    <thead><tr><th>";
        echo $LNG["service"];
        echo "</th>\n                        <th>";
        echo $LNG["order"];
        echo "</th></tr></thead>\n                    <tbody>\n                    ";
        $imeiarr = explode(",", $clientDetails["remote_services"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_services_imei` WHERE `id`='" . $arr . "' and useasserver=2"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_imei where reply_by_sup='" . $id . "' and user_can_c='4' and service_id='" . $arr . "'\n        and  `server`='2'"));
            if ($service["service_name"]) {
                echo "                            <tr><td>";
                echo $service["service_name"];
                echo "</td><td>";
                echo $cnt["cnt"];
                echo "</td></tr>\n                            ";
            }
        }
        echo "                    </tbody></table>\n                ";
    } else {
        echo "                <table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                    <tbody>\n                    <tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["remote"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n                    </tbody></table>\n                ";
    }
    echo "        </div></div>\n";
}
if (!$IsFileOnly && !$OnlyEcommerce) {
    echo "<div  id=\"s3\" class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["serverallowedservice"];
    echo "</span> \n  </h2>\n  <div class=\"groupstabescontant\">\n\n";
    if ($clientDetails["server_log_access"]) {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<thead><tr><th>";
        echo $LNG["service"];
        echo "</th>\n<th>";
        echo $LNG["order"];
        echo "</th></tr></thead>\n<tbody>\n";
        $imeiarr = explode(",", $clientDetails["newserver_services"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_server_log` WHERE `id`='" . $arr . "'"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_server where reply_by_sup='" . $id . "' and user_can_c='4' and service_id='" . $arr . "'"));
            echo "    <tr><td>";
            echo $service["service_name"];
            echo "</td><td>";
            echo $cnt["cnt"];
            echo "</td></tr>\n    ";
        }
        echo "</tbody></table>\n";
    } else {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["server"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n</tbody></table>\n";
    }
    echo "</div></div>\n\n";
}
if ($SUPPLIERSP && !$IsFileOnly) {
    echo "<div  id=\"s4\" class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["services"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n";
    if ($clientDetails["shop_service_access"]) {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tr><td>";
        echo $LNG["service"];
        echo "</td>\n<td>";
        echo $LNG["order"];
        echo "</td></tr>\n<tbody>\n";
        $imeiarr = explode(",", $clientDetails["shop_services"]);
        foreach ($imeiarr as $arr) {
            $service = mysqli_fetch_assoc(dquery("SELECT `service_name` FROM `tbl_products` WHERE `id`='" . $arr . "'"));
            $cnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt from tbl_order_product  where reply_by_sup='" . $id . "' and user_can_c='4' and service_id='" . $arr . "'"));
            echo "     <tr><td>";
            echo $service["service_name"];
            echo "</td><td>";
            echo $cnt["cnt"];
            echo "</td></tr>\n    ";
        }
        echo "</tbody></table>\n";
    } else {
        echo "<table id=\"main_tbl\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" colspan=\"2\" style=\"text-align: center;\">";
        echo $LNG["shop"];
        echo " ";
        echo $LNG["servicedisabled"];
        echo "</td></tr>\n</tbody></table>\n";
    }
    echo "</div>\n";
}
echo "\n</div></div>\n</div>\n\n<div class=\"fixedbtn\">\n    ";
if ($SUPPLIERSP) {
    echo "<span><strong>+</strong> ";
    echo $LNG["positive"];
    echo " ";
    echo $LNG["feedback"];
    echo ": ";
    echo $clientDetails["success"];
    echo "</span> &nbsp;&nbsp;&nbsp;  \n<strong>-</strong> ";
    echo $LNG["negative"];
    echo " ";
    echo $LNG["feedback"];
    echo ": ";
    echo $clientDetails["reject"];
    echo "</span>\n   \n</tbody>\n</table>\n";
}
echo "</div>\n\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Clients---Suppliers/?aid=29&pid=1&cid=5#suppliers\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>