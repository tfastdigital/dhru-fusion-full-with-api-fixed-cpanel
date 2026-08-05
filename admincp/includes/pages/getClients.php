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
$sql = dquery("select username,id from tblUsers  where username like '" . $find . "%'");
echo "<h2>Client List</h2><table class=\"grid\">\n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr><td>\n<a href=\"main4.php?page=userdetail&u=";
    echo $row["id"];
    echo "\" class=\"btn\">";
    echo $row["username"];
    echo "</a>\n</td></tr>\n";
}
echo "</table>\n";

?>