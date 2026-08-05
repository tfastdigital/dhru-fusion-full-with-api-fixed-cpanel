<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$i = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $i);
chkMd5sumsubpage();
echo "<div style=\" position: fixed;\r\n    left: 50%;\r\n    top: 50%;\r\n    background-color: white;\r\n    z-index: 100;\r\n    height: 800px;\r\n    margin-top: -200px;\r\n    margin-left: -300px;\r\n    width: 600px;\">\r\n";
if (mysqli_num_rows(dquery("select * from tbl_massmail where md5(id)='" . $i . "'"))) {
    $mass = mysqli_fetch_assoc(dquery("select * from \r\n    tbl_massmail where md5(id)='" . $i . "'"));
    echo str_replace("view mail in browser", "", $mass["message"]);
}
echo "</div>";
class no
{
}

?>