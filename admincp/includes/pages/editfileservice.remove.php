<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 315;
checkPagePermission($pageid);
if ($delete) {
    if ($virtual) {
        dquery("UPDATE tbl_services_file set active='2' where id='" . $id . "'");
    } else {
        dquery("DELETE FROM tbl_services_file WHERE id='" . $id . "'");
        dquery("DELETE FROM tbl_file_credit WHERE service_id='" . $id . "'");
        if ($order) {
            dquery("DELETE FROM tbl_order_file WHERE service_id='" . $id . "'");
        }
        if ($group) {
            dquery("DELETE FROM tbl_client_group_price WHERE service_id='" . $id . "' AND service_type='file'");
        }
        dquery("DELETE FROM tbl_discount_file WHERE service_id='" . $id . "'");
    }
    echo "    <div id=\"notification1\" class=\"successbox\">";
    echo $LNG["remove"] . " " . $LNG["successfully"];
    echo "</div>\n    ";
}
$pending = mysqli_num_rows(dquery("select * from tbl_order_file where (user_can_c='0' or user_can_c='1' or user_can_c='5' or verified=1) and service_id='" . $id . "'"));
echo " ";
if ($pending) {
    echo "<div id=\"notification1\" class=\"alert\">";
    echo $LNG["servicependingorder"];
    echo "</div>\n";
}
echo "\n<script>\nfunction getS(){\n    if(document.getElementById('ev').checked){\n        document.getElementById('s1').style.display='none';\n        document.getElementById('s2').style.display='none';\n    }else{\n        document.getElementById('s1').style.display='';\n        document.getElementById('s2').style.display='';\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<input type=\"hidden\" value=\"editfileservice.remove.php\" name=\"defaultloadpage\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["virtual"];
echo " ";
echo $LNG["remove"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" onclick=\"getS()\" name=\"virtual\" value=\"1\" id=\"ev\" checked=\"checked\"  /> <label for=\"ev\">";
echo $LNG["soft"];
echo " ";
echo $LNG["delete"];
echo "</label>\n    <input type=\"radio\" onclick=\"getS()\" name=\"virtual\" value=\"0\" id=\"dv\" /> <label for=\"dv\">";
echo $LNG["physically"];
echo " ";
echo $LNG["remove"];
echo "</label>\n    </td>\n</tr>\n<tr id=\"s1\" style=\"display: none;\">\n    <td class=\"fieldlabel\">";
echo $LNG["remove"];
echo " ";
echo $LNG["orders"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"order\" value=\"1\" /></td>\n</tr>\n\n<tr id=\"s2\" style=\"display: none;\">\n    <td class=\"fieldlabel\">";
echo $LNG["remove"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["clientgroup"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"group\" value=\"1\" /></td>\n</tr>\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["remove"];
echo "\" id=\"btnoverview\" name=\"delete\" class=\"btn\" type=\"submit\"/> </p>\n</form>\n</div></div>";
$fileverioncheck = "6.1.0";

?>