<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["mepservername"] = "mepserver";
$APIMODULE["mepservervisiblename"] = "Mepserver.com";
$APIMODULE["mepservernotes"] = "Your call back URL is : " . $config["site_address"] . "/api/mepserver.php";
function mepserver_activate()
{
    GatewayField("fusion1", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("fusion1", "text", "accountid", "", "Account ID", "600", "");
}
function mepserver_accoutinfo($VAL)
{
    define("API_PROACCOUNT_ID", "");
    define("API_PROACCOUNT_KEY", "");
}
function mepserver_services($VAL)
{
    $return["Group"][0]["ID"] = "mepserver";
    $return["Group"][0]["Name"] = "mepserver";
    $return["Group"][0]["Tool"][0]["ID"] = "1";
    $return["Group"][0]["Tool"][0]["Name"] = "Calc using operator";
    $return["Group"][0]["Tool"][0]["Requires.Network"] = "Required";
    $return["Group"][0]["Tool"][0]["Requires.Provider"] = "Required";
    $return["Group"][0]["Tool"][0]["Requires.Mobile"] = "Required";
    $return["Group"][0]["Tool"][1]["ID"] = "2";
    $return["Group"][0]["Tool"][1]["Name"] = "Calc using MEP ";
    $return["Group"][0]["Tool"][1]["Requires.MEP"] = "Required";
    return $return;
}
function mepserver_mobiles($VAL)
{
    $content = file_get_contents("http://mepserver.com/api_helpers/brands_list.php?extra=1|1|1|1");
    $content = unserialize($content);
    if ($content) {
        $BID = NULL;
        foreach ($content as $gk => $Brand) {
            $BID = (string) $gk;
            $return["Brand"][$BID]["ID"] = $BID;
            $return["Brand"][$BID]["Name"] = $Brand;
            $MID = NULL;
            $content1 = file_get_contents("http://mepserver.com/api_helpers/models_list.php?brand=" . $BID);
            $content1 = unserialize($content1);
            if ($content1) {
                foreach ($content1 as $gk => $Mobile) {
                    $MID = (string) $gk;
                    $return["Brand"][$BID]["Mobile"][$MID]["ID"] = $MID;
                    $return["Brand"][$BID]["Mobile"][$MID]["Name"] = $Mobile;
                }
            }
        }
        return $return;
    } else {
        $return["ERROR"] = "ERROR 5695";
        return $return;
    }
}
function mepserver_provider($VAL)
{
    $content = file_get_contents("http://mepserver.com/api_helpers/countries_list.php?phone=1");
    $content = unserialize($content);
    if ($content) {
        $BID = NULL;
        foreach ($content as $gk => $Country) {
            $BID = (string) $gk;
            $return["Country"][$BID]["ID"] = $BID;
            $return["Country"][$BID]["Name"] = $Country;
            $MID = NULL;
            $content1 = file_get_contents("http://mepserver.com/api_helpers/operators_list.php?model=1&country=" . $BID);
            $content1 = unserialize($content1);
            if ($content1) {
                foreach ($content1 as $gk => $Network) {
                    $MID = (string) $gk;
                    $return["Country"][$BID]["Network"][$MID]["ID"] = $MID;
                    $return["Country"][$BID]["Network"][$MID]["Name"] = $Network;
                }
            }
        }
        return $return;
    } else {
        $return["ERROR"] = "ERROR 2345";
        return $return;
    }
}
function mepserver_mep($VAL)
{
    $content = file_get_contents("http://mepserver.com/api_helpers/meps_list.php");
    $content = unserialize($content);
    return $content;
}
function mepserver_send($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/mepserver.class.php";
    if ($VAL["API_ID"] == 2) {
        $_TYPE = "byMEP";
        $codes[] = ["imei" => trim($VAL["IMEI"]), "brand" => 0, "phone_model" => 0, "country" => 0, "operator" => 0, "mep" => $VAL["API_MEP_ID"], "email" => ""];
    } else {
        if ($VAL["API_ID"] == 1) {
            $_TYPE = "simple";
            $codes[] = ["imei" => trim($VAL["IMEI"]), "brand" => trim($VAL["BRAND_ID"]), "phone_model" => trim($VAL["API_MODEL_ID"]), "country" => trim($VAL["PROVIDER_COUNTRY_ID"]), "operator" => trim($VAL["API_PROVIDER_ID"]), "mep" => "", "email" => ""];
        }
    }
    foreach ($codes as $key => $value) {
        $codes[$key]["custom_field"] = "";
        $codes[$key]["email"] = "";
    }
    print_r($codes);
    $array = [];
    $array["codes"] = serialize($codes);
    $array["type"] = $_TYPE;
    $_PATHINFO = NULL;
    $_PATHINFO["dirname"] = "http://shoppingcartdemo.dhru.com/mepserver";
    $_PATHINFO["basename"] = "cron.php?action=mepserver";
    $_PATHINFO["extension"] = "php?action=mepserver";
    $_PATHINFO["filename"] = "cron";
    $array["referer"] = serialize($_PATHINFO);
    $cript = my_crypt($VAL["accountid"], $VAL["apikey"], $_POST["type"]);
    $compressed = my_crypt($VAL["accountid"], $VAL["apikey"], gzdeflate(implode("[ || ]", $array), 9));
    $array_keys = array_keys($array);
    $compressed_keys = my_crypt($VAL["accountid"], $VAL["apikey"], gzdeflate(implode("[ || ]", $array_keys), 9));
    $data = "cript=" . rawurlencode($cript) . "&data=" . rawurlencode($compressed) . "&keys=" . rawurlencode($compressed_keys) . "";
    $sessiune_trimitere = curl_init();
    curl_setopt($sessiune_trimitere, CURLOPT_URL, "http://mepserver.com/api_helpers/receive_values.php");
    curl_setopt($sessiune_trimitere, CURLOPT_POST, 1);
    curl_setopt($sessiune_trimitere, CURLOPT_POSTFIELDS, $data);
    curl_setopt($sessiune_trimitere, CURLOPT_RETURNTRANSFER, true);
    $incommingValues = curl_exec($sessiune_trimitere);
    echo $incommingValues = "<h1>Response from mepserver</h1>" . $incommingValues;
    if (deregi("Success", $incommingValues)) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($incommingValues);
        $return["ID"] = $VAL["IMEI"];
    }
    return $return;
}
function mepserver_get($VAL)
{
    $_CODE = mysqli_fetch_assoc(dquery("SELECT * from `tbl_mepserver` WHERE `imei`='" . $VAL["IMEI"] . "'"));
    $_CODE = $_CODE["unlock_code"];
    if ($_CODE) {
        dquery("DELETE FROM `tbl_mepserver` WHERE `imei` = '" . $VAL["IMEI"] . "'");
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars("Order Found");
        $return["CODES"] = $_CODE;
    }
    return $return;
}

?>