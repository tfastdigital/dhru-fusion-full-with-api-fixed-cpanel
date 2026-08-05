<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include "../../../comm.php";
$sql = dquery("select * from tbl_admin where `online`='1'");
echo "<fieldset style=\"border: #c4c4c4 solid 1px; width: 190px; margin: auto; padding: 10px;  color: #666 !important;\">\n            <legend>Online Staff</legend>\n            <div style=\"font-size: 12px !important; color: #666 !important;\">";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<li style='list-style-type: square !important;color:green;clear:both'><span style='color:#666;margin-left:-5px;margin-top:1px'>" . $row["username"] . "</span></li>";
}
echo " </div>\n        </fieldset>";
$fileverioncheck = "6.1.0";

?>