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
echo "<style>\n    .progressbar{height: 5px;width: 80%;background: #f4f4f4;text-align: left;float: left;margin-top:7px}\n    .percent{background: green;height: 5px;}\n</style>\n\n";
$surv = mysqli_fetch_assoc(dquery("select * from tbl_survey where id='" . $id . "'"));
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>";
echo $surv["title"];
echo "</h2>\n<table id=\"main_tbl\">\n            <thead>\n              <tr>\n<th>";
echo $LNG["name"];
echo "</th>\n<th><div align=\"left\">";
echo $LNG["value"];
echo "</div></th>\n<th><div align=\"center\"></div></th>\n              </tr>\n            </thead>\n<tbody> \n";
$sql = dquery("select id,relid,fieldoptions,fieldname from tbl_customfields where `type`='survey_" . $surv["id"] . "'\n and (fieldtype='dropdown' OR fieldtype='radio' OR fieldtype='tickbox')");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<th colspan=\"3\" style=\"text-align: left; font-style: italic;\" >";
    echo $row["fieldname"];
    echo "</th>\n</tr>\n    ";
    $exp = explode(",", $row["fieldoptions"]);
    $total = mysqli_fetch_assoc(dquery("select count(*) as total  from tbl_customfieldsvalues where fieldid='" . $row["id"] . "'"));
    foreach ($exp as $e) {
        $q = mysqli_num_rows(dquery("select * from tbl_customfieldsvalues where fieldid='" . $row["id"] . "'\n  and (value='" . $e . "' OR value='on')"));
        $percent = 100 * $q / $total["total"];
        echo "    <tr>\n    <td></td>\n    <td>";
        echo $e;
        echo "</td>    \n    <td align=\"center\" width=\"300px\"><div class=\"progressbar\"><div class=\"percent\" style=\"width:";
        echo $percent;
        echo "%;\"></div></div> <span style=\"float:right\">";
        echo $q;
        echo " (";
        echo $total["total"];
        echo ")</span>  </td>\n    </tr>\n    ";
    }
    $total = 0;
}
echo "</tbody></table>\n\n\n</div></div> ";
$fileverioncheck = "6.1.0";

?>