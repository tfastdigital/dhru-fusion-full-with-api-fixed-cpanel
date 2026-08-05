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
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($keyboard) {
    if ($_POST["keyboard_shortcuts"]) {
        $_POST["keyboard_shortcuts"] = 1;
    } else {
        $_POST["keyboard_shortcuts"] = 0;
    }
} else {
    if ($_POST["dontdiscconect"]) {
        $_POST["dontdiscconect"] = 0;
    } else {
        $_POST["dontdiscconect"] = 1;
    }
    if ($dailyemailbackup == 1) {
        $_POST["dailyemailbackup"] = 1;
    } else {
        $_POST["dailyemailbackup"] = "";
    }
    if ($imeisummary == 1) {
        $_POST["imeisummary"] = 1;
    } else {
        $_POST["imeisummary"] = "";
    }
    if ($dailysitemap == 1) {
        $_POST["dailysitemap"] = 1;
    } else {
        $_POST["dailysitemap"] = "";
    }
    if ($lowstockalert == 1) {
        $_POST["lowstockalert"] = 1;
    } else {
        $_POST["lowstockalert"] = "";
    }
    if ($currencyupdate == 1) {
        $_POST["currencyupdate"] = 1;
    } else {
        $_POST["currencyupdate"] = "";
    }
    if ($countryupdate == 1) {
        $_POST["countryupdate"] = 1;
    } else {
        $_POST["countryupdate"] = "";
    }
    foreach ($lowcreditnotification as $k => $v) {
        if ($_POST["lowcreditnotification"][$k]) {
            $_POST["lowcreditnotification"][$k] = 1;
        } else {
            $_POST["lowcreditnotification"][$k] = 0;
        }
    }
    if (!$pricechange) {
        $_POST["pricechange"][999] = 0;
        $b = dquery("select * from tbl_client_group");
        while ($rb = mysqli_fetch_assoc($b)) {
            $_POST["pricechange"][$rb["id"]] = 0;
        }
    }
    foreach ($pricechange as $k => $v) {
        if ($_POST["pricechange"][$k]) {
            $_POST["pricechange"][$k] = 1;
        } else {
            $_POST["pricechange"][$k] = 0;
        }
    }
    if ($_POST["removecc"]) {
        $_POST["removecc"] = 1;
    } else {
        $_POST["removecc"] = 0;
    }
    if ($_POST["newimeiavailable"]) {
        $_POST["newimeiavailable"] = 1;
    } else {
        $_POST["newimeiavailable"] = 0;
    }
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>