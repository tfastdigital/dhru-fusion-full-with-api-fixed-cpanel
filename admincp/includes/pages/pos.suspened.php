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
require_once "../../../includes/fun.inc.php";
require_once "../../../includes/clients.fun.inc.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n\n<link rel=\"stylesheet\" href=\"../../templates/pos/x-main2.css\" />\n<script>\nfunction Unsuspended(val){\n    window.opener.setSuspended(val);\n    window.close();\n}\n</script>\n</head>\n<body>\n<div id=\"tabcontent1\"> \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>Suspended Sales</h2>\n<hr />\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" id=\"main_tbl\">\n<thead>\n<th>";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["customer"];
echo "</th>\n<th>";
echo $LNG["items"];
echo "</th>\n<th>&nbsp;</th>\n</thead>\n<tbody>\n";
$sql = dquery("select * from tbl_suspended_sale");
while ($row = mysqli_fetch_assoc($sql)) {
    $customer = mysqli_fetch_assoc(dquery("select username from tblUsers where id='" . $row["cid"] . "'"));
    $pro = explode(",", $row["pid"]);
    $pd = "";
    foreach ($pro as $p) {
        $s = mysqli_fetch_assoc(dquery("select service_name from tbl_products where\n        id='" . $p . "'"));
        $pd = $pd . $s["service_name"] . "<br />";
    }
    echo "    \n <tr>\n    <td>";
    echo $row["date"];
    echo " </td>\n    <td> ";
    echo $customer["username"];
    echo "</td>\n    <td> ";
    echo $pd;
    echo "</td>\n    <td> <input type=\"button\" name=\"unspe[";
    echo $row["id"];
    echo "]\" value=\"Unsuspended\" \n    onclick=\"Unsuspended(";
    echo $row["id"];
    echo ");\" /></td>\n  </tr>  \n";
}
echo "</tbody>\n</table>\n</div>\n</div>\n</div>\n</body>\n</html>";
$fileverioncheck = "6.1.0";

?>