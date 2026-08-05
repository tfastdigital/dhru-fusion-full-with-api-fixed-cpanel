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
echo "<script>\n\$(document).ready(function() {\n        MgetInvoices ('";
echo $u;
echo "','#userlists','false','');\n});\n</script>\n    <div id=\"notification\"></div>\n     <div class=\"content\">\n<div class=\"panel\">\n            <h2>Unpaid Invoices</h2>\n            <div class=\"grid\"  id=\"userlists\" >\n               \n            </div>\n</div>\n</div>";

?>