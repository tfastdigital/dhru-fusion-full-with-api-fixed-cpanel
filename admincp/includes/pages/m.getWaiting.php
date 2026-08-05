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
require_once "../../../comm.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$find = $_POST["find"];
$sql = dquery("select username,id from tblUsers  where userstatus='2'");
echo "<table class=\"grid\">\n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr onclick=\"setcheck('";
    echo $row["id"];
    echo "');\" ><td><input type=\"checkbox\" value=\"";
    echo $row["id"];
    echo "\" id=\"";
    echo $row["id"];
    echo "\" name=\"ids\" /> &nbsp;&nbsp;&nbsp;";
    echo $row["username"];
    echo "</td></tr>\n";
}
echo "  \n</table>    ";

?>