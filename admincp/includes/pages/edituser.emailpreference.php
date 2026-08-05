<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <div  class=\"groupstabes\">\n\n\n\n            <div class=\"groupstabescontant\">\n                ";
$result = dquery("select id,name from tbl_emailtemplates where \n    (for_reseller='1' or name='Price update notification')\n    AND ( type='imeiorder' or type='fileorder' or type='serverorder' \n    or type='imeiorder' or type='product' )");
echo "                <form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n                    <input type=\"hidden\" name=\"uid\" value=\"";
echo $id;
echo "\" />\n                    ";
echo generate_token("form");
echo "                    <table id=\"main_tbl\">\n                        <thead><tr>\n                            <th style=\"width: 40px !important;\">";
echo $LNG["active"];
echo "</th>\n\n                            <th>";
echo $LNG["template"];
echo "</th>\n                            <th></th>\n                        </thead>\n                        <tbody>\n                        ";
while ($row = mysqli_fetch_assoc($result)) {
    $checked = "checked";
    if (mysqli_num_rows(dquery("select id from tbl_disabledemail\nwhere uid='" . $id . "' and tid='" . $row["id"] . "'"))) {
        $checked = "";
    }
    echo "                            <tr>\n                                <td>\n                                    <input ";
    echo $checked;
    echo " type=\"checkbox\" name=\"tid[";
    echo $row["id"];
    echo "]\" value=\"";
    echo $row["id"];
    echo "\" />\n\n                                </td>\n\n                                <td>";
    echo $row["name"];
    echo "</td>\n                                <td></td>\n                            </tr>\n                            ";
}
echo "                        </tbody>\n                    </table>\n\n                    <p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituserip\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituserip','edituser.emailpreference','#frmedituser','#notification','true','#main_loader','main2.php?page=edituser.loginiprange','";
echo $id;
echo "');\"/>\n\n\n                    </p>\n\n                </form>\n\n\n            </div>\n";
$fileverioncheck = "6.1.0";

?>