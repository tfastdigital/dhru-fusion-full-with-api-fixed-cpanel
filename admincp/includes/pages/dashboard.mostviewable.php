<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<table cellspacing=\"0\" cellpadding=\"4\" id=\"main_tbl\">\n<!--\n<thead align=\"left\"><td colspan=\"7\"><strong style=\"color:#4572A7;\">";
echo $LNG["mostviewable"];
echo " ";
echo $LNG["products"];
echo "</strong></td></thead>\n-->\n<thead>\n<tr>\n<th align=\"left\">";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th>\n<th align=\"right\">";
echo $LNG["viewers"];
echo "</th></tr>\n</thead>\n";
$sql = dquery("select id,service_name,viewer \nfrom tbl_products order by viewer desc limit 5");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<td align=\"left\">";
    echo $row["service_name"];
    echo "</td>\n<td align=\"right\">";
    echo $row["viewer"];
    echo "</td></tr>\n";
}
echo " \n</table>\n";
$fileverioncheck = "6.1.0";

?>