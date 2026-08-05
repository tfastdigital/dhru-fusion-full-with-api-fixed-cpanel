<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo " \n<div id=\"content\">\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo " \n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n";
$sql = mysqli_fetch_assoc(dquery("select * from tbl_private_order\n where id='" . $id . "'"));
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n  ";
if ($sql["date"]) {
    echo $sql["date"];
} else {
    $e = mysqli_fetch_assoc(dquery("select date from \n    tbl_order_imei where ebay='" . $sql["id"] . "'"));
    echo $e["date"];
}
echo "    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["select_"];
echo " ";
echo $LNG["service"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n    <select name=\"sid\">\n    ";
$gr = dquery("select * from tbl_imei_group order by display_order");
while ($gt = mysqli_fetch_assoc($gr)) {
    echo "   <optgroup   label=\"";
    echo $gt["group_name"];
    echo "\">\n    ";
    $s = dquery("select id,service_name from tbl_services_imei where active='1' and\n             group_id='" . $gt["id"] . "' ORDER by sort");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "<option   ";
        if ($r["id"] == $sql["sid"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["service_name"];
        echo "</option>\n            ";
    }
    echo "    </optgroup>\n    ";
}
echo "    </select>\n    </span>\n     </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["client"];
echo " ";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\"  class=\"txt medium\" name=\"email\" value=\"";
echo $sql["email"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["quantity"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\"  class=\"txt small\" name=\"qnt\" value=\"";
echo $sql["qnt"];
echo "\" />\n    </span></td>\n</tr>\n </tbody>\n</table>\n \n <div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo " \" id=\"btnoverview\" class=\"btn save\" type=\"button\"  \nonclick=\"SubmitForm ('#btnoverview','editebayorder','#frm','#notification','true','#main_loader');\"/>\n </div>\n\n</form>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>