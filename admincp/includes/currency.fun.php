<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
function getCurrencyRates($exchangecode = "", $response = false)
{
    $result = select_query("tbl_currencies", "", ["`default`" => "1"]);
    $data = mysqli_fetch_assoc($result);
    $currencycode = $data["code"];
    $license = dquery("select * from tbl_license where id='1'");
    $license = mysqli_fetch_assoc($license);
    $curlreturn = initCurl("https://api.dhru.com/integration/api/v1/exchangerates?base=" . $currencycode . "&licensekey=1&token=" . $license["license_key"], []);
    if (1==1) {
        $curlreturn = json_decode($curlreturn, true);
    }
    $exchrate[$currencycode] = 1;
    foreach ($curlreturn["data"]["rates"] as $code => $rate) {
        $exchrate[(string) $code] = (string) $rate;
    }
    if ($exchangecode) {
        foreach ($exchrate as $cd => $rt) {
            if ($cd == $exchangecode) {
                return $rt;
            }
        }
        exit;
    } else {
        $baserate = $exchrate[$currencycode];
        $result = select_query("tbl_currencies", "", ["`default`" => ["sqltype" => "NEQ", "value" => "1"]], "code", "ASC");
        while ($data = mysqli_fetch_assoc($result)) {
            $id = $data["id"];
            $code = $data["code"];
            $coderate = $exchrate[$code];
            if (0 < $coderate) {
                if (!$baserate) {
                    $baserate = 1;
                }
                if (!$data["dontupdate"]) {
                    $exchangerate = round(1 / ($baserate / $coderate), 5);
                    update_query("tbl_currencies", ["rate" => $exchangerate], ["id" => $id]);
                    $msg .= "Updated " . $code . " Exchange Rate to " . $exchangerate . "<br>";
                }
            } else {
               $exchangerate = round(1 / ($baserate / $coderate), 5);
                    update_query("tbl_currencies", ["rate" => $exchangerate], ["id" => $id]);
                    $msg .= "Updated " . $code . " Exchange Rate to " . $exchangerate . "<br>";
            }
        }
        if ($response) {
            return $exchrate;
        }
        return $msg;
    }
}

?>