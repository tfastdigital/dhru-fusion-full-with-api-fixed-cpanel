<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " ";
include_once ROOTDIR . "/includes/features.fun.php";
echo " \n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\">\n<input type=\"hidden\" value=\"productfeaturelist.php\" name=\"defaultpageload\"/>\n<select name=\"mastergroup\">\n        ";
$sql = dquery("select group_name,id from tbl_product_group where mid='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    if ($mastergroup == $row["id"]) {
        $selected = "selected='selected'";
    } else {
        $selected = "";
    }
    echo "<option value='" . $row["id"] . "' " . $selected . " >" . $row["group_name"] . "</option>";
}
echo " </select>   \n &nbsp;<input type=\"submit\" name=\"list\" value=\"";
echo $LNG["list"] . " " . $LNG["features"];
echo "\" /> \n </form>\n";
if (!$mastergroup) {
    $mastergroup = "";
}
$row = getFeatures("features", $mastergroup, "");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\"><tbody>\n \n";
if ($row) {
    foreach ($row as $key => $value) {
        $id = $value["id"];
        $grp = mysqli_fetch_assoc(dquery("select group_id from tbl_features where id='" . $id . "'"));
        $sql = mysqli_fetch_assoc(dquery("select group_name from tbl_product_group where id='" . $grp["group_id"] . "'"));
        echo "    <tr><td width=\"20%\" class=\"fieldlabel\" ><strong>";
        echo $value["name"];
        echo "</strong></td>\n    <td class=\"fieldarea\" >";
        echo $sql["group_name"];
        echo "</td>\n    <td class=\"fieldarea\" >";
        echo $value["description"];
        echo "</td></tr>\n    ";
    }
}
echo "</tbody>\n</table>\n<dir style=\"clear: both;\"></dir>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>