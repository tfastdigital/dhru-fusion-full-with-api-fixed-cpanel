<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$result = dquery("SELECT `id`,`mep` FROM `tbl_mep` " . $WHERE);
while ($data = mysqli_fetch_assoc($result)) {
    $Brands[$data["id"]]["NAME"] = $data["mep"];
    $Brands[$data["id"]]["ID"] = $data["id"];
}
if ($ServiceDetails["id"]) {
    if ($ServiceDetails["reqredfield"]["mep"] == "1") {
        $apiresults["SUCCESS"][] = ["MESSAGE" => "Mep List", "LIST" => $Brands];
    } else {
        $apiresults["ERROR"][] = ["MESSAGE" => "No Model Required"];
    }
} else {
    $apiresults["SUCCESS"][] = ["MESSAGE" => "Mep List", "LIST" => $Brands];
}
unset($NewServiceDetails);
unset($ServiceDetails);

?>