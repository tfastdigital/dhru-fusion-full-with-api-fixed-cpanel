<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Reseller Store</a></li>\n</ul>\n";
$pageid = 338;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo " <table cellspacing=\"5\"  id=\"main_tbl\">\n<thead><th>";
echo $LNG["id"];
echo "</th><th>";
echo $LNG["username"];
echo "</th>\n<th>";
echo $LNG["domain"];
echo "</th><th>";
echo $LNG["company"];
echo " ";
echo $LNG["name"];
echo "</th>\n<th><div>";
echo $LNG["fund"];
echo " ";
echo $LNG["history"];
echo "</div></th>\n<th><div>";
echo $LNG["earnings"];
echo "</div></th>\n<th><div align=\"right\">";
echo $LNG["template"];
echo "</div></th>\n</thead>\n<tbody>                        \n";
$result = dquery("SELECT distinct uid,(select username from tblUsers where id=uid) as reseller,value from tbl_store_config where attribute='domain'");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $template = mysqli_fetch_assoc(dquery("SELECT value from tbl_store_config where attribute='template' and uid=" . $row["uid"]));
        $templatename = explode("_", $template["value"]);
        $companyname = mysqli_fetch_assoc(dquery("SELECT value from tbl_store_config where attribute='companyname' and uid=" . $row["uid"]));
        echo "<tr><td>" . $row["uid"] . "</td>\n        <td><a class=default_dg_a2  href=javascript:load_fromsubpage('edituser&id=" . $row["uid"] . "','" . $row["reseller"] . "')>" . $row["reseller"] . "</a></td>\n        <td>" . $row["value"] . "</td>\n        <td>" . $companyname["value"] . "</td>\n        <td>";
        echo "        <a href=\"javascript: load_subpage('main2.php?page=fundhistory&id=";
        echo $row["uid"];
        echo "','Store Fund History');\">";
        echo $LNG["view"];
        echo " ";
        echo $LNG["fund"];
        echo "</a>\n        </td><td><a href=\"javascript: load_subpage('main2.php?page=earnings&id=";
        echo $row["uid"];
        echo "','Resellers Orders');\">\n";
        echo $LNG["view"];
        echo " ";
        echo $LNG["orders"];
        echo "</a>\n        ";
        echo "</td><td align=right>" . $templatename[1] . "</td></tr>";
    }
}
echo "</tbody></table>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>