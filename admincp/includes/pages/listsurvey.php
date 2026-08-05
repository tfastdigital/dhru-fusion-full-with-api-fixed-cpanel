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
echo "  \n<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<div id=\"notification\"></div>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($del) {
    dquery("delete from tbl_survey where id='" . $del . "'");
}
echo "\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n        <th>";
echo $LNG["id"];
echo "</th>\n        <th>";
echo $LNG["title"];
echo " </th>\n        <th>";
echo $LNG["status"];
echo " </th>\n        <th>";
echo $LNG["survey"];
echo " </th>\n        <th>";
echo $LNG["action"];
echo "</th>\n\n  </tr>\n</thead>  \n<tbody>  \n";
$bann = dquery("SELECT * FROM tbl_survey");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "        <tr>\n        <td>";
    echo $row["id"];
    echo "</td>\n        <td>";
    echo $row["title"];
    echo "</td> \n        <td>";
    echo $row["statut"] ? "Completed" : "Pending";
    echo " </td>\n        <td>\n        ";
    echo mysqli_num_rows(dquery("select id from tbl_survey_detail where srid='" . $row["id"] . "'"));
    echo "        </td>\n        <td>\n        \n  <a class='default_dg_a2' \nhref=\"javascript: load_subpage('main2.php?page=viewopinion&id=";
    echo $row["id"];
    echo "','View Survey Opinion')\">\n";
    echo $LNG["view"];
    echo " ";
    echo $LNG["opinion"];
    echo "</a>    \n&nbsp;\n  <a class='default_dg_a2' \nhref=\"javascript: load_subpage('main2.php?page=viewsurveyreport&id=";
    echo $row["id"];
    echo "','View Survey Report')\">\n";
    echo $LNG["view"];
    echo " ";
    echo $LNG["report"];
    echo "</a>    \n&nbsp;  <a class='default_dg_a2 editdata' href=\"javascript: load_subpage('main2.php?page=editsurvey&id=";
    echo $row["id"];
    echo "','Edit Survey')\">";
    echo $LNG["edit"];
    echo "</a>\n  <a class='default_dg_a2 deletedata' onclick='return confirm(\"Are you sure want to remove ?\");' href=\"javascript: redirectedit('survey','&laoddefaultpage=listsurvey.php&del=";
    echo $row["id"];
    echo "')\">\n";
    echo $LNG["delete"];
    echo "</a>      \n        </td> \n    </tr>\n";
}
echo "</tbody></table>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>