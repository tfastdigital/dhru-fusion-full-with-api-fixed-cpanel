<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n    ";
$WHERES = " and userid='" . $uid . "'";
echo "\n\n    <div id=\"content\">\n        <div id=\"content_padded\">\n\n            <form id=\"newimeiorder\" name=\"\" method=\"post\">\n                <table id=\"main_tbl\" >\n                    <thead>\n                    <tr>\n                        <th>";
echo $LNG["name"];
echo "</th>\n                        <th>Date</th>\n                        <th>IMEI</th>\n                        <th>";
echo $LNG["status"];
echo "</th>\n                        <th>";
echo $LNG["user"];
echo "</th>\n                        <th>";
echo $LNG["action"];
echo "</th>\n                    </tr>\n                    </thead>\n                    <tbody>\n\n                    <tr class=\"\">\n                        ";
if ($delete && $id) {
    dquery("DELETE FROM tbl_pos_terminal WHERE `posterminalid`='" . $id . "' " . $WHERES);
}
$sql = dquery("SELECT *,(select username from tblUsers where id=userid) as user FROM tbl_pos_terminal where 1=1 " . $WHERES . " order by posterminalid");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                    <tr>\n                        <td>";
    echo $row["devicename"];
    echo "</td>\n                        <td>";
    echo $row["date"];
    echo "</td>\n                        <td>";
    echo $row["serialno"];
    echo "</td>\n                        <td>";
    echo $row["devicestatus"] ? "Active" : "In-Active";
    echo "</td>\n                        <td>";
    echo $row["user"];
    echo "</td>\n                        <td>\n<span title=\"edit\"><input class=\"button editdata\" title=\"edit\" type=\"button\"\n                          onclick=\"javascript:load_subpage('main2.php?page=editposdevice&id=";
    echo $row["posterminalid"];
    echo "','Edit POS Terminal')\" value=\"";
    echo $LNG["edit"];
    echo "\" /></span>\n                        </td>\n                    </tr>\n                    ";
}
echo "\n                    </tbody></table>\n            </form>\n\n\n\n        </div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>