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
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$sql = dquery("select * from tbl_admin where `online`='1'");
echo "<fieldset style=\"border: none;color: #666 !important;font-weight:bold;\">\n            <legend style=\"color:#888\">Online Staff</legend>\n            <div style=\"font-size: 12px !important; color: #666 !important;\">";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<li style='list-style-type: square !important;color:green;clear:both;background:none'><span style='color:#666;margin-left:-5px;margin-top:1px'>" . $row["username"] . "</span></li>";
}
echo " </div>\n        </fieldset>";
$fileverioncheck = "6.1.0";

?>