<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>.form {margin-bottom: 4px !important;}\n</style>\n";
$pageid = 196;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($id);
include_once DATAGRID_DIR . "comm.php";
echo "<div id=\"notification\"></div>\n<div id=\"content\"> \n<div id=\"content_padded\">\n";
if ($SUPPLIERSP) {
    echo "<table class=\"form\" border=\"0\">\n<tbody>\n   <tr>\n     <td class=\"fieldarea\" ><span style=\"background: #A4CC8A;padding:10px;color:white\"><strong>+</strong> ";
    echo $LNG["positive"];
    echo " ";
    echo $LNG["feedback"];
    echo ": ";
    echo $clientDetails["success"];
    echo "</span> </td>  \n     <td class=\"fieldarea\" align=\"right\"><span style=\"background: #F0AA65;padding:10px;color:white\"><strong>-</strong> ";
    echo $LNG["negative"];
    echo " ";
    echo $LNG["feedback"];
    echo ": ";
    echo $clientDetails["reject"];
    echo "</span> </td>\n   </tr> \n</tbody>\n</table>\n";
}
echo "<br />\n<div style=\"clear: both;\"></div>\n \n \n \n \n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
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
echo "</div>\n \n\n</div></div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>