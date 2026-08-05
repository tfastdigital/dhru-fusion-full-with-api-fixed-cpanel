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
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$sh = mysqli_fetch_assoc(dquery("select relid from tbl_invoiceitems where invoiceid='" . $id . "'"));
$sh = mysqli_fetch_assoc(dquery("select sh_firstname,sh_lastname,sh_address1,sh_address2,sh_city,sh_zip,sh_state\n\t,sh_country from tbl_order_product where order_id='" . $sh["relid"] . "'"));
require "../../includes/3rdparty/GoogleMapAPI.class.php";
$map = new GoogleMapAPI("map");
$map->setAPIKey($config["googlelanguageapi"]);
$map->addMarkerByAddress($sh["sh_address1"] . " " . $sh["sh_address2"] . " " . $sh["sh_city"] . "  " . $sh["sh_zip"] . "\n    " . $sh["sh_state"] . " " . $sh["sh_country"] . " ", $sh["first_name"] . " " . $sh["last_name"], "<b>" . $sh["first_name"] . " " . $sh["last_name"] . "</b>");
echo "    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n    <html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\">\n    <head>\n    ";
$map->printHeaderJS();
echo "    ";
$map->printMapJS();
echo "    <style type=\"text/css\">\n      v\\:* {\n        behavior:url(#default#VML);\n      }\n    </style>\n    </head>\n    <body onload=\"onLoad()\">\n    <table border=1>\n    <tr><td>\n    ";
$map->printMap();
echo "    </td></tr>\n    </table>\n    </body>\n    </html>\n";
$fileverioncheck = "6.1.0";

?>