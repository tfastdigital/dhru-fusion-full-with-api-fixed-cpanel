<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n \n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/exporting.js\"></script>\n \n\n\n<link href=\"templates/";
echo $_SESSION["admin_template"];
echo "/x-dashboard.css\" media=\"screen\" rel=\"stylesheet\"/>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/x-dashboard.js\"></script>\n \n\n<!--\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/Chart.min.js\"  type=\"text/javascript\"></script>\n-->\n";
if ($OnlyEcommerce) {
    include "dashboard.ecommerce.php";
} else {
    include "dashboard.all.php";
}
$fileverioncheck = "6.1.0";

?>