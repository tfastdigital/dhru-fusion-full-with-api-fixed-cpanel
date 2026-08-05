<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<style>\n    #deshbordsub td,#deshbordsub th {border-bottom: solid #edeced 1px  ;padding: 5px;}\n</style>\n<div class=\"contentbox\">     \n";
$resultstock = dquery("select id,service_name,stock from tbl_products where stock < 5 order by stock");
if ($resultstock) {
    echo "    \n    <div class=\"data\">\n        <table class=\"list\" id=\"deshbordsub\" cellpadding=\"0\" cellspacing=\"0\">\n           <tr><th align=\"left\">Service Name</th><th align=\"left\">Stock</th></tr>  \n                ";
    while ($rowstock = mysqli_fetch_assoc($resultstock)) {
        echo "                    <tr><td class=\"label\">";
        echo $rowstock["service_name"];
        echo "</td><td>";
        echo $rowstock["stock"];
        echo "</td></tr>\n                ";
    }
}
echo "       </table> \n   </div>    \n</div>";
$fileverioncheck = "6.1.0";

?>