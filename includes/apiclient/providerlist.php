<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    require ROOTDIR . "/includes/imeiservices.fun.php";
    $parameters["ID"] = ($parameters["ID"] - 5) / 9;
    if ($parameters["ID"]) {
        $ServiceDetails = getIMEIServices("", md5($parameters["ID"]), $UserDetails["id"], true, false, "");
    }
}
if ($ServiceDetails["reqredfield"]["provider"] == "1") {
    if ($ServiceDetails["reqredfield"]["assigned_country"]) {
        $WHERE = " WHERE`api`='" . $ServiceDetails["listing"] . "' AND `ID` IN (" . $ServiceDetails["reqredfield"]["assigned_country"] . ")";
    }
    $dataX = mysqli_fetch_assoc(dquery("SELECT `assigned_provider`,`listing` FROM `tbl_services_imei` WHERE id='" . $ServiceDetails["id"] . "'"));
    if ($dataX["assigned_provider"]) {
        $WHERE2 = " AND `id` IN (" . $dataX["assigned_provider"] . ")";
    }
}
$result = dquery("SELECT `ID`,`Name` FROM `tbl_provider_country` " . $WHERE . " ");
while ($data = mysqli_fetch_assoc($result)) {
    $Brands[$data["ID"]]["COUNTRY"] = $data["Name"];
    $Brands[$data["ID"]]["CID"] = $data["ID"];
    $res = dquery("SELECT `ID`,`Name` FROM `tbl_provider` WHERE `C_ID`='" . $data["ID"] . "' " . $WHERE2);
    while ($data1 = mysqli_fetch_assoc($res)) {
        $Brands[$data["ID"]]["PROVIDERS"][$data1["ID"]] = ["ID" => $data1["ID"], "NAME" => $data1["Name"]];
    }
}
if ($ServiceDetails["id"]) {
    if ($ServiceDetails["reqredfield"]["provider"] == "1") {
        $apiresults["SUCCESS"][] = ["MESSAGE" => "Country and Provider List", "LIST" => $Brands];
    } else {
        $apiresults["ERROR"][] = ["MESSAGE" => "No Provider Required"];
    }
} else {
    $apiresults["SUCCESS"][] = ["MESSAGE" => "Country and Provider List", "LIST" => $Brands];
}
unset($NewServiceDetails);
unset($ServiceDetails);

?>