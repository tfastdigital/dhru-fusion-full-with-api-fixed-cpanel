<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

for ($i = 0; $i <= 255; $i++) {
    $fpdf_charwidths["courier"][chr($i)] = 600;
}
$fpdf_charwidths["courierB"] = $fpdf_charwidths["courier"];
$fpdf_charwidths["courierI"] = $fpdf_charwidths["courier"];
$fpdf_charwidths["courierBI"] = $fpdf_charwidths["courier"];

?>