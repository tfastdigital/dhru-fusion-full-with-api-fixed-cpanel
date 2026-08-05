<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 430;
checkPagePermission($pageid);
if (isset($save)) {
    checkDemoMode(false);
    if ($value && $setting) {
        $data["value"] = $value;
        $data["setting"] = $setting;
        $data["trackingurl"] = $trackingurl;
        $data["gateway"] = "custom";
        $db->insert("tbl_shipping_services", $data);
        echo "<div id=notification1 class=successbox> " . $LNG["datasavesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
if ($id && $gat) {
    dquery("UPDATE tbl_shipping_services SET status=IF(status=0,1,0) WHERE md5(gateway)='" . $gat . "' AND md5(value)='" . $id . "'");
}
if ($delete) {
    dquery("delete from tbl_shipping_services where id='" . $delete . "'");
    echo "<div id=notification1 class=successbox> " . $LNG["gateway"] . " " . $LNG["remove"] . " " . $LNG["successfully"] . "</div>";
}
echo "\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\" >\n            <form method=\"post\" name=\"\" id=\"frmcst\">\n                <input type=\"hidden\" name=\"laoddefaultpage\" value=\"shippingatewaycustom.php\" />\n                <input type=\"hidden\" name=\"gateway\" value=\"";
echo $data["gateway"];
echo "\" />\n                ";
echo generate_token("form");
echo "\n\n                <table id=\"main_tbl\" ><thead><tr>";
echo "<th>" . $LNG["custom"] . " " . $LNG["gateway"] . " " . $LNG["service"] . "</th>";
echo "<th>" . $LNG["delivery"] . " " . $LNG["time"] . "</th>";
echo "<th>" . $LNG["status"] . "</th>";
echo "<th ><div align='right'> " . $LNG["action"] . " </div> </th>";
echo "</tr></thead><tbody>                <tr class=\"\">\n                    <td><input type=\"text\" name=\"value\" /></td>\n                    <td><input type=\"text\" name=\"deliverytime\" /></td>\n                    <td></td>\n                    <td align=\"right\"><input value=\"+ ";
echo $LNG["add"];
echo "\" class=\"btn\" type=\"button\" id=\"btnedituser1\" name=\"save\"\n                                             onclick=\"SubmitForm ('#btnedituser1','shippingatewaycustom','#frmcst','#notification','true','#main_loader','main2.php?page=shippingatewaycustom');\"   /></td></tr>\n                ";
$req1 = dquery("SELECT `id`,`value`,`deliverytime`,`status`,`gateway` FROM `tbl_shipping_services` WHERE `gateway`='custom'");
while ($data1 = mysqli_fetch_assoc($req1)) {
    echo "<tr>";
    echo "<td>" . $data1["value"] . "</td>";
    echo "<td>" . $data1["deliverytime"] . "</td>";
    if ($data1["status"]) {
        $string = "<span class='textgreen'>" . $LNG["active"] . "</span>";
    } else {
        $string = "<span class='textred'>" . $LNG["inactive"] . "</span>";
    }
    echo "<td align='right' ><a class='default_dg_a2' href=\"javascript:reloadcurrent('shippingateway','" . md5($data1["value"]) . "&gat=" . md5($data1["gateway"]) . "')\"> " . $string . " </a></td>";
    echo "<td align='right' class='action'><a class='default_dg_a2 editdata'\n        href=\"javascript: void(0)\"  \nonclick=\"javascript:load_subpage('main2.php?page=editcustomgateway&id=" . $data1["id"] . "', '" . $LNG["edit"] . "');    return false;\">\n " . $LNG["edit"] . " </a>\n \n <a class='default_dg_a2 deletedata'\n        href=\"javascript: void(0)\"  \nonclick=\"javascript: \nif(confirm('Are you sure want to remove Gateway?')){\n    redirectedit('shippingateway&laoddefaultpage=shippingatewaycustom.php&delete=" . $data1["id"] . "', '" . $LNG["delete"] . "');\n}\n\">\n " . $LNG["delete"] . " </a>\n </td>";
    echo "</tr>";
}
echo "</tbody></table><br />            </form>\n        </div></div>\n";
$fileverioncheck = "6.1.0";

?>