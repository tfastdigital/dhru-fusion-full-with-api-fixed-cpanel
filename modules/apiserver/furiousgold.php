<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["furiousgoldname"] = "furiousgold";
$APIMODULE["furiousgoldvisiblename"] = "Furious Gold";
function furiousgold_activate()
{
    GatewayField("furiousgold", "text", "apiuser", "", "APi User", "30", "");
    GatewayField("furiousgold", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("furiousgold", "text", "apiurl", "http://www.furiousgold.com/api/version1/", "APi url", "500", "");
}
function furiousgold_accoutinfo($VAL)
{
    $post[API_USER] = $VAL["apiuser"];
    $post[API_KEY] = $VAL["apikey"];
    $post[METHOD] = "CHECK_MY_CREDITS";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $VAL["apiurl"]);
    curl_setopt($ch, CURLOPT_USERAGENT, "FuriousGold API Client");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = curl_error($ch);
    $errorno = curl_errno($ch);
    curl_close($ch);
    $DATA = unserialize($result);
    if (count($DATA["RESULT"])) {
        $return["Available balance"] = $DATA["RESULT"]["AMOUNT"];
        $return["currency"] = $DATA["RESULT"]["CURRENCY"];
        return $return;
    }
    if ($errorno) {
        $return["ERROR"] = $error;
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function furiousgold_services($VAL)
{
    $post[API_USER] = $VAL["apiuser"];
    $post[API_KEY] = $VAL["apikey"];
    $post[METHOD] = "LIST_PRODUCT_CATEGORIES";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $VAL["apiurl"]);
    curl_setopt($ch, CURLOPT_USERAGENT, "FuriousGold API Client");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = curl_error($ch);
    $errorno = curl_errno($ch);
    curl_close($ch);
    $DATA = unserialize($result);
    $CATEGORY = $DATA["RESULT"];
    $PRODUCTS = [];
    if (count($CATEGORY)) {
        $post[API_USER] = $VAL["apiuser"];
        $post[API_KEY] = $VAL["apikey"];
        $post[METHOD] = "LIST_PRODUCTS";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $VAL["apiurl"]);
        curl_setopt($ch, CURLOPT_USERAGENT, "FuriousGold API Client");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        $errorno = curl_errno($ch);
        curl_close($ch);
        $DATA = unserialize($result);
        $PRODUCTS = $DATA["RESULT"];
    }
    if (count($PRODUCTS)) {
        foreach ($CATEGORY as $CatDetail) {
            $GROUPID = $CatDetail["CATEGORY_ID"];
            $Group = $CatDetail["CATEGORY_NAME"];
            $return["Group"][$GROUPID]["Name"] = $Group;
            $return["Group"][$GROUPID]["GroupType"] = "SERVER";
            $return["Group"][$GROUPID]["ID"] = $GROUPID;
            foreach ($PRODUCTS as $ProDetail) {
                if ($ProDetail["CATEGORY_ID"] == $GROUPID) {
                    $Tools = $ProDetail["PRODUCT_ID"];
                    $return["Group"][$GROUPID]["Tool"][$Tools]["SERVER"] = 1;
                    $return["Group"][$GROUPID]["Tool"][$Tools]["SERVICETYPE"] = "SERVER";
                    $return["Group"][$GROUPID]["Tool"][$Tools]["Name"] = $ProDetail["PRODUCT_NAME"];
                    $return["Group"][$GROUPID]["Tool"][$Tools]["Credits"] = $ProDetail["UNIT_SALE_PRICE"];
                }
            }
        }
        return $return;
    } else {
        if ($errorno) {
            $return["ERROR"] = $error;
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
        return $return;
    }
}
function furiousgold_send($VAL)
{
}

?>