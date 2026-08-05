<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 425;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo " <table cellspacing=\"5\"  id=\"main_tbl\">\n       <thead><th>";
echo $LNG["username"];
echo "</th><th><div align=\"center\">";
echo $LNG["login"];
echo " ";
echo $LNG["time"];
echo "</div></th><th><div align=\"right\">";
echo $LNG["login"];
echo " ";
echo $LNG["ip"];
echo "</div></th></thead>                        \n";
$result = dquery("SELECT * FROM `tbl_supplier_log` ORDER BY `tbl_supplier_log`.`time` DESC LIMIT 0 , 30");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["username"] . "</td><td align=center>";
        echo date("Y-m-d h:i:s", $row["time"]);
        echo "</td><td align=right>\n        <a href='javascript: load_subpage(\"" . $config["ip_location"] . $row["ip"] . "\",\"" . $LNG["ip"] . " " . $LNG["location"] . "\")>" . $row["ip"] . "</a></td></tr>";
    }
}
echo "\n</tbody></table>\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>