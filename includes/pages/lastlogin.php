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
require_once "comm.php";
require_once "includes/fun.inc.php";
require_once "includes/client.area.inc.php";
include_once "includes/geo.fun.php";
$gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
if ($_SESSION["uid"]) {
    echo "<html>\n    <body>\n    <div class=\"outfit\">\n    <table width=\"99%\" class=\"data table table-bordered table-striped\">\n<tr><th width=\"30%\">IP</th><th width=\"30%\">Country</th><th width=\"40%\">Time</th></tr>  \n";
    $uid = $_SESSION["uid"];
    $sql = dquery("select * from tbl_loginlog_user where userid='" . $uid . "' order by id desc limit 20");
    while ($row = mysqli_fetch_assoc($sql)) {
        $login_country_code = ipToCountry($row["ip"]);
        $login_country = $login_country_code;
        if ($login_country) {
            $login_country_code = strtolower($login_country_code);
            $flag = "<img style='line-height:20' src='images/flags/" . $login_country_code . ".png' />";
        } else {
            $flag = "";
        }
        echo "<tr><td>";
        echo $row["ip"];
        echo "</td><td >";
        echo $login_country . " " . $flag;
        echo "</td><td align=\"center\">";
        echo date("d-m-Y H:i:s", $row["time"]);
        echo "</td></tr>\n";
    }
    echo "</table>\n</div>\n</body>\n</html>";
} else {
    header("Location: login.php");
    exit;
}
class no
{
}

?>