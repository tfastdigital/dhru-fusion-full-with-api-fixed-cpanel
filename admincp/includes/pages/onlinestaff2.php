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
$norows = mysqli_num_rows($sql);
echo "\n\n    <a href=\"#collapse18\" style=\"position: relative;\" class=\"nav-link collapsed\" data-toggle=\"collapse\" >\n        <span class=\"badge badge-orange\">";
echo $norows;
echo "</span>\n        <i  class=\"nav-icon flaticon-speech-bubble\"></i>\n        <span class='nav-head'>\n            ";
echo $LNG["online"];
echo " ";
echo $LNG["staff"];
echo "        </span>\n    </a>\n\n    <ul  class=\"collapse\" data-parent=\"#accordion2\" id=\"collapse18\">\n        ";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<a class='dropdown-item' href='javascript:void(0)'>" . $row["username"] . "</a>";
}
echo "    </ul>\n\n";
$fileverioncheck = "6.1.0";

?>