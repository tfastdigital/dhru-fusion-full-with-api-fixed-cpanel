<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<table cellspacing=\"0\" cellpadding=\"4\" id=\"main_tbl\">\n<thead>\n<tr>\n<th align=\"left\"><strong>APi ";
echo $LNG["server"];
echo " ";
echo $LNG["name"];
echo "</strong></th>\n<th align=\"left\"><strong>Credits available</strong></th>\n<th align=\"right\"><strong>Connected to service</strong></th></tr>\n</thead>\n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$sql = dquery("select * from `tbl_apiservers` WHERE `setting`='name'");
if (mysqli_num_rows($sql)) {
    require_once ROOTDIR . "/includes/apiserver.fun.php";
    while ($row = mysqli_fetch_assoc($sql)) {
        $gateway = $row["gateway"];
        $CONNECTEd = mysqli_num_rows(dquery("SELECT id FROM tbl_services_imei WHERE API='" . $gateway . "' AND API_ID!='' "));
        if ($CustomName = mysqli_fetch_assoc(dquery("select * from `tbl_apiservers` WHERE `gateway`='" . $gateway . "' AND setting='customname'"))) {
            $CustomName = " (" . $CustomName["value"] . ")";
        }
        $apisaveddetails = loadApiModule($gateway, false);
        require_once ROOTDIR . "/modules/apiserver/" . $gateway . ".php";
        if (function_exists($gateway . "_accoutinfo")) {
            $accoutinfo = call_user_func($gateway . "_accoutinfo", $apisaveddetails);
            $CreditAvalable = $accoutinfo["Credits available"];
        }
        if (!$CreditAvalable) {
            $CreditAvalable = "can't check";
        }
        echo "<tr>\n<td align=\"left\">";
        echo $row["value"] . $CustomName;
        echo "</td>\n<td align=\"left\">";
        echo $CreditAvalable;
        echo "</td>\n<td align=\"right\">";
        echo $CONNECTEd;
        echo "</td></tr>\n";
        unset($apisaveddetails);
        unset($CreditAvalable);
    }
} else {
    echo " \n<td align=\"center\" colspan=\"3\">No APi Activated</td>\n";
}
echo "</table>\n";
$fileverioncheck = "6.1.0";

?>